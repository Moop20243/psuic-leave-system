<?php
session_start();

// 1. ถ้ายังไม่ล็อกอิน ให้กลับไปหน้า Login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

// 2. ป้องกัน Session ตีกัน: ถ้าไม่ใช่ lecturer ให้เตะไป "ล้างค่า" ที่ logout
if ($_SESSION['role'] !== 'lecturer') {
    // 🔴 จุดนี้สำคัญ: ต้องเด้งไป logout.php เท่านั้น ห้ามเด้งไปหน้าอื่น ไม่งั้นลูปจะพัง
    header("Location: ../logout.php");
    exit();
}

include '../connect.php';

// ดึงข้อมูลอาจารย์จาก Session
$lecturer_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];

// --- เพิ่มการเช็ค Error ป้องกันฐานข้อมูลว่างเหมือนของ Admin ---
// ดึงจำนวนคำขอทั้งหมด (ลบ WHERE advisor_id ออกไปก่อนเพื่อให้รันผ่าน)
$sql_total = "SELECT COUNT(*) as total FROM leave_requests"; 
$total_result = mysqli_query($conn, $sql_total);
$total_req = ($total_result) ? mysqli_fetch_assoc($total_result)['total'] : 0;

// ดึงจำนวนที่อนุมัติ (นับจาก status อย่างเดียวไปก่อน)
$sql_app = "SELECT COUNT(*) as total FROM leave_requests WHERE status='Approved'";
$app_result = mysqli_query($conn, $sql_app);
$app_req = ($app_result) ? mysqli_fetch_assoc($app_result)['total'] : 0;

// ป้องกันหารด้วย 0
$percent_app = ($total_req > 0) ? round(($app_req / $total_req) * 100) : 0;
$percent_rej = ($total_req > 0) ? (100 - $percent_app) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/lecturerhomepage.css">
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
            <a href="Lecturerhomepage.php" class="menu-item active">
                <img src="../Photo/homepage.png" alt="">
                <h3>Home Page</h3>
            </a>
            <a href="AbsenceRequestlistpage.php" class="menu-item">
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
        
            <div class="top-section">
                <div class="card">
                    <h3>Virtual Lecturer Card</h3>
                    <div class="card-content">
                        <img src="../Photo/messi.jpg" alt="Lecturer Photo">
                        <div class="info">
                            <h2><?php echo $_SESSION['fullname']; ?></h2>
                            <h3>ID: <?php echo $_SESSION['user_id']; ?></h3>
                            <h3>PSUIC Lecturer</h3>
                        </div>
                    </div>
                </div>

                <div class="lecturer-dashboard">
                    <div class="summary-row">
                        <div class="stat-card leave-request">
                            <div class="stat-content">
                                <h3>Leave Requests</h3>
                                <h2 class="big-number"><?php echo $total_req; ?></h2>
                                <p class="trend">Updated live</p>
                            </div>
                            <div class="stat-graph">
                                <img src="../Photo/Group 1.png" alt="Bar Graph">
                            </div>
                        </div>

                        <div class="stat-card leave-status">
                            <div class="stat-content">
                                <h3>Leave Status</h3>
                                <div class="legend">
                                    <div class="legend-item">
                                        <span class="dot approved"></span>
                                        <p>Approved</p>
                                    </div>
                                    <div class="legend-item">
                                        <span class="dot rejected"></span>
                                        <p>Not Approved</p>
                                    </div>
                                </div>
                            </div>
                            <div class="stat-graph">
                                <div class="pie-container">
                                    <img src="../Photo/Group 2.png" alt="Pie Chart">
                                    <span class="percent-90"><?php echo $percent_app; ?>%</span>
                                    <span class="percent-10"><?php echo $percent_rej; ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="number">
                <h2>Students with Most Leave of absence Requests</h2>
                <div class="stat-row">
                    <label>6410110xxx</label> 
                    <div class="progress-bar">
                        <div class="progress-fill" style="--target-width: 100%;"></div>
                    </div>
                    <span class="times">10 times</span>
                </div>
                </div>

            <div class="number">
                <h2>Courses with Most Leave of absence Requests</h2>
                <div class="stat-row">
                    <label>Course Name</label> 
                    <div class="progress-bar">
                        <div class="progress-fill" style="--target-width: 100%;"></div>
                    </div>
                    <span class="times">12 times</span>
                </div>
                </div>

        </div> 
    </div> 
</body>
</html>