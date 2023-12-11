<?php

require_once __DIR__ . '/../app/bootstrap.php';

use App\Models\User;
use App\Models\Role;

$rolesData = [
    [
        'id'    => 1,
        'name'  => 'admin'
    ],
    [
        'id'    => 2,
        'name'  => 'member'
    ]
];

$checkRoles = Role::whereIn('id', [1, 2])->count();

if ($checkRoles == 0) {
    echo "Roles is not defined, create these roles " . PHP_EOL;
    foreach ($rolesData as $role) {
        echo $role['name'] . PHP_EOL;
        Role::create($role);
    }
}

$findIdOne = User::find(1);
if ($findIdOne)
{
    echo "\e[32mUser ID 1 is already exists" . PHP_EOL;
} else {
    $userData = [
        'id'            => 1,
        'first_name'    => 'admin',
        'last_name'     => 'dev',
        'email'         => 'admin@admin.com',
        'password'      => password_hash('admin1234!', PASSWORD_BCRYPT, ['cost' => 10]),
        'registered'    => date('Y-m-d H:i:s'),
        'verified'      => date('Y-m-d H:i:s'),
        'role_id'       => 1
    ];
    try {
        $user = User::create($userData);
        if ($user) {
            echo "\e[32mUser created successfuly " . PHP_EOL .
                "\e[39mYou can login using email \e[32madmin@admin.com \e[39mand password \e[32madmin1234!" . PHP_EOL;
        } else {
            echo "\e[41mUser not created" . PHP_EOL;
        }
    } catch (Exception $e) {
        echo "\e[41mError : " . $e->getMessage();
    }
}
