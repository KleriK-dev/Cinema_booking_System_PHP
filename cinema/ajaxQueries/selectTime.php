<?php

include "../includes/connectDB.inc.php";

if(isset($_GET['date'])){

$movie = $_GET['movie'];
$room = $_GET['room'];
$date = $_GET['date'];

$query = "SELECT schedule.startHours 
        FROM schedule
        WHERE schedule.room_id = (SELECT room_id FROM rooms WHERE roomName = '$room' )
        AND schedule.movie_id = (SELECT movie_id FROM movies WHERE movieName = '$movie' )
        AND schedule.startDate = '$date' ";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0) {

    foreach ($result as $row) { ?>

<option selected value="<?php echo $row['startHours'];?>"><?php echo $row['startHours'];?></option>

<?php        
    }

}

} 

?>