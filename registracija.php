<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "vijesti";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnicko_ime = $conn->real_escape_string($_POST['korisnicko_ime']);
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_DEFAULT); 
    $admin = isset($_POST['admin']) ? 1 : 0;

    
    $sql = "INSERT INTO korisnik (korisnicko_ime, lozinka, admin) 
            VALUES ('$korisnicko_ime', '$lozinka', '$admin')";

    if ($conn->query($sql) === TRUE) {
        echo "Korisnik uspješno registriran.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Registracija korisnika</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="korisnicko_ime">Korisničko ime:</label>
        <input type="text" id="korisnicko_ime" name="korisnicko_ime" required><br><br>

        <label for="lozinka">Lozinka:</label>
        <input type="password" id="lozinka" name="lozinka" required><br><br>

        <label for="admin">Administrator:</label>
        <input type="checkbox" id="admin" name="admin" value="1"><br><br>

        <input type="submit" value="Registriraj se">
    </form>
</body>
</html>