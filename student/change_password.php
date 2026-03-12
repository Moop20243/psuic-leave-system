<?php
session_start();
include '../connect.php';

$msg = "";
$msg_type = ""; 

if (isset($_POST['change_pwd_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    
    if ($new_password !== $confirm_password) {
        $msg = "รหัสผ่านใหม่ไม่ตรงกัน กรุณาลองอีกครั้ง! (New passwords do not match)";
        $msg_type = "error";
    } else {
        
        $sql_check = "SELECT * FROM users WHERE username = '$username' AND password = '$old_password'";
        $result = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result) == 1) {
            
            $sql_update = "UPDATE users SET password = '$new_password' WHERE username = '$username'";
            if (mysqli_query($conn, $sql_update)) {
                $msg = "เปลี่ยนรหัสผ่านสำเร็จ! คุณสามารถกลับไปหน้า Login ได้เลย";
                $msg_type = "success";
            } else {
                $msg = "เกิดข้อผิดพลาดของระบบฐานข้อมูล กรุณาลองใหม่";
                $msg_type = "error";
            }
        } else {
            $msg = "Username หรือ รหัสผ่านเดิม ไม่ถูกต้อง!";
            $msg_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - PSUIC</title>
    <link rel="stylesheet" href="../css.css/Loginstyle.css">
    <style>
        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px; 
            width: 90%;
            max-width: 400px;
            margin: 20px auto; 
        }
        .input-group {
            width: 100%;
        }
        .input-group input {
            width: 100%;
            padding: 14px 20px; 
            border: 2px solid #e2e8f0; 
            border-radius: 12px; 
            font-size: 15px;
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
            margin-top: 10px;
        }
        .alert-message {
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            width: 100%;
            max-width: 380px;
            margin: 0 auto 15px auto;
            font-weight: bold;
        }
        .alert-error {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .back-link {
            color: #666;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            margin-top: 15px;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .back-link:hover {
            color: #193c6c; 
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

    <div class="welcome-section" style="margin-top: 50px;">
        <h1 class="title" style="font-size: 40px; margin-bottom: 10px;">Change Password</h1>
        <p class="subtitle" style="font-size: 20px;">Please enter your new password</p>
    </div>

    <?php if($msg != "") { ?>
        <div class="alert-message <?php echo ($msg_type == 'success') ? 'alert-success' : 'alert-error'; ?>">
            <?php echo $msg; ?>
        </div>
    <?php } ?>

    <form method="POST" action="change_password.php" class="login-form">
        
        <div class="input-group">
            <input type="text" name="username" placeholder="Username / Student ID" required>
        </div>
        
        <div class="input-group">
            <input type="password" name="old_password" placeholder="Current Password (รหัสผ่านเดิม)" required>
        </div>

        <div class="input-group">
            <input type="password" name="new_password" placeholder="New Password (รหัสผ่านใหม่)" required>
        </div>

        <div class="input-group">
            <input type="password" name="confirm_password" placeholder="Confirm New Password (ยืนยันรหัสผ่านใหม่)" required>
        </div>

        <button type="submit" name="change_pwd_btn" class="login-btn">
            <div class="login" style="margin: 0; width: 100%; justify-content: center;"> 
                <div class="login-with">
                    <p>Update Password</p> 
                </div>
            </div>
        </button>

        <a href="index.php" class="back-link">
            <span>&larr;</span> Back to Login
        </a>

    </form>

</body>
</html>