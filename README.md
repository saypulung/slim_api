# Slim API project
Using Eloquent and Phinx migration tools for Slim Framework 4

# How to run
`composer install`

Copy .env.example into .env

Customize your .env based on your database configuration or other

`php vendor/bin/phinx migrate -c config-phinx.php`

`composer run-script init-admin`

`composer run-script start-dev`

Access your API by URL [localhost:5001](http://localhost:5001)

Optionally, you can setup to your web server by pointing document root into directory public
