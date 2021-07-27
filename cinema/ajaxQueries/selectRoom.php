<?php

include "../includes/connectDB.inc.php";

if(isset($_GET['movie'])){

$movie = $_GET['movie'];

$query = "SELECT schedule.startDate, schedule.startHours, rooms.roomName 
FROM schedule, rooms
WHERE schedule.movie_id = (SELECT movie_id FROM movies WHERE movieName = '$movie' )
AND schedule.room_id = rooms.room_id";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0) {

    foreach ($result as $row) { ?>

<option selected value="<?php echo $row['roomName'];?>"><?php echo $row['roomName'];?></option>

<?php        
    }

}
    
} 

?>