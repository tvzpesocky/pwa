<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Administracija vijesti</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Odjava</a></li>
        </ul>
    </nav>
    <main>
        <section>
            <h2>Sve vijesti</h2>
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

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['brisi'])) {
                    $id = $_POST['brisi'];
                
                    $sql = "DELETE FROM vijesti WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                
                    if ($stmt->affected_rows > 0) {
                        echo "Vijest je uspješno obrisana.";
                    } else {
                        echo "Došlo je do greške prilikom brisanja vijesti.";
                    }
                
                    $stmt->close();
                }
                
                
                $sql = "SELECT id, naslov, sadrzaj, kratki_sadrzaj, autor, slika_path, arhivirano FROM vijesti";
                $result = $conn->query($sql);
                
               
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div>";
                        echo "<h2>" . htmlspecialchars($row['naslov']) . "</h2>";
                        echo "<p>Autor: " . htmlspecialchars($row['autor']) . "</p>";
                        echo "<p>" . nl2br(htmlspecialchars($row['sadrzaj'])) . "</p>";
                        echo "<p>" . nl2br(htmlspecialchars($row['kratki_sadrzaj'])) . "</p>";
                
                        
                        if (!empty($row['slika'])) {
                            echo "<img src='" . htmlspecialchars($row['slika']) . "' alt='Slika vijesti'>";
                        }
                
                        
                        if ($row['arhivirano'] == 1) {
                            echo "<p><strong>Ova vijest je arhivirana.</strong></p>";
                        } else {
                            echo "<form action='' method='POST'>";
                            echo "<input type='hidden' name='brisi' value='" . htmlspecialchars($row['id']) . "'>";
                            echo "<input type='submit' value='Obriši'>";
                            echo "</form>";
                        }
                
                        echo "</div>";
                        echo "<hr>";
                    }
                } else {
                    echo "Nema unesenih vijesti.";
                }
                
                $conn->close();
                ?>
                <!DOCTYPE html>
                <html lang="hr">
                <head>
                    <meta charset="UTF-8">
                    <title>Administracija vijesti</title>
                    <link rel="stylesheet" href="style.css">
                </head>
                <body>
                    
                
                    
                
                    
                </body>
                </html>
            </div>
        </section>
        
    </main>
    <footer>
        <p>Ime i prezime autora: Ivan Horvat</p>
        <p>Kontakt e-mail: ivan.horvat@example.com</p>
        <p>Godina izrade: 2024</p>
    </footer>
</body>
</html>
