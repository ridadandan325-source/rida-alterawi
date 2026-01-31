<?php
include 'vendor/autoload.php';
$app = include 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$columns = Schema::getColumnListing('transactions');
echo "Transactions: " . implode(', ', $columns) . "\n";
$columns = Schema::getColumnListing('land_ownerships');
echo "Land Ownerships: " . implode(', ', $columns) . "\n";
