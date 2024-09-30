<?php
$message = "";
$name = "";
$address = "";

$host = "127.0.0.1";
$port = "3307";
$username = "noelianyt";
$password = "Jkth1l4ng@D26";
$dbname = "mahasiswa_db";

$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $npm = htmlspecialchars($_POST['npm']);
    $name = strtoupper(htmlspecialchars($_POST['name']));
    $address = strtoupper(htmlspecialchars($_POST['address']));
    $birthplace = htmlspecialchars($_POST['birthplace']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    $gender = htmlspecialchars($_POST['gender']);
    $hobby = htmlspecialchars($_POST['hobby']);

    $stmt = $conn->prepare("INSERT INTO mahasiswa (npm, name, address, birthplace, birthdate, gender, hobby) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $npm, $name, $address, $birthplace, $birthdate, $gender, $hobby);

    if ($stmt->execute()) {
        $message = "Data berhasil disimpan!<br>
                    NPM: $npm<br>
                    Nama: $name<br>
                    Alamat: $address<br>
                    Tempat Lahir: $birthplace<br>
                    Tanggal Lahir: $birthdate<br>
                    Jenis Kelamin: $gender<br>
                    Hobi: $hobby";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data Mahasiswa</title>
    <link rel="stylesheet" href="myStyle.css">
</head>
<body>
    <h2>Form Input Data Mahasiswa</h2>
    <form action="" method="POST">
        <label for="npm">NPM:</label>
        <input type="text" id="npm" name="npm" required>

        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required>

        <label for="address">Alamat:</label>
        <input type="text" id="address" name="address" required>

        <label for="birthplace">Tempat Lahir:</label>
        <input type="text" id="birthplace" name="birthplace" required>

        <label for="birthdate">Tanggal Lahir:</label>
        <input type="date" id="birthdate" name="birthdate" required>

        <label for="gender">Jenis Kelamin:</label><br>
        <input type="radio" id="male" name="gender" value="Laki-laki" required>
        <label for="male">Laki-laki</label><br>
        <input type="radio" id="female" name="gender" value="Perempuan" required>
        <label for="female">Perempuan</label><br>

        <label for="hobby">Hobi:</label>
        <input type="text" id="hobby" name="hobby" required>

        <input type="submit" value="Kirim">
    </form>

    <?php if ($message): ?>
        <div class="message"><?= $message; ?></div>
    <?php endif; ?>
</body>
</html>