<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "phonebook-project");
if (!$conn) {
    echo "Error in Connection" . mysqli_connect_error();
} else {
    if (isset($_SESSION['admin_user_id']) || isset($_SESSION['admin_user_type'])) {
        $admin_user_id = $_SESSION['admin_user_id'];
        $admin_type = $_SESSION['admin_user_type'];

        // $sql = "SELECT user_profile.user_id, user_profile.user_name,contact_details.contact_id,contact_details.contact_name,contact_number.contact_number
        // from user_profile
        // right join contact_details
        // on user_profile.user_id = contact_details.user_id 
        // right join contact_number
        // on contact_details.contact_id = contact_number.contact_id
        // where user_profile.user_id = $user_id and contact_number.contact_number_active=1
        // order by contact_details.contact_name ASC";


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['toggle_status'])) {
                $admin_id = $_POST['id'];
                $current_active = $_POST['new_active'];
                if (($current_active == 1) || ($current_active == "1")) {
                    $current_active = 0;
                } else {
                    $current_active = 1;
                }
                $sql = "UPDATE admin_users SET admin_user_active = {$current_active} WHERE admin_user_id = $admin_id";

                if (!mysqli_query($conn, $sql)) {
                    echo 'Error' . $sql . mysqli_error($conn);
                    exit;
                }
            }
        }
    } else {
        header("location:admin_login.php");
        // echo "User ID not found in session.";
    }
    $sql = "SELECT * from admin_users";

    $result = mysqli_query($conn, $sql);
    $data = mysqli_num_rows($result);
}

?>


<!doctype html>
<html lang="en">

<head>
    <title>View Admin Users</title>
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

        /* 
        .custom_container {
            width: 90%;
            margin-top: 30px;
            padding-bottom: 20px;
            background-color: rgba(15, 15, 15, 0.8);
        } */
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
            width: 100px;
            /* Adjust the width and height according to your needs */
            height: 100px;
            overflow: hidden;
            /* border-radius: 50%; */
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
                        <?php
                        if ($admin_type == "1") {
                        ?>
                            <a href="add_new_admin_user.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Add New Admin</a>
                        <?php } ?>
                        <a href="view_all_users.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">View All Users</a>
                        <a href="admin_profile.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Profile</a>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ms-3 mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-4 text-center w-60">
                                <thead>
                                    <tr class="table-dark text-white">

                                        <th class="align-middle">ID</th>
                                        <th class="align-middle">Name</th>
                                        <th class="align-middle">Username</th>
                                        <th class="align-middle">Email</th>
                                        <th class="align-middle">Gender</th>
                                        <th class="align-middle">Image</th>
                                        <th class="align-middle">Type</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Active</th>
                                        <th class="align-middle">Password</th>
                                        <th class="align-middle">Delete</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($data > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) { ?>

                                            <tr>
                                                <td class="align-middle"><?php echo $row['admin_user_id']; ?></td>
                                                <td class="align-middle"><?php echo $row['admin_user_name']; ?></td>
                                                <td class="align-middle"><?php echo $row['admin_user_username']; ?></td>
                                                <td class="align-middle"><?php echo $row['admin_user_email']; ?></td>
                                                <td class="align-middle"><?php echo $row['admin_user_gender']; ?></td>
                                                <td class="custom_image mt-2">
                                                    <img class='img-fluid' src="<?php echo "uploaded_file/" . $row['admin_user_image']; ?>" alt='image'>
                                                </td>
                                                <td class="align-middle">
                                                    <?php
                                                    if ($row['admin_user_type'] == 1) {
                                                        echo "Super User";
                                                    } else {
                                                        echo "Sub User";
                                                    } ?></td>

                                                <td class="align-middle">

                                                    <?php if ($row['admin_user_active'] == 1) {
                                                        echo "Active";
                                                    } else {
                                                        echo "In-Active";
                                                    }
                                                    ?></td>
                                                <td class="align-middle">
                                                    <?php if ($admin_type == '1') { 
                                                    ?>
                                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                            <input type="hidden" name="id" value="<?php echo $row['admin_user_id']; ?>">
                                                            <input type="hidden" name="new_active" value="<?php echo $row['admin_user_active']; ?>">
                                                            <button type="submit" name="toggle_status" class="icon-btn px-2 py-2">
                                                                <?php if ($row['admin_user_active'] == '1') { ?>
                                                                    <i class="fa-solid fa-toggle-on"></i>
                                                                <?php } else { ?>
                                                                    <i class="fa-solid fa-toggle-off"></i>
                                                                <?php } ?>
                                                            </button>
                                                        </form>
                                                    <?php } else { ?>
                                                        <button type="button" class="icon-btn px-2 py-2" disabled>
                                                            <?php if ($row['admin_user_active'] == '1') { ?>
                                                                <i class="fa-solid fa-toggle-on" style="color: #a0a0a0;"></i>
                                                            <?php } else { ?>
                                                                <i class="fa-solid fa-toggle-off" style="color: #a0a0a0;"></i>
                                                            <?php } ?>
                                                        </button>
                                                    <?php } ?>
                                                </td>



                                                <td class="align-middle">

                                                    <form action="change_admin_pwd.php" method="post">
                                                        <input type="hidden" name="id" value="<?php echo $row['admin_user_id']; ?>">
                                                        <input type="submit" value="Change" name="pwd" class="btn btn-dark bg-secondary">

                                                    </form>
                                                </td>
                                                <td class="align-middle">
                                                    <?php if ($admin_type == '1') { ?>

                                                        <form action="delete_admin_user.php" method="post">
                                                            <input type="hidden" name="aid" value="<?php echo $row['admin_user_id']; ?>">
                                                            <input type="hidden" name="name" value="<?php echo $row['admin_user_name']; ?>">
                                                            <input type="hidden" name="username" value="<?php echo $row['admin_user_username']; ?>">

                                                            <input type="submit" value="Delete" name="del" class="btn btn-dark bg-secondary">

                                                        </form>
                                                    <?php } else { ?>
                                                        <input type="submit" value="Delete" name="del" class="btn btn- bg-secondary" disabled>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo 'No Records found';
                                        // exit;
                                    } ?>
                                </tbody>
                            </table>
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