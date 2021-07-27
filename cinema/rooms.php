<?php
require "header.php";
?>

<main>

  <div class="container-xl">

    <?php

    //checking URL to display alerts
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if ($url === "http://localhost/cinema/rooms.php?roomDeleted=success") {

      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Room was deleted successfully!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    } else if ($url === "http://localhost/cinema/rooms.php?roomDeleted=failed") {

      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      This room can not be deleted as it has a schedule, Please first delete the schedule!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    } else if ($url === "http://localhost/cinema/rooms.php?roomEdited=success") {

      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      Room was edited successfully!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    } else if ($url === "http://localhost/cinema/rooms.php?roomEdited=failed") {

      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Room could not be edited, Unknown Error occured!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }

    ?>

    <div class="jumbotron" style="background-color: #333333; margin-top: -30px; margin-bottom: -80px;">
      <h1 class="title" style="text-align: center;">Opened Rooms</h1>
      <div class="jumbotron" style="background-color: #333333; margin-top: -30px;">

        <?php

        include "includes/connectDB.inc.php";

        $query = "SELECT * FROM rooms";

        $result = $conn->query($query);
        $row = mysqli_fetch_assoc($result);

        if ($result->num_rows > 0) {

          foreach ($result as $row) {

        ?>

            <div class="card mb-3" style="max-width: 650px; margin: 0 auto; background-color: #666666; color: white;">
              <?php echo '<img src="data:image;base64,' . base64_encode($row['room_image']) . '" class="card-img-top">'; ?>
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['roomName']; ?></h5>
                <p class="card-text"><?php echo $row['roomDescription']; ?></p>
                <p class="card-text"><strong> SEATS: &nbsp;
                 <?php echo $row['seat_column'] * $row['seat_row']; //multiplying col and row to find total seats?></strong></p>


                <?php
                if (isset($_SESSION['userId'])) { //Check first if someone is logged in
                  if ($_SESSION['userRole'] == "Administrator") { //than check who logged in
                ?>
                    <!-- Show buttons only to administrator-->
                    <a href="createRoom.php?editRoom=<?php echo $row['room_id']; ?>" class="btn btn-info">Edit</a>
                    <a href="classes/rooms.class.php?deleteRoom=<?php echo $row['room_id']; ?>" class="btn btn-danger">Delete</a>
                <?php
                  }
                }
                ?>


              </div>
            </div>

        <?php
          }
        } else {

          echo '<h3 style="color: white; text-align: center;">No rooms are opened!</h3>';
        }

        ?>

      </div>
    </div>
  </div>

</main>


<?php
require "footer.php";
?>