<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrudExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_examples', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->double('number');
            $table->string('select');
            $table->text('textarea');
            $table->string('radio');
            $table->text('checkbox');
            $table->text('file');
            $table->date('date');
            $table->time('time');
            $table->string('color', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crud_examples');
    }
}
