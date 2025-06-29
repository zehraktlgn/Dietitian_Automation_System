<?php
session_start();

// Kullanıcının giriş yapıp yapmadığını kontrol et
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

// Danışanın notlarını almak için SQL sorgusu
$sql = "SELECT note, created_at FROM daily_notes WHERE client_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Günlük Notlarım</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        .note-item {
            margin-bottom: 15px;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .note-item:last-child {
            margin-bottom: 0;
        }
        .note-text {
            color: #555;
            font-size: 1rem;
        }
        .note-date {
            font-size: 0.8rem;
            color: #999;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Günlük Notlarım</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="note-item">
                    <p class="note-text"><?php echo htmlspecialchars($row['note']); ?></p>
                    <p class="note-date"><?php echo date("d M Y H:i", strtotime($row['created_at'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Henüz bir not eklenmemiş.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
