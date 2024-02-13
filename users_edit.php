<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

include('includes/header.php');

if (isset($_POST['username'])) {

    if ($stm = $connect->prepare('UPDATE users set  username = ?,email = ? , active = ?  WHERE id = ?')) {
        $stm->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['active'], $_GET['id']);
        $stm->execute();

              


        $stm->close();
        // if our variable post and value password is set the statement if
        if (isset($_POST['password'])) {
            /* if statement connects then prepare update user and set password = to our $GET variable "i" where i ='s id with a value of ?
            referencing our hashed to hash our password in our post variable. */                                   
            if ($stm = $connect->prepare('UPDATE users set  password = ? WHERE id = ?')) {
                $hashed = SHA1($_POST['password']);
                // bind our param values of s and i where id and password are retrieved from users to be updated then excute our statement.
                $stm->bind_param('si', $hashed, $_GET['id']);
                $stm->execute();
                
                $stm->close();
 
            } else {
                echo 'Could not prepare password update statement!';
            }
        }

        set_message("A user  " . $_GET['id'] . " has beed updated");
        header('Location: users.php');
        die();

    } else {
        echo 'Could not prepare user update statement statement!';
    }





}

// Initializing an empty variable to reference our id using get
if (isset($_GET['id'])) {
    /* if our statement connects prepare our connection and select all from users where id = question mark an empty paramter to be used.
     Bind the paramater value i to get variable id and then excute our method */
    if ($stm = $connect->prepare('SELECT * from users WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();
        // If  user has all these conditions below else could not prepare statment or no users selected for editing
        if ($user) {


            ?>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Edit user</h1>

                        <form method="post">
                            <!-- Username input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="username" name="username" class="form-control active"
                                    value="<?php echo $user['username'] ?>" />
                                <label class="form-label" for="username">Username</label>
                            </div>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control active"
                                    value="<?php echo $user['email'] ?>" />
                                <label class="form-label" for="email">Email address</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control" />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <!-- Active select -->
                            <!-- Allows us to select users to an active or deactive state, can also edit username and password.  -->
                            <div class="form-outline mb-4">
                                <select name="active" class="form-select" id="active">
                                    <option <?php echo ($user['active']) ? "selected" : ""; ?> value="1">Active</option>
                                    <option <?php echo ($user['active']) ? "" : "selected"; ?> value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Update user</button>
                        </form>



                    </div>

                </div>
            </div>


            <?php
        }
        $stm->close();
     

    } else {
        echo 'Could not prepare statement!';
    }

} else {
    echo "No user selected";
    die();
}

include('includes/footer.php');
?>