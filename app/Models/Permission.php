<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Permission extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}