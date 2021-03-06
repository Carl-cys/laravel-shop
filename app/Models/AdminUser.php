<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Zizaco\Entrust\HasRole;
//use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{

    use EntrustUserTrait;

    //定义表名
    protected $table    = 'admin_users';

    //定义批量添加
    protected $fillable = [
    	'nickname', 'password', 'email', 'status','last_login_time', 'last_login_ip','login_num','pic'
    ];


    /**
     * 用户有哪些角色
     *
     * @return $this
     */
    public function roles()
    {
        return $this->belongsToMany(\App\Role::class, 'role_user',  'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    /**
     * 判断是否有某个角色，某些角色
     *
     * @param  $role
     * @return bool
     */
    public function isInRoles($role)
    {
        return !!$role->intersect($this->roles)->count();
    }

    /**
     * 给用户分配角色
     *
     * @param  $role
     * @return mixed
     */
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    /**
     * 取消用户分配的角色
     *
     * @param  $role
     * @return mixed
     */
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * 用户是否有权限
     *
     * @param  $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }



}
