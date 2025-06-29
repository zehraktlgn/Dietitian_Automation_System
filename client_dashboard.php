<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: index.php");
    exit();
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "29062003";
$dbname = "dyt_oto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_info'])) {
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $age = $_POST['age'];
    $target_weight = $_POST['target_weight'];

    // Kullanıcıyı kontrol et
    $checkSql = "SELECT id FROM clients WHERE user_id = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Kullanıcı varsa, güncelle
        $updateSql = "UPDATE clients SET weight = ?, height = ?, age = ?, target_weight = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ddidi", $weight, $height, $age, $target_weight, $user_id);
    } else {
        // Kullanıcı yoksa, ekle
        $insertSql = "INSERT INTO clients (user_id, weight, height, age, target_weight) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("iddid", $user_id, $weight, $height, $age, $target_weight);
    }

    if ($stmt->execute()) {
        $message = "Bilgiler başarıyla kaydedildi.";
    } else {
        $message = "Bir hata oluştu. Lütfen tekrar deneyin.";
    }

    $stmt->close();
}

$conn->close();
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php"); // Ana sayfaya yönlendir
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danışan Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Genel stil kodları */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #FFD580, #A5D6A7);
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            position: sticky;
            top: 0;
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        header .logout-form {
            margin: 0;
        }

        header .logout-button {
            background: white;
            color: #4CAF50;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        header .logout-button:hover {
            background-color: #E57373;
            color: white;
        }

        .container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            margin: 40px auto;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }

        form input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #f9f9f9;
        }

        form button {
            padding: 15px;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #FF9800;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .menu-button, .review-button {
            background-color: #FF9800;
            color: white;
            border: none;
            padding: 15px 20px;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            width: 65%;
            transition: background-color 0.3s;
        }

        .menu-button:hover, .review-button:hover {
            background-color: #A5D6A7;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Danışan Paneli</div>
        <form method="POST" class="logout-form">
            <button type="submit" name="logout" class="logout-button">Çıkış Yap</button>
        </form>
    </header>

    <div class="container">
        <h2>Hoş Geldiniz, <?php echo $_SESSION['username']; ?>!</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'hata') !== false ? 'error' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label for="weight">Kilo (kg):</label>
            <input type="number" name="weight" id="weight" step="0.1" placeholder="Mevcut kilonuz" required>

            <label for="height">Boy (cm):</label>
            <input type="number" name="height" id="height" step="0.1" placeholder="Boyunuz" required>

            <label for="age">Yaş:</label>
            <input type="number" name="age" id="age" placeholder="Yaşınız" required>

            <label for="target_weight">Hedef Kilo (kg):</label>
            <input type="number" name="target_weight" id="target_weight" step="0.1" placeholder="Hedef kilonuz" required>

            <button type="submit" name="update_info">Bilgileri Kaydet</button>
        </form>

        <div class="button-container">
            <form method="GET" action="menu.php">
                <button type="submit" class="menu-button">Menümü Gör</button>
            </form>

            <form method="GET" action="daily_notes.php">
                <button type="submit" class="review-button">Günlük Notumu Gör</button>
            </form>

            <form method="GET" action="rate_dietitian.php">
                <button type="submit" class="review-button">Diyetisyeni Değerlendir</button>
            </form>
        </div>
    </div>
</body>
</html>

