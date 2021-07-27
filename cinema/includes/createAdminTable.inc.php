<?php

//connecting to database
include "includes/connectDB.inc.php";

//a query that joins 4 tables to get all the data we need
$query = "SELECT users.userEmail, 
                 seats.roomName, 
                 seats.startDate, 
                 seats.movieName, 
                 seats.startHours, 
                 booking.booking_id, 
                 booking.booked_date,
                 reservedseats.seatName,
                 reservedseats.seat_id,
                 reservedseats.reservedSeat_id
            FROM users
            INNER JOIN booking ON users.userID = booking.user_id
            INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
            INNER JOIN seats ON seats.seat_id = reservedseats.seat_id";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0){
    
    foreach($result as $row){
?>

<tr>
    <td><?php echo $row['booking_id']; ?></td>
    <td><?php echo $row['booked_date']; ?></td>
    <td><?php echo $row['userEmail']; ?></td>
    <td><?php echo $row['movieName']; ?></td>
    <td><?php echo $row['roomName']; ?> , <?php echo $row['seatName']; ?></td> 
    <td><?php echo $row['startDate'];?> , <?php echo $row['startHours'];?></td>
    <td>
        <a href="classes/booking.class.php?completeBooking=<?php echo $row['booking_id']; ?>&roomName=<?php echo $row['roomName']; ?>&date=<?php echo $row['startDate']; ?> &time=<?php echo $row['startHours']; ?>&seat=<?php echo $row['seatName']; ?>&reSeat=<?php echo $row['reservedSeat_id']; ?>" class="btn btn-success btn-sm">Complete</a>
        <a href="booking.php?editBooking=<?php echo $row['booking_id']; ?>&oldDate=<?php echo $row['startDate'];?>&oldTime=<?php echo $row['startHours'];?>&oldRoom=<?php echo $row['roomName']; ?>&oldSeat=<?php echo $row['seatName']; ?>&seatID=<?php echo $row['seat_id']; ?>" class="btn btn-info btn-sm">Edit</a>
        <a href="classes/booking.class.php?cancelBooking=<?php echo $row['booking_id']; ?>&roomName=<?php echo $row['roomName']; ?>&date=<?php echo $row['startDate']; ?> &time=<?php echo $row['startHours']; ?>&seat=<?php echo $row['seatName']; ?>&reSeat=<?php echo $row['reservedSeat_id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
    </td>
</tr>

<?php 
    }
}

?>