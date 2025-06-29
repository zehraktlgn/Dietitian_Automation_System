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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $sql = "INSERT INTO dietitian_reviews (user_id, rating, review) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user_id, $rating, $review);

    if ($stmt->execute()) {
        $message = "Değerlendirmeniz başarıyla kaydedildi.";
    } else {
        $message = "Bir hata oluştu. Lütfen tekrar deneyin.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diyetisyeni Değerlendir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #A5D6A7;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-bottom: 20px;
            color: #4CAF50;
        }

        .message {
            background-color: #e8f5e9;
            color: #4CAF50;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 1rem;
        }

        .message.error {
            background-color: #fce4ec;
            color: #d32f2f;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        form select, form textarea, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 1rem;
            cursor: pointer;
        }

        form button:hover {
            background-color: #FF9800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Diyetisyeni Değerlendir</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'hata') !== false ? 'error' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="rating">Puan:</label>
            <select name="rating" id="rating" required>
                <option value="1">1 - Kötü</option>
                <option value="2">2 - Orta</option>
                <option value="3">3 - İyi</option>
                <option value="4">4 - Çok İyi</option>
                <option value="5">5 - Mükemmel</option>
            </select>

            <label for="review">Yorum:</label>
            <textarea name="review" id="review" rows="5" placeholder="Yorumunuzu yazın" required></textarea>

            <button type="submit">Değerlendirmeyi Kaydet</button>
        </form>
    </div>
</body>
</html>
