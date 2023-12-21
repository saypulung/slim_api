<?php

declare(strict_types=1);

use \Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

final class CreateTablePermissions extends Migration
{
    public function up(): void
    {
        $this->schema->create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        $this->schema->drop('permissions');
    }
}
