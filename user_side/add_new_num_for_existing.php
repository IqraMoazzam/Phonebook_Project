<?php
session_start();
if(isset($_SESSION['user_id'])){
if (isset($_POST['add_existing_btn'])) {
    $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
    if (!$conn) {
        echo "Error in Connection" . mysqli_connect_error();
    } else {

        $sql = "SELECT contact_name FROM contact_details";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_num_rows($result);
        if ($data > 0) {
        } else {
            echo "Error:" . $sql . "<br>" . mysqli_error($conn);
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_btn'])) {

        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error in Connection" . mysqli_connect_error();
        } else {
            $cname = $_POST['cname'];
            $cnum = $_POST['cnum'];

            $sql = "INSERT INTO contact_number (contact_id,contact_number,contact_number_active)
            VALUES ( (select contact_id from contact_details where user_id= {$_SESSION['user_id']} and contact_name='{$cname}'), '{$cnum}',1)";
            try {
                if (mysqli_query($conn, $sql)) {

                    header("location:view_contact.php");
                    exit();
                } else {
                    $error_message = "Error: " . mysqli_error($conn);
                }
            } catch (mysqli_sql_exception $e) {
                // Handle the duplicate entry error
                $error_message = "Error: Duplicate entry for the contact number. Please try again with a different number.";
            }
        }
    }
}
}else{
    header("location:login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Add New Number for Existing Contacts</title>
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

        .custom_nav {
            top: 8px;
            right: 20px;
            text-align: center;
            position: absolute;
        }

        .custom_modal {
            margin-top: 7%;
            margin-left: 5%;

        }

        .custom_field_width {
            width: 100%;
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
                <div class="breakpoints col-lg-10 col-md-9 col-sm-8 h-auto mt-5">
                    <div class="container">
                        <h3 class="mt-5 ms-3 text-danger">
                            <?php
                            if (isset($error_message)) {
                                echo $error_message;
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="modal custom_modal" tabindex="-1" id="modal_id">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Contact</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-5">
                                                <div class="pb-3 pt-2 fw-bold">Contact Name</div>
                                                <div class="fw-bold pt-2">Contact Number</div>
                                            </div>
                                            <div class="col-1">
                                                <div class="pb-3 pt-2">:</div>
                                                <div class="pt-2">:</div>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-select custom_field_width" name="cname">
                                                    <option selected value="<?php echo $row['contact_name']; ?>">Open this select menu</option>

                                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                        <option value="<?php echo $row['contact_name']; ?>"><?php echo $row['contact_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div>
                                                    <input type="text" class="mt-3 custom_field_width" name="cnum">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" value="Add" class="btn btn-primary" name="add_btn" id="add">
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <script>
        let my_modal = new bootstrap.Modal(document.getElementById('modal_id'));
        my_modal.show();
        document.getElementById('close').addEventListener('click', function() {

            my_modal.hide();
            window.location.replace("view_contact.php");
        });

        document.getElementById('add').addEventListener('click', function() {
            window.location.replace("view_contact.php");

        });
    </script>
</body>

</html>