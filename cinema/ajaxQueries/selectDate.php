<?php

include "../includes/connectDB.inc.php";

if(isset($_GET['room'])){

    $movie = $_GET['movie'];
    $room = $_GET['room'];

$query = "SELECT schedule.startDate 
            FROM schedule
            WHERE schedule.room_id = (SELECT room_id FROM rooms WHERE roomName = '$room' )
            AND schedule.movie_id = (SELECT movie_id FROM movies WHERE movieName = '$movie' )";

        $result = $conn->query($query);
        $row = mysqli_fetch_assoc($result);

        if ($result->num_rows > 0) {

            foreach ($result as $row) { ?>

<option selected value="<?php echo $row['startDate']; ?> "><?php echo $row['startDate']; ?></option>

<?php 
        }
    }
}
?>