<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Početna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Vijesti forum</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Početna</a></li>
            <li><a href="about.html">O meni</a></li>
            <li><a href="contact.html">Kontakt</a></li>
            <li><a href="unos.html">Unos novosti</a></li>
            <li><a href="kategorija.php?kategorija=Sport">Sport</a></li>
            <li><a href="kategorija.php?kategorija=Kultura">Kultura</a></li>
            <li><a href="administrator.php">Administrator</a></li>
            <li><a href="registracija.php">Registracija</a></li>
        </ul>
    </nav>
    <main>
        <section>
            <h2>Najnovije vijesti</h2>
            <div id="news">
            <?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "vijesti";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM vijesti WHERE arhivirano = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<hr>";
        echo "<div class='vijest'>";
        echo "<h3><a href='clanak.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["naslov"]) . "</a></h3>";
        echo "<p><strong>Kratki sadržaj:</strong> " . htmlspecialchars($row['sadrzaj']) . "</p>";
        echo "<p><strong>Autor:</strong> " . htmlspecialchars($row['autor']) . "</p>";
        echo "<p><strong>Kategorija:</strong> " . htmlspecialchars($row['kategorija']) . "</p>";
        echo "<p><strong>Sadržaj:</strong><br>" . nl2br(htmlspecialchars($row['sadrzaj'])) . "</p>";
        echo "</div>";
    }
} else {
    echo "Nema unesenih vijesti.";
}

$conn->close();
?>
            </div>
        </section>
    </main>
    
    <footer>
        <p>Ime i prezime autora: Valentin Pesocky</p>
        <p>Kontakt e-mail: valentin.pesocky@tvz.hr</p>
        <p>Godina izrade: 2024</p>
    </footer>
    
</body>
</html>

