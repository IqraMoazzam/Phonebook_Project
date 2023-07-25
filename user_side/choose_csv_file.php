<?php
session_start();
$file_error = "";
$conn = mysqli_connect("localhost", "root", "", "phonebook-project");
if (!$conn) {
    echo "Error in Connection" . mysqli_connect_error();
} else {
    if(isset($_SESSION['user_id'])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $is_form_valid = true;
        if (isset($_POST['sub'])) {
            if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === 0) {
                $file_name = $_FILES['csv_file']['name'];
                $file_type = $_FILES['csv_file']['type'];
                $file_size = $_FILES['csv_file']['size'];
                $file_tmp = $_FILES['csv_file']['tmp_name'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                if (strtolower($file_ext) !== 'csv') {
                    $file_error = "Invalid file format. Please upload a CSV file.";
                    $is_form_valid = false;
                }


                $query = "SELECT MAX(contact_id) as contact_id FROM contact_details";
            // (SELECT MAX(contact_number_id) FROM contact_number) AS contact_number_id

                $result = mysqli_query($conn, $query);
                $data = mysqli_num_rows($result);
                if ($data > 0) {
                    $row = mysqli_fetch_assoc($result);
                    // $contact_active = $row['contact_active'];
                    $contact_id = $row['contact_id'];
                    // echo $contact_id;
                    // die;
                    // $contact_num_id = $row['contact_number_id'] + 1;
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                if ($is_form_valid = true) {
                    $file = fopen($file_tmp, "r");

                    $sql_contact_details = "INSERT INTO contact_details(user_id, contact_id, contact_name, contact_active) VALUES";
                    $sql_contact_number = "INSERT INTO contact_number(contact_id, contact_number, contact_number_active) VALUES";

                    $record = fgetcsv($file);

                    while (!feof($file)) {
                        $record = fgetcsv($file);
                        if (!empty($record[0])) {
                            // Insert into contact_details
                            $contact_id++;
                            $sql_contact_details .= " ({$_SESSION['user_id']}, {$contact_id}, '{$record[0]}', 1),";

                            // Insert into contact_number
                            $sql_contact_number .= " ({$contact_id}, '{$record[1]}', 1),";
                            // $contact_num_id++;
                        }
                    }

                    fclose($file);

                    // Remove the trailing comma from the SQL strings
                    $sql_contact_details = rtrim($sql_contact_details, ",");
                    $sql_contact_number = rtrim($sql_contact_number, ",");

                    // Execute the combined queries
                    try {
                        if (mysqli_query($conn, $sql_contact_details) && mysqli_query($conn, $sql_contact_number)) {
                            $message = "New records inserted via CSV File successfully";
                        } else {
                            $error_message = "Error: " . mysqli_error($conn);
                        }
                    } catch (mysqli_sql_exception $e) {
                        $error_message = "Error: You can only upload the file once.";
                    }
                }
            } else {
                $file_error = "Could not File Uploaded.";
                $is_form_valid = false;
            }
        }
    }
}else{
    header("location:login.php");
}
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Select CSV File</title>
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

        .container {
            border: 2px solid black;
            padding: 40px;
            border-radius: 5px;
            max-width: 500px;
            margin-top: 13%;
        }

        .container label {
            margin-bottom: 10px;
        }

        .navbar {
            height: 55px;
            border: 1px solid black;

        }

        .breakpoints {
            height: 573px;
            /* border: 2px solid black; */
        }


        .custom_nav {
            top: 8px;
            right: 20px;
            text-align: center;
            position: absolute;
        }

        .error {
            color: red;
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

                    <div class="container">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <div class="h5">

                                <label for="csv_file">Please Select File(only CSV Format)
                                    <span class="error">*</span>

                                </label>

                            </div>
                            <span class="error">
                                <?php echo $file_error; ?>
                            </span>
                            <div class="mt-3">
                                <input type="file" name="csv_file" id="csv_file" accept=".csv">
                            </div>
                            <div class="mt-3">
                                <input type="submit" value="Upload" name="sub" class="btn btn-dark bg-secondary ms-2">

                            </div>
                        </form>
                    </div>
                    <div class="">
                        <h3 class="mt-5 text-center text-danger">
                            <?php
                            if (isset($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="">
                        <h3 class="mt-5 text-center text-dark">
                            <?php
                            if (isset($message)) {
                                echo $message;
                            }
                            ?>
                        </h3>
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