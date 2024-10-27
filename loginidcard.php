<?php
header('Content-Type: text/html; charset=utf-8');

$host = 'localhost';
$dbname = 'card_users';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

$full_name = "";
$identification = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_card'])) {
        $id_card = $_POST['id_card'];

        $query = "SELECT * FROM `users_dusi` WHERE id_card = :id_card";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_card', $id_card);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $name_title = htmlspecialchars($result['name_title']);
            $name = htmlspecialchars($result['name']);
            $surname = htmlspecialchars($result['surname']);
            $identification = htmlspecialchars($result['identification']);

            // รวมชื่อ
            $full_name = $name_title . ' ' . $name . ' ' . $surname;
        } else {
            $full_name = "";
            $identification ="";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cssidcard/user.css">
    <title>Login</title>
</head>
<body>
    <div class="login-box">
        <div class="login-header">
            <header>DR.DUSI</header>
        </div>
        <div class="input-box">
                <input type="text" name="full_name" class="input-field" placeholder="Enter ... " autocomplete="off" required 
                        value="<?php echo htmlspecialchars($full_name); ?>">
                <input type="text" name="identification" class="input-field" placeholder="Enter ... " autocomplete="off" required 
                       value="<?php echo $identification; ?>">
            <form action="drtest/Home.html" method="POST">
                <div class="input-submit">
                <button type="submit" class="submit-btn" id="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
