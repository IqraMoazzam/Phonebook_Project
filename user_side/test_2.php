<!-- align-middle -->
<?php
session_start();

function sendEmail($to,$v_code){
// Set your ElasticEmail API key
$apiKey = '3F02346C2621CF5F57519E71141102EE73647057B738186CE76CBDE080325CFBA7BF8CDCC116D54A38E7875D8C6A2364';

// API endpoint for sending emails
$url = 'https://api.elasticemail.com/v2/email/send';

// Email parameters
$from = 'iqramoazzam22@gmail.com';
// $to = 'ahmed.wwaallii@gmail.com';
$subject = 'Email Verification from Iqra Moazzam.';
$message = "<b>Thanks for Registration!</b>
Click the Link Below to verify the Email Address
<a href='http://localhost/phonebook-project/user_side/test_5.php?email=$to&v_code=$v_code'>Verify</a>";
;

// Prepare the request data
$data = array(
    'apikey' => $apiKey,
    'from' => $from,
    'to' => $to,
    'subject' => $subject,
    'body' => $message,
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
    echo 'Email sent successfully!';
} else {
    echo 'Failed to send the email. Error: ' . $responseData['error'];
}

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error Connection" . mysqli_connect_error();
        } else {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $v_code = bin2hex(random_bytes(15));
            $password = sha1($password);
            $sql = "insert into email_verification(name,email,password,verification_code,is_verified,active)
    values('$name','$email','$password','$v_code',0,1)";
  
            if (mysqli_query($conn, $sql)) {
                if(sendEmail($_POST['email'],$v_code)){
                echo "Email Verification Successfully!";
                header("Location: login.php");
                exit();
                }
            } else {
                echo "Error" . $sql . "<br>" . mysqli_error($conn);
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
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control custom_form_field_width ps-3" placeholder="Enter Full Name">
                  

                        </div>
                        
                        <div class="ps-4 pt-2">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control custom_form_field_width ps-3" placeholder="Enter Email">
                         

                        </div>

                        <div class="ps-4 pt-2">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control custom_form_field_width ps-3" placeholder="Enter Password">
                         

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