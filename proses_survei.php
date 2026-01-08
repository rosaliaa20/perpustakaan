<?php
include 'includes/db.php';

if (isset($_POST['rating'])) {
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan']);
    
    $query = "INSERT INTO survei (rating, alasan) VALUES ('$rating', '$alasan')";
    
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>