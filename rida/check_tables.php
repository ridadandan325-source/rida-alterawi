<?php
include 'vendor/autoload.php';
$app = include 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$tables = DB::select('SHOW TABLES');
foreach ($tables as $table) {
    echo current((array) $table) . "\n";
}
