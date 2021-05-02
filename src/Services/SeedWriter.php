<?php
namespace LaravelSeedGenerator\Services;

use Illuminate\Support\Str;

class SeedWriter {
    /**
     * @var string
     */
    protected string $tableName;

    protected $rows;

    public function __construct(string $tableName, iterable $rows){
        $this->tableName = $tableName;
        $this->rows = $rows;
    }

    protected function getStub(){
        if (file_exists($overridden = resource_path('stubs/vendor/laravel-seed-generator/'.$this->tableName.'.stub'))) {
            return $overridden;
        }

        if (file_exists($overridden = resource_path('stubs/vendor/laravel-migration-generator/seed.stub'))) {
            return $overridden;
        }

        return __DIR__ . '/../../stubs/seed.stub';
    }

    protected function formatRows(string $tabCharacter = '    '){
        $str = '';

        $indent = str_repeat($tabCharacter, 3);
        $subIndent = str_repeat($tabCharacter, 2);

        foreach($this->rows as $row){
            $str .= $indent.'[';
            foreach($row as $column => $value){
                $str .= "'{$column}' => '{$value}', ";
            }
            $str = rtrim($str, ', ');
            $str .= '],'."\n";
        }
        $str = rtrim($str, ",\n");
        return '['."\n".$str."\n".$subIndent.']';
    }

    public function write(string $tabCharacter = '    '){
        $stub = $this->getStub();
        $stubContents = file_get_contents($stub);
        $replacers = [
            '[TableName:Studly]' => Str::studly($this->tableName),
            '[TableName]' => $this->tableName,
            '[SeedData]' => $this->formatRows($tabCharacter)
        ];

        foreach($replacers as $token => $replacement){
            $stubContents = str_replace($token, $replacement, $stubContents);
        }

        file_put_contents(database_path('seeders/'.Str::studly(Str::singular($this->tableName)).'Seeder.php'), $stubContents);
    }
}