<?php
include '../connect.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "DELETE FROM courses WHERE id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('The course has been successfully deleted.!'); window.location.href='Courselistpage.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>