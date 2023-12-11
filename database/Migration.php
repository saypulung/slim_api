<?php

namespace Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

    public function init()
    {
        $this->capsule = new Capsule;
        $settings = [
            'driver' => DB_ADAPTER,
            'host' => DB_HOST,
            'database' => DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASS,
            'port'     => DB_PORT,
            'charset'   => DB_CHARSET,
            'collation' => DB_COLLATION,
        ];
        $this->capsule->addConnection($settings);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}