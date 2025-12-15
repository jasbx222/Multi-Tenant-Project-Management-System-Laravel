<?php


use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider{
protected $policies = [
    \App\Models\Company::class => \App\Policies\CompanyPolicy::class,
    \App\Models\Project::class => \App\Policies\ProjectPolicy::class,
    \App\Models\Task::class => \App\Policies\TaskPolicy::class,
];

}