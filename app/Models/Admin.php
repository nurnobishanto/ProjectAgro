<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes,HasRoles;
    protected $fillable = [
        'name',
        'photo',
        'email',
        'password',
        'status',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function adminlte_profile_url(){
        return 'admin/profile';
    }
    public function adminlte_image(){
        if (auth()->user()->photo){
            return asset('uploads/'.auth()->user()->photo);
        }
        return asset('self/avatar.webp');
    }

}
