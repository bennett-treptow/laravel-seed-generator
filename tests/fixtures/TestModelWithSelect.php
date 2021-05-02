<?php
namespace Tests\fixtures;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaravelSeedGenerator\Contracts\SeedableContract;

class TestModelWithSelect extends Model implements SeedableContract {
    public $timestamps = false;
    protected $guarded = ['id'];
    public function seedQuery(Builder $builder)
    {
        return $builder->select(['id', 'name']);
    }
}