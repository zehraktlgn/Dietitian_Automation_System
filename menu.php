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

// Günlük menüyü getir
$menuSql = "SELECT mp.id as meal_plan_id, mp.meal_date, mp.breakfast, mp.lunch, mp.dinner, 
            COALESCE(mt.breakfast_done, 0) as breakfast_done, 
            COALESCE(mt.lunch_done, 0) as lunch_done, 
            COALESCE(mt.dinner_done, 0) as dinner_done
            FROM meal_plans mp
            LEFT JOIN meal_tracking mt ON mp.id = mt.meal_plan_id
            JOIN clients c ON mp.client_id = c.user_id
            WHERE c.user_id = ? AND mp.meal_date = CURDATE()";
$stmt = $conn->prepare($menuSql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$menuResult = $stmt->get_result();
$menu = $menuResult->fetch_assoc();

// Yemek durumu güncellemesi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meal_plan_id = $_POST['meal_plan_id'];
    $breakfast_done = isset($_POST['breakfast_done']) ? 1 : 0;
    $lunch_done = isset($_POST['lunch_done']) ? 1 : 0;
    $dinner_done = isset($_POST['dinner_done']) ? 1 : 0;

    $checkSql = "SELECT id FROM meal_tracking WHERE meal_plan_id = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("i", $meal_plan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Eğer veritabanında zaten bu menü için takip verisi varsa güncelle
        $updateSql = "UPDATE meal_tracking SET breakfast_done = ?, lunch_done = ?, dinner_done = ? WHERE meal_plan_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("iiii", $breakfast_done, $lunch_done, $dinner_done, $meal_plan_id);
    } else {
        // Yoksa yeni bir veri ekle
        $insertSql = "INSERT INTO meal_tracking (meal_plan_id, breakfast_done, lunch_done, dinner_done) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("iiii", $meal_plan_id, $breakfast_done, $lunch_done, $dinner_done);
    }

    if ($stmt->execute()) {
        echo "Yemek durumu başarıyla güncellendi.";
    } else {
        echo "Hata: Yemek durumu güncellenemedi.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Günlük Menü</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #fffacd;
            background-size: cover;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            color: #4CAF50;
            margin-bottom: 20px;
            text-align: center;
        }

        .menu-item {
            background-color: #f4f4f4;
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .menu-item h3 {
            color: #4CAF50;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .menu-item p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #d65a31;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Günlük Menü</h2>

        <?php if ($menu): ?>
            <form method="POST">
                <input type="hidden" name="meal_plan_id" value="<?php echo $menu['meal_plan_id']; ?>">

                <div class="menu-item">
                    <h3>Kahvaltı</h3>
                    <p><?php echo $menu['breakfast']; ?></p>
                    <label>
                        <input type="checkbox" name="breakfast_done" <?php echo $menu['breakfast_done'] ? 'checked' : ''; ?>>
                        Yapıldı
                    </label>
                </div>

                <div class="menu-item">
                    <h3>Öğle Yemeği</h3>
                    <p><?php echo $menu['lunch']; ?></p>
                    <label>
                        <input type="checkbox" name="lunch_done" <?php echo $menu['lunch_done'] ? 'checked' : ''; ?>>
                        Yapıldı
                    </label>
                </div>

                <div class="menu-item">
                    <h3>Akşam Yemeği</h3>
                    <p><?php echo $menu['dinner']; ?></p>
                    <label>
                        <input type="checkbox" name="dinner_done" <?php echo $menu['dinner_done'] ? 'checked' : ''; ?>>
                        Yapıldı
                    </label>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn">Durumu Güncelle</button>
                </div>
            </form>
        <?php else: ?>
            <p>Bugün için menü bulunmamaktadır.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>
