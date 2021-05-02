<?php
namespace Tests\Unit;

use LaravelSeedGenerator\Services\SeedWriter;
use Tests\TestCase;

class SeedWriterTest extends TestCase {
    public function tearDown(): void
    {
        parent::tearDown();

        foreach(glob(database_path('seeders/*.php')) as $file){
            unlink($file);
        }
    }

    public function test_it_can_write(){
        $writer = new SeedWriter('test', [
            ['id' => 1, 'name' => 'Test'],
            ['id' => 2, 'name' => 'Test2']
        ]);

        $writer->write();
        $this->assertFileExists($path = database_path('seeders/TestSeeder.php'));
        $contents = file_get_contents($path);

        $this->assertStringContainsString("['id' => '1', 'name' => 'Test'],\n", $contents);
        $this->assertStringContainsString("['id' => '2', 'name' => 'Test2']\n", $contents);
    }
}