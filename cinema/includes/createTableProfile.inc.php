<?php

$userId = $_SESSION['userId'];

//connecting to database
include "includes/connectDB.inc.php";

//Join 5 tables to get the data we want based on user's id
$query = " SELECT schedule.startDate, movies.movieName, rooms.roomName, booking.booked_date, reservedseats.seatName
            FROM users 
            INNER JOIN booking ON users.userID = booking.user_id
            INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
            INNER JOIN movies ON schedule.movie_id = movies.movie_id
            INNER JOIN rooms ON schedule.room_id = rooms.room_id
            INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
            WHERE booking.user_id = '$userId'";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0){
    
    foreach($result as $row){
?>
<tr>
    <td><?php echo $row['startDate']; ?></td>
    <td><?php echo $row['movieName']; ?></td>
    <td><?php echo $row['roomName']; ?></td>
    <td><?php echo $row['seatName']; ?></td>
    <td><?php echo $row['booked_date']; ?></td>
</tr>

<?php
    }
}

?>