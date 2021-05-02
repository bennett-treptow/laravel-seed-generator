<?php
namespace LaravelSeedGenerator\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TableResolver {
    private string $tableName;
    /**
     * @var array|string[]
     */
    private array $columns;

    public function __construct(string $tableName, array $columns = ['*']){
        $this->tableName = $tableName;
        $this->columns = $columns;
    }

    public function builder(): Builder{
        return DB::table($this->tableName)->select($this->columns);
    }
}