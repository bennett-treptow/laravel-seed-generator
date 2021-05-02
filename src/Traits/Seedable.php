<?php
namespace LaravelSeedGenerator\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Seedable {
    public function seedQuery(Builder $builder){
        return $builder;
    }
}