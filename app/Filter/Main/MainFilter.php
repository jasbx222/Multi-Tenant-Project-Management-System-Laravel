<?php


namespace App\Filter\Main;

use App\Enums\Operations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

abstract class MainFilter extends FormRequest
{

    // <editor-fold default-state="collapsed" desc="Constants">

    private const PAGE = 'page';

    private const PER_PAGE = 'perPage';

    private const KEYWORD = 'keyword';

    private const FILTERS = 'filters';

    private const ORDERS = 'orders';

    private const DEFAULT_OPERATION = '=';

    // </editor-fold>

    // <editor-fold default-state="collapsed" desc="Other">
    public function apply(Builder $builder): Builder
    {
        $data = $this->validated();

        $page = $data[self::PAGE] ?? null;
        $perPage = $data[self::PER_PAGE] ?? 200; //todo 200 just for testing
        $keyword = $data[self::KEYWORD] ?? null;
        $filters = $data[self::FILTERS] ?? null;
        $orders = $data[self::ORDERS] ?? null;

        if ($filters) {
            $builder = $this->runFilters($builder, $filters);
        }

        if ($orders) {
            $builder = $this->runOrders($builder, $orders);
        } else {
            $builder = $this->defaultOrder($builder);
        }

        if ($keyword) {
            $builder = $this->search($builder, trim($keyword));
        }

        return $this->pagination($builder, $page, $perPage);
    }

    abstract protected function Map(): array;

    abstract protected function Table(): string;

    protected function local(): string
    {
        return app()->getLocale();
    }
    // </editor-fold>

    // <editor-fold default-state="collapsed" desc="Search">
    abstract protected function search(Builder $builder, string $keyword): Builder;
    // </editor-fold>

    // <editor-fold default-state="collapsed" desc="Filter">
    private function runFilters(Builder $builder, array $filters): Builder
    {
        foreach ($filters as $filter) {
            $name = $filter['name'];
            $value = $filter['value'];
            $operation = $filter['operation'] ?? self::DEFAULT_OPERATION;

            $column = $this->Map()[$name] ?? $name;

            if (method_exists($this, $method = $name . 'Filter')) {
                $builder = $this->$method($builder, $value, $operation, $column);
            } else {
                $builder = $this->addFilter($builder, $value, $operation, $column);
            }
        }
        return $builder;
    }

    protected function addFilter(Builder $builder, mixed $value, string $operation, string $column, string $table = null): Builder
    {
        $table = $table ?? $this->Table();
        $column = $table . '.' . $column;

        switch ($operation) {
            case Operations::IN:
                if (!is_array($value)) {
                    $value = [$value];
                }
                $builder->whereIn($column, $value);
                break;
            case Operations::NOT_IN:
                if (!is_array($value)) {
                    $value = [$value];
                }
                $builder->whereNotIn($column, $value);
                break;
            default:
                $builder->where($column, $operation, $value);
                break;
        }
        return $builder;
    }
    // </editor-fold>

    // <editor-fold default-state="collapsed" desc="Order">
    private function runOrders(Builder $builder, array $orders): Builder
    {
        foreach ($orders as $order) {
            $name = $order['name'];
            $direction = $order['direction'];

            $column = $this->Map()[$name] ?? $name;

            if (method_exists($this, $method = $name . 'Order')) {
                $builder = $this->$method($builder, $direction, $column);
            } else {
                $builder = $this->addOrder($builder, $direction, $column);
            }
        }
        return $builder;
    }

    protected function addOrder(Builder $builder, string $direction, string $column, string $table = null): Builder
    {
        $table = $table ?? $this->Table();
        $column = $table . '.' . $column;

        return $builder->orderBy($column, $direction);
    }

    protected abstract function defaultOrder(Builder $builder): Builder;
    // </editor-fold>

    // <editor-fold default-state="collapsed" desc="Pagination">
    private function pagination(Builder $builder, $page, $perPage): Builder
    {
        if (!$page) {
            $page = 1;
        }
        if (!$perPage) {
            $perPage = $builder->getModel()->getPerPage();
        }

        $builder->skip(($page - 1) * $perPage)->take($perPage);

        return $builder;
    }
    // </editor-fold>

    // <editor-fold default-state="collapsed" desc="Rules">
    public function rules(): array
    {
        return [
            self::PAGE => ['integer', 'min:1'],
            self::PER_PAGE => ['integer', 'min:1'],

            self::KEYWORD => ['string'],

            self::ORDERS . '.*.name' => ['required', 'string', Rule::in($this->getMapName())],
            self::ORDERS . '.*.direction' => ['required', Rule::in(['asc', 'desc'])],

            self::FILTERS . '.*.name' => ['required', 'string', Rule::in($this->getMapName())],
            self::FILTERS . '.*.operation' => ['nullable', Rule::in(Operations::SET)],
            self::FILTERS . '.*.value' => ['required'],
        ];
    }

    private function getMapName(): Collection
    {
        $name = collect();
        foreach ($this->Map() as $key => $value) {
            if (is_numeric($key)) {
                $name->add($value);
            } else {
                $name->add($key);
            }
        }
        return $name;
    }

    // </editor-fold>

}
