<?php
    // Database configuration
    $host = "192.168.1.100";
    $dbname = "Web-Ecommerce";
    $dbUser = "postgres";
    $dbPassword = "456287";  // Password untuk koneksi database
    $port = "5433";  // Port PostgreSQL

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST["nama"];
        $email = $_POST["email"];
        $formPassword = $_POST["password"];  // Ambil password dari form
        $hashedPassword = password_hash($formPassword, PASSWORD_DEFAULT);  // Hash the password for storage
        $nomor_telepon = $_POST["nomor_telepon"];
        $alamat = $_POST["alamat"];
        $role = $_POST["role"];

        try {
            // Connect to PostgreSQL
            $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $dbUser, $dbPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert user data into users table
            $sql = "INSERT INTO users (nama, email, password, nomor_telepon, alamat, role) 
                    VALUES (:nama, :email, :password, :nomor_telepon, :alamat, :role)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":nama" => $nama,
                ":email" => $email,
                ":password" => $hashedPassword,  // Store hashed password
                ":nomor_telepon" => $nomor_telepon,
                ":alamat" => $alamat,
                ":role" => $role
            ]);

            echo "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
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
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <label>Nomor Telepon:</label><br>
        <input type="text" name="nomor_telepon"><br>
        <label>Alamat:</label><br>
        <textarea name="alamat"></textarea><br>
        <label>Role:</label><br>
        <select name="role" required>
            <option value="Penjual">Penjual</option>
            <option value="Pembeli">Pembeli</option>
        </select><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
