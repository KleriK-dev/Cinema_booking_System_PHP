<?php

include "includes/connectDB.inc.php";

$query = "SELECT movies.movieName, rooms.roomName, rooms.seat_column, rooms.seat_row, schedule.startDate, schedule.startHours, schedule.schedule_id
          FROM movies
          INNER JOIN schedule ON schedule.movie_id = movies.movie_id
          INNER JOIN rooms ON schedule.room_id = rooms.room_id";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0) {

    foreach ($result as $row) {

?>


<tr>
    <td><?php echo $row['schedule_id']; ?></td>
    <td><?php echo $row['movieName']; ?></td>
    <td><?php echo $row['roomName']; ?></td>
    <td><?php echo $row['seat_column'] * $row['seat_row']; ?></td> 
    <td><?php echo $row['startDate'];?></td>
    <td><?php echo $row['startHours'];?></td>
    <td>
        <a href="classes/schedules.class.php?completeSchedule=<?php echo $row['schedule_id']; ?>&date=<?php echo $row['startDate'];?>&time=<?php echo $row['startHours'];?>&room=<?php echo $row['roomName']; ?>" class="btn btn-success btn-sm">Complete</a>
        <a href="createSchedule.php?editSchedule=<?php echo $row['schedule_id']; ?>&date=<?php echo $row['startDate'];?>&time=<?php echo $row['startHours'];?>&room=<?php echo $row['roomName']; ?>" class="btn btn-info btn-sm">Edit</a>
        <a href="classes/schedules.class.php?cancelSchedule=<?php echo $row['schedule_id'];?>&date=<?php echo $row['startDate'];?>&time=<?php echo $row['startHours'];?>&room=<?php echo $row['roomName']; ?>" class="btn btn-danger btn-sm">Cancel</a>
    </td>
</tr>


<?php
    }
}
?>