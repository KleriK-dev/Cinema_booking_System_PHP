<?php
require "header.php";
?>

<main>

<?php
//checking if someone that is not logged in or administrator tries to access the page through url
if(isset($_SESSION['userId'])){
    if($_SESSION['userRole'] == "Administrator"){ //if it is administrator display else display nothing

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

//check creation and alert
if ($url === "http://localhost/cinema/createMovie.php?movieCreated=success") {
		
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        Movie was created successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

} else if ($url === "http://localhost/cinema/createMovie.php?movieCreated=failed") {

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Movie was not created, Unknown error occured!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

} 
//check deletion and alert
else if ($url === "http://localhost/cinema/createMovie.php?movieDeleted=success") {

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Movie deleted successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

} else if ($url === "http://localhost/cinema/createMovie.php?movieDeleted=failed") {

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Movie was not deleted, it exists in a schedule!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

} 
//check editetion and alert
else if ($url === "http://localhost/cinema/createMovie.php?movieEdited=success") {

    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Movie was edited successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

} else if ($url === "http://localhost/cinema/createMovie.php?movieEdited=failed") {

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Movie was not edited, Unknown error occured!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';

}

?>

<div class="rowM">

    <div class="columnM">

    <h1 class="title" style="text-align: center; margin-bottom: 30px;">Movies</h1>

        <?php

    include "includes/createAdminMovieC.inc.php";

    ?>

    </div>

    <div class="columnM" style="color:white;">


    <?php 
    
    if (isset($_GET['editMovie'])) { //check if edit button was pressed and display the edit form

        include "includes/connectDB.inc.php";

        $movieID = $_GET['editMovie'];

        $query = "SELECT * FROM movies WHERE movie_id = $movieID ";

        $result = $conn->query($query);
        $row = mysqli_fetch_assoc($result);
    
        echo '<h1 style="text-align: center; margin-bottom: 30px;">Update Movie</h1>
        <div style="max-width: 50%; margin: auto; color: white;">
            <form action="classes/movies.class.php" method="POST" enctype="multipart/form-data">
            <input type="text" style="display: none;" name="movie_idH" value="' . $row['movie_id'] . '">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Update movie title:</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" name="movieName"
                        value="' . $row['movieName'] . '" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Input a description:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                     name="movieDescription" required>' . $row['movieDescription'] . '</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Input Image of Movie:</label><br>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                As you pressed edit, you have to input the image again!
                            </div>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="movieImage" required>
                </div>
                <div style="text-align: left;">
                    <button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-movieUP">Update Movie</button>
                </div>
            </form>
        </div>';
    
    } else {

        echo '<h1 class="title" style="text-align: center; margin-bottom: 30px;">Create Movie</h1>
        <div style="max-width: 50%; margin: auto; color: white;">
            <form action="classes/movies.class.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Input movie title:</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" name="movieName"
                        placeholder="Movie Name" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Input a description:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                        placeholder="Movie Description" name="movieDescription" required></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Input Image of Movie:</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="movieImage" required>
                </div>
                <div style="text-align: left;">
                    <button type="submit" class="btn btn-warning btn-lg btn-block" name="submit-movieCr">Create Movie</button>
                </div>
            </form>
        </div>';

    }

    ?>

    </div>
</div>

<?php 
    } 
}
?>

</main>


<?php
require "footer.php";
?>