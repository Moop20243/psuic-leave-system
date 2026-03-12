<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'student') {
        header("Location: Homepage.php"); 
    } else if ($_SESSION['role'] == 'lecturer') {
        header("Location: ../lecturer/Lecturerhomepage.php");
    } else if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/Dashboardpage.php");
    }
    exit();
}

include '../connect.php';

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['user_id'] = $row['username'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'student') {
            header("Location: Homepage.php");
        } else if ($row['role'] == 'lecturer') {
            header("Location: ../lecturer/Lecturerhomepage.php");
        } else if ($row['role'] == 'admin') {
            header("Location: ../admin/Dashboardpage.php"); 
        }
        exit();
    } else {
        $error_msg = "Username or Password incorrect!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Login</title>
    <link rel="stylesheet" href="../css.css/Loginstyle.css">
    <style>

       
        
        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 22px; 
            width: 90%;
            max-width: 400px; 
            margin: 30px auto; 
        }
        .input-group {
            width: 100%;
        }
        .input-group input {
            width: 100%;
            padding: 16px 20px; 
            border: 2px solid #e2e8f0; 
            border-radius: 12px; 
            font-size: 16px;
            box-sizing: border-box; 
            transition: all 0.3s ease; 
        }
        
        .input-group input:focus {
            border-color: #193c6c; 
            outline: none;
            box-shadow: 0 0 0 3px rgba(25, 60, 108, 0.1);
        }
        .login-btn {
            background-color: transparent;
            border: none;
            cursor: pointer;
            width: 100%;
            padding: 0;
            margin-top: 5px; 
        }
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            width: 100%;
            max-width: 380px;
            margin: 0 auto 15px auto;
            font-weight: bold;
        }
        
        .change-pwd-link {
            color: #193c6c;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            margin-top: 10px;
            transition: 0.2s;
        }
        .change-pwd-link:hover {
            color: #ff9900; /* เปลี่ยนสีตอนเอาเมาส์ชี้ */
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="">
        </div>
    </div>

    <div class="welcome-section">
        <p class="welcome">Welcome</p>
        <h1 class="title">Students Absence Request System</h1>
        <p class="subtitle">Prince of Songkla University International College</p>
    </div>

    <?php if(isset($error_msg)) { ?>
        <div class="error-message"><?php echo $error_msg; ?></div>
    <?php } ?>

    <form method="POST" action="index.php" class="login-form">
        
        <div class="input-group">
            <input type="text" name="username" placeholder="Username / Student ID" required>
        </div>
        
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="login_btn" class="login-btn">
            <div class="login" style="margin: 0; width: 100%;"> 
                <div class="logo-mini">
                    <img src="../Photo/PSUIC White Medium  2024 7.png" alt="">
                </div>
                <div class="login-with">
                    <p>Login</p> 
                </div>
            </div>
        </button>

        <a href="change_password.php" class="change-pwd-link"><u>Change Password</u></a>

    </form>

    
</body>
</html>