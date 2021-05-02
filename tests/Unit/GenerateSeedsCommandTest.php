<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Support\Facades\Config;
use Tests\fixtures\TestModel;
use Tests\fixtures\TestModelWithSelect;
use Tests\TestCase;

class GenerateSeedsCommandTest extends TestCase {
    use InteractsWithConsole;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--path' => __DIR__.'/../database/migrations',
            '--realpath' => true
        ]);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        foreach(glob(database_path('seeders/*.php')) as $file){
            unlink($file);
        }
    }

    public function test_generates_seeds_default(){
        Config::set('laravel-seed-generator.seed_classes', [TestModel::class]);
        Config::set('laravel-seed-generator.seed_tables', ['tests']);

        $this->artisan('generate:seeds');

        $this->assertFileExists(database_path('seeders/TestModelSeeder.php'));
        $this->assertFileExists(database_path('seeders/TestSeeder.php'));
    }

    public function test_generates_seeds_classes_only(){
        Config::set('laravel-seed-generator.seed_classes', [TestModel::class]);
        Config::set('laravel-seed-generator.seed_tables', ['tests']);

        $this->artisan('generate:seeds', ['--classes-only' => 1]);

        $this->assertFileExists(database_path('seeders/TestModelSeeder.php'));
        $this->assertFileDoesNotExist(database_path('seeders/TestSeeder.php'));
    }

    public function test_generates_seeds_tables_only(){
        Config::set('laravel-seed-generator.seed_classes', [TestModel::class]);
        Config::set('laravel-seed-generator.seed_tables', ['tests']);

        $this->artisan('generate:seeds', ['--tables-only' => 1]);

        $this->assertFileDoesNotExist(database_path('seeders/TestModelSeeder.php'));
        $this->assertFileExists(database_path('seeders/TestSeeder.php'));
    }

    public function test_generates_seeds_specified_tables(){
        Config::set('laravel-seed-generator.seed_classes', [TestModel::class]);
        Config::set('laravel-seed-generator.seed_tables', ['tests']);

        $this->artisan('generate:seeds', ['--table' => ['test_groups'], '--tables-only' => 1]);

        $this->assertFileDoesNotExist(database_path('seeders/TestModelSeeder.php'));
        $this->assertFileDoesNotExist(database_path('seeders/TestSeeder.php'));
        $this->assertFileExists(database_path('seeders/TestGroupSeeder.php'));
    }

    public function test_generates_seeds_specified_classes(){
        Config::set('laravel-seed-generator.seed_classes', [TestModel::class]);
        Config::set('laravel-seed-generator.seed_tables', ['tests']);

        $this->artisan('generate:seeds', ['--class' => [TestModelWithSelect::class], '--classes-only' => 1]);

        $this->assertFileDoesNotExist(database_path('seeders/TestModelSeeder.php'));
        $this->assertFileDoesNotExist(database_path('seeders/TestSeeder.php'));
        $this->assertFileExists(database_path('seeders/TestModelWithSelectSeeder.php'));
    }
}