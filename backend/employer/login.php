<?php
require_once '/../db.php'; // Include database connection

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        try {
            $pdo = (new Database())->getConnection();
            $stmt = $pdo->prepare("SELECT employer_id, password_hash FROM employers WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password_hash"])) {
                session_start();
                $_SESSION["employer_id"] = $user["employer_id"];
                $_SESSION["loggedin"] = true;

                header("Location: employer_dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .login-container {
            display: flex;
            height: 100vh;
        }
        .left-section {
            width: 50%;
            background: url('images/login-banner.jpg') no-repeat center center;
            background-size: cover;
        }
        .right-section {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="left-section"></div>
        <div class="right-section">
            <div class="w-50">
                <h2 class="text-center">Employer Login</h2>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>
                <form action="employer_login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
