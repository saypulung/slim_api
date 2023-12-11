<?php

declare(strict_types=1);

use \Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

final class CreateTableUser extends Migration
{
    public function up(): void
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',50);
            $table->string('last_name',50)->nullable();
            $table->string('email',50)->unique();
            $table->string('password');
            $table->datetime('registered')->nullable();
            $table->datetime('verified')->nullable();
            $table->string('token')->nullable();
            $table->mediumText('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema->drop('users');
    }
}
