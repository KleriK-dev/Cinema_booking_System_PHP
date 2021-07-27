<?php
require "header.php";
?>

<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

//check urls to display the correct alert
if ($url === "http://localhost/cinema/createRoom.php?roomCreated=success") {

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Room was created successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

} else if ($url === "http://localhost/cinema/createRoom.php?roomCreated=failed"){

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Room can not be created, Unknown Error!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

}

?>

<main>

    <?php

    if (isset($_GET['editRoom'])) { //check if edit button was pressed and display the edit form

        include "includes/connectDB.inc.php";

        $roomID = $_GET['editRoom'];

        $query = "SELECT * FROM rooms WHERE room_id = $roomID ";

        $result = $conn->query($query);
        $row = mysqli_fetch_assoc($result);

        //show edit form
        echo '
                <div style="margin: 35px 0 35px 0 ;">
        <h1 class="title" style="text-align: center; margin-bottom: 30px;">Update Room</h1>
        <div style="max-width: 50%; margin: auto; color: white;">
            <form action="classes/rooms.class.php" method="POST" enctype="multipart/form-data">
            <input type="text" style="display: none;" name="room_idH" value="' . $row['room_id'] . '">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Update room name:</label>
                <input type="text" class="form-control" id="formGroupExampleInput" name="roomName"
                    value="' . $row['roomName'] . '" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Update a description:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                    name="roomDescription">' . $row['roomDescription'] . '</textarea> 
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Update Image of Room:</label><br>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                As you pressed edit, you have to input the image again!
                            </div>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="uploadfile" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Update Seats:</label>
                <input type="numeric" class="form-control-file" id="exampleFormControlFile1" name="columnNr" value="' . $row['seat_column'] . '" required>
                <input type="numeric" class="form-control-file" id="exampleFormControlFile1" name="rowNr" value="' . $row['seat_row'] . '" required>
            </div>
            <div style="text-align: left;">
                <button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-roomUp">Update Room</button>
            </div>
        </form>
            ';
    } else { //else show creation form
        echo '
                <div style="margin: 35px 0 35px 0 ;">
        <h1 class="title" style="text-align: center; margin-bottom: 30px;">Create Room</h1>
        <div style="max-width: 50%; margin: auto; color: white;">
                <form action="classes/rooms.class.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Input room name:</label>
                <input type="text" class="form-control" id="formGroupExampleInput" name="roomName"
                    placeholder="Room Name" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Input a description:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                    placeholder="Room Description" name="roomDescription"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Input Image of Room:</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="uploadfile" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Create Seats:</label>
                <input type="numeric" class="form-control-file" id="exampleFormControlFile1" name="columnNr" placeholder="Column Number" required>
                <input type="numeric" class="form-control-file" id="exampleFormControlFile1" name="rowNr" placeholder="Row Number" required>
            </div>
                <button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-roomCr">Create Room</button>
        </form>
        ';
    }

    ?>

    </div>
    </div>

</main>


<?php
require "footer.php";
?>