<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - Task Manager</title>
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
                <p class="text-muted">Create your account</p>
              </div>

              <form
                id="signupForm"
                name="form"
                action="sign_up.php"
                onsubmit="return isvalid()"
                method="POST"
              >
                <div class="mb-3">
                  <label for="signupName" class="form-label">Full Name</label>
                  <input
                    name="signupName"
                    type="text"
                    class="form-control"
                    id="signupName"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="signupEmail" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="signupEmail"
                    name="signupEmail"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="signupPassword" class="form-label"
                    >Password</label
                  >
                  <input
                    type="password"
                    class="form-control"
                    id="signupPassword"
                    name="signupPassword"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="signupConfirm" class="form-label"
                    >Confirm Password</label
                  >
                  <input
                    type="password"
                    class="form-control"
                    id="signupConfirm"
                    required
                  />
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100 mb-3">
                  Sign Up
                </button>
                <div class="text-center">
                  <p>Already have an account? <a href="login_page.php">Login</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script >
      function isvalid() {
  const pass = document.getElementById("signupPassword").value;
  const confirm = document.getElementById("signupConfirm").value;
  if (pass !== confirm) {
    alert("Passwords do not match!");
    return false;
  }
  return true;
}
    </script>
  </body>
</html>
