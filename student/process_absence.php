<?php
session_start();

// 1. เช็คการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

// 2. ป้องกันอาจารย์แอบส่งใบลา (Security Check)
if ($_SESSION['role'] !== 'student') {
    header("Location: ../logout.php");
    exit();
}

include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['user_id']; 
    
    // รับค่าและป้องกัน SQL Injection
    $absence_type = mysqli_real_escape_string($conn, $_POST['absence_type']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    
    // กำหนดสถานะเริ่มต้น
    $status = "Pending Advisor";

    // --- ส่วนจัดการไฟล์อัปโหลด ---
    $file_path = ""; 
    if (isset($_FILES['medical_cert']) && $_FILES['medical_cert']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        }
        
        $extension = pathinfo($_FILES['medical_cert']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $student_id . "." . $extension;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['medical_cert']['tmp_name'], $target_file)) {
            $file_path = $file_name;
        }
    }

    // --- ส่วนเขียนข้อมูลลงฐานข้อมูล (INSERT) ---
    $sql = "INSERT INTO leave_requests (student_id, leave_type, course, start_date, end_date, reason, contact_number, file_path, status) 
            VALUES ('$student_id', '$absence_type', '$course', '$start_date', '$end_date', '$reason', '$contact_number', '$file_path', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('ส่งใบลาเรียบร้อยแล้ว! (Submitted Successfully)');
                window.location.href = 'Checkstatuspage.php'; 
              </script>";
    } else {
        // หาก Error จะโชว์ข้อความจากฐานข้อมูลเพื่อให้เรารู้ว่าผิดที่คอลัมน์ไหน
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>