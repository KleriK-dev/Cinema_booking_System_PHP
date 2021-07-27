<?php
require "header.php";
?>

<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if ($url === "http://localhost/cinema/createSchedule.php?scheduleCreated=success") {

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                A schedule was created successfully!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
} else if ($url === "http://localhost/cinema/createSchedule.php?scheduleCreated=failed") {

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Schedule was not created, Unknown error occured!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}

?>

<main>
    <div style="margin: 35px 0 35px 0 ;">

        <?php

        if (isset($_GET['editSchedule'])) { //check if edit button was pressed and display the edit form

            include "includes/connectDB.inc.php";

            $scheduleID = $_GET['editSchedule'];

            //select all the data that exists on this schedule id and then display them as vaules
            $query = "SELECT movies.movieName, rooms.roomName, rooms.seat_column, rooms.seat_row, schedule.startDate, schedule.startHours, schedule.schedule_id
                FROM movies
                INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                INNER JOIN rooms ON schedule.room_id = rooms.room_id
                WHERE schedule.schedule_id = $scheduleID ";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            $query2 = "SELECT movieName FROM movies";

            $result2 = $conn->query($query2);
            $row2 = mysqli_fetch_assoc($result2);

            $query3 = "SELECT roomName FROM rooms";

            $result3 = $conn->query($query3);
            $row3 = mysqli_fetch_assoc($result3);

            echo '<h1 class="title" style="text-align: center; margin-bottom: 30px;">Update Schedule</h1>
    <div style="max-width: 50%; margin: auto; color: white;">
                <form action="classes/schedules.class.php" method="POST">
                <input type="text" style="display: none;" name="schedule_idH" value="' . $row['schedule_id'] . '">
                <input type="text" style="display: none;" name="oldScheduleRoom_H" value="' . $_GET['room'] . '">
                <input type="text" style="display: none;" name="oldScheduleDate_H" value="' . $_GET['date'] . '">
                <input type="text" style="display: none;" name="oldScheduleTime_H" value="' . $_GET['time'] . '">

                <div class="form-group">
                <label for="exampleFormControlSelect1">Update movie:</label>
                        <select class="custom-select" id="inputGroupSelect01" name="sch_movieName" required>
                            <option value="' . $row['movieName'] . '" selected>' . $row['movieName'] . '</option>';

            if ($result2->num_rows > 0) {

                foreach ($result2 as $row2) {

                    echo '<option value="' . $row2['movieName'] . '">' . $row2['movieName'] . '</option>';

                }
            }

            echo '</select>
                            </div>';

                            echo '<div class="form-group">
                <label for="exampleFormControlSelect1">Update room:</label>
                        <select class="custom-select" id="inputGroupSelect01" name="sch_movieRoom" required>
                            <option value="' . $row['roomName'] . '" selected>' . $row['roomName'] . '</option>';

            if ($result3->num_rows > 0) {

                foreach ($result3 as $row3) {

                    echo '<option value="' . $row3['roomName'] . '">' . $row3['roomName'] . '</option>';

                }
            }

            echo '</select>
                            </div>';

                    echo '<div class="form-group">
                        <label for="exampleFormControlSelect1">Input date:</label>
                        <input type="date" class="form-control" id="exampleFormControlFile1" name="sch_movieDate" value="' . $row['startDate'] . '" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Input hour:</label>
                        <input type="time" class="form-control" id="exampleFormControlFile1" name="sch_movieTime" value="' . $row['startHours'] . '" required>
                    </div>
                    <div style="text-align: left;">
                        <button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-scheduleUp">Updat Schedule</button>
                    </div>
                </form>
            </div>';
        } else {

            include "includes/connectDB.inc.php";

            $query = "SELECT movieName FROM movies";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            $query2 = "SELECT roomName FROM rooms";

            $result2 = $conn->query($query2);
            $row2 = mysqli_fetch_assoc($result2); ?>

            <h1 class="title" style="text-align: center; margin-bottom: 30px;">Create Schedule</h1>
            <div style="max-width: 50%; margin: auto; color: white;">
                <form action="classes/schedules.class.php" method="POST">

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Input movie:</label>
                        <select class="custom-select" id="inputGroupSelect01" name="sch_movieName" required>
                            <option disabled selected>Select Movie</option>
                            <?php
                            if ($result->num_rows > 0) {

                                foreach ($result as $row) {

                                    echo '<option value="' . $row['movieName'] . '">' . $row['movieName'] . '</option>';
                                }
                            } ?>

                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Input room:</label>
                        <select class="custom-select" id="inputGroupSelect01" name="sch_movieRoom" required>
                            <option value="" disabled selected>Select Room</option>
                            <?php
                            if ($result2->num_rows > 0) {

                                foreach ($result2 as $row2) {

                                    echo '<option value="' . $row2['roomName'] . '">' . $row2['roomName'] . '</option>';
                                }
                            } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Input date:</label>
                        <input type="date" class="form-control" id="exampleFormControlFile1" name="sch_movieDate" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Input hour:</label>
                        <input type="time" class="form-control" id="exampleFormControlFile1" name="sch_movieTime" required>
                    </div>
                    <div style="text-align: left;">
                        <button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-scheduleCr">Create
                            Schedule</button>
                    </div>
                </form>
            </div>

        <?php

        }

        ?>

    </div>

</main>


<?php
require "footer.php";
?>