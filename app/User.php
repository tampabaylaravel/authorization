<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    private $permissions = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //public function permissions()
    //{
        //$this->belongsToMany(Permission::class);
    //}

    public function addPermission($permission)
    {
        $this->permissions[] = $permission;
    }

    public function hasPermission($permission)
    {
        return collect($this->permissions)->contains($permission);
    }

    public function canEditPost($post)
    {
        return $this->is_admin || $this->is($post->user);
    }
}
