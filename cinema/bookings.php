<?php
require "header.php";
?>

	<?php 
	
	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

	if ($url === "http://localhost/cinema/bookings.php?bookingCanceled=success") {
		
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Ticket was Canceled!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

	} else if ($url === "http://localhost/cinema/bookings.php?bookingCanceled=failed") {
		
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Ticket was not canceled, Unknown error occured!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

	} else if ($url === "http://localhost/cinema/bookings.php?bookingCompleted=success") {

		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Ticket completed!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

	} else if ($url === "http://localhost/cinema/bookings.php?bookingCompleted=failed") {

		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Ticket did not complete, as it still in ongoing schedule!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

	} else if ($url === "http://localhost/cinema/bookings.php?bookingEdited=success") {
		
		echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Ticked updated successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

	} else if ($url === "http://localhost/cinema/bookings.php?bookingEdited=failed") {
		
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Ticket was not updated, Unknown error occured!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

	} else if ($url === "http://localhost/cinema/bookings.php?bookingEdited=null") {
		
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Ticket was not updated, no seat was selected!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

	}
	
	?>
	
	<div class="container-xl">
		<div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
			<h1 class="title" style="display: inline;">Customers Bookings</h1>
            <div class="alert alert-warning alert-dismissible fade show" style="float: right;" role="alert">
        Edit bookings one by one if a customer has booked 2 or more seats!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
		</div>
		
		<table class="table table-bordered border-primary" style="color: white; border-color: #ff6600; margin-bottom: 150px; font-size:smaller;">
			<tr>
				<td><strong>ID</strong></td>
				<td><strong>BOOKED ON</strong></td>
				<td><strong>CUSTOMER</strong></td>
				<td><strong>MOVIE</strong></td>
				<td><strong>ROOM & SEATS</strong></td>
				<td><strong>SCHEDULE DATE</strong></td>
				<td><strong>MANAGE</strong></td>
			</tr>

            <?php

             include "includes/createAdminTable.inc.php";

            ?>

			</table>
			
			</div>
			
			</main>


<?php
require "footer.php";
?>