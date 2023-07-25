<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
}

$conn = mysqli_connect("localhost","root","","phonebook-project");
if(!$conn){
    echo "Error in Connection" . mysqli_connect_error();
}else{
    $sql = "select * from user_profile where user_id = '{$_SESSION['user_id']}'";
    $result = mysqli_query($conn,$sql);
    $data = mysqli_num_rows($result);
    if($data > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
    }
    else{
        echo "Error" . $sql ."<br>" . mysqli_error($conn);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sub'])) {
        $name = $_POST['name'];
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['birth'];
        $user_id = $_SESSION["user_id"];
        
        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error in Connection" . mysqli_connect_error();
        } else {
            $sql = "update user_profile set user_name ='$name', user_username = '$uname',
    user_email = '$email', user_dob = '$date_of_birth' where user_id = '$user_id'";
            if (mysqli_query($conn, $sql)) {
                echo "Profile Updated Successfully!";
                header("location: home.php");
                exit; // Add an exit statement after redirection
            } else {
                echo "Error Updating Profile" . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Update Profile</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/bedf38be05.js" crossorigin="anonymous"></script>

    <style>
        *,
        *::after,
        *::before {
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
        }

        .custom_main {
            width: 100%;
            /* border: 2px solid black; */
        }

        .navbar {
            height: 55px;
            border: 1px solid black;

        }

        .breakpoints {
            height: 573px;
            /* border: 2px solid black; */
        }

        .div_width {
            width: 400px;
            /* border: 2px solid black; */
        }

        .adjust_form {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .custom_form {
            width: 40%;
            border: 2px solid black;
        }

        .field_width {
            width: 62%;
        }
        .custom_nav {
            top: 8px;
            right: 20px;
            text-align: center;
            position: absolute;
                }
    </style>
</head>

<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid text-light">
                <div class="row">
                    <div class="col-12">
                    <p class="h4"><i class="fa-solid fa-address-book fa-sm text-secondary"></i> PhoneBook Directory
                         <a href="logout.php" class="text-decoration-none text-light custom_nav">Logout</a></p>                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Body -->
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="breakpoints col-lg-2 col-md-3 col-sm-4 d-flex gap-4 flex-column bg-dark pt-3 ps-3">
                    <a class="link text-decoration-none text-light" href="home.php"><i class="fa-solid fa-house-user fa-sm text-secondary"></i> Home</a>
                    <a class="link text-decoration-none text-light" href="add_new_contact.php"><i class="fa-solid fa-user-plus fa-sm text-secondary"></i> Add New Contact</a>
                    <a class="link text-decoration-none text-light" href="view_contact.php"><i class="fa-solid fa-users-viewfinder fa-sm text-secondary"></i> View All Contacts</a>
                    <a class="link text-decoration-none text-light" href="update_user_profile.php"><i class="fa-solid fas fa-user-edit fa-sm text-secondary"></i> Update Profile</a>
                    <a class="link text-decoration-none text-light" href="delete_account.php"><i class="fa-solid fa-user-xmark text-secondary"></i> Delete Contact</a>
                    <a class="link text-decoration-none text-light" href="choose_csv_file.php"><i class="fa-solid fa-file-csv fa-sm text-secondary"></i> Choose CSV File</a>

                </div>
                <div class="breakpoints col-lg-10 col-md-9 col-sm-8 h-auto adjust_form">
                    <form class="custom_form mt-2 pt-4 ps-4 pb-3" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <div class="div_width mb-3 ps-3 ms-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" name="name" id="name" value="<?php echo $row['user_name']; ?>" class="field_width form-control" placeholder="Update Your Name">
                        </div>

                        <div class="div_width mb-3 ps-3 ms-3">
                            <label for="uname" class="form-label">Username:</label>
                            <input type="text" name="uname" id="uname" value="<?php echo $row['user_username']; ?>" class="field_width form-control" placeholder="Update Your Username">
                        </div>
                        <div class="div_width mb-3 ps-3 ms-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" value="<?php echo $row['user_email']; ?>" class="field_width form-control" placeholder="Update Your Email">
                        </div>
                        <div class="div_width mb-3 ps-3 ms-3">
                            <label for="birth" class="form-label">Date of Birth:</label>
                            <input type="date" name="birth" id="birth" value="<?php echo $row['user_dob']; ?>" class="field_width form-control" placeholder="Update Your DOB">
                        </div>
                        <input type="submit" value="Update" name="sub" class="btn btn-primary float-end me-5">
                    </form>
                </div>
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