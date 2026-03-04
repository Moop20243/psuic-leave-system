<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}


if ($_SESSION['role'] !== 'lecturer') {
    header("Location: ../logout.php");
    exit();
}

include '../connect.php';


if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    
    $sql = "SELECT * FROM leave_requests WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        die("ไม่พบข้อมูลใบลา (ID ไม่ถูกต้อง หรือถูกลบไปแล้ว)");
    }

    $row = mysqli_fetch_assoc($result);
} else {
    die("ไม่ได้ระบุ ID ใบลา (No ID specified)");
}


if (isset($_POST['update_status'])) {
    $new_status = $_POST['update_status']; 
    $current_status = $row['status']; 
    
    if ($new_status == 'Approved') {
        
        if ($current_status == 'Pending Advisor') {
            $update_sql = "UPDATE leave_requests SET status = 'Pending Lecturer' WHERE id = '$id'";
            $msg = "อนุมัติเบื้องต้นเรียบร้อย! ส่งต่อให้อาจารย์ประจำวิชาพิจารณาต่อ";
        } 
        
        else if ($current_status == 'Pending Lecturer') {
            $update_sql = "UPDATE leave_requests SET status = 'Approved' WHERE id = '$id'";
            $msg = "อนุมัติเสร็จสมบูรณ์เรียบร้อยแล้ว!";
        }
        else {
            $update_sql = "UPDATE leave_requests SET status = 'Approved' WHERE id = '$id'";
            $msg = "ดำเนินการเรียบร้อยแล้ว!";
        }
    } else {
        
        $update_sql = "UPDATE leave_requests SET status = 'Not Approved' WHERE id = '$id'";
        $msg = "ปฏิเสธคำขอเรียบร้อยแล้ว";
    }
    
    // ทำการรันคำสั่ง SQL
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>
                alert('$msg');
                window.location.href = 'AbsenceRequestlistpage.php';
              </script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Status - PSUIC</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/lecturerhomepage.css">
    <link rel="stylesheet" href="../css.css/lecturercheckstatus.css">
    <style>
        .btn-action {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            margin-left: 10px;
            font-size: 16px;
        }
        .btn-approve { background-color: #28a745; } 
        .btn-reject { background-color: #dc3545; }  
        .btn-approve:hover { background-color: #218838; }
        .btn-reject:hover { background-color: #c82333; }
        
        .action-buttons {
            display: inline-flex;
            gap: 10px;
        }

        .btn-back {
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
        <div class="change">
            <img src="../Photo/solar_global-outline.png" alt="Change Language">
        </div>
    </div>

    <div class="main-container"> 
        <div class="menu-bar">
            <a href="Lecturerhomepage.php" class="menu-item">
                <img src="../Photo/homepage.png" alt="">
                <h3>Home Page</h3>
            </a>
            <a href="AbsenceRequestlistpage.php" class="menu-item active">
                <img src="../Photo/absencerequest.png" alt="">
                <h3>Absence Request list</h3>
            </a>
            <a href="Lecturerhistorypage.php" class="menu-item">
                <img src="../Photo/history.png" alt="">
                <h3>History</h3>
            </a>
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
            
            <div class="status-card">
                <h1 class="page-title">Check Details & Approve</h1>

                <div class="student-info">
                    <h2>Student ID: <?php echo $row['student_id']; ?></h2>
                    <p>International College</p>
                </div>

                <div class="divider"></div>

                <div class="detail-row">
                    <span class="label">Leave Type</span>
                    <span class="value"><?php echo $row['leave_type']; ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Reason</span>
                    <span class="value"><?php echo $row['reason']; ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Contact Number</span>
                    <span class="value">
                        <?php echo isset($row['contact_number']) ? $row['contact_number'] : '-'; ?>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label">Course</span>
                    <span class="value"><?php echo $row['course']; ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Start Date</span>
                    <span class="value"><?php echo date("d/m/Y", strtotime($row['start_date'])); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">End Date</span>
                    <span class="value"><?php echo date("d/m/Y", strtotime($row['end_date'])); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Status</span>
                    <span class="value status-pending" style="color: #f39c12; font-weight: bold;"><?php echo $row['status']; ?></span>
                </div>

                <div class="detail-row">
                    <span class="label">Medical certificate</span>
                    <span class="value">
                        <?php if (!empty($row['file_path'])): ?>
                            <a href="../uploads/<?php echo $row['file_path']; ?>" target="_blank" class="download-link" style="color: #007bff; text-decoration: underline;">
                                View File / Download
                            </a>
                        <?php else: ?>
                            No file attached
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            <div class="action-bar" style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                
                <a href="AbsenceRequestlistpage.php" class="btn-back">
                    &lt; Back
                </a>

                <form method="POST" class="action-buttons" onsubmit="return confirm('ยืนยันการตัดสินใจของคุณ?');">
                    <button type="submit" name="update_status" value="Approved" class="btn-action btn-approve">
                        ✅ Approve
                    </button>
                    <button type="submit" name="update_status" value="Not Approved" class="btn-action btn-reject">
                        ❌ Reject
                    </button>
                </form>

            </div>

        </div> 
    </div>
</body>
</html>