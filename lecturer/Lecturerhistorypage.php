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

$logged_in_user = $_SESSION['user_id'];


$sql = "SELECT lr.* FROM leave_requests lr
        INNER JOIN users u ON lr.student_id = u.username
        WHERE lr.status NOT LIKE '%Pending%' 
        AND (
            u.advisor_id = '$logged_in_user' 
            OR 
            lr.course IN (SELECT course_code FROM courses WHERE lecturer_name = (SELECT fullname FROM users WHERE username = '$logged_in_user'))
        )
        ORDER BY lr.id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History - PSUIC (Lecturer)</title>
    
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/historystyle.css">
    
    <style>
        
        .status-btn {
            padding: 6px 12px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            min-width: 110px;
            font-size: 14px;
        }
        .pending { background-color: #f39d12cb; }
        .approved { background-color: #2dc550d0; }
        .not-approved { background-color: #e23030c9; }
        
        
        .history-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        
        .history-table th { 
            text-align: left; 
            padding: 15px; 
            color: #666; 
            font-weight: bold;
            border-bottom: 2px solid #f0f0f0; 
        }
        
        .history-table td { 
            padding: 15px; 
            background: white; 
            color: #333;
           
            border-bottom: 1px solid #f5f5f5; 
            vertical-align: middle;
        }

        
        .history-table tr:last-child td {
            border-bottom: none;
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
            <a href="Lecturerhomepage.php" class="menu-item">
                <img src="../Photo/homepage.png" alt="Home">
                <h3>Home Page</h3>
            </a>
            <a href="AbsenceRequestlistpage.php" class="menu-item">
                <img src="../Photo/absencerequest.png" alt="Request">
                <h3>Absence Request list</h3>
            </a>
            <a href="Lecturerhistorypage.php" class="menu-item active">
                <img src="../Photo/history.png" alt="History">
                <h3>History</h3>
            </a>
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="Logout">
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
                                <th>Student ID</th>
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
                                while ($row = mysqli_fetch_assoc($result)) {
                                    
                                  
                                    $student_id = $row['student_id'];
                                    $course = $row['course'];
                                    $type = $row['leave_type'];
                                    $reason = $row['reason'];
                                    $status_db = $row['status'];
                                    
                                    
                                    $s_date = date("d/m/Y", strtotime($row['start_date']));
                                    $e_date = date("d/m/Y", strtotime($row['end_date']));
                                    $date_show = $s_date . " - " . $e_date;

                                   
                                    $status_class = 'pending';
                                    if (strtolower($status_db) == 'approved') {
                                        $status_class = 'approved';
                                    } elseif (strpos(strtolower($status_db), 'not') !== false || strtolower($status_db) == 'rejected') {
                                        $status_class = 'not-approved';
                                    }

                                   
                                    echo "<tr>";
                                    echo "<td style='font-weight:bold; color:#555;'>" . $student_id . "</td>";
                                    echo "<td>" . $course . "</td>";
                                    echo "<td>" . $type . "</td>";
                                    echo "<td>" . $date_show . "</td>";
                                    echo "<td>" . $reason . "</td>";
                                    echo "<td><span class='status-btn " . $status_class . "'>" . $status_db . "</span></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center; padding:30px; color:#999;'>No history found.</td></tr>";
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