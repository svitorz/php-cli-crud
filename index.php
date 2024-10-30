<?php


$string_connection = "pgsql:postgresql://localhost:5432/php-crud";

try {
    $conn = new PDO(
        $string_connection,
        'vitor',
        'postdba'
    );
    echo "rodou";
} catch (Exception $e) {
    echo $e->getMessage();
}
