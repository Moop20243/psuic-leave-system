<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';

$student_id = $_SESSION['user_id'];

// 🔴 แก้ไข SQL: เปลี่ยนจาก = 'Pending' เป็น LIKE 'Pending%' เพื่อให้ดึงทั้ง Pending Advisor และ Pending Lecturer
$sql = "SELECT * FROM leave_requests WHERE student_id = '$student_id' AND status LIKE 'Pending%' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Status - PSUIC</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/lecturerhomepage.css"> 
    
    <style>
        .content-area { padding: 40px; }
        
        .no-request-box {
            background-color: white;
            border-radius: 15px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            font-size: 24px;
            color: #888;
        }

        .status-card {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        
        .status-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            font-size: 16px;
        }
        .detail-label {
            width: 180px;
            font-weight: bold;
            color: #555;
        }
        .detail-value {
            flex: 1;
            color: #333;
        }

        .status-pending { color: #f6ad55; font-weight: bold; }
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
            <a href="Homepage.php" class="menu-item">
                <img src="../Photo/homepage.png" alt="">
                <h3>Home Page</h3>
            </a>
            <a href="Absencepage.php" class="menu-item"> 
                <img src="../Photo/absencerequest.png" alt="">
                <h3>Absence Request</h3>
            </a>
            <a href="Checkstatuspage.php" class="menu-item active">
                <img src="../Photo/checkstatus.png" alt="">
                <h3>Check Status</h3>
            </a>
            <a href="Historypsge.php" class="menu-item">
                <img src="../Photo/history.png" alt="">
                <h3>History</h3>
            </a>
            <a href="Advisorpage.html" class="menu-item">
                <img src="../Photo/advisor.png" alt="">
                <h3>Advisor</h3>
            </a>
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
            
            <h1 style="margin-bottom: 20px; color: #333;">Check Status</h1>

            <?php if (mysqli_num_rows($result) == 0): ?>
                
                <div class="no-request-box">
                    No pending requests found
                </div>

            <?php else: ?>

                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="status-card">
                        <div class="status-header">
                            <h2 style="margin: 0; font-size: 20px;">Request Details</h2>
                            <span style="font-size: 14px; color: #999;">
                                Submitted on: <?php echo date("d/m/Y", strtotime($row['created_at'])); ?>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Absence Type</span>
                            <span class="detail-value"><?php echo $row['leave_type']; ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Reason</span>
                            <span class="detail-value"><?php echo $row['reason']; ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Course</span>
                            <span class="detail-value"><?php echo $row['course']; ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Duration</span>
                            <span class="detail-value">
                                <?php echo date("d/m/Y", strtotime($row['start_date'])); ?> 
                                - 
                                <?php echo date("d/m/Y", strtotime($row['end_date'])); ?>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Contact Number</span>
                            <span class="detail-value"><?php echo isset($row['contact_number']) ? $row['contact_number'] : '-'; ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Status</span>
                            <span class="detail-value">
                                <span class="status-pending"><?php echo $row['status']; ?></span>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Medical certificate</span>
                            <span class="detail-value">
                                <?php if (!empty($row['file_path'])): ?>
                                    <a href="../uploads/<?php echo $row['file_path']; ?>" target="_blank" style="color: #007bff; text-decoration: none;">
                                        View / Download
                                    </a>
                                <?php else: ?>
                                    No file attached
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                <?php endwhile; ?>

            <?php endif; ?>

        </div>
    </div> 
</body>
</html>