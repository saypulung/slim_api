<?php

declare(strict_types=1);

use \Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

final class CreateTableRolePermissions extends Migration
{
    public function up(): void
    {
        $this->schema->create('role_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->nullable();
            $table->unsignedInteger('permission_id')->nullable();
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema->drop('role_permissions');
    }
}
