<?php
namespace LaravelSeedGenerator\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface SeedableContract {
    public function seedQuery(Builder $builder);
}