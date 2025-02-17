<?php
require_once '../backend/db.php'; // Database class

// Initialize response messages
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = trim($_POST['company_name']);
    $industry = trim($_POST['industry']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $company_website = trim($_POST['company_website']);
    $company_description = trim($_POST['company_description']);
    $location = trim($_POST['location']);

    // Basic validation
    if (empty($company_name) || empty($industry) || empty($email) || empty($password) || empty($location)) {
        $error = "All required fields must be filled.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        try {
            $db = new Database();
            $pdo = $db->getConnection();

            // Check if email is already registered
            $stmt = $pdo->prepare("SELECT email FROM employers WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $error = "Email is already in use.";
            } else {
                // Insert employer data
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO employers (company_name, industry, email, password_hash, company_website, company_description, location) VALUES (?, ?, ?, ?, ?, ?, ?)");

                if ($stmt->execute([$company_name, $industry, $email, $hashed_password, $company_website, $company_description, $location])) {
                    $success = "Registration successful! Redirecting to login page...";
                    header("location=../backend/employer/login.php");
                } else {
                    $error = "Failed to register. Try again.";
                }
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Registration - TalentSync</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Left Section with Background Image -->
            <div class="col-md-6 d-flex align-items-center justify-content-center text-white bg-primary p-5">
                <div class="text-center">
                    <h1 class="mb-4">Welcome to TalentSync</h1>
                    <p>Find the right talent for your company with ease.</p>
                    <img src="assets/images/employer_banner.png" class="img-fluid" alt="Employer Illustration">
                </div>
            </div>
            
            <!-- Right Section with Form -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-white p-5">
                <div class="w-75">
                    <h2 class="mb-4 text-center">Employer Registration</h2>
                    <form action="employer.php" method="POST">
                        <!-- Display messages -->
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success"><?= $success; ?></div>
                            <script>
                                setTimeout(function() {
                                    window.location.href = 'employer_login.php';
                                }, 3000); // Redirect after 3 seconds
                            </script>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" required value="<?= htmlspecialchars($_POST['company_name'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Industry</label>
                            <input type="text" name="industry" class="form-control" required value="<?= htmlspecialchars($_POST['industry'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Company Website (Optional)</label>
                            <input type="text" name="company_website" class="form-control" value="<?= htmlspecialchars($_POST['company_website'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Company Description</label>
                            <textarea name="company_description" class="form-control"><?= htmlspecialchars($_POST['company_description'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" required value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
