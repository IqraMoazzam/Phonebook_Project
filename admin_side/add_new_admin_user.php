<!-- align-middle -->

<?php
session_start();
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//define variables and set to empty values
$name = $uname = $email = $password = $gender = $date_of_birth = $upload_image = $user_type = "";
$nameError = $unameError = $emailError = $passwordError = $genderError = $date_of_birth_Error = $upload_image_Error = $user_type_error = "";
$retain_name = $retain_uname = $retain_email = $retain_password = "";
if(isset($_SESSION['admin_user_id'])){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['btn'])) {
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

        if (empty($_POST["user_type"])) {
            $user_type_error = "User Type is Required";
            $is_form_valid = false;
        } else {
            $user_type = $_POST["user_type"];
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

                $password = sha1($password);

                $sql = "INSERT INTO admin_users(admin_user_name,admin_user_username,admin_user_password,admin_user_email,admin_user_gender,admin_user_image,admin_user_type,admin_user_active)
            values('$name','$uname','$password','$email','$gender','$upload_image',1,1)";

                if (mysqli_query($conn, $sql)) {
                        header("Location: admin_profile.php");
                } else {
                    echo "Error" . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
}
}else{
    header("location:admin_login.php");
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Add New Admin User</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/bedf38be05.js" crossorigin="anonymous"></script>

    <style>
        /* * {
            color: white;
        } */

        *,
        *::after,
        *::before {
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
        }

        .container-fluid {
            width: 100%;
            height: 565px;
            /* border: 2px solid pink; */

        }

        .breakpoints {
            height: 565px;

        }

        .custom_nav {
            gap: 20px;
            height: 47px;
            padding-top: 4px;
            padding-right: 10px;
            border: 1px solid black;
            text-align: center;
            display: flex;
            flex-direction: row-reverse;
        }

        .custom_container {
            width: 90%;
            margin-top: 55px;
            padding-bottom: 20px;
            background-color: rgba(15, 15, 15, 0.8);
        }

        .cust_field_label {
            width: 100px;
            /* border: 2px solid red; */

        }

        .temp_margin {
            padding-top: 50px;
        }

        .error {
            color: red;
        }

        .custom_image img {
            width: 150px;
            /* Adjust the width and height according to your needs */
            height: 150px;
            overflow: hidden;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <main>
        <div class="container-fluid">

            <div class="row">
            
                <div class="col-lg-12 col-md-12 col-sm-12 h-auto px-0 border border-dark">
                    <div class="h-auto custom_nav bg-dark">
                        <a href="admin_logout.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Logout</a>
                        <a href="view_admin_users.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">View Admin Users</a>
                        <a href="view_all_users.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">View All Users</a>
                        <a href="admin_profile.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Admin Profile</a>

                    </div>
    </div>
            </div>
                    <div class="container custom_container">
                   
                        <form class="pt-3 px-3 pb-2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-6">
                                    <div class="pt-3 mt-3 mb-3">
                                        <label for="name" class="form-label me-2 cust_field_label text-light fw-bold">Full Name:<span class="error">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control-sm custom_form_field_width ps-3 text-dark" placeholder="Enter Full Name" value="<?php if (!empty($retain_name)) {
                                                                                                                                                                                            echo $retain_name;
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo "";
                                                                                                                                                                                        } ?>">
                                        <span class="error d-block"><?php echo $nameError; ?></span>

                                    </div>
                                    <div class="pt-3 mt-3 mb-3">
                                        <label for="uname" class="form-label me-2 text-light cust_field_label fw-bold">Username:<span class="error">*</span></label>
                                        <input type="text" name="uname" id="uname" class="form-control-sm custom_form_field_width ps-3 text-dark" placeholder="Enter Username" value="<?php if (!empty($retain_uname)) {
                                                                                                                                                                                            echo $retain_uname;
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo "";
                                                                                                                                                                                        } ?>">
                                        <span class="error d-block"><?php echo $unameError; ?></span>

                                    </div>
                                    <div class="pt-3 mt-3 mb-3">
                                        <label for="email" class="form-label me-2 text-light cust_field_label fw-bold">Email:<span class="error">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control-sm custom_form_field_width ps-3 text-dark" placeholder="Enter Email" value="<?php if (!empty($retain_email)) {
                                                                                                                                                                                        echo $retain_email;
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo "";
                                                                                                                                                                                    } ?>">
                                        <span class="error d-block"><?php echo $emailError; ?></span>

                                    </div>

                                    <div class="pt-3 mt-3 mb-3">
                                        <label for="pwd" class="form-label me-2 text-light cust_field_label fw-bold">Password:<span class="error">*</span></label>
                                        <input type="password" name="pwd" id="pwd" class="form-control-sm custom_form_field_width ps-3 text-dark" placeholder="Enter Password" value="<?php if (!empty($retain_password)) {
                                                                                                                                                                                            echo $retain_password;
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo "";
                                                                                                                                                                                        } ?>">
                                        <span class="error d-block"><?php echo $passwordError; ?></span>

                                    </div>

                                </div>


                                <div class="col-6">

                                    <div class="pt-3 mt-3 mb-3">
                                        <label class="form-label me-2 text-light cust_field_label fw-bold">Gender:<span class="error">*</span></label>
                                        <select name="gen" id="" class="form-control-sm text-dark">
                                            <option value="male" class="text-dark">Male</option>
                                            <option value="female" class="text-dark">Female</option>
                                        </select>
                                        <span class="error d-block"><?php echo $genderError; ?></span>

                                    </div>
                                    <div class="pt-3 mt-3 mb-3">
                                        <label for="" class="form-label text-light me-2 cust_field_label fw-bold">User Type:<span class="error">*</span></label>
                                        <select name="user_type" id="" class="form-control-sm text-dark">
                                            <option value="1" class="text-dark">Super Type</option>
                                            <option value="2" class="text-dark">Sub Type</option>
                                        </select>
                                        <span class="error d-block"><?php echo $user_type_error; ?></span>

                                    </div>
                                    <div class="pt-3 mt-3 mb-3 d-flex align-items-center">
                                        <label for="image" class="form-label me-2 text-light cust_field_label fw-bold">Upload Image:<span class="error">*</span></label>
                                        <input type="file" name="image" id="image" class="form-control-sm text-light" accept=".png,.jpeg,.jpg,.avif,webp">
                                        <span class="error d-block"><?php echo $upload_image_Error; ?></span>
                                    </div>
                                </div>

                            </div>
                            <div class="text-center ">
                                <button type="submit" class="btn btn-light my-2 px-3 py-2 fw-bold mt-2" name="btn" id="btn">Create New Admin User</button>
                            </div>
                        </form>

                    </div>
                
        </div>

    </main>

    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>
