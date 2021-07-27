<?php
require "header.php";
?>

	<?php 
	
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

	if ($url === "http://localhost/cinema/schedules.php?scheduleCanceled=success") {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		Schedule canceled successfully!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

    } else if ($url === "http://localhost/cinema/schedules.php?scheduleCanceled=failed") {

		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		Schedule did not cancel, It is booked by a customer!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	} else if ($url === "http://localhost/cinema/schedules.php?scheduleEdited=success"){

		echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
		Schedule updated!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	} else if ($url === "http://localhost/cinema/schedules.php?scheduleEdited=failed") {

		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		Schedule did not update, Unknown error occured!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	} else if ($url === "http://localhost/cinema/schedules.php?scheduleCompleted=success") {

		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
		Schedule completed!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	} else if ($url === "http://localhost/cinema/schedules.php?scheduleCompleted=failed") {

		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		Schedule did not complete, as it is booked by a customer!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';

	}
	
	?>

<div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
		<h1 class="title">Schedules</h1>
	</div>
	
	<div class="container-xl">
		
		<table class="table table-bordered border-primary" style="color: white; border-color: #ff6600; margin-bottom: 150px; font-size: smaller;">
			<tr>
                <td><strong>ID</strong></td>
				<td><strong>MOVIE</strong></td>
				<td><strong>ROOM</strong></td>
                <td><strong>SEATS</strong></td>
                <td><strong>PLAYING DATE</strong></td>
                <td><strong>PLAYING TIME</strong></td>
				<td><strong>MANAGE</strong></td>
			</tr>

            <?php

             include "includes/createScheduleTable.inc.php";

            ?>

			</table>
			
			</div>

			
			</main>


<?php
require "footer.php";
?>