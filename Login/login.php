<?php
// Konfigurasi database
$host = "192.168.1.100"; // Ganti dengan IP server PostgreSQL Anda
$port = "5433";          // Port PostgreSQL (ubah sesuai konfigurasi server)
$dbname = "Web-Ecommerce"; // Nama database
$dbUser = "postgres";    // Username database
$dbPassword = "456287";  // Password untuk koneksi database

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    try {
        // Koneksi ke PostgreSQL
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $dbUser, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Periksa kredensial user
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([":email" => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $message = "Login berhasil! Selamat datang, " . htmlspecialchars($user["nama"]) . "!";
        } else {
            $message = "Username atau password salah.";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/Login/login.css">
</head>
<body>
<div class="login-wrapper">
  <!--Front-->
  <div class="login-card">
    <div class="login-inner">
      <div class="login-header">
        <h3>Sign In</h3>
        <p>to get complete access</p>
        <div class="login-card-title">
          <i class="fas fa-ellipsis-h"></i>
        </div>
      </div>
      <form method="POST" action="">
        <div class="login-group">
          <input type="text" name="username" class="login-control" placeholder="Email" required>
        </div>
        <div class="login-group">
          <input type="password" name="password" class="login-control" placeholder="password" required>
        </div>
        <div class="login-btn-group">
          <p>
            <a href="">Forgotten password?</a>
          </p>
          <div class="login-group">
            <button type="submit" class="_btn">
              <i class="fas fa-sign-in-alt"></i> Login</button>
          </div>
        </div>
      </form>
      <div class="login-footer">
        <p>Don't have account?
          <span>
            <a href="/Register/register.php">click here..</a>
          </span>
        </p>
      </div>
      <!-- Menampilkan pesan -->
      <?php if ($message): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($message); ?></p>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
