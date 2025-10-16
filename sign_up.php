<?php
    include('connection.php');
    if (isset($_POST['submit'])) {
        $username = $_POST['signupName'];
        $password = $_POST['signupPassword'];
        $email = $_POST['signupEmail'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);



        $sql = "select * from accounts where username = '$username'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
        
        if($count == 0){  
            $sql = "INSERT INTO accounts (username, password,email) VALUES ('$username', '$hashedPassword', '$email')";
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            header("Location: login_page.php");
        }  
        else{  
            echo  '<script>
                        window.location.href = "index.php";
                        alert("Login failed. Invalid username or password!!")
                    </script>';
        }     
    }
    ?>