<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uzman Diyetisyen - Giriş</title>
    <style>
        /* Genel Stil */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('images/resim.png') no-repeat center center fixed;
            background-size: cover;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            height: 40px;
            width: auto;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            margin-left: 15px;
        }

        .navbar ul li a {
            text-decoration: none;
            font-size: 1rem;
            color: #333;
            transition: color 0.3s;
        }

        .navbar ul li a:hover {
            color: #d65a31;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
            text-align: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 100%;
            max-width: 400px;
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }

        .input-container {
            margin-bottom: 15px;
        }

        .input-container input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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

        p {
            margin-top: 10px;
            font-size: 0.9rem;
        }

        a {
            color: #2196F3;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Üst Menü -->
    <header class="main-header">
        <div class="logo">
            <img src="images/logo.png" alt="Diyetisyen Otomasyon Logo">
        </div>
        <nav class="navbar">
            <ul>
                <li><a href="#home">Ana Sayfa</a></li>
                <li><a href="tanisalim.php">Tanışalım</a></li>
                <li><a href="neler_yapiyoruz.php">Neler Yapıyoruz</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="iletisim.php">İletişim</a></li>
                <li><a href="degerlendirmeler.php">Değerlendirmeler</a></li>
            </ul>
        </nav>
    </header>

    <!-- İçerik -->
    <div class="content">
        <!-- Login Form -->
        <div class="container login-form">
            <form action="process.php" method="POST">
                <h2>Kullanıcı Girişi</h2>
                <div class="input-container">
                    <input type="email" name="email" placeholder="E-posta" required>
                </div>
                <div class="input-container">
                    <input type="password" name="password" placeholder="Şifre" required>
                </div>
                <button type="submit" name="login">Giriş Yap</button>
                <p>Hesabın yok mu? <a href="#" id="register-link">Kaydol</a></p>
            </form>
        </div>

        <!-- Register Form -->
        <div class="container register-form" style="display: none;">
            <form action="process.php" method="POST">
                <h2>Kayıt Ol</h2>
                <div class="input-container">
                    <input type="text" name="username" placeholder="Kullanıcı Adı" required>
                </div>
                <div class="input-container">
                    <input type="email" name="email" placeholder="E-posta" required>
                </div>
                <div class="input-container">
                    <input type="password" name="password" placeholder="Şifre" required>
                </div>

                <!-- Danışan rolü gizli bir alanla ayarlanıyor -->
                <input type="hidden" name="role_id" value="3">

                <button type="submit" name="register">Kayıt Ol ve Giriş Yap</button>
                <p>Zaten bir hesabın var mı? <a href="#" id="login-link">Giriş Yap</a></p>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('register-link').addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector('.login-form').style.display = 'none';
            document.querySelector('.register-form').style.display = 'block';
        });

        document.getElementById('login-link').addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector('.register-form').style.display = 'none';
            document.querySelector('.login-form').style.display = 'block';
        });
    </script>

    <?php
    // Veritabanı bağlantısı
    $servername = "localhost";
    $username = "root";
    $password = "29062003";
    $dbname = "dyt_oto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

    // Diyetisyen varsayılan olarak ekleniyor
    $defaultDietitianEmail = "zehrakutlugun@gmail.com";

    // Diyetisyenin var olup olmadığını kontrol et
    $checkSql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $defaultDietitianEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $hashedPassword = password_hash("zehra2906", PASSWORD_BCRYPT);
        $insertSql = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, 2)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("sss", $username, $defaultDietitianEmail, $hashedPassword);
        $username = "Diyetisyen Zehra Kutlugün";
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
