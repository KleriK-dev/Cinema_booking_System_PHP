<?php

class Movie
{
    private $movie_id;
    private $movieName;
    private $movieDescription;
    private $movieImage;

    function __construct($movie_id, $movieName, $movieDescription, $movieImage)
    {
        $this->movie_id = $movie_id;
        $this->movieName = $movieName;
        $this->movieDescription = $movieDescription;
        $this->movieImage = $movieImage;
    }

    public function addMovie()
    {

        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO movies 
                  VALUES (NULL, '$this->movieName', '$this->movieImage', '$this->movieDescription')";

        if ($conn->query($query) == true) {
            header("Location: ../createMovie.php?movieCreated=success");
            exit();
        } else {
            header("Location: ../createMovie.php?movieCreated=failed");
            exit();
        }
    }

    public function deleteMovie()
    {
        include "../includes/connectDB.inc.php";

        $query = "DELETE FROM movies WHERE movie_id = $this->movie_id ";

        if ($conn->query($query) == true) {
            header("Location: ../createMovie.php?movieDeleted=success");
            exit();
        } else {
            header("Location: ../createMovie.php?movieDeleted=failed");
            exit();
        }
    }

    public function editMovie()
    {
        include "../includes/connectDB.inc.php";

        $query = "UPDATE movies
                    SET movieName = '$this->movieName',
                        movieDescription = '$this->movieDescription',
                        movieImage = '$this->movieImage'
                    WHERE movie_id = $this->movie_id
                    ";

        if ($conn->query($query) == true) {
            header("Location: ../createMovie.php?movieEdited=success");
            exit();
        } else {
            header("Location: ../createMovie.php?movieEdited=failed");
            exit();
        }
    }

}

if (isset($_POST['submit-movieCr'])) {// check if create button was pressed

    //we need to prepare the file to a string in correct form so it can be saved correctlly
    $image = addslashes(file_get_contents($_FILES['movieImage']['tmp_name']));

    $newMovie = new Movie(null, $_POST['movieName'], $_POST['movieDescription'], $image); //we put null to the first parameter as we dont need it in this action

    $newMovie->addMovie();
}

if (isset($_GET['delete'])) {// check if delete button was pressed

    $deleteMovie = new Movie($_GET['delete'], null, null, null); //we put null to the other parameters as we don't need them

    $deleteMovie->deleteMovie();
}

if(isset($_POST['submit-movieUP'])){// check if edit button was pressed

    $image = addslashes(file_get_contents($_FILES['movieImage']['tmp_name']));

    $updateMovie = new Movie($_POST['movie_idH'], $_POST['movieName'], $_POST['movieDescription'], $image); 

    $updateMovie->editMovie();

}