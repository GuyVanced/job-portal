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
                    <form action="backend/employer/register.php" method="POST">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry</label>
                            <input type="text" class="form-control" id="industry" name="industry">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="company_website" class="form-label">Company Website</label>
                            <input type="url" class="form-control" id="company_website" name="company_website">
                        </div>
                        <div class="mb-3">
                            <label for="company_description" class="form-label">Company Description</label>
                            <textarea class="form-control" id="company_description" name="company_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                        <div class="text-center mt-3">
                            <a href="employer_login.php">Already registered? Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
