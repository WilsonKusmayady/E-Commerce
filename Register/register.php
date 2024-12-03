<?php
// Konfigurasi database
$host = "192.168.1.100";  // Ganti dengan IP server PostgreSQL Anda
$port = "5433";           // Port PostgreSQL (ubah sesuai konfigurasi server)
$dbname = "Web-Ecommerce"; // Nama database
$dbUser = "postgres";     // Username database
$dbPassword = "456287";   // Password untuk koneksi database

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $address = $_POST["address"] ?? "";
    $role = $_POST["role"] ?? "";

    // Ubah nilai role jika perlu
    if ($role === "buyer") {
        $role = "Pembeli";
    } elseif ($role === "seller") {
        $role = "Penjual";
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $dbUser, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO users (nama, email, password, nomor_telepon, alamat, role) 
                VALUES (:name, :email, :password, :phone, :address, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":password" => $hashedPassword,
            ":phone" => $phone,
            ":address" => $address,
            ":role" => $role
        ]);

        // Tampilkan pesan sukses
        echo "Registrasi berhasil";
        exit; // Pastikan tidak ada output tambahan
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
    <title>Register</title>
    <link rel="stylesheet" href="/Register/register.css">
</head>
<body>
<div class="register-wrapper">
  <!-- Register Card -->
  <div class="register-card">
    <div class="register-inner">
      <div class="register-header">
        <h3>Register</h3>
        <div class="login-footer">
        <p>Create your account Already have?
          <span>
            <a href="/Login/login.php">click here..</a>
          </span>
        </p>
      </div>
      </div>
      <form method="POST" action="">
        <div class="register-group">
          <input type="text" name="name" class="register-control" placeholder="Name" required>
        </div>
        <div class="register-group">
          <input type="email" name="email" class="register-control" placeholder="Email" required>
        </div>
        <div class="register-group">
          <input type="password" name="password" class="register-control" placeholder="Password" required>
        </div>
        <div class="register-group">
          <input type="tel" name="phone" class="register-control" placeholder="Phone Number">
        </div>
        <div class="register-group">
          <textarea name="address" class="register-control" placeholder="Address"></textarea>
        </div>
        <div class="register-group">
          <select name="role" class="register-control" required>
            <option value="" disabled selected>Select Role</option>
            <option value="Penjual">Penjual</option>
            <option value="Pembeli">Pembeli</option>
          </select>
        </div>
        <div class="register-btn-group">
          <button type="submit" class="_btn">
            <i class="fas fa-user-plus"></i> Register
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
