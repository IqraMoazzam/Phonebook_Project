    <?php
    session_start();

    $error_message = "";
    if (isset($_SESSION['user_id'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $cname = $_POST['cname'];
            $cnumber = $_POST['cnumber'];

            // $contact_id = $row['contact_id'];

            $conn = mysqli_connect("localhost", "root", "", "phonebook-project");

            if (!$conn) {

                echo "Error in Connection" . mysqli_connect_error();
            } else {

                $user_id = $_SESSION['user_id'];
                try {

                    $query = "SELECT contact_name FROM contact_details 
                          JOIN contact_number ON contact_details.contact_id = contact_number.contact_id
                          WHERE contact_details.user_id = {$user_id}
                          AND contact_number.contact_number = '$cnumber'";

                    $result = mysqli_query($conn, $query);
                    $data = mysqli_num_rows($result);
                    if ($data > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $existingContactName = $row['contact_name'];

                        $error_message = "Error: The entered phone number already exists for this Contact Name " .
                            $existingContactName;
                    } else {
                        $sql = "INSERT into contact_details(user_id,contact_name,contact_active)
            values('$user_id','$cname',1)";


                        if (mysqli_query($conn, $sql)) {

                            $sql_2 = "INSERT into contact_number(contact_id,contact_number,contact_number_active)
        values((SELECT contact_id from contact_details where user_id = '$user_id'
        AND contact_name = '$cname'), '$cnumber' , 1)";

                            if (mysqli_query($conn, $sql_2)) {
                                echo "Added Contact Successfully!";
                                header("location:view_contact.php");
                            } else {
                                $error_message = "Error" . mysqli_error($conn);
                            }
                        } else {
                            $error_message = "Error" . mysqli_error($conn);
                        }
                    }
                } catch (mysqli_sql_exception $e) {
                    $error_message = "Error: The entered contact name already exists for this user. Please try a different name.";
                }
            }
        }
    } else {
        header("location:login.php");
    }

    ?>

    <!doctype html>
    <html lang="en">

    <head>
        <title>Add New Contacts</title>
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

            .custom_btn {
                width: 70px;
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
                        <a class="link text-decoration-none text-light" href="delete_account.php"><i class="fa-solid fa-user-xmark text-secondary"></i> Delete Contact</a>
                        <a class="link text-decoration-none text-light" href="choose_csv_file.php"><i class="fa-solid fa-file-csv fa-sm text-secondary"></i> Choose CSV File</a>

                    </div>


                    <div class="breakpoints col-lg-10 col-md-9 col-sm-8 h-auto adjust_form">

                        <form class="custom_form mt-2 pt-4 ps-4 pb-3" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            <div class="div_width mb-3 ps-3 ms-3">
                                <label for="cname" class="form-label">Name:</label>
                                <input type="text" name="cname" id="cname" class="field_width form-control" placeholder="Add Contact Name">
                            </div>

                            <div class="div_width mb-3 ps-3 ms-3">
                                <label for="cnumber" class="form-label">Number:</label>
                                <input type="tel" name="cnumber" id="cnumber" class="field_width form-control" placeholder="Add Contact Number">
                            </div>
                            <div class="pt-0">
                                <p class="mt-5 ms-3 text-danger">
                                    <?php
                                    if (isset($error_message)) {
                                        echo $error_message;
                                    }
                                    ?>
                                </p>
                            </div>

                            <input type="submit" value="Add" name="sub" class="btn btn-primary float-end me-4 custom_btn">
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