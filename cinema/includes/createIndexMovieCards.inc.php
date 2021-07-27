<?php

//connecting to database
include "includes/connectDB.inc.php";

$query = "SELECT movies.movieName, movies.movieImage, movies.movieDescription, rooms.roomName, schedule.startDate, schedule.startHours, schedule.schedule_id
            FROM movies
            INNER JOIN schedule ON schedule.movie_id = movies.movie_id
            INNER JOIN rooms ON schedule.room_id = rooms.room_id";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0) {

    foreach ($result as $row) {
?>

        <div class="col mb-4">
            <div class="card text-center" style="border-color: #ff6600; box-shadow: 0 0 15px #ff6600; background-color: #666666; color: white;">
                <?php echo '<img src="data:image;base64,' . base64_encode($row['movieImage']) . '" class="card-img-top">'; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['movieName']; ?></h5>
                    <p class="card-text"><?php echo $row['movieDescription']; ?></p>
                    <p class="card-text">Playing at <strong><?php echo $row['startDate']; ?> , <?php echo $row['startHours']; ?></strong></p>
                    <p>Room: <strong><?php echo $row['roomName']; ?></strong></p>
                    <?php

                    if (isset($_SESSION['userId'])) {
                        echo '<a href="booking.php?scheduleID='.$row['schedule_id'].'" class="btn btn-primary">Book now</a>';
                    }
                    ?>
                </div>
            </div>
        </div>

<?php
    }
} else { ?>


 <h4 style="color: white; font-family: Simplifica; text-align: center;">No scheduled movies!!</h4>



<?php } ?>