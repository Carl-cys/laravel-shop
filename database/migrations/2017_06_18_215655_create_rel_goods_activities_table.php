<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelGoodsActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商品活动关联表
        Schema::create('rel_goods_activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('activity_id')->comment('活动ID');
            $table->integer('goods_id')->comment('货品ID');
            $table->string('key')->comment('货品的规格key');
            $table->tinyInteger('number')->comment('用来做活动的商品数量');
            $table->integer('promotion_price')->comment('促销价');
            $table->timestamps();

            $table->foreign('activity_id')->references('id')->on('activities')->comment('活动表的ID外键');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_goods_activities');
    }
}
