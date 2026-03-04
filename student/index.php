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
        /* เพิ่ม CSS เฉพาะกิจสำหรับช่องกรอกรหัส */
        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
        }
        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box; /* สำคัญ: ให้ padding ไม่ทำให้กล่องบวม */
        }
        .login-btn {
            background-color: transparent;
            border: none;
            cursor: pointer;
            width: 100%;
            padding: 0;
        }
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            width: 80%;
            margin: 0 auto 15px auto;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="">
        </div>
        <div class="change">
            <img src="../Photo/solar_global-outline.png" alt="">
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
        
        <div class="input-group" style="width: 80%;">
            <input type="text" name="username" placeholder="Username / Student ID" required>
        </div>
        
        <div class="input-group" style="width: 80%;">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="login_btn" class="login-btn">
            <div class="login" style="margin: 0; width: 100%;"> 
                <div class="logo-mini">
                    <img src="../Photo/PSUIC White Medium  2024 7.png" alt="">
                </div>
                <div class="login-with">
                    <p>Login</p> </div>
            </div>
        </button>
 
    </form>

    <div class="Student">
        <img src="../Photo/FeatureImage 2.png" alt="">
    </div>
</body>
</html>