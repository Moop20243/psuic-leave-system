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

$student_id = $_SESSION['user_id'];


$sql = "SELECT * FROM leave_requests WHERE student_id = '$student_id' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/historystyle.css">
    <style>
        
        .status-btn.pending {
            background-color: #f39c12; 
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
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
            
            <a href="Checkstatuspage.php" class="menu-item">
                <img src="../Photo/checkstatus.png" alt="">
                <h3>Check Status</h3>
            </a>
            
            <a href="Historypsge.php" class="menu-item active">
                <img src="../Photo/history.png" alt="">
                <h3>History</h3>
            </a>
            
            <a href="Advisorpage.php" class="menu-item">
                <img src="../Photo/advisor.png" alt="">
                <h3>Advisor</h3>
            </a>
            
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
            <div class="history-container">
                <h1 class="main-title">History</h1>
                
                <div class="table-wrapper">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Absence Type</th>
                                <th>Date (Start - End)</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            if (mysqli_num_rows($result) > 0) {
                                
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    
                                    $status_class = 'pending'; 
                                    if(strtolower($row['status']) == 'approved') {
                                        $status_class = 'approved'; 
                                    } else if (strtolower($row['status']) == 'not approved') { // แก้คำผิดให้ตรงกับที่ database อาจจะเก็บ
                                        $status_class = 'not-approved'; 
                                    }
                            ?>
                                    <tr>
                                        <td><?php echo $row['course']; ?></td>
                                        <td><?php echo $row['leave_type']; ?></td>
                                        <td>
                                            <?php echo $row['start_date']; ?> ถึง <?php echo $row['end_date']; ?>
                                        </td>
                                        <td><?php echo $row['reason']; ?></td>
                                        <td>
                                            <span class="status-btn <?php echo $status_class; ?>">
                                                <?php echo $row['status']; ?>
                                            </span>
                                        </td>
                                    </tr>
                            <?php 
                                } 
                            } else {
                                
                                echo "<tr><td colspan='5' style='text-align:center;'>No history found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>