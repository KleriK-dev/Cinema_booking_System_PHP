<?php

session_start(); //Start a session here to see who is logged in and get his id from $_SESSION

class Booking
{
    private $booking_id;
    private $movie;
    private $date;
    private $hour;
    private $room;
    private $seats;
    // we need these variables to update seat status by storing the old values here 
    private $datePrevious;
    private $hourPrevious;
    private $roomPrevious;
    private $seatsPrevious;
    private $seatID;
    private $reSeatID;

    function __construct($booking_id, $movie, $date, $hour, $room, $seats, $datePrevious, $hourPrevious, $roomPrevious, $seatsPrevious,$seatID,$reSeatID)
    {
        $this->booking_id = $booking_id;
        $this->movie = $movie;
        $this->date = $date;
        $this->hour = $hour;
        $this->room = $room;
        $this->seats = $seats;
        $this->datePrevious = $datePrevious;
        $this->hourPrevious = $hourPrevious;
        $this->roomPrevious = $roomPrevious;
        $this->seatsPrevious = $seatsPrevious;
        $this->seatID = $seatID;
        $this->reSeatID = $reSeatID;

    }

    public function addBooking($userId) //The parameter gets the user's id so we can know who is booking 
    {
        //connecting to database
        include "../includes/connectDB.inc.php";

        //insert user id and the schedule he choosed by checking one by one his choices
        //if the choices he made are the same of one row of the schedule table than get its id
        $query = "INSERT INTO booking (user_id, schedule_id) 
                SELECT userID, schedule_id  FROM users, schedule 
                WHERE movie_id = (SELECT movie_id FROM movies WHERE movieName='$this->movie') 
                AND room_id = (SELECT room_id FROM rooms WHERE roomName='$this->room') 
                AND startDate = '$this->date'
                AND startHours = '$this->hour' 
                AND userID = '$userId'"; 

        if ($conn->query($query) == true) {

            foreach($this->seats as $row){

            $query2 = "INSERT INTO reservedseats (booking_id, seatName, seat_id)
                        SELECT booking.booking_id, seats.seatName, seats.seat_id FROM booking
                        INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
                        INNER JOIN rooms ON schedule.room_id = rooms.room_id
                        INNER JOIN seats ON rooms.roomName = seats.roomName
                        WHERE booking.user_id = '$userId'
                        AND schedule.room_id = (SELECT room_id FROM rooms WHERE roomName = '$this->room')
                        AND seats.seatName = '$row'
                        AND seats.startDate = '$this->date'
                        AND seats.startHours = '$this->hour' ";

                        $result = $conn->query($query2);

                        if ($result == false) {
                            echo "Error occured!";
                        } else {

                            $query3 = "UPDATE seats SET seatStatus = 'Booked'
                                        WHERE seatName = '$row' 
                                        AND roomName = '$this->room'
                                        AND startDate = '$this->date'
                                        AND startHours = '$this->hour' ";            

                            $result = $conn->query($query3);

                            if ($result == false) {
                               echo "Error occured!";
                            }

                        }

            }

            header("Location: ../booking.php?TicketBooked=success");
            exit();
            
            } else {
            header("Location: ../booking.php?TicketBooked=failed");
            exit();
        } 
    }

    public function cancelBooking() //this function will insert the canceled bookings in another table and delete it from the booking table
    {
        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO `canceledbookings` (c_Email, movie, room, seat, s_date, s_time)
                    SELECT users.userEmail, movies.movieName, rooms.roomName, reservedseats.seatName, schedule.startDate, schedule.startHours
                    FROM users
                    INNER JOIN booking ON users.userID = booking.user_id
                    INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
                    INNER JOIN movies ON schedule.movie_id = movies.movie_id
                    INNER JOIN rooms ON schedule.room_id = rooms.room_id
                    INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
                    INNER JOIN seats ON seats.roomName = rooms.roomName
                    WHERE booking.booking_id = '$this->booking_id'
                    AND seats.roomName = '$this->room'
                    AND seats.startDate = '$this->date'
                    AND seats.startHours = '$this->hour'
                    AND seats.seatName = '$this->seats'
                    AND reservedseats.reservedSeat_id = '$this->reSeatID' ";         

        if ($conn->query($query) == true) { //if the insertion succed than delete

            $query1 = "UPDATE seats SET seatStatus = 'Not booked' 
                        WHERE seatName = '$this->seats'
                        AND seats.roomName = '$this->room'
                        AND seats.startDate = '$this->date'
                        AND seats.startHours = '$this->hour' "; 

            if($conn->query($query1) == true){

                $query2 = "DELETE FROM reservedseats WHERE booking_id = '$this->booking_id' AND seatName = '$this->seats' "; 
                
                if($conn->query($query2) == true){

                    $query3 = "DELETE FROM booking WHERE booking_id = '$this->booking_id'";

                    //this query will give false as many times the admin cancel a seat from a customer 
                    if($conn->query($query3) == true){
                        //it will become true once the admin cancels the last seat that the customer booked because than it will delete the booking_id from booking
                        header("Location: ../bookings.php?bookingCanceled=success");
                        exit();
                    } else {
                        //head on bookings with the message success as the seat will be canceled but there exists more booked seats in customers name
                        header("Location: ../bookings.php?bookingCanceled=success");
                        exit();
                    }

            }

            }
            
        } else {
            header("Location: ../bookings.php?bookingCanceled=failed");
            exit();
        }
     }

    public function editBooking()
    {
        include "../includes/connectDB.inc.php";

        $query = "UPDATE booking 
                    SET booking.schedule_id = 
                    (
                        SELECT schedule.schedule_id FROM schedule 
                        WHERE schedule.movie_id = (SELECT movies.movie_id FROM movies WHERE movieName = '$this->movie')
                        AND schedule.room_id = (SELECT rooms.room_id FROM rooms WHERE roomName = '$this->room' )
                        AND schedule.startDate = '$this->date'
                        AND schedule.startHours = '$this->hour'
                    )
                    WHERE booking_id = '$this->booking_id' ";

        if ($conn->query($query) == true) {

            $query1 = "UPDATE seats SET seatStatus = 'Not booked' 
                        WHERE seatName = '$this->seatsPrevious'
                        AND seats.roomName = '$this->roomPrevious'
                        AND seats.startDate = '$this->datePrevious'
                        AND seats.startHours = '$this->hourPrevious'";

                if($conn->query($query1) == true){


            $query12 = "DELETE FROM reservedseats WHERE booking_id = '$this->booking_id' AND seatName = '$this->seatsPrevious' AND seat_id = '$this->seatID' ";

            if($conn->query($query12) == true){

            foreach($this->seats as $row){

            $query2 = "INSERT INTO reservedseats (booking_id, seatName, seat_id) 
                        SELECT '$this->booking_id', seats.seatName, seat_id FROM booking, seats
                        WHERE seats.roomName = '$this->room'
                        AND seats.seatName = '$row'
                        AND seats.startDate = '$this->date'
                        AND seats.startHours = '$this->hour'
                        LIMIT 1 ";

            $result = $conn->query($query2);

            if ($result == false) {
                echo "Error occured!";
            } else{

                $query3 = "UPDATE seats SET seatStatus = 'Booked' WHERE seatName = '$row' 
                            AND roomName = '$this->room' 
                            AND seats.startDate = '$this->date'
                            AND seats.startHours = '$this->hour'";

                $result = $conn->query($query3);

            if ($result == false) {
                echo "Error occured!";
            } 
   
        }
            }
        }

        }

            header("Location: ../bookings.php?bookingEdited=success");
            exit();
        } else {
            header("Location: ../bookings.php?bookingEdited=failed");
            exit();
        }
    }

    public function completeBooking() //a function that stores the completed tickets to a table 
    {

        include "../includes/connectDB.inc.php";

        //insert all the data to the table
        $query = "INSERT INTO completed_bookings (userEmail, movieName, roomName, seatName, startDate, startHours)
                SELECT users.userEmail, movies.movieName, rooms.roomName, reservedseats.seatName, schedule.startDate, schedule.startHours
                FROM users
                INNER JOIN booking ON users.userID = booking.user_id
                INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
                INNER JOIN movies ON schedule.movie_id = movies.movie_id
                INNER JOIN rooms ON schedule.room_id = rooms.room_id
                INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
                INNER JOIN seats ON seats.roomName = rooms.roomName
                WHERE reservedseats.booking_id = '$this->booking_id'
                AND seats.roomName = '$this->room'
                AND seats.startDate = '$this->date'
                AND seats.startHours = '$this->hour'
                AND seats.seatName = '$this->seats'
                AND reservedseats.reservedSeat_id = '$this->reSeatID' ";

        if ($conn->query($query) == true) {

            //delete data from reservedseats as it has foreign key from booking and need to be deleted first
            
            $query1 = "UPDATE seats SET seatStatus = 'Not booked' 
                        WHERE seatName = '$this->seats'
                        AND seats.roomName = '$this->room'
                        AND seats.startDate = '$this->date'
                        AND seats.startHours = '$this->hour' ";

            if($conn->query($query1) == true){

                //than delete booking
                $query2 = "DELETE FROM reservedseats WHERE booking_id = '$this->booking_id' AND seatName = '$this->seats' ";

                if($conn->query($query2) == true){

                    $query3 = "DELETE FROM booking WHERE booking_id = '$this->booking_id'";

                    $result = $conn->query($query3);

                    //we do this for the same reason as in cancel booking
                    if ($result == false) {
                        header("Location: ../bookings.php?bookingCompleted=success");
                        exit();
                    } else {
                        header("Location: ../bookings.php?bookingCompleted=success");
                        exit();
                    }
                }

            }

        } else {
            header("Location: ../bookings.php?bookingCompleted=failed");
            exit();
        }

    }

}

//check if submit button is pressed from customer
if (isset($_POST['submit-booking'])) {

    //Converting date and time in the proper format so it can be saved in DB
    $date = date('Y-m-d', strtotime($_POST['date']));
    $hour = date('H:i:s', strtotime($_POST['hours']));

    if($_POST['seats'] == null){
        header("Location: ../booking.php?TicketBooked=null");
        exit;
    }

    $newBooking = new Booking(null, $_POST['movie'], $date, $hour, $_POST['room'], $_POST['seats'], null, null, null, null, null, null);

    $newBooking->addBooking($_SESSION['userId']); //Store users id in the parameter of the function 

}

//check if submit button is pressed from admin
if (isset($_POST['submit-booking-admin'])) {

    //Converting date and time in the proper format so it can be saved in DB
    $date = date('Y-m-d', strtotime($_POST['date']));
    $hour = date('H:i:s', strtotime($_POST['hours']));

    if($_POST['seats'] == null){ //check if seat was choosed
        header("Location: ../booking.php?TicketBooked=null");
        exit;
    }

    $newBooking = new Booking(null, $_POST['movie'], $date, $hour, $_POST['room'], $_POST['seats'], null, null, null, null, null, null);

    $newBooking->addBooking($_POST['customer']); //Store customers id in the parameter of the function 

}

if (isset($_GET['cancelBooking'])) { //check if admin pressed cancel button

    $date = date('Y-m-d', strtotime($_GET['date']));
    $hour = date('H:i:s', strtotime($_GET['time']));

    $deleteBooking = new Booking($_GET['cancelBooking'], null, $date, $hour, $_GET['roomName'], $_GET['seat'], null, null, null, null, null, $_GET['reSeat']); //we need only booking_id as a parameter

    $deleteBooking->cancelBooking();
}

if (isset($_POST['submit-bookingUp'])) { //check if admin pressed edit button

    $date = date('Y-m-d', strtotime($_POST['date']));
    $hour = date('H:i:s', strtotime($_POST['hours']));

    $datePrev = date('Y-m-d', strtotime($_POST['oldDate_H']));
    $hourPrev = date('H:i:s', strtotime($_POST['oldTime_H']));

    if($_POST['seats'] == null){ //check if seat was choosed
        header("Location: ../bookings.php?bookingEdited=null");
        exit;
    }

    $editBooking = new Booking($_POST['booking_idH'],  $_POST['movie'], $date, $hour, $_POST['room'], $_POST['seats'], $datePrev, $hourPrev, $_POST['oldRoom_H'], $_POST['oldSeat_H'], $_POST['oldSeatID_H'], null);

    $editBooking->editBooking();
}

if(isset($_GET['completeBooking'])){ //check if admin pressed complete button

    $date = date('Y-m-d', strtotime($_GET['date']));
    $hour = date('H:i:s', strtotime($_GET['time']));

    $completeBooking = new Booking($_GET['completeBooking'], null,  $date, $hour, $_GET['roomName'],  $_GET['seat'], null, null,null, null, null, $_GET['reSeat']); //we need only booking_id as a parameter

    $completeBooking->completeBooking();

}