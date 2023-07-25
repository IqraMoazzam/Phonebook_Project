<?php
session_start();
if(isset($_SESSION['user_id'])){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Code for handling the submit action
    } else if (isset($_POST['change'])) {
        $cname = $_POST['cname'];
        $oldname = $_POST['old_name'];
        $oldnumber = $_POST['old_number'];
        $cnumber = $_POST['cnumber'];

        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error in Connection" . mysqli_connect_error();
        } else {

            if ($cname == "") {
                $cname = $oldname;
            }

            if ($cname != $oldname) {
                $sql = "UPDATE contact_details SET contact_name = '{$cname}'
                WHERE contact_id = (SELECT contact_id FROM contact_details WHERE user_id = {$_SESSION['user_id']} AND contact_name = '{$oldname}')";

                if (mysqli_query($conn, $sql)) {
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
            if ($cnumber == "") {
                $cnumber = $oldnumber;
            }

            if ($cnumber != $oldnumber) {
                
                $sql_2 = "UPDATE contact_number SET contact_number = '{$cnumber}'
                WHERE contact_id = (SELECT contact_id FROM contact_details WHERE user_id = {$_SESSION['user_id']} AND contact_name = '{$cname}') AND contact_number = '{$oldnumber}'";

                if (mysqli_query($conn, $sql_2)) {
                   
                } else {
                    echo "Error: " . $sql_2 . "<br>" . mysqli_error($conn);
                }
            }
            header("location:view_contact.php");
        }
    }
}
}else{
    header("location:login.php");
}
?>

<!doctype html>
<!-- Rest of your HTML code -->


<!doctype html>
<html lang="en">

<head>
    <title>Update Contact Details</title>
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

                    <div class="modal mt-5 h-100" tabindex="-1" id="modal_id">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Contact Details</h5>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <div class="modal-body">
                                        <div>
                                            <label for="oldname" class="form-label mb-2">Old Contact Name:</label>
                                            <input type="text" name="old_name" id="oldname" class="form-control" value="<?php echo $_POST['oldname']; ?>" readonly>
                                        </div>
                                        <div>
                                            <label for="cname" class="form-label mb-2">New Contact Name:</label>
                                            <input type="text" name="cname" id="cname" class="form-control" placeholder="Enter New Contact Name">
                                        </div>

                                        <div>
                                            <label id="oldnumber" class="form-label">Old Contact Number:</label>
                                            <input type="tel" name="old_number" id="oldnumber" class="form-control" value="<?php echo $_POST['oldnumber']; ?>" readonly>
                                        </div>
                                        <div>
                                            <label id="cnumber" class="form-label">New Contact Number:</label>
                                            <input type="tel" name="cnumber" id="cnumber" class="form-control" placeholder="Enter New Contact Number">
                                        </div>

                                        <!-- <input type="hidden" name="oldName" value="<?php //echo $oldname; 
                                                                                        ?>"> -->

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" value="Update" id="change" name="change" class="btn btn-primary">
                                    </div>
                                </form>
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


    <script>
        let my_modal = new bootstrap.Modal(document.getElementById('modal_id'));
        my_modal.show();

        document.getElementById('change').addEventListener('click', function() {
            my_modal.hide();
            window.location.replace("view_contact.php");
        });

        document.getElementById('close').addEventListener('click', function() {
            window.location.replace("view_contact.php");
            // alert('testing');
        });
    </script>
</body>

</html>