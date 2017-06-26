<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('brand', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('name', 60)->nullable()->comment('Ʒ������');
			$table->string('logo', 80)->nullable()->comment('Ʒ��logo');
			$table->text('desc')->comment('Ʒ������');
			$table->string('url')->comment('Ʒ�Ƶ�ַ');
			$table->tinyInteger('sort')->default(50)->unsigned()->comment(50);
			$table->tingInteger('is_hot', 1)->unsigned()->comment('�Ƿ��Ƽ�,0��1��');
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
        Schema::drop('brand');
    }
}
