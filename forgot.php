<html>

<head>
    <title>Forgot Password</title>
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
<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/vendor/autoload.php';
include_once ('config.php');

if (isset ($_POST['pwdrst'])) {
    $email = $_POST['username'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format";
    } else {
        // Check if the email exists
        $stmt = mysqli_prepare($conn, "SELECT email FROM admins WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $resultEmail);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($resultEmail === $email) {
            // Send email with reset link
            $reset_link = "http://localhost/brgyv2/passwordreset.php";
            $message = '<div>
                    <p><b>Hello!</b></p>
                    <p>You are receiving this email because we received a password reset request for your account.</p>
                    <br>
                    <p><button class="btn btn-primary"><a href="' . $reset_link . '">Reset Password</a></button></p>
                    <br>
                    <p>If you did not request a password reset, no further action is required.</p>
                </div>';

            // Include PHPMailer and SMTP classes
            include_once ("SMTP/class.phpmailer.php");
            include_once ("SMTP/class.smtp.php");
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->Username = "sherdypagaran9@gmail.com";   // Enter your username/emailid
            $mail->Password = "nwoj xotb locd unvm";
            // send by h-hotel email
            $mail->setFrom('sherdypagaran9@gmail.com', 'Bulua Health Center');  // Enter your password

            $mail->AddAddress($email);
            $mail->Subject = "Reset Password";
            $mail->isHTML(TRUE);
            $mail->Body = $message;

            if ($mail->send()) {
                $msg = "We have e-mailed your password reset link!";
            } else {
                $msg = "Error sending email. Please try again later.";
            }
        } else {
            $msg = "We can't find a user with that email address";
        }
    }
}
?>

<body>
    <div class="container">
        <div class="table-responsive">
            <h3 align="center">Forgot Password</h3><br />
            <div class="box">
                <form id="validate_form" method="post">
                    <div class="form-group">
                        <label for="username">Email Address</label>
                        <input type="text" name="username" id="username" placeholder="Enter Email" required
                            data-parsley-type="email" data-parsley-trigg er="keyup" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="submit" id="login" name="pwdrst" value="Send Password Reset Link"
                            class="btn btn-success" />
                    </div>

                    <p class="error">
                        <?php if (!empty ($msg)) {
                            echo $msg;
                        } ?>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>