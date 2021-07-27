<?php
require "header.php";
?>

<main>

<div class="jumbotron" style="background-color: #333333; margin-bottom: -45px;">
		<h1 class="title">Completed Schedules</h1>
	</div>
	
	<div class="container-xl">
		
		<table class="table table-bordered border-primary" style="color: white; border-color: #ff6600; margin-bottom: 150px; font-size: smaller;">
			<tr>
				<td><strong>ID</strong></td>
				<td><strong>MOVIE</strong></td>
				<td><strong>ROOM</strong></td>
                <td><strong>PLAYING DATE</strong></td>
                <td><strong>PLAYING TIME</strong></td>
			</tr>

            <?php

             include "includes/createCompleSchTable.inc.php";

            ?>

			</table>
			
			</div>

</main>

<?php
require "footer.php";
?>