<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Veritabanına bağlan
    $servername = "localhost";
    $username = "root";
    $password = "29062003";
    $dbname = "dyt_oto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

    // İletişim mesajını ekle
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $successMessage = "Mesajınız başarıyla gönderildi.";
    } else {
        $errorMessage = "Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
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
    <title>İletişim</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        nav {
            background-color: #4caf50;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav ul li a:hover {
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

        h1 {
            text-align: center;
            color: #4caf50;
            margin-bottom: 20px;
        }

        p {
            margin: 15px 0;
            text-align: justify;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: 20px auto;
        }

        .form-container h2 {
            text-align: center;
            color: #4caf50;
            margin-bottom: 20px;
        }

        form .input-container {
            margin-bottom: 15px;
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form textarea {
            resize: none;
            height: 100px;
        }

        button {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: none;
            background-color: #4caf50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        footer {
            background-color: #4caf50;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Üst Menü -->
    <nav>
        <div>
            <img src="images/logo.png" alt="Logo" style="height: 50px;">
        </div>
        <ul>
            <li><a href="index.php">Ana Sayfa</a></li>
            <li><a href="tanisalim.php">Tanışalım</a></li>
            <li><a href="online-diyet.php">Online Diyet</a></li>
            <li><a href="iletisim.php">İletişim</a></li>
        </ul>
    </nav>

    <!-- İletişim Formu -->
    <div class="container">
        <h1>İletişim</h1>

        <?php if (!empty($successMessage)) { ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php } ?>

        <?php if (!empty($errorMessage)) { ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <div class="form-container">
            <h2>Bize Ulaşın</h2>
            <form method="POST" action="">
                <div class="input-container">
                    <input type="text" name="name" placeholder="Adınız" required>
                </div>
                <div class="input-container">
                    <input type="email" name="email" placeholder="E-posta Adresiniz" required>
                </div>
                <div class="input-container">
                    <textarea name="message" placeholder="Mesajınız" required></textarea>
                </div>
                <button type="submit">Gönder</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Diyetisyen Otomasyonu - Tüm Hakları Saklıdır.
    </footer>

</body>
</html>
