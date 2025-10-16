<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Task Manager</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body class="auth-page">
    <div class="container d-flex align-items-center min-vh-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6">
          <div class="auth-card card shadow">
            <div class="card-body p-4 p-md-5">
              <div class="auth-header text-center mb-4">
                <h2>
                  <i class="bi bi-check2-circle text-primary"></i> Task Manager
                </h2>
                <p class="text-muted">Sign in to manage your tasks</p>
              </div>

              <form
                id="loginForm"
                action="login.php"
                onsubmit="return isvalidLogin()"
                method="POST"
              >
                <div class="mb-3">
                  <label for="loginEmail" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="loginEmail"
                    name="loginEmail"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="loginPassword" class="form-label">Password</label>
                  <input
                    type="password"
                    class="form-control"
                    id="loginPassword"
                    name="pass"
                    required
                  />
                </div>
                <div class="mb-3 form-check">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    id="rememberMe"
                  />
                  <label class="form-check-label" for="rememberMe"
                    >Remember me</label
                  >
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100 mb-3">
                  Login
                </button>
                <div class="text-center">
                  <p>
                    Don't have an account? <a href="signup_page.php">Sign up</a>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function isvalidLogin() {
  const email = document.getElementById("loginEmail").value;
  const pass = document.getElementById("loginPassword").value;

  if (!email || !pass) {
    alert("Please fill in all fields.");
    return false;
  }
  return true;
}
    </script>
  </body>
</html>
