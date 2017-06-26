<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('goods_attribute', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('attr_id');
			$table->string('attr_name', 60)->nullable()->comment('Ʒ������');
			 $table->integer('type_id')->unsigned()->nullable()->default(0)->comment('���Է���id');
			$table->tinyInteger('attr_index',1)->unsigned()->default(0)->comment('0����Ҫ���� 1�ؼ��ּ��� 2��Χ����');
			$table->tinyInteger('attr_type',1)->unsigned()->default(0)->comment('0Ψһ���� 1��ѡ���� 2��ѡ����');
			$table->tinyInteger('attr_input_type', 1)->unsigned()->default(0)->comment('0 �ֹ�¼�� 1���б���ѡ�� 2�����ı���');
			$table->text('attr_values')->comment('��ѡֵ�б�');
			$table->tinyInteger('order')->unsigned()->nullable()->default(50)->comment('��������');
			
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
        Schema::drop('goods_attribute');
    }
}
