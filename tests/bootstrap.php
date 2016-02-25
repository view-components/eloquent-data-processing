<?php
require_once __DIR__ . '/../vendor/view-components/testing-helpers/bootstrap/bootstrap.php';
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection([
    'driver'   => 'sqlite',
    'database' => __DIR__ . '/../db.sqlite',
    'prefix'   => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
// set timezone for timestamps etc
date_default_timezone_set('UTC');