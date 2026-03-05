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

    $file_path = ""; 
    // เช็คว่ามีการส่งไฟล์มาหรือไม่
    if (isset($_FILES['medical_cert']) && $_FILES['medical_cert']['error'] !== 4) {
        
        if ($_FILES['medical_cert']['error'] == 0) {
            $target_dir = "../uploads/";
            
            // 🔴 แก้ไข: เปลี่ยนจาก 0777 เป็น 0755 เพื่อไม่ให้เซิร์ฟเวอร์มหาลัยบล็อก (Error 500)
            if (!file_exists($target_dir)) { 
                @mkdir($target_dir, 0755, true); 
            }
            
            $extension = pathinfo($_FILES['medical_cert']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $student_id . "." . $extension;
            $target_file = $target_dir . $file_name;

            // 🔴 แก้ไข: ใช้ @ เพื่อซ่อน Error ร้ายแรง และใช้ Alert แจ้งผู้ใช้แทน
            if (@move_uploaded_file($_FILES['medical_cert']['tmp_name'], $target_file)) {
                $file_path = $file_name;
            } else {
                die("<script>
                        alert('อัปโหลดรูปล้มเหลว! เซิร์ฟเวอร์ไม่อนุญาตให้บันทึกไฟล์ (Permission Denied) กรุณาแจ้ง Admin'); 
                        window.history.back();
                     </script>");
            }
        } else {
            $err_code = $_FILES['medical_cert']['error'];
            die("<script>
                    alert('ไฟล์มีปัญหาหรือมีขนาดใหญ่เกินไป (Error Code: $err_code)'); 
                    window.history.back();
                 </script>");
        }
    }

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
