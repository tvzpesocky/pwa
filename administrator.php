<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "vijesti";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];

    
    $stmt = $conn->prepare("SELECT id, korisnicko_ime, lozinka, admin FROM korisnik WHERE korisnicko_ime = ?");
    $stmt->bind_param("s", $korisnicko_ime);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashed_password, $admin);
        $stmt->fetch();

        
        if (password_verify($lozinka, $hashed_password)) {
            $_SESSION['korisnik_id'] = $id;
            $_SESSION['korisnicko_ime'] = $username;
            $_SESSION['admin'] = $admin;

            if ($admin == 1) {
                header('Location: administracija.php');
                exit();
            } else {
                echo "Pozdrav, $username. Nemate prava za pristup administracijskoj stranici.";
            }
        } else {
            echo "Neispravno korisničko ime ili lozinka.";
        }
    } else {
        echo "Korisnik nije pronađen. <a href='registracija.php'>Registrirajte se</a>.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Administracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Administracija</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="korisnicko_ime">Korisničko ime:</label>
        <input type="text" id="korisnicko_ime" name="korisnicko_ime" required><br><br>

        <label for="lozinka">Lozinka:</label>
        <input type="password" id="lozinka" name="lozinka" required><br><br>

        <input type="submit" value="Prijavi se">
    </form>
</body>
</html>