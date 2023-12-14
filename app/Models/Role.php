<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}