<?php

include "../includes/connectDB.inc.php";

if(isset($_GET['room'])){

    if($_GET['room'] == "nothing"){ //if the room has value nothing display a message

        echo "<p>Select a movie to display the available seats!</p>"; //we need that to avoid a warning of null value on $_GET['room']

    } else { //else display the seats of the room that was selected

    $room = $_GET['room'];
    $date = $_GET['date'];
    $time = $_GET['time'];

$query = "SELECT seat_column, seat_row FROM rooms WHERE rooms.roomName = '$room'";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);


//check the size of the row and create their own class
if ($row['seat_column'] <= 9){ 

    $setCheckboxClass = "checkboxSeat-9";
    $setLabelClass = "seat-9";

} else if ($row['seat_column'] == 10){

    $setCheckboxClass = "checkboxSeat-10";
    $setLabelClass = "seat-10";

} else if ($row['seat_column'] >= 11 && $row['seat_column'] <= 13){

    $setCheckboxClass = "checkboxSeat-11";
    $setLabelClass = "seat-11";

} else if ($row['seat_column'] >= 14){

    $setCheckboxClass = "checkboxSeat-14";
    $setLabelClass = "seat-14";

}

for ($i = 1; $i <= $row['seat_row']; $i++) {

    echo '<div>';

    for ($j = 1; $j <= $row['seat_column']; $j++) {


        //in the nested for loop we need to select the status of the seat with the name that $i and $j from the loop gives and in which room they are
        $query2 = "SELECT seatStatus FROM seats WHERE seatName = '$i-$j' 
                                                AND roomName = '$room'
                                                AND startDate = '$date'
                                                AND startHours = '$time'
                                                ";

        $result2 = $conn->query($query2);
        $row2 = mysqli_fetch_assoc($result2);

        //echo $row2['seatStatus'];

            if ($result2 == false) {
                echo "Error occured!";
            } else {

                if ($row2['seatStatus'] == "Booked"){ //if status is booked make two virables and place them in input tag

                    $checked = "checked"; //to be checked and has color red 
                    $disabled = "disabled"; //to be disabled so it cant be changed as it is booked by someone
                
                } else { //else empty virables 
                
                    $checked = "";
                    $disabled = "";

                }


            


        //name is equal to seats[] as it will get multiple values 
        echo '
                <input class="'.$setCheckboxClass.'" id="chair'.$i.'-'.$j.'" type="checkbox" value="' . $i . '-' . $j . '" name="seats[]" '.$checked.' '.$disabled.'>
                <label for="chair'.$i.'-'.$j.'" class="'.$setLabelClass.'"></label>
              ';
            } 
    }

    echo '</div>';
}

    }

    echo '';

}


?>

<script>

$(document).ready(function(){

    

});

</script>

