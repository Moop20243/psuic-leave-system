<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

if ($_SESSION['role'] !== 'student') {
    header("Location: ../logout.php");
    exit();
}

include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['user_id']; 
    
    $absence_type = mysqli_real_escape_string($conn, $_POST['absence_type']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    
    $status = "Pending Advisor";

    // --- ส่วนจัดการไฟล์อัปโหลด (ปรับปรุงใหม่เพื่อเช็ค Error) ---
    $file_path = ""; 
    // เช็คว่ามีการเลือกไฟล์มาจริงๆ (error 4 คือไม่ได้เลือกไฟล์)
    if (isset($_FILES['medical_cert']) && $_FILES['medical_cert']['error'] !== 4) {
        
        if ($_FILES['medical_cert']['error'] == 0) {
            $target_dir = "../uploads/";
            if (!file_exists($target_dir)) { 
                mkdir($target_dir, 0777, true); 
            }
            
            $extension = pathinfo($_FILES['medical_cert']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $student_id . "." . $extension;
            $target_file = $target_dir . $file_name;

            // ถ้าอัปโหลดสำเร็จ
            if (move_uploaded_file($_FILES['medical_cert']['tmp_name'], $target_file)) {
                $file_path = $file_name;
            } else {
                // ถ้าโฟลเดอร์ไม่ให้สิทธิ์เขียน (Permission ไม่ใช่ 777)
                die("<script>alert('ระบบไม่สามารถบันทึกไฟล์ได้: กรุณาแจ้ง Admin ให้ตั้งค่า Permission โฟลเดอร์ uploads เป็น 777'); window.history.back();</script>");
            }
        } else {
            // ถ้าติด Error อื่นๆ จากเซิร์ฟเวอร์ เช่น ไฟล์ใหญ่เกิน (Error 1 หรือ 2)
            $err_code = $_FILES['medical_cert']['error'];
            die("<script>alert('อัปโหลดไฟล์ไม่สำเร็จ! (Error Code: $err_code) ถ้ารหัส 1 หรือ 2 แปลว่าไฟล์ขนาดใหญ่เกินไปครับ'); window.history.back();</script>");
        }
    }

    // --- ส่วนเขียนข้อมูลลงฐานข้อมูล ---
    $sql = "INSERT INTO leave_requests (student_id, leave_type, course, start_date, end_date, reason, contact_number, file_path, status) 
            VALUES ('$student_id', '$absence_type', '$course', '$start_date', '$end_date', '$reason', '$contact_number', '$file_path', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('ส่งใบลาเรียบร้อยแล้ว! (Submitted Successfully)');
                window.location.href = 'Checkstatuspage.php'; 
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
