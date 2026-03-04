<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC - Lecturers</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/adminlecturer.css">
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
            <a href="Dashboardpage.php" class="menu-item"><img src="../Photo/dashboard.png"><h3>Dashboard</h3></a>
            <a href="Courselistpage.php" class="menu-item"><img src="../Photo/courselist.png"><h3>Course List</h3></a>
            <a href="Absencetypepage.php" class="menu-item"><img src="../Photo/absencetype.png"><h3>Absence Type</h3></a>
            <a href="studentspage.php" class="menu-item"><img src="../Photo/student.png"><h3>Students</h3></a>
            <a href="lecturerpage.php" class="menu-item active"><img src="../Photo/lecturer.png"><h3>Lecturers</h3></a>
            <a href="../logout.php" class="menu-item logout"><img src="../Photo/logout.png"><h3>Logout</h3></a>
        </div>

        <div class="content-area">
            <div class="white-card">
                <h2>Lecturers Management</h2>

                <div style="margin-bottom: 25px; padding: 20px; background: #fcfcfc; border: 1px solid #eee; border-radius: 10px;">
                    <h4 style="margin-bottom: 15px; color: #003366;">Add New Lecturer</h4>
                    <form action="insert_lecturer.php" method="POST" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 120px;">
                            <label style="display:block; font-size: 13px; margin-bottom: 5px;">Lecturer ID</label>
                            <input type="text" name="username" placeholder="Lecturer ID" required style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 1.5; min-width: 180px;">
                            <label style="display:block; font-size: 13px; margin-bottom: 5px;">Full Name</label>
                            <input type="text" name="fullname" placeholder="Lecturer Name" required style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 1.5; min-width: 180px;">
                            <label style="display:block; font-size: 13px; margin-bottom: 5px;">Email</label>
                            <input type="email" name="email" placeholder="lecturer@psu.ac.th" required style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 1; min-width: 120px;">
                            <label style="display:block; font-size: 13px; margin-bottom: 5px;">Password</label>
                            <input type="password" name="password" placeholder="Password" required style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <button type="submit" style="background: #003366; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">Add</button>
                    </form>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="15%">Lecturer ID</th>
                            <th width="25%">Lecturer Name</th>
                            <th width="30%">Email</th>
                            <th width="30%">Signed in</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM users WHERE role = 'lecturer' ORDER BY id ASC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo '<td>' . $row['username'] . '</td>'; 
                                echo '<td>' . $row['fullname'] . '</td>'; 
                                echo '<td>' . (isset($row['email']) ? $row['email'] : '-') . '</td>'; 
                                $date = ($row['created_at']) ? date("d/m/Y", strtotime($row['created_at'])) : '-';
                                echo '<td>' . $date . '</td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center; padding: 20px;'>No lecturers found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="pagination-container">
                    <button class="btn-next">Next &gt;</button>
                </div>
            </div> 
        </div>
    </div> 
</body>
</html>