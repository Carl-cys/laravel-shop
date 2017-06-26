<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('spec', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
			 $table->integer('type_id')->unsigned()->nullable()->default(0)->comment('�������');
			 $table->string('name')->nullable()->comment('�������');
			 $table->tinyInteger('order')->unsigned()->nullable()->default(50)->comment('����');
			$table->tinyInteger('search_index',1)->unsigned()->default(0)->comment('0����Ҫ���� 1���� ');
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
        Schema::drop('spec');
    }
}
