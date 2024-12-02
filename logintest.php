<?php
// Konfigurasi koneksi database
$host = "192.168.1.100";  // Ganti dengan IP server PostgreSQL Anda
$port = "5433";           // Port PostgreSQL (ubah sesuai konfigurasi server)
$dbname = "Web-Ecommerce";    // Nama database
$dbUser = "postgres";     // Username database
$dbPassword = "456287"; // Password untuk koneksi database (untuk koneksi ke database)

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $loginPassword = $_POST["password"]; // Password yang dimasukkan di form

    try {
        // Membuat koneksi ke PostgreSQL
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $conn = new PDO($dsn, $dbUser, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query untuk memeriksa kredensial user
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($loginPassword, $user["password"])) {
            echo "Login berhasil! Selamat datang, " . htmlspecialchars($user["nama"]) . "!";
        } else {
            echo "Email atau password salah.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</body>
</html>
