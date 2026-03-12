<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';


$lecturer_query = "SELECT username, fullname FROM users WHERE role = 'lecturer'";
$lecturers = mysqli_query($conn, $lecturer_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/adminstudentstyle.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
        
    </div>

    <div class="main-container">  
        <div class="menu-bar">
            <a href="Dashboardpage.php" class="menu-item">
                <img src="../Photo/dashboard.png" alt="">
                <h3>Dashboard</h3>
            </a>
            <a href="Courselistpage.php" class="menu-item">
                <img src="../Photo/courselist.png" alt="">
                <h3>Course List</h3>
            </a>
            <a href="Absencetypepage.php" class="menu-item">
                <img src="../Photo/absencetype.png" alt="">
                <h3>Absence Type</h3>
            </a>
            <a href="studentspage.php" class="menu-item active">
                <img src="../Photo/student.png" alt="">
                <h3>Students</h3>
            </a>
            <a href="lecturerpage.php" class="menu-item">
                <img src="../Photo/lecturer.png" alt="">
                <h3>Lecturers</h3>
            </a>
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
            <div class="white-card">
                <h2>Students Management</h2>

                <div style="margin-bottom: 30px; padding: 20px; border: 1px solid #eee; border-radius: 10px; background-color: #fcfcfc;">
                    <h4 style="margin-bottom: 15px; color: #003366;">Add New Student</h4>
                    <form action="insert_student.php" method="POST" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
                        <div style="flex: 1; min-width: 120px;">
                            <label style="display: block; font-size: 13px; margin-bottom: 5px;">Student ID</label>
                            <input type="text" name="username" placeholder="ID" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 1; min-width: 180px;">
                            <label style="display: block; font-size: 13px; margin-bottom: 5px;">Full Name</label>
                            <input type="text" name="fullname" placeholder="Full Name" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 1; min-width: 180px;">
                            <label style="display: block; font-size: 13px; margin-bottom: 5px;">Email</label>
                            <input type="email" name="email" placeholder="student@psu.ac.th" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 1; min-width: 130px;">
                            <label style="display: block; font-size: 13px; margin-bottom: 5px;">Password</label>
                            <input type="password" name="password" placeholder="Password" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 1; min-width: 180px;">
                            <label style="display: block; font-size: 13px; margin-bottom: 5px;">Advisor</label>
                            <select name="advisor_id" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                                <option value="">-- Select Advisor --</option>
                                <?php 
                                mysqli_data_seek($lecturers, 0); 
                                while($adv = mysqli_fetch_assoc($lecturers)): 
                                ?>
                                    <option value="<?php echo $adv['username']; ?>"><?php echo $adv['fullname']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" style="padding: 9px 25px; background-color: #003366; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Add</button>
                    </form>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="15%">ID</th>
                            <th width="20%">Student Name</th>
                            <th width="20%">Advisor</th> <th width="20%">Email</th>
                            <th width="25%">Signed in</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT s.*, a.fullname as advisor_name 
                            FROM users s 
                            LEFT JOIN users a ON s.advisor_id = a.username 
                            WHERE s.role = 'student' 
                            ORDER BY s.id ASC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo '<td>' . $row['username'] . '</td>'; 
                            echo '<td>' . $row['fullname'] . '</td>'; 
                            echo '<td>' . ($row['advisor_name'] ? $row['advisor_name'] : '<span style="color: #999;">Not Assigned</span>') . '</td>';
                            echo '<td>' . (isset($row['email']) ? $row['email'] : '-') . '</td>'; 
                            $date = date("d/m/Y", strtotime($row['created_at']));
                            echo '<td>' . $date . '</td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center;'>No students found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>

               
            </div> 
        </div> 
    </div> 
</body>
</html>