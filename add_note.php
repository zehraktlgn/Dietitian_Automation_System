<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "29062003";
    $dbname = "dyt_oto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

    $client_id = $_POST['client_id'];
    $note = $_POST['note'];

    $sql = "INSERT INTO daily_notes (client_id, note) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $client_id, $note);

    if ($stmt->execute()) {
        echo "Not başarıyla eklendi!";
    } else {
        echo "Hata: Not eklenemedi.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not Ekle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fffacd;
            background-size: cover;
        }

        header {
            background-color: #4CAF50;
            padding: 10px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 15px;
        }

        header nav ul li {
            display: inline;
        }

        header nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        header nav ul li a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 500px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.99); 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #d65a31;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Diyetisyen Paneli</div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Anasayfa</a></li>
                <li><a href="client_details.php">Detayları Gör</a></li>
                <li><a href="add_menu.php">Menü Ekle</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Not Ekle</h2>
        <form method="POST" action="">
            <input type="hidden" name="client_id" value="<?php echo $_GET['client_id']; ?>">
            <textarea name="note" rows="5" placeholder="Notunuzu buraya yazın..." required></textarea>
            <button type="submit">Not Ekle</button>
        </form>
    </div>
</body>
</html>
