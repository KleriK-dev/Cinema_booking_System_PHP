<?php 
	require "header.php";
?>

<main>

    <script>
    //check url and display alert
    if (window.location.href == "http://localhost/cinema/index.php?login=success") {
        alert("Welcome to CinemaCity!");
    } else if (window.location.href == "http://localhost/cinema/index.php?login=failed"){
        alert("Wrong username or password!");
    } else if (window.location.href == "http://localhost/cinema/index.php?login=notExists"){
        alert("This user does not exists!");
    }

    if (window.location.href == "http://localhost/cinema/index.php?signup=success") {
        alert("Sign up successfully, log in to our site!");
    } else if (window.location.href == "http://localhost/cinema/index.php?signup=failed"){
        alert("Unknown error occured!");
    }

    if (window.location.href == "http://localhost/cinema/index.php?signup=userNameExists") {
        alert("The username exists, please enter different username!");
    } else if (window.location.href == "http://localhost/cinema/index.php?signup=emailExists"){
        alert("The email exists, please enter different email!");
    }

    if (window.location.href == "http://localhost/cinema/index.php?signup=failedreCAPTCHA") {
        alert("Did not check reCAPTCHA!");
    } else if (window.location.href == "http://localhost/cinema/index.php?signup=failedEmptyreCAPTCHA"){
        alert("Did not check reCAPTCHA!");
    }

    </script>

    <div class="jumbotron" style="background-color: #333333; margin-bottom: -50px;">

        <!-- Start Carousel -->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel"
            style="box-shadow: 0 0 5px #f2f2f2;">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/1.jpg" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="images/2.jpg" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="images/3.jpg" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="images/4.jpg" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="images/5.jpg" class="d-block w-100">
                </div>
            </div>
        </div>

        <!-- End Carousel -->

        <div class="jumbotron" style="background-color: #333333; margin-bottom: -67px;">
            <h1 class="title">Scheduled Movies</h1>
        </div>

        <div class="container-xl">
            <div class="jumbotron" style="background-color: #333333; margin-bottom: -15px;">

                <!-- Start cards -->
                <div class="row row-cols-1 row-cols-md-3">

                <?php 
                
                    include "includes/createIndexMovieCards.inc.php";

                ?>

                </div>
                <!-- End cards -->

            </div>

            <?php 
			if(isset($_SESSION['userId'])){
			echo '<h1 class="title">Thank you for choosing us!</h1>
			<p>Book a ticket now and enjoy the best movies out there in good and clean conditions!</p> ';
			} else{
			echo '<h1 class="title">Book a ticket now!</h1>
			<p>You can preorder a ticket for the upcoming movies or you can go to movies and see the movies
			that are playing now!</p>
			<p>But first you have to Sign up and log in!!</p>
			<p>Click <a href="index.php" class="text-decoration-none">here</a> to sign up.</p>';
			}
			?>

        </div>
    </div>

</main>

<?php 
	require "footer.php";
?>