<?php

//connecting to database
include "includes/connectDB.inc.php";

    

$query = "SELECT * FROM completed_schedule";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0){
    
    foreach($result as $row){
?>

<tr>
    <td><?php echo $row['compS_id']; ?></td>
    <td><?php echo $row['movieName']; ?></td>
    <td><?php echo $row['roomName']; ?></td>
    <td><?php echo $row['startDate'];?></td>
    <td><?php echo $row['startHours'];?></td>
</tr>

<?php 
    }
}

?>