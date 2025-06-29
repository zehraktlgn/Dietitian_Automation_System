<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neler Yapıyoruz?</title>
    <style>
        /* Genel Stil */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Üst Menü */
        nav {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 50px;
            width: auto;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
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
            margin-bottom: 10px;
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

    <!-- İçerik -->
    <div class="container">
        <h1>Neler Yapıyoruz?</h1>

        <div class="blog-post">
            <h2>📡 Online Diyet</h2>
            <p>
                İstediğiniz zaman, istediğiniz yerden diyet programınıza ulaşabilirsiniz. Bu hizmet, zaman ve mekandan bağımsız olarak 
                sağlıklı beslenme hedeflerinize ulaşmanızı sağlar.
            </p>
        </div>

        <div class="blog-post">
            <h2>📝 Kişiye Özel Diyet Planları</h2>
            <p>
                Her bireyin ihtiyaçları farklıdır, bu yüzden kişiselleştirilmiş çözümler sunuyoruz. Size özel beslenme programları ile 
                sağlıklı yaşam yolculuğunuzda yanınızdayız.
            </p>
        </div>

        <div class="blog-post">
            <h2>📊 Diyet Takibi</h2>
            <p>
                Sadece bir diyet listesi vermekle kalmıyoruz, aynı zamanda hedeflerinize ulaşmanız için sürekli takip ve destek sağlıyoruz. 
                Böylece, motivasyonunuzu kaybetmeden ilerleyebilirsiniz.
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Diyetisyen Otomasyonu - Tüm Hakları Saklıdır.
    </footer>

</body>
</html>
