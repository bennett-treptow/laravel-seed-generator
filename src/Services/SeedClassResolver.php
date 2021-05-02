<?php
namespace LaravelSeedGenerator\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use LaravelSeedGenerator\Contracts\SeedableContract;

class SeedClassResolver {
    private string $className;

    public function __construct(string $className){
        $this->className = $className;
    }

    public function builder(): Builder{
        $className = $this->className;
        /** @var Model|SeedableContract $instance */
        $instance = new $className;
        $builder = $instance->newQuery();
        $instance->seedQuery($builder);

        return $builder->getQuery();
    }
}