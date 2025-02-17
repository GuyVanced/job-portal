<?php
require_once '../db.php';
session_start();

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $db = new Database();
        $pdo = $db->getConnection();

        // Fetch employer data
        $stmt = $pdo->prepare("SELECT employer_id, email, password_hash FROM employers WHERE email = ?");
        $stmt->execute([$email]);
        $employer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employer && password_verify($password, $employer['password_hash'])) {
            $_SESSION['employer_id'] = $employer['employer_id'];
            $_SESSION['email'] = $employer['email'];

            $success = "Login successful! Redirecting...";
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Login - TalentSync</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 w-50">
        <h2 class="text-center mb-4">Employer Login</h2>
        
        <!-- Display alert messages -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert alert-success"><?= $success; ?></div>
            <script>
                setTimeout(function() {
                    window.location.href = 'employer_dashboard.php';
                }, 3000); // Redirect after 3 seconds
            </script>
        <?php endif; ?>

        <form action="login.php" method="POST">
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

</body>
</html>
