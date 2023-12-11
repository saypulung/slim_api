<?php

declare(strict_types=1);

use \Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

final class CreateTableUser extends Migration
{
    public function up(): void
    {
        $this->schema->create('users', function (Blueprint $table) {
            // Auto-increment id
            $table->increments('id');
            $table->string('name',50);
            $table->string('email',50)->unique();
            $table->string('password');
            // Required for Eloquent's created_at and updated_at columns
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema->drop('users');
    }
}
