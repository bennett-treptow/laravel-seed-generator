<?php
namespace Tests\fixtures;

use Illuminate\Database\Eloquent\Model;
use LaravelSeedGenerator\Contracts\SeedableContract;
use LaravelSeedGenerator\Traits\Seedable;

class TestModel extends Model implements SeedableContract {
    use Seedable;
}