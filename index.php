<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />
</head>
<body style="padding-top: 70px;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-check2-circle"></i> Task Manager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup_page.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login_page.php">Log In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-3 fw-bold">
                <i class="bi bi-check2-circle"></i> Organize Your Life
            </h1>
            <p class="lead">
                Task Manager helps you stay on top of your tasks with ease and efficiency.
            </p>
            <a href="signup_page.php" class="btn btn-primary btn-lg">
                <i class="bi bi-person-plus"></i> Get Started
            </a>
        </div>

        

        <!-- Features Section -->
        <div class="row mb-5">
            <h2 class="text-center mb-4">Why Choose Task Manager?</h2>
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-list-task display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Easy Task Creation</h5>
                        <p class="card-text">Add tasks quickly with customizable priorities to suit your needs.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-check2-square display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Track Progress</h5>
                        <p class="card-text">Monitor active and completed tasks to stay organized.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-shield-lock display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Secure Access</h5>
                        <p class="card-text">Your data is protected with secure login and session management.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light py-3">
        <div class="container text-center">
            <p class="mb-0">
                &copy; 2025 Task Manager. All rights reserved.
                <span class="mx-2">|</span>
                <a href="index.php">Home</a>
                <span class="mx-2">|</span>
                <a href="signup_page.php">Sign Up</a>
                <span class="mx-2">|</span>
                <a href="login_page.php">Log In</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>