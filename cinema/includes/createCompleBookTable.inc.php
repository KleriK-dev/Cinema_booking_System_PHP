<?php

//connecting to database
include "includes/connectDB.inc.php";

    

$query = "SELECT * FROM completed_bookings";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0){
    
    foreach($result as $row){
?>

<tr>
    <td><?php echo $row['compB_id']; ?></td>
    <td><?php echo $row['userEmail']; ?></td>
    <td><?php echo $row['movieName']; ?></td>
    <td><?php echo $row['roomName']; ?> , <?php echo $row['seatName']; ?></td> 
    <td><?php echo $row['startDate'];?> , <?php echo $row['startHours'];?></td>
</tr>

<?php 
    }
}

?>