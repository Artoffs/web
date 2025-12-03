<?php

function getDbConnection(): PDO {
    $host = "localhost";
    $port = "5432";
    $dbname = 'testdb';  
    $user = 'postgres'; 
    $password = 'postgres'; 
    
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Ошибка подключения к БД: " . $e->getMessage());
    }
}
?>