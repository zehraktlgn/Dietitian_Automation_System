<?php
session_start();

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "29062003";
$dbname = "dyt_oto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Değerlendirmeleri al
$sql = "SELECT u.username, r.rating, r.review, r.review_date 
        FROM dietitian_reviews r 
        JOIN users u ON r.user_id = u.id 
        ORDER BY r.review_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Değerlendirmeler</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
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

        .review-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .username {
            font-weight: bold;
            color: #333;
        }

        .rating {
            color: #FFD700;
            font-size: 1.2rem;
        }

        .review-text {
            margin: 10px 0;
            color: #555;
        }

        .date {
            font-size: 0.8rem;
            color: #999;
        }

        .login-section {
            text-align: center;
            margin-top: 20px;
        }

        .login-section button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-section button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">Diyetisyen Otomasyonu</div>
        <nav>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="tanisalim.php">Tanışalım</a></li>
                <li><a href="neler_yapiyoruz.php">Neler Yapıyoruz</a></li>
                <li><a href="iletisim.php">İletişim</a></li>
            </ul>
        </nav>
    </header>

    <!-- Değerlendirme İçeriği -->
    <div class="container">
        <h2>Değerlendirmeler</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="review-item">
                    <span class="username"><?php echo htmlspecialchars($row['username']); ?></span>
                    <span class="rating"><?php echo str_repeat('★', $row['rating']); ?></span>
                    <p class="review-text"><?php echo htmlspecialchars($row['review']); ?></p>
                    <span class="date"><?php echo date("d M Y", strtotime($row['review_date'])); ?></span>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Henüz değerlendirme yapılmamış.</p>
        <?php endif; ?>

        <div class="login-section">
            <button onclick="window.location.href='index.php';">Yorum Yapmak için Giriş Yap</button>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>


<?php
$conn->close();
?>
