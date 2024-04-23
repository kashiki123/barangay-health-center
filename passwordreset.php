<html>

<head>
    <title>Password Reset</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<style>
    .box {
        width: 100%;
        max-width: 600px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 16px;
        margin: 0 auto;
    }

    input.parsley-success,
    select.parsley-success,
    textarea.parsley-success {
        color: #468847;
        background-color: #DFF0D8;
        border: 1px solid #D6E9C6;
    }

    input.parsley-error,
    select.parsley-error,
    textarea.parsley-error {
        color: #B94A48;
        background-color: #F2DEDE;
        border: 1px solid #EED3D7;
    }

    .parsley-errors-list {
        margin: 2px 0 3px;
        padding: 0;
        list-style-type: none;
        font-size: 0.9em;
        line-height: 0.9em;
        opacity: 0;

        transition: all .3s ease-in;
        -o-transition: all .3s ease-in;
        -moz-transition: all .3s ease-in;
        -webkit-transition: all .3s ease-in;
    }

    .parsley-errors-list.filled {
        opacity: 1;
    }

    .parsley-type,
    .parsley-required,
    .parsley-equalto {
        color: #ff0000;
    }

    .error {
        color: red;
        font-weight: 700;
    }
</style>

<body>
    <div class="container">
        <div class="table-responsive">
            <h3 align="center">Reset Password</h3><br />
            <div class="box">
                <?php
                include_once('config.php');

                if (isset($_GET['secret']) && isset($_POST['new_password'])) {
                    // Decode the email from the URL parameter
                    $email = base64_decode($_GET['secret']);

                    // Retrieve the user ID associated with the given email
                    $get_user_query = mysqli_query($connection, "SELECT user_id FROM admins WHERE email='$email'");
                    $user_data = mysqli_fetch_assoc($get_user_query);
                    $user_id = $user_data['user_id'];

                    // Get the new password from the form
                    $new_password = $_POST['new_password'];

                    // Check if the new password field is not empty
                    if (!empty($new_password)) {
                        // Update the password for the user
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $update_query = mysqli_query($connection, "UPDATE admins SET password='$hashed_password' WHERE user_id='$user_id'");

                        if ($update_query) {
                            // Password updated successfully
                            echo "Password updated successfully.";
                        } else {
                            // Error updating password
                            echo "Error updating password.";
                        }
                    } else {
                        // New password field is empty, do not update the password
                        echo "New password field is empty. No password update performed.";
                    }
                }
                ?>

                <form id="validate_form" method="post">
                    <input type="hidden" name="email" value="<?php echo isset($email) ? $email : ''; ?>" />
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" id="new_password" placeholder="Enter New Password" required class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Reset Password" class="btn btn-success" />
                    </div>
                    <p class="error"><?php if (!empty($msg)) {
                                            echo $msg;
                                        } ?></p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>