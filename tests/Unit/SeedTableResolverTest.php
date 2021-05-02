<?php
namespace Tests\Unit;

use LaravelSeedGenerator\Services\TableResolver;
use Tests\TestCase;

class SeedTableResolverTest extends TestCase {
    public function test_resolves_table(){
        $resolver = new TableResolver('test_table');
        $builder = $resolver->builder();
        $this->assertEquals('select * from "test_table"', $builder->toSql());
    }

    public function test_resolves_table_with_columns(){
        $resolver = new TableResolver('test_table', ['id']);
        $builder = $resolver->builder();
        $this->assertEquals('select "id" from "test_table"', $builder->toSql());
    }
}