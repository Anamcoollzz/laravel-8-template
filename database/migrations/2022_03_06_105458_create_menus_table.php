<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->string('route_name')->nullable();
            $table->string('uri')->nullable();
            $table->boolean('is_blank')->default(false);
            $table->string('icon')->nullable();
            $table->string('permission')->nullable();
            $table->text('is_active_if_url_includes')->nullable();
            $table->unsignedBigInteger('parent_menu_id')->nullable();
            $table->foreign('parent_menu_id')->on('menus')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('menu_group_id')->nullable();
            $table->foreign('menu_group_id')->on('menu_groups')->references('id')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('menus');
    }
}
