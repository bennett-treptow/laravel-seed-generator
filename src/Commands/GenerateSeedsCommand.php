<?php
namespace LaravelSeedGenerator\Commands;

use Illuminate\Console\Command;
use LaravelSeedGenerator\Services\SeedClassResolver;
use LaravelSeedGenerator\Services\SeedWriter;
use LaravelSeedGenerator\Services\TableResolver;

class GenerateSeedsCommand extends Command {
    protected $signature = 'generate:seeds {--table=*} {--class=*} {--tables-only} {--classes-only}';

    public function handle(){
        $classes = config('laravel-seed-generator.seed_classes');
        $tableConfig = config('laravel-seed-generator.seed_tables');

        $tables = [];
        foreach($tableConfig as $key => $table){
            if(is_numeric($key)){
                $tables[$table] = ['*'];
            } else {
                $tables[$key] = $table;
            }
        }

        if($this->hasOption('class')){
            $optionClasses = $this->option('class');
            if(count($optionClasses) > 0){
                $classes = $optionClasses;
            }
        }

        if($this->hasOption('table')){
            $optionTables = $this->option('table');
            if(count($optionTables) > 0){
                $tables = [];
                foreach($optionTables as $table){
                    if(config()->has('laravel-seed-generator.seed_tables.'.$table)){
                        $tables[$table] = config('laravel-seed-generator.seed_tables.'.$table);
                    } else {
                        $tables[$table] = ['*'];
                    }
                }
            }
        }

        if($this->option('tables-only')){
            $classes = [];
        }
        if($this->option('classes-only')){
            $tables = [];
        }

        foreach($classes as $class){
            /** @var \Illuminate\Database\Eloquent\Model $instance */
            $builder = (new SeedClassResolver($class))->builder();
            (new SeedWriter($builder->from, $builder->cursor()))
                ->write();
        }

        foreach($tables as $table => $columns){
            $builder = (new TableResolver($table, $columns))->builder();
            (new SeedWriter($table, $builder->cursor()))
                ->write();
        }
    }
}