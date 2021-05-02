<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Tests\TestCase;

class GenerateSeedsCommandTest extends TestCase {
    use InteractsWithConsole;

    public function test_generates_seeds_default(){
        $this->artisan('generate:seeds');
    }
}