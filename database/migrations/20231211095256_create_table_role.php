<?php

declare(strict_types=1);

use \Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

final class CreateTableRole extends Migration
{
    public function up(): void
    {
        $this->schema->create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->timestamps();
        });
        $this->schema->table('users', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->nullable();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    public function down(): void
    {
        $this->schema->disableForeignKeyConstraints();
        $this->schema->table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
        $this->schema->drop('roles');
    }
}
