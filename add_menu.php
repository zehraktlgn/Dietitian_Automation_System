<?php
session_start();

// Veritabanı bağlantısını başlat
$servername = "localhost";
$username = "root";
$password = "29062003";
$dbname = "dyt_oto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

$message = "";

// POST isteği kontrolü
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $breakfast = $_POST['breakfast'];
    $lunch = $_POST['lunch'];
    $dinner = $_POST['dinner'];

    // Menü verilerini veritabanına eklemek için SQL sorgusu
    $sql = "INSERT INTO meal_plans (client_id, meal_date, breakfast, lunch, dinner) VALUES (?, CURDATE(), ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $client_id, $breakfast, $lunch, $dinner);

    // Sorgunun başarılı olup olmadığını kontrol et
    if ($stmt->execute()) {
        $message = "Menü başarıyla eklendi!";
    } else {
        $message = "Hata: Menü eklenemedi.";
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
    <title>Menü Ekle</title>
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

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
        }

        .success {
            background-color: #e8f5e9;
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }

        .error {
            background-color: #fce4ec;
            color: #d32f2f;
            border: 1px solid #d32f2f;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
        }

        form input {
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
                <li><a href="add_note.php">Not Ekle</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Danışana Menü Ekle</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'Hata') === false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($_GET['client_id']); ?>">
            
            <label for="breakfast">Kahvaltı:</label>
            <input type="text" name="breakfast" id="breakfast" placeholder="Kahvaltı öğesi ekleyin" required>

            <label for="lunch">Öğle Yemeği:</label>
            <input type="text" name="lunch" id="lunch" placeholder="Öğle yemeği öğesi ekleyin" required>

            <label for="dinner">Akşam Yemeği:</label>
            <input type="text" name="dinner" id="dinner" placeholder="Akşam yemeği öğesi ekleyin" required>

            <button type="submit">Menü Ekle</button>
        </form>
    </div>
</body>
</html>
