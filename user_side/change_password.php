<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("location:home.php");
}
function sendEmail($to,$v_code)
{
    // Set your ElasticEmail API key
    $apiKey = '3F02346C2621CF5F57519E71141102EE73647057B738186CE76CBDE080325CFBA7BF8CDCC116D54A38E7875D8C6A2364';

    // API endpoint for sending emails
    $url = 'https://api.elasticemail.com/v2/email/send';

    // Email parameters
    $from = 'iqramoazzam22@gmail.com';

    $subject = "Password Reset";
    $message = "You have requested to reset your password. Click the link below to reset it:<br>
    http://localhost/phonebook-project/user_side/reset_password.php?v_code=$v_code<br>
    If you didn't request this, please ignore this email.";
    $headers = "From: iqramoazzam22@gmail.com";

    // Prepare the request data
    $data = array(
        'apikey' => $apiKey,
        'from' => $from,
        'to' => $to,
        'verification_code' => $v_code,
        'subject' => $subject,
        'body' => $message,
        'header' => $headers,
        'isTransactional' => true, // Set to true for transactional emails
    );

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Process the response
    $responseData = json_decode($response, true);

    // Check the response status
    if ($responseData['success']) {
        echo "<h5>"  . 'Email sent successfully!' . "</h5>";
    } else {
        echo 'Failed to send the email. Error: ' . $responseData['error'];
    }
}
//function used to check the space,slashes and prevent to sqa injection
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//define variables and set to empty values
$email = "";
$emailError = "";
$retain_email = "";

//check if request_method is equal to post then it starts working
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['btn_pass'])) {
    } else if ((isset($_POST['btn_send']))) {
        //define flag that is used to check condition based on true and false
        $is_form_valid = true;

        //if email field is empty then it thrown an error and also flag don't send the file to other page
        if (empty($_POST["email"])) {
            $emailError = "Email is Required";
            $is_form_valid = false;
        } else {

            //if email field can't be empty then second condition is checked the function of test_input
            $email = test_input($_POST["email"]);

            //if both condition is true then third condition is check the form validation through php
            if (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/", $email)) {
                $emailError = "Invalid Email Error";
                $is_form_valid = false;
            }
        }

        // if both error can be true then it retains the value that user enter before it    
        if (empty($emailError) || ($emailError == "Invalid Email Error")) {
            $retain_email = $email;
        }
        //Database Connection
        if ($is_form_valid) {
            $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
            if (!$conn) {
                echo "Error in Connection" . mysqli_connect_error();
            } else {
                $email = $_POST['email'];

                $sql = "SELECT verification_code from user_profile where user_email = '{$email}'";

                $result = mysqli_query($conn, $sql);
                $data = mysqli_num_rows($result);
                if ($data > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $v_code = $row['verification_code'];
                    if (mysqli_query($conn, $sql)) {

                        if (sendEmail($_POST['email'], $v_code)) {
                            echo "<h5>Password reset link sent to your email.</h5>";
                        }
                    }
                } else {
                    echo "<h5>Verification Code not found in the database.</h5>";
                }
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Phone-Book login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        * {
            color: white;
        }

        body {
            background: url("pic/d.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        .custom_container {
            width: 36%;
            height: auto;
            margin-top: 120px;
            margin-bottom: 80px;
            margin-right: 70px;
            border: 4px solid black;
            background-color: rgba(15, 15, 15, 0.5);
        }

        .custom_form {
            padding-top: 5px;
        }

        .custom_form_field_width {
            width: 80%;
        }

        .custom_form_field_width:focus {
            border: 5px solid black;
            outline-color: rgb(15, 15, 15);
            border-color: rgb(15, 15, 15);
            box-shadow: 2px 2px 5px rgb(15, 15, 15), -2px -2px 5px rgb(15, 15, 15);
        }

        .custom_height {
            height: 330px;
        }

        .custom_col {
            width: 80%;
            margin-right: auto;
            margin-left: auto;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>

        <div class="container custom_container">
            <div class="row">
                <div class=" col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 custom_col custom_height custom_form">
                    <form class="pt-3 px-3 pb-2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="h2 text-center fw-bold pt-4">Change Password</div>
                        <div class="ps-4 pt-4">
                            <label for="email" class="form-label fw-bold">Email:<span class="error">*</span></label>
                            <input type="email" name="email" id="email" class="form-control custom_form_field_width ps-3" placeholder="Enter Email" value="<?php if (!empty($retain_email)) {
                                                                                                                                                                echo $retain_email;
                                                                                                                                                            } else {
                                                                                                                                                                echo "";
                                                                                                                                                            } ?>">
                            <span class="error"><?php echo $emailError ?></span>

                        </div>

                        <div class="text-center mb-3 pt-4">
                            <button type="submit" class="btn btn-light w-50 fw-bold ms-2" name="btn_send" id="btn">Send Email</button>

                        </div>

                        <span class="error">
                            <?php
                            if (isset($message)) {
                                echo $message;
                            }
                            ?>

                        </span>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
</body>

</html>