<?php
require __DIR__ . '/config.php';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO(
        'mysql:host=' . APP_CONFIG['db']['host'] . ';dbname=' . APP_CONFIG['db']['name'] . ';charset=' . APP_CONFIG['db']['charset'],
        APP_CONFIG['db']['user'],
        APP_CONFIG['db']['pass'],
        $options
    );
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}
