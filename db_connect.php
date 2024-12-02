<?php
    // Database configuration
    $host = "localhost"; // IP server PostgreSQL 17
    $port = "5433";          // Port yang digunakan PostgreSQL 17
    $dbname = "Web-Ecommerce"; // Nama database
    $user = "postgres";      // Username PostgreSQL
    $password = "456287"; // Password PostgreSQL

    // Koneksi ke PostgreSQL 17
    try {
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Koneksi berhasil ke PostgreSQL 17!";
    } catch (PDOException $e) {
        echo "Koneksi gagal: " . $e->getMessage();
    }
?>
