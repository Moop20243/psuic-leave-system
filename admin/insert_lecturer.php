<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']); // รับค่า email
    $role = 'lecturer';

    $sql = "INSERT INTO users (username, fullname, password, email, role) 
            VALUES ('$username', '$fullname', '$password', '$email', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('เพิ่มข้อมูลอาจารย์เรียบร้อยแล้ว!');
                window.location.href = 'lecturerpage.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>