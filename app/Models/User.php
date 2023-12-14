<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Role;

class User extends Model {

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'metadata',
        'registered',
        'role_id',
        'verified',
        'token',
    ];

    protected $hidden = [
        'password',
        'id',
        'token',
    ];

    protected $casts = [
        'metadata' => 'object'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}