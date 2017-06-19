<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCodeInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 会员积分明细表
        Schema::create('users_code_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->comment('用户ID');
            $table->integer('code_num')->comment('获取和消耗积分');
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
       Schema::drop('users_code_info');
    }
}