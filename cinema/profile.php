<?php 
	require "header.php";
?>

<main>
		<div class="container-xl">
		<div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
			<h1 class="title">Previous bookings</h1>
		</div>
		
		<table class="table table-bordered border-primary" style="color: white; border-color: #ff6600; margin-bottom: 150px;">
			<tr>
				<td><strong>PLAYING DATE</strong></td>
				<td><strong>MOVIE</strong></td>
				<td><strong>ROOM</strong></td>
				<td><strong>SEAT</strong></td>
				<td><strong>BOOKED DATE</strong></td>
			</tr>

			<?php 
			
				include "includes/createTableProfile.inc.php";

			?>


			</tr>
			</table>
			
			</div>
			
			</main>
			
			<?php 
			require "footer.php";
			?>			