<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public const ADMIN = 1;
    public const STAFF = 2;
    public const CUSTOMER = 3;
    public const SUPPLIER = 4;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'nid',
        'address',
        'company_name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeAdmin()
    {
        return $this->where(['role_id' => User::ADMIN]);
    }
    public function scopeStaff()
    {
        return $this->where(['role_id' => User::STAFF]);
    }
    public function scopeCustomer()
    {
        return $this->where(['role_id' => User::CUSTOMER]);
    }
    public function scopeSupplier()
    {
        return $this->where(['role_id' => User::SUPPLIER]);
    }
}
