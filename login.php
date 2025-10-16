<?php
session_start();
include('connection.php');

if (isset($_POST['submit'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
// Inside login.php after successful login verification
if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $row['id'];
        header("Location: main_p.php");
        exit();
    } else {
        echo '<script>
                alert("Login failed. Invalid email or password!");
                window.location.href = "login_page.php";
              </script>';
    }
} else {
    echo '<script>
            alert("Login failed. Invalid email or password!");
            window.location.href = "login_page.php";
          </script>';
}

}
?>