<?php
$app = (require_once __DIR__ . '/../app/bootstrap.php');

use App\Models\Permission;
use App\Models\Role;

$connections = $app->getContainer()->get('db')->getConnection();
$connections->beginTransaction();
try {

    $permissionsData = [
        [
            'id'    => 1,
            'name'  => "user.me"
        ],
        [
            'id'    => 2,
            'name'  => 'user.updateProfile'
        ]
    ];

    $checkRoles = Role::whereIn('id', [1, 2])->count();

    if ($checkRoles == 0) {
        die("\e[32mPlease run `composer run-script init-admin` first");
    }

    $permissions = [
        [
            "id"    => 1,
            "name"  => "user.me"
        ],
        [
            "id"    => 2,
            "name"  => "user.updateProfile"
        ],
        [
            "id"    => 3,
            "name"  => "project.all"
        ],
        [
            "id"    => 4,
            "name"  => "project.detail"
        ],
        [
            "id"    => 5,
            "name"  => "project.create"
        ],
        [
            "id"    => 6,
            "name"  => "project.update"
        ],
        [
            "id"    => 7,
            "name"  => "project.delete"
        ],
    ];

    $role_permission = [
        1 => [1, 2, 3, 4, 5, 6, 7],
        2 => [1, 2, 3, 4],
    ];

    $permissionsCount = Permission::whereIn('id', $role_permission[1])->count();
    if ($permissionsCount == 7) {
        exit("\e[32mPermissions already created" . PHP_EOL);
    }

    echo 'Creating permissions: ' . PHP_EOL;

    foreach ($permissions as $permission)
    {
        echo "$permission[name]" . PHP_EOL;
        Permission::create([
            'id'    => $permission['id'],
            'name'  => $permission['name']
        ]);
    }

    foreach ($role_permission as $roleId => $rp)
    {
        echo 'Attaching permission to ID ' . $roleId . PHP_EOL;
        $role = Role::find($roleId);
        $permissionsCollection = Permission::whereIn('id', $rp)->get();
        
        if ($permissionsCollection) {
            foreach ($permissionsCollection as $p)
            {
                $role->permissions()->attach($p);
            }
        }
    }
    $connections->commit();
} catch (\Exception $e) {
    echo "Rollback...." . PHP_EOL;
    $connections->rollBack();
}
