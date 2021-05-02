<?php

class CreateTestModelWithSelectsTable extends \Illuminate\Database\Migrations\Migration {
    public function up(){
        \Illuminate\Support\Facades\Schema::create('test_model_with_selects', function(\Illuminate\Database\Schema\Blueprint $table){
            $table->id();
            $table->string('name');
        });

        for($i = 0; $i < 10; $i++){
            \Tests\fixtures\TestModelWithSelect::create([
                'name' => 'Test'.$i
            ]);
        }
    }

    public function down(){
        \Illuminate\Support\Facades\Schema::dropIfExists('test_models');
    }
}