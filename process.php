<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";  // MySQL kullanıcı adı
$password = "29062003"; // MySQL şifresi
$dbname = "dyt_oto"; // Veritabanı adı

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Kayıt işlemi
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Şifreyi güvenli şekilde hash'leme
    $role_id = $_POST['role_id'];

    $sql = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $password, $role_id);

    if ($stmt->execute()) {
        echo "Kayıt başarılı! Giriş yapılıyor...";
        header("Location: index.php");
        exit();
    } else {
        echo "Kayıt başarısız: " . $stmt->error;
    }
    $stmt->close();
}

// Giriş işlemi
if (isset($_POST['login'])) {
    session_start(); // Session başlat
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Kullanıcı bilgilerini session'a kaydet
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];

            // Hoş geldiniz mesajı ve yönlendirme
            echo "Giriş başarılı! Hoş geldiniz, " . $user['username'] . ". Yönlendiriliyorsunuz...";
            
            // Role göre yönlendirme
            if ($user['role_id'] == 2) {
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'dashboard.php';
                        }, 2000); // 2 saniye bekle
                      </script>";
            } elseif ($user['role_id'] == 3) {
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'client_dashboard.php';
                        }, 2000); // 2 saniye bekle
                      </script>";
            }
        } else {
            echo "Hatalı şifre.";
        }
    } else {
        echo "Kullanıcı bulunamadı.";
    }
    $stmt->close();
}

$conn->close();
?>
