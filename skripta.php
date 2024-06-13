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
    $naslov = $conn->real_escape_string($_POST['naslov']);
    $kratki_sadrzaj = $conn->real_escape_string($_POST['kratki_sadrzaj']);
    $sadrzaj = $conn->real_escape_string($_POST['sadrzaj']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $kategorija = $conn->real_escape_string($_POST['kategorija']);
    $arhivirano = isset($_POST['arhivirano']) ? 1 : 0;

    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["slika_path"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["slika_path"]["tmp_name"]);
        if($check !== false) {
            echo "Datoteka je slika - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Datoteka nije slika.";
            $uploadOk = 0;
        }
    }

    if (move_uploaded_file($_FILES["slika_path"]["tmp_name"], $target_file)) {
        echo "Datoteka ". htmlspecialchars( basename( $_FILES["slika"]["name"])). " je uspješno pohranjena.";
        
       
        $sql = "INSERT INTO vijesti (naslov, kratki_sadrzaj, sadrzaj, autor, kategorija, arhivirano, slika_path) 
                VALUES ('$naslov', '$kratki_sadrzaj', '$sadrzaj', '$autor', '$kategorija', '$arhivirano', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Pogreška s učitavanjem.";
    }
} else {
    echo "Forma nije ispravno popunjena.";
}

$conn->close();
?>