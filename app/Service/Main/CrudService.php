<?php


namespace  App\Service\Main;

use App\Filter\Main\MainFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class CrudService
{
    abstract protected function getModelClass(): string;

    protected function getQuery(): Builder
    {
        return $this->getModelClass()::query();
    }

    public function index(MainFilter $filter): Builder
    {
        return $filter->apply($this->getQuery());
    }

    public function find(mixed $id): Model
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->getQuery()->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);
        return $model;
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }
}
