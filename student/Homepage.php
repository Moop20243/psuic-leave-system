<?php
session_start();

// 1. ถ้ายังไม่ล็อกอิน ให้กลับไปหน้า index (Login) ของโฟลเดอร์เดียวกัน
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 2. ป้องกัน Session ตีกัน: ถ้าไม่ใช่ student ให้เตะไปล้างค่าที่ logout
if ($_SESSION['role'] !== 'student') {
    header("Location: ../logout.php"); 
    exit();
}

// ถ้าคุณมี include '../connect.php'; ก็ใส่ต่อจากตรงนี้ได้เลยครับ (ถ้ามี)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/Studenthomepagestyle.css">
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
            <a href="Homepage.php" class="menu-item active">
                <img src="../Photo/homepage.png" alt="">
                <h3>Home Page</h3>
            </a>
            
            <a href="Absencepage.php" class="menu-item">
                <img src="../Photo/absencerequest.png" alt="">
                <h3>Absence Request</h3>
            </a>
            
            <a href="Checkstatuspage.php" class="menu-item">
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
    
    <div class="card">
        <h3>Virtual Student Card</h3>
        <div class="card-content">
            <img src="../Photo/ronaldo.jpg" alt="Student Photo">
            <div class="info">
                <h2><?php echo $_SESSION['fullname']; ?></h2>
                <h3><?php echo $_SESSION['user_id']; ?></h3>
                <h3>PSUIC Student</h3>
            </div>
        </div>
    </div>
    
    <div class="number">
        <h2>Number of times of leave taken</h2>
        
        <div class="stat-row">
            <label>Course Name</label>
            <div class="progress-bar"><div class="progress-fill" style="width: 80%;"></div></div>
            <span class="times">2 times</span>
        </div>

        <div class="stat-row">
            <label>Course Name</label>
            <div class="progress-bar"><div class="progress-fill" style="width: 40%;"></div></div>
            <span class="times">1 time</span>
        </div>

        <div class="stat-row">
            <label>Course Name</label>
            <div class="progress-bar"><div class="progress-fill" style="width: 40%;"></div></div>
            <span class="times">1 time</span>
        </div>
    </div>

    <div class="number">
        <h2>Number of times leave can be taken</h2>
        
        <div class="stat-row">
            <label>Course Name</label>
            <div class="progress-bar"><div class="progress-fill" style="width: 100%;"></div></div>
            <span class="times">3 times</span>
        </div>

        <div class="stat-row">
            <label>Course Name</label>
            <div class="progress-bar"><div class="progress-fill" style="width: 80%;"></div></div>
            <span class="times">2 time</span>
        </div>
    
        <div class="stat-row">
            <label>Course Name</label>
            <div class="progress-bar"><div class="progress-fill" style="width: 40%;"></div></div>
            <span class="times">1 time</span>
        </div>
    </div>

</div>
              
    </div> 
</body>
</html>