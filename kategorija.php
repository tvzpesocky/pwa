<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Vijesti po kategoriji</h1>
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
            <h2>Vijesti po kategoriji: <?php echo htmlspecialchars($_GET['kategorija']); ?></h2>
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

                $kategorija = $conn->real_escape_string($_GET['kategorija']);
                $sql = "SELECT id, naslov, sadrzaj, autor, datum FROM vijesti WHERE kategorija='$kategorija' AND arhivirano=0 ORDER BY datum DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<article>";
                        echo "<h3><a href='clanak.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["naslov"]) . "</a></h3>";
                        echo "<p>" . nl2br(htmlspecialchars($row["sadrzaj"])) . "</p>";
                        echo "<p><strong>Autor:</strong> " . htmlspecialchars($row["autor"]) . "</p>";
                        echo "<p><strong>Datum:</strong> " . $row["datum"] . "</p>";
                        echo "</article>";
                    }
                } else {
                    echo "<p>Nema vijesti u ovoj kategoriji.</p>";
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