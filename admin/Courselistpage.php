<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';


$lecturer_query = "SELECT fullname FROM users WHERE role = 'lecturer' ORDER BY fullname ASC";
$lecturers = mysqli_query($conn, $lecturer_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Course List</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/admincourseliststyle.css">
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
            <a href="Courselistpage.php" class="menu-item active">
                <img src="../Photo/courselist.png" alt="">
                <h3>Course List</h3>
            </a>
            <a href="Absencetypepage.php" class="menu-item">
                <img src="../Photo/absencetype.png" alt="">
                <h3>Absence Type</h3>
            </a>
            <a href="studentspage.php" class="menu-item">
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
            <div class="course-list-card">
                
                <div class="card-header">
                    <h1>Course List</h1>
                </div>

                <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #eee;">
                    <form action="insert_course.php" method="POST" style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 120px;">
                            <label style="display:block; font-size: 13px; margin-bottom: 5px;">Course Code</label>
                            <input type="text" name="course_code" placeholder="e.g. IT101" required style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 2; min-width: 200px;">
                            <label style="display:block; font-size: 13px; margin-bottom: 5px;">Course Name</label>
                            <input type="text" name="course_name" placeholder="Course Name" required style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <div style="flex: 1.5; min-width: 180px;">
                            <label style="display:block; font-size: 13px; margin-bottom: 5px;">Lecturer Name</label>
                            <select name="lecturer_name" required style="width:100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                                <option value="">-- Select Lecturer --</option>
                                <?php 
                               
                                mysqli_data_seek($lecturers, 0);
                                while($lec = mysqli_fetch_assoc($lecturers)): ?>
                                    <option value="<?php echo $lec['fullname']; ?>"><?php echo $lec['fullname']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" style="background: #003366; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">+ Add Course</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="course-table">
                        <thead>
                             <tr>
                                <th width="10%">ID</th>
                                <th width="15%">Course Code</th>
                                <th width="30%">Course Name</th>
                                <th width="30%">Lecturer Name</th>
                                <th width="15%">Action</th> </tr>
                        </thead>

                        <tbody>
    <?php
    
    $sql = "SELECT * FROM courses ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            
            
            echo '<td>';
            echo '<a href="editcoursepage.php?id=' . $row['id'] . '" style="color: #003366; text-decoration: underline; font-size: 14px;">';
            echo str_pad($row['id'], 4, '0', STR_PAD_LEFT);
            echo '</a>';
            echo '</td>';

            echo '<td>' . $row['course_code'] . '</td>';
            echo '<td>' . $row['course_name'] . '</td>';
            echo '<td>' . $row['lecturer_name'] . '</td>';
            
            
            echo '<td>';
            echo '<a href="delete_course.php?id=' . $row['id'] . '" onclick="return confirm(\'ยืนยันการลบรายวิชานี้?\')" style="color: red; text-decoration: none; font-weight:bold;">Delete</a>';
            echo '</td>';
            
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5' style='text-align:center; padding: 20px;'>No courses found</td></tr>";
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