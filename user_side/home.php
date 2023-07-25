<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
}
$conn = mysqli_connect("localhost", "root", "", "phonebook-project");
if (!$conn) {
    echo "Error in Connection" . mysqli_connect_error();
} else {
    // $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user_profile WHERE user_id = '{$_SESSION['user_id']}'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_num_rows($result);
    if ($data > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
    } else {
        echo "Error" . $sql . "<br>" . mysqli_error($conn);
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
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

        .container-fluid {
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

        .custom_image {
            width: 80%;
            margin-left: 18px;
            margin-top: 5px;
            /* border: 2px solid black; */
            height: 150px;
        }

        .custom_nav {
            top: 8px;
            right: 20px;
            text-align: center;
            position: absolute;
        }

        .custom_image {
            width: 150px;
            /* Adjust the width and height according to your needs */
            height: 150px;
            overflow: hidden;
            /* border-radius: 50%; */
            object-fit: cover;
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
                            <a href="logout.php" class="text-decoration-none text-light custom_nav">Logout</a>
                        </p>

                    </div>
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
                    <a class="link text-decoration-none text-light" href="delete_account.php"><i class="fa-solid fa-user-xmark text-secondary"></i> Delete Account</a>
                    <a class="link text-decoration-none text-light" href="choose_csv_file.php"><i class="fa-solid fa-file-csv text-secondary"></i> Choose CSV File</a>

                </div>
                <div class="col-lg-10 col-md-9 col-sm-8 h-auto">
                    <div class="container w-75">
                        <div class="row">
                            <div class="col-12 h-auto">
                                <p class="h2 bg-dark text-light mt-2 mb-4 fw-bold ps-3 pt-1 pb-2">
                                    <?php echo "Welcome: " . $row['user_name']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="row border border-2 ms-1 me-2">
                            <div class="col-5 text-center">
                                <img class='img-fluid custom_image pt-2' src="<?php echo "uploaded_file/" . $row['user_image']; ?>" alt='image'>
                            </div>
                            <div class="col-7"></div>
                            <div class="col-lg-5 col-md-4 col-sm-3 text-center pt-3 pb-3 h-auto">
                                <div class="pb-2 fw-bold">Name</div>
                                <div class="pb-2 fw-bold">Username</div>
                                <div class="pb-2 fw-bold">Email</div>
                                <div class="pb-2 fw-bold">Gender</div>
                                <div class="pb-2 fw-bold">Date_Of_Birth</div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 pt-3 h-auto">
                                <div class="pb-2">:</div>
                                <div class="pb-2">:</div>
                                <div class="pb-2">:</div>
                                <div class="pb-2">:</div>
                                <div class="pb-2">:</div>
                            </div>
                            <div class="breakpoints col-lg-6 col-md-7 col-sm-8 pt-3 text-center h-auto">
                                <div class="name pb-1">
                                    <?php echo $row['user_name']; ?>
                                </div>
                                <div class="username pb-2">
                                    <?php echo $row['user_username']; ?>
                                </div>
                                <div class="email pb-2">
                                    <?php echo $row['user_email']; ?>
                                </div>
                                <div class="gender pb-2">
                                    <?php echo $row['user_gender']; ?>
                                </div>
                                <div class="date_of_birth pb-2">
                                    <?php echo $row['user_dob']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
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