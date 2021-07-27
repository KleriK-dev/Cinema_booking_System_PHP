<?php
require "header.php"
?>

<main>

    <?php

    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if ($url === "http://localhost/cinema/booking.php?TicketBooked=success") {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Ticket was booked successfully!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
    } else if ($url === "http://localhost/cinema/booking.php?TicketBooked=failed") {

        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Failed to book ticket, Unknown error occured!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';
    } else if ($url === "http://localhost/cinema/booking.php?TicketBooked=null") {

        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Failed to book ticket, no seat was selected!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';
    }

    ?>


    <div class="jumbotron" style="background-color: #333333; ">

        <?php
        //check which button was pressed and display form
        if (isset($_GET['scheduleID'])) { //book now button

            $id = $_GET['scheduleID'];

            //connecting to database
            include "includes/connectDB.inc.php";

            $query = "SELECT movies.movieName, rooms.roomName, schedule.startDate, schedule.startHours, schedule.schedule_id
                                        FROM movies
                                        INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                                        INNER JOIN rooms ON schedule.room_id = rooms.room_id
                                        WHERE schedule_id = $id ";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result); ?>

            <div style="color: white;">
                <h1 style="text-align: center; margin-bottom: 30px;">Booking</h1>
                <div style="max-width: 50%; text-align: center; margin: auto;">
                    <form action="classes/booking.class.php" method="POST">

                        <?php
                        //check if administrator is booking and display one more field for the customer input
                        if (isset($_SESSION['userId'])) {
                            if ($_SESSION['userRole'] == "Administrator") {

                                $buttonName = "submit-booking-admin"; //if its the admin we send data with this post name 
                                
                                include "includes/connectDB.inc.php";

                                $selectUser = "SELECT userID, userEmail FROM users"; //select all users emails and ids

                                $result1 = $conn->query($selectUser);
                                $row1 = mysqli_fetch_assoc($result1);

                        ?>
                                <div class="form-group">
                                    <select class="custom-select" id="inputGroupSelectCustomer" name="customer" required>
                                    <option value="" disabled selected>Select Customer</option>
                                    <?php

                                        if ($result1->num_rows > 0) {

                                            foreach ($result1 as $row1) { //display users emails with value their id

                                            echo '<option value="'.$row1['userID'].'">'.$row1['userEmail'].'</option>';

                                            }
                                        }

                                    ?>
                                    </select>
                                </div>

                        <?php

                            } else {

                                $buttonName = "submit-booking"; //if its the customer we send data with this post name 

                            }
                        }
                        ?>

                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectMovie" name="movie" required>
                                <option value="<?php echo $row['movieName']; ?>" selected><?php echo $row['movieName']; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectRoom" name="room" required>
                                <option value="<?php echo $row['roomName']; ?>" selected><?php echo $row['roomName']; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectDate" name="date" required>
                                <option value="<?php echo $row['startDate']; ?>" selected><?php echo $row['startDate']; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectTime" name="hours" required>
                                <option value="<?php echo $row['startHours']; ?>" selected><?php echo $row['startHours']; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="theatre" id="createSeats">

                            </div>
                        </div>
                        <div style="text-align: left;"><button type="submit" class="btn btn-warning btn-lg btn-block" name="<?php echo $buttonName; ?>">Book Ticket</button></div>
                    </form>
                </div>
            </div>

        <?php
        } else if (isset($_GET['editBooking'])) { //edit button

            $id = $_GET['editBooking'];

            include "includes/connectDB.inc.php";

            $query = "SELECT movies.movieName, rooms.roomName, schedule.startDate, schedule.startHours, booking.booking_id
                                        FROM movies
                                        INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                                        INNER JOIN rooms ON schedule.room_id = rooms.room_id
                                        INNER JOIN booking ON booking.schedule_id = schedule.schedule_id
                                        WHERE booking_id = $id ";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

            //a query that selects scheduled movies so we have options to update the booking
            $query2 = "SELECT movieName FROM movies, schedule WHERE schedule.movie_id = movies.movie_id";

            $result2 = $conn->query($query2);
            $row2 = mysqli_fetch_assoc($result2); ?>

            <div style="color: white;">
                <h1 style="text-align: center; margin-bottom: 30px;">Update Ticket</h1>
                <div style="max-width: 50%; text-align: center; margin: auto;">
                    <form action="classes/booking.class.php" method="POST">
                    <!-- send this old data without displaying them as we need them to manipulate the seats from database -->
                        <input type="text" style="display: none;" name="booking_idH" value="<?php echo $row['booking_id']; ?>">
                        <input type="text" style="display: none;" name="oldSeatID_H" value="<?php echo $_GET['seatID']; ?>">
                        <input type="text" style="display: none;" name="oldDate_H" value="<?php echo $_GET['oldDate']; ?>">
                        <input type="text" style="display: none;" name="oldTime_H" value="<?php echo $_GET['oldTime']; ?>">
                        <input type="text" style="display: none;" name="oldRoom_H" value="<?php echo $_GET['oldRoom']; ?>">
                        <input type="text" style="display: none;" name="oldSeat_H" value="<?php echo $_GET['oldSeat']; ?>">
                        <div class="form-group">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                To update a booking you have to select a movie first that is not selected. It can be the same movie if you want!
                            </div>
                            <select class="custom-select" id="inputGroupSelectMovie" name="movie" required>
                                <option value="<?php echo $row['movieName']; ?>" selected><?php echo $row['movieName']; ?></option>
                                <?php
                                if ($result2->num_rows > 0) {

                                    foreach ($result2 as $row2) {

                                        echo '<option value="' . $row2['movieName'] . '">' . $row2['movieName'] . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectRoom" name="room" required>
                                <option value="<?php echo $row['roomName']; ?>" selected><?php echo $row['roomName']; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectDate" name="date" required>
                                <option value="<?php echo $row['startDate']; ?>" selected><?php echo $row['startDate']; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectTime" name="hours" required>
                                <option value="<?php echo $row['startHours']; ?>" selected><?php echo $row['startHours']; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="theatre" id="createSeats">

                            </div>
                        </div>
                        <div style="text-align: left;"><button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-bookingUp">Update Ticket</button></div>
                    </form>
                </div>
            </div>
        <?php
        } else { //no button pressed

            include "includes/connectDB.inc.php";

            //select all the movies that are scheduled 
            $query = "SELECT movieName FROM movies, schedule WHERE schedule.movie_id = movies.movie_id";

            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);

        ?>

            <div style="color: white;">
                <h1 class="title" style="text-align: center; margin-bottom: 30px;">Booking</h1>
                <div style="max-width: 50%; text-align: center; margin: auto;">
                    <form action="classes/booking.class.php" method="post">

                    <?php
                        //check if administrator is booking and display one more field for the customer input
                        if (isset($_SESSION['userId'])) {
                            if ($_SESSION['userRole'] == "Administrator") {

                                $buttonName = "submit-booking-admin"; //if its the admin we send data with this post name 
                                
                                include "includes/connectDB.inc.php";

                                $selectUser = "SELECT userID, userEmail, userFirstName, userLastName FROM users"; //select all users emails and ids

                                $result1 = $conn->query($selectUser);
                                $row1 = mysqli_fetch_assoc($result1);

                        ?>
                                <div class="form-group">
                                    <select class="custom-select" id="inputGroupSelectCustomer" name="customer" required>
                                    <option value="" disabled selected>Select Customer</option>
                                    <?php

                                        if ($result1->num_rows > 0) {

                                            foreach ($result1 as $row1) { //display users emails with value their id

                                            echo '<option value="'.$row1['userID'].'">'.$row1['userEmail'].'</option>';

                                            }
                                        }

                                    ?>
                                    </select>
                                </div>

                        <?php

                            } else {

                                $buttonName = "submit-booking"; //if its the customer we send data with this post name 

                            }
                        }
                        ?>

                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectMovie" name="movie" required>
                                <option value="" disabled selected>Select Movie</option>
                                <?php
                                if ($result->num_rows > 0) {

                                    foreach ($result as $row) {

                                        echo '<option value="' . $row['movieName'] . '">' . $row['movieName'] . '</option>';
                                    }
                                } ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectRoom" name="room" required>
                                <!-- We need this to be selected and have a value for a php check -->
                                <option value="nothing" selected>Select Room</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectDate" name="date" required>
                                <option value="" disabled selected>Select Date</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="inputGroupSelectTime" name="hours" required>
                                <option value="" disabled selected>Select Time</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="theatre" id="createSeats">

                            </div>
                        </div>
                        <div style="text-align: left;">
                            <button type="submit" class="btn btn-warning btn-lg btn-block" name="<?php echo $buttonName; ?>">Book Ticket</button>
                        </div>
                    </form>

                <?php
            }

                ?>

                </div>
            </div>
    </div>

</main>

<script src="ajaxTicket.js"></script> <!-- link js file with ajax -->

<?php
require "footer.php"
?>