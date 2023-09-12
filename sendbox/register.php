<?php
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

require '../db/pdo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form registrasi
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash kata sandi sebelum menyimpannya ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query untuk memasukkan data ke dalam tabel user
    $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            // Registrasi sukses, bisa tambahkan tindakan tambahan jika diperlukan
            header("Location: login.php?msg=registration_success");
            exit();
        } else {
            // Gagal memasukkan data ke database
            header("Location: register.php?msg=registration_error");
            exit();
        }
    } catch (PDOException $e) {
        // Handle kesalahan database
        header("Location: register.php?msg=database_error");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>
<body>
    <h1>Registrasi</h1>
    <?php
    // Menampilkan pesan kesalahan jika ada
    if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        if ($msg === "registration_error") {
            echo "<p>Registrasi gagal. Silakan coba lagi.</p>";
        } elseif ($msg === "database_error") {
            echo "<p>Kesalahan database. Silakan coba lagi.</p>";
        } elseif ($msg === "registration_success") {
            echo "<p>Registrasi berhasil. Silakan <a href='login.php'>masuk</a>.</p>";
        }
    }
    ?>

    <form method="POST" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
