<?php
require "header.php";
?>

<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if ($url === "http://localhost/cinema/addUser.php?userAdded=succes") {

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                A user was added successfully!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
} else if ($url === "http://localhost/cinema/addUser.php?userAdded=failed") {

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                User was not added, Unknown error occured!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}

?>

<main>

    <div style="margin: 35px 0 35px 0 ;">
        <h1 class="title" style="text-align: center; margin-bottom: 30px;">Add User</h1>
        <div style="max-width: 50%; margin: auto; color: white;">
            <form action="classes/signup.class.php" method="post" id="signup-form">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFullname">First Name</label>
                        <input type="text" class="form-control" id="inputFullname" name="firstname" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputFullname">Last Name</label>
                        <input type="text" class="form-control" id="inputFullname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" name="email" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputUsername">Username</label>
                        <input type="text" class="form-control" id="inputUsername" name="username" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="inputPassword4" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPhone">Phone number</label>
                    <input type="text" class="form-control" id="inputPhone" name="phonenumber" required>
                </div>
                <div class="form-group">
                <label for="exampleFormControlSelect1">Input role:</label>
                        <select class="custom-select" id="inputGroupSelect01" name="userRole" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="Customer">Customer</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                </div>
                <div class="g-recaptcha" data-sitekey="6LcIX8QaAAAAAJ7-s2j9ZVM5WNfnMdNyDw7Rnbop"></div>
                <span id="captcha_error" class="text-danger"></span>
                <br>
                <button type="submit" class="btn btn-warning btn-lg btn-block" name="signup-submit-admin">Add User</button>
            </form>
        </div>
    </div>
</main>


<?php
require "footer.php";
?>