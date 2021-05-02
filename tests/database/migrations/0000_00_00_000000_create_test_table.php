<?php

class CreateTestTable extends \Illuminate\Database\Migrations\Migration {
    public function up(){
        \Illuminate\Support\Facades\Schema::create('tests', function(\Illuminate\Database\Schema\Blueprint $table){
            $table->id();
            $table->string('name');
        });

        for($i = 0; $i < 10; $i++){
            \Illuminate\Support\Facades\DB::table('tests')->insert(['name' => 'Test'.$i]);
        }
    }

    public function down(){
        \Illuminate\Support\Facades\Schema::dropIfExists('tests');
    }
}