<!-- align-middle -->
<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email,$v_code){
    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'iqramoazzam22@gmail.com';                     //SMTP username
        $mail->Password   = 'mmvnbunzsrtmcugw';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('iqramoazzam22@gmail.com', 'Iqra Moazzam');
        $mail->addAddress($email);     //Add a recipient
        
    
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email Verification from Iqra Moazzam.';
        $mail->Body    = "<b>Thanks for Registration!</b>
        Click the Link Below to verify the Email Address
        <a href='http://localhost/phonebook-project/email_verification.php?email=$email&v_code=$v_code'>Verify</a>";
       
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_SESSION['user_id'])) {
    header("location:home.php");
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//define variables and set to empty values
$name = $uname = $email = $password = $gender = $date_of_birth = $upload_image = "";
$nameError = $unameError = $emailError = $passwordError = $genderError = $date_of_birth_Error = $upload_image_Error = "";
$retain_name = $retain_uname = $retain_email = $retain_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $is_form_valid = true;
    if (empty($_POST["name"])) {
        $nameError = "Name is Required";
        $is_form_valid = false;
    } else {
        $name = test_input($_POST["name"]);

        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameError = "Only letters and white space allowed";
            $is_form_valid = false;
        }
    }
    if (empty($nameError) || ($nameError == "Only letters and white space allowed")) {
        $retain_name = $name;
    }



    if (empty($_POST["uname"])) {
        $unameError = "Username is required";
        $is_form_valid = false;
    } else {
        $uname = test_input($_POST["uname"]);

        // check if username is alphanumeric
        if (!preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/", $uname)) {
            $unameError = "Username can only contain letters with numbers";
            $is_form_valid = false;
        }
    }

    if (empty($unameError)  || ($unameError == "Username can only contain letters with numbers")) {
        $retain_uname = $uname;
    }


    if (empty($_POST["email"])) {
        $emailError = "Email is Required";
        $is_form_valid = false;
    } else {
        $email = test_input($_POST["email"]);

        //check if email is invalid format
        if (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/", $email)) {
            $emailError = "Invalid Email Error";
            $is_form_valid = false;
        }
    }
    if (empty($emailError) || ($emailError == "Invalid Email Error")) {
        $retain_email = $email;
    }

    if (empty($_POST["pwd"])) {
        $passwordError = "Password is Required";
        $is_form_valid = false;
    } else {
        $password = test_input($_POST["pwd"]);

        // check if password contains 8 characters with one capital letter and one numeric character
        if (!preg_match("/^(?=.*[A-Z])(?=.*\d).{8,}$/", $password)) {
            $passwordError = "Password must be at least 8 characters long, contain at least one capital letter, and one numeric character";
            $is_form_valid = false;
        }

        if (empty($passwordError) || ($passwordError == "Password must be at least 8 characters long, contain at least one capital letter, and one numeric character")) {
            $retain_password = $password;
        }
    }
    if (empty($_POST["gen"])) {
        $genderError = "Gender is Required";
        $is_form_valid = false;
    } else {
        $gender = $_POST["gen"];
    }

    if (empty($_POST["birth"])) {
        $date_of_birth_Error = "Date of birth is Required";
        $is_form_valid = false;
    } else {
        $date_of_birth = $_POST["birth"];
    }
    if (empty($_FILES["image"]["name"])) {
        $upload_image_Error = "Please upload an image";
        $is_form_valid = false;
    } else {
        $upload_image = $_FILES["image"]["name"];
    }
    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];
        if (move_uploaded_file($file_tmp, "uploaded_file/" . $file_name)) {
            echo "Successfully File Uploaded";
        } else {
            $upload_image_Error = "Could not file Uploaded";
            $is_form_valid = false;
        }
    }

    //Database Connection
    if ($is_form_valid) {
        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error Connection" . mysqli_connect_error();
        } else {
            $v_code = bin2hex(random_bytes(15));
            $password = sha1($password);
            $sql = "INSERT INTO user_profile(user_name,user_username,user_email,user_password,user_gender,user_dob,user_image,verification_code,is_verified,user_active)
    values('$name','$uname','$email','$password','$gender','$date_of_birth','$upload_image','$v_code',0,1)";
            if (mysqli_query($conn, $sql) && sendMail($_POST['email'],$v_code)) {
                echo "Email Verification Successfully!";
                header("Location: login.php");
                exit();
            } else {
                echo "Error" . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}
?>










<!doctype html>
<html lang="en">

<head>
    <title>Phone-Book SignUp</title>
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
            background: url("pic/img-1.avif");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        .custom_container {
            width: 80%;
            margin-top: 40px;
            margin-bottom: 80px;
            border: 4px solid black;
            background-color: rgba(15, 15, 15, 0.2);
        }

        .custom_img {
            align-content: center;
            margin-top: 5px;
            max-width: 100%;
            height: auto;
            border: 5px solid black;
            /* margin-left: 20px; */
        }

        .custom_col_md_6_img {
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .custom_form {
            padding-top: 10px;
        }

        .custom_border {
            border: 1px solid black;
        }

        .custom_form_field_width {
            width: 80%;
        }

        .custom_form_field_width:focus {
            border: 5px solid black;
            outline-color: rgb(161, 94, 32);
            border-color: rgb(161, 94, 32);
            box-shadow: 2px 2px 5px rgb(161, 94, 32), -2px -2px 5px rgb(161, 94, 32);
        }

        .custom_height {
            height: 830px;
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
            <div class="row d-flex display-content-center align-items-center custom_border text-align-center">
                <div class="col-lg-6 col-md-6 col-sm-12 custom_col_md_6_img">
                    <div clas="text-center">
                        <img class="img-fluid custom_img rounded" src="pic/phonebook.jpg" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 custom_height custom_form custom_border">
                    <form class="pt-3 px-3 pb-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                        <div class="h2 text-center fw-bold">PhoneBook SignUp</div>
                        <div class="ps-4 pt-3">
                            <label for="name" class="form-label fw-bold">Full Name:<span class="error">*</span></label>
                            <input type="text" name="name" id="name" class="form-control custom_form_field_width ps-3" placeholder="Enter Full Name" value="<?php if (!empty($retain_name)) {
                                                                                                                                                                echo $retain_name;
                                                                                                                                                            } else {
                                                                                                                                                                echo "";
                                                                                                                                                            } ?>">
                            <span class="error"><?php echo $nameError; ?></span>

                        </div>
                        <div class="ps-4 pt-2">
                            <label for="uname" class="form-label fw-bold">Username:<span class="error">*</span></label>
                            <input type="text" name="uname" id="uname" class="form-control custom_form_field_width ps-3" placeholder="Enter Username" value="<?php if (!empty($retain_uname)) {
                                                                                                                                                                    echo $retain_uname;
                                                                                                                                                                } else {
                                                                                                                                                                    echo "";
                                                                                                                                                                } ?>">
                            <span class="error"><?php echo $unameError; ?></span>

                        </div>
                        <div class="ps-4 pt-2">
                            <label for="email" class="form-label fw-bold">Email:<span class="error">*</span></label>
                            <input type="email" name="email" id="email" class="form-control custom_form_field_width ps-3" placeholder="Enter Email" value="<?php if (!empty($retain_email)) {
                                                                                                                                                                echo $retain_email;
                                                                                                                                                            } else {
                                                                                                                                                                echo "";
                                                                                                                                                            } ?>">
                            <span class="error"><?php echo $emailError; ?></span>

                        </div>
                        <div class="ps-4 pt-2">
                            <label for="pwd" class="form-label fw-bold">Password:<span class="error">*</span></label>
                            <input type="password" name="pwd" id="pwd" class="form-control custom_form_field_width ps-3" placeholder="Enter Password" value="<?php if (!empty($retain_password)) {
                                                                                                                                                                    echo $retain_password;
                                                                                                                                                                } else {
                                                                                                                                                                    echo "";
                                                                                                                                                                } ?>">
                            <span class="error"><?php echo $passwordError; ?></span>

                        </div>
                        <div class="ps-4 pt-2">
                            <label class="form-label fw-bold">Gender:<span class="error">*</span></label>
                        </div>
                        <div class="ps-4 pt-2">
                            <div><input type="radio" name="gen" value="male"> Male</div>
                            <div><input type="radio" name="gen" value="female"> Female</div>
                            <span class="error"><?php echo $genderError; ?></span>

                        </div>
                        <div class="ps-4 pt-2">
                            <label for="birth" class="form-label fw-bold">Date of Birth:<span class="error">*</span></label>
                            <input type="date" name="birth" id="birth" class="form-control custom_form_field_width ps-3">
                            <span class="error"><?php echo $date_of_birth_Error; ?></span>

                        </div>
                        <div class="ps-4 pt-2">
                            <label for="image" class="form-label fw-bold">Upload a Picture:<span class="error">*</span></label>
                            <input type="file" name="image" id="image" class="form-control custom_form_field_width ps-3 mt-1" accept=".png,.jpeg,.jpg,.avif,webp">
                            <span class="error"><?php echo $upload_image_Error; ?></span>
                        </div>

                        <div class="text-center mb-3 pt-3">
                            <button type="submit" class="btn btn-light w-50 fw-bold mt-2" name="btn" id="btn">Create Account</button>
                        </div>
                        <div class="text-center fw-bold pt-3">Already have an account? please <a href="login.php" class="btn btn-light btn-sm">Log in</a></div>
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