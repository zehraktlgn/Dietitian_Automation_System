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

// Tüm danışanları getir
$sql = "SELECT c.user_id as client_id, c.weight, c.height, c.age, c.target_weight, u.username
        FROM clients c
        JOIN users u ON c.user_id = u.id
        WHERE u.role_id = 3"; // Danışanlar için role_id = 3
$result = $conn->query($sql);

// Logout işlemi
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
    <title>Diyetisyen Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #dfffcc;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
        }
        .header h1 {
            font-size: 1.5rem;
        }
        .header form {
            margin: 0;
        }
        .header button {
            background: white;
            color: #4CAF50;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
        }
        .header button:hover {
            background: #45a049;
            color: white;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
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
        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Diyetisyen Paneli</h1>
        <form method="POST">
            <button type="submit" name="logout">Çıkış Yap</button>
        </form>
    </div>

    <div class="container">
        <h2>Danışanlarım</h2>
        <table>
            <thead>
                <tr>
                    <th>Danışan Adı</th>
                    <th>Kilo</th>
                    <th>Boy</th>
                    <th>Yaş</th>
                    <th>Hedef Kilo</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($client = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $client['username'] . "</td>";
                        echo "<td>" . $client['weight'] . "</td>";
                        echo "<td>" . $client['height'] . "</td>";
                        echo "<td>" . $client['age'] . "</td>";
                        echo "<td>" . $client['target_weight'] . "</td>";
                        echo "<td>
                                <div class='action-buttons'>
                                    <form method='GET' action='client_details.php'>
                                        <input type='hidden' name='client_id' value='" . $client['client_id'] . "'>
                                        <button type='submit'>Detayları Gör</button>
                                    </form>
                                    <form method='GET' action='add_menu.php'>
                                        <input type='hidden' name='client_id' value='" . $client['client_id'] . "'>
                                        <button type='submit'>Menü Ekle</button>
                                    </form>
                                    <form method='GET' action='add_note.php'>
                                        <input type='hidden' name='client_id' value='" . $client['client_id'] . "'>
                                        <button type='submit'>Not Ekle</button>
                                    </form>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Danışan bulunamadı.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
