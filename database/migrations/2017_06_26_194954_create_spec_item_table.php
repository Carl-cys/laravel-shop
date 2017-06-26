<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('spec_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
			 $table->integer('spec_id')->unsigned()->comment('���id');
			 $table->string('item', 60)->nullable()->comment('�����');
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
        Schema::drop('spec_item');
    }
}
