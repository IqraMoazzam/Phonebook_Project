<?php
session_start();




//define variables and set to empty values



//check if request_method is equal to post then it starts working
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error in Connection" . mysqli_connect_error();
        } else {
            $email = $_POST['email'];
             $password = $_POST['password'];
            // if(isset($_SESSION['user_id'])){
            $password = sha1($password);
            try {
                $sql = "SELECT id from email_verification where email = '$email' and password = '$password'";

                $result = mysqli_query($conn, $sql);
                $data = mysqli_num_rows($result);
                if ($data > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if ($row['is_verified'] == 1) {
                        $_SESSION['user_id'] = $row["user_id"];
                        header("location:home.php");
                        
                    } else {
                        echo "Email not Verified.";
                    }
                } else {
                   $message = "Email or Password might be incorrect." . mysqli_error($conn);
                }
            } catch (mysqli_sql_exception $e) {
                echo $message;
            }
       
            // }else{
            //     header("location:home.php");
            // }
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
                        <div class="h2 text-center fw-bold">PhoneBook Login</div>
                        <div class="ps-4 pt-2">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control custom_form_field_width ps-3" placeholder="Enter Email">

                        </div>
                        <div class="ps-4 pt-2">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control custom_form_field_width ps-3" placeholder="Enter Password">
                        </div>


                        <div class="text-center mb-3 pt-3">
                            <button type="submit" class="btn btn-light w-50 fw-bold" name="btn" id="btn">Login</button>
                        </div>
                        
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