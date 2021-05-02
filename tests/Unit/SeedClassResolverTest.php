<?php
namespace Tests\Unit;

use LaravelSeedGenerator\Services\SeedClassResolver;
use Tests\fixtures\TestModel;
use Tests\fixtures\TestModelWithSelect;
use Tests\TestCase;

class SeedClassResolverTest extends TestCase {
    public function test_it_resolves_class(){
        $resolver = new SeedClassResolver(TestModel::class);

        $builder = $resolver->builder();
        $this->assertEquals('select * from "test_models"', $builder->toSql());
    }

    public function test_it_resolves_class_with_select(){
        $resolver = new SeedClassResolver(TestModelWithSelect::class);

        $builder = $resolver->builder();
        $this->assertEquals('select "id", "name" from "test_model_with_selects"', $builder->toSql());
    }
}