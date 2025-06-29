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

$client_id = $_GET['client_id'];

// Günlük menüyü getir
$sql = "SELECT mp.meal_date, mp.breakfast, mp.lunch, mp.dinner, mt.breakfast_done, mt.lunch_done, mt.dinner_done
        FROM meal_plans mp
        LEFT JOIN meal_tracking mt ON mp.id = mt.meal_plan_id
        WHERE mp.client_id = ? AND mp.meal_date = CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danışan Detayları</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fffacd;
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
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            color: #4CAF50;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background: #4CAF50;
            color: white;
        }

        table td {
            background: #f9f9f9;
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
                <li><a href="add_note.php">Not Ekle</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Danışan Günlük Menü Detayları</h2>
        <?php if ($menu): ?>
            <table>
                <tr>
                    <th>Tarih</th>
                    <td><?php echo htmlspecialchars($menu['meal_date']); ?></td>
                </tr>
                <tr>
                    <th>Kahvaltı</th>
                    <td><?php echo htmlspecialchars($menu['breakfast']); ?></td>
                </tr>
                <tr>
                    <th>Öğle Yemeği</th>
                    <td><?php echo htmlspecialchars($menu['lunch']); ?></td>
                </tr>
                <tr>
                    <th>Akşam Yemeği</th>
                    <td><?php echo htmlspecialchars($menu['dinner']); ?></td>
                </tr>
                <tr>
                    <th>Kahvaltı Durumu</th>
                    <td><?php echo $menu['breakfast_done'] ? "Tamamlandı" : "Eksik"; ?></td>
                </tr>
                <tr>
                    <th>Öğle Yemeği Durumu</th>
                    <td><?php echo $menu['lunch_done'] ? "Tamamlandı" : "Eksik"; ?></td>
                </tr>
                <tr>
                    <th>Akşam Yemeği Durumu</th>
                    <td><?php echo $menu['dinner_done'] ? "Tamamlandı" : "Eksik"; ?></td>
                </tr>
            </table>
        <?php else: ?>
            <p>Bugün için bir menü bulunamadı.</p>
        <?php endif; ?>
    </div>
</body>
</html>
