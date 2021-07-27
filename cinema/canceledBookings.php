<?php
require "header.php";
?>

<div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
		<h1 class="title">Canceled Bookings</h1>
	</div>
	
	<div class="container-xl">
		
		<table class="table table-bordered border-primary" style="color: white; border-color: #ff6600; margin-bottom: 150px; font-size:smaller;">
			<tr>
			    <td><strong>ID</strong></td>
				<td><strong>CUSTOMER</strong></td>
				<td><strong>MOVIE</strong></td>
				<td><strong>ROOM & SEAT</strong></td>
				<td><strong>SCHEDULE DATE</strong></td>
				<td><strong>CANCEL DATE</strong></td>
			</tr>

            <?php

             include "includes/createCanceledBookTable.inc.php";

            ?>

			</table>
			
			</div>
			
			</main>


<?php
require "footer.php";
?>