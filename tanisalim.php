<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanışalım</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
        }

        nav {
            background-color: #4caf50;
            color: white;
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

        .logo img {
            height: 50px;
            width: auto;
        }

        .container {
            max-width: 900px;
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

        .blog-post {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .blog-post h2 {
            color: #4caf50;
            font-size: 1.8rem;
        }

        .blog-post p {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
            text-align: justify;
        }

        footer {
            background-color: #4caf50;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!-- Üst Menü -->
    <nav>
        <div class="logo">
            <img src="images/logo.png" alt="Diyetisyen Otomasyonu Logo">
        </div>
        <ul>
            <li><a href="index.php">Ana Sayfa</a></li>
            <li><a href="tanisalim.php">Tanışalım</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="iletisim.php">İletişim</a></li>
        </ul>
    </nav>

    <!-- Tanışalım İçeriği -->
    <div class="container">
        <h1>Tanışalım</h1>

        <div class="blog-post">
            <h2>Merhaba!</h2>
            <p>
                Ben Uzman Diyetisyen Zehra Kutlugün. Sağlıklı beslenme ve yaşam tarzı değişiklikleri konusunda size rehberlik etmek için buradayım.
                Hedeflerinize ulaşmanız için kişiselleştirilmiş çözümler sunuyorum.
            </p>
        </div>

        <div class="blog-post">
            <h2>Hakkımızda</h2>
            <p>
                Beslenme, yaşam kalitemizi ve sağlığımızı etkileyen en önemli unsurlardan biridir. Kişiye özel diyet programları ve yaşam tarzı önerileriyle 
                sizi hedeflerinize ulaştırmak için çalışıyorum. Sağlıklı yaşam yolculuğunuzda yanınızdayım.
            </p>
        </div>

        <div class="blog-post">
            <h2>Uzmanlık Alanlarımız</h2>
            <p>
                <ul>
                    <li>Sağlıklı kilo yönetimi</li>
                    <li>Sporcu beslenmesi</li>
                    <li>Metabolik hastalıklarda beslenme</li>
                    <li>Çocuk ve ergen beslenmesi</li>
                    <li>Hamilelik ve emzirme dönemi beslenmesi</li>
                </ul>
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Diyetisyen Otomasyonu - Tüm Hakları Saklıdır.
    </footer>

</body>
</html>
