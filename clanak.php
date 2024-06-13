<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Članak</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Pojedinačni članak</h1>
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
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "vijesti";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $article_id = $_GET['id'];
            $sql = "SELECT naslov, sadrzaj, autor, kategorija, datum ,slika_path FROM vijesti WHERE id='$article_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<article>";
                echo "<h2>" . htmlspecialchars($row["naslov"]) . "</h2>";
                echo "<p>" . nl2br(htmlspecialchars($row["sadrzaj"])) . "</p>";
                echo "<p><strong>Autor:</strong> " . htmlspecialchars($row["autor"]) . "</p>";
                echo "<p><strong>Kategorija:</strong> " . htmlspecialchars($row["kategorija"]) . "</p>";
                echo "<p><strong>Datum:</strong> " . $row["datum"] . "</p>";
                echo "</article>";
                echo "<img src='" . htmlspecialchars($row['slika_path']) . "' alt='Slika vijesti'>";
            } else {
                echo "<p>Članak nije pronađen.</p>";
            }

            $conn->close();
            ?>
        </section>
    </main>
    
    <footer>
        <p>Ime i prezime autora: Valentin Pesocky</p>
        <p>Kontakt e-mail: valentin.pesocky@tvz.hr</p>
        <p>Godina izrade: 2024</p>
    </footer>
    
</body>
</html>