<?php
session_start();
// if (!isset($_SESSION['admin_user_type']) || $_SESSION['admin_user_type'] !== "1") {
//     // Redirect to admin profile page or any other suitable page
//     header("Location: admin_profile.php");
//     exit();
// }
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
        $sql = "SELECT * from user_profile";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_num_rows($result);

        if ($data > 0) {
            // $_SESSION['admin_user_type'] = $row['admin_user_type'];

        } else {
            echo 'No Records found';
        }
    } else {
        header("location:admin_login.php");
        // echo "User ID not found in session.";
    }
}



?>


<!doctype html>
<html lang="en">

<head>
    <title>View All Users</title>
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
                <!-- <div class="breakpoints col-lg-1 col-md-3 col-sm-4 d-flex gap-4 flex-column bg-dark pt-1 ps-2 ">
                    <img class='img-fluid rounded-circle custom_image pt-2' src="<?php echo "uploaded_file/" . $row['admin_user_image']; ?>" alt='image'>
                    <div>
                        <a href="admin_profile.php" class="h5 text-light bg-dark ps-2  text-decoration-none">Hello, Admin</a>
                    </div> -->
                <!-- <a class="link text-decoration-none text-light" href="home.php"><i class="fa-solid fa-house-user fa-sm text-secondary"></i> Home</a>
                    <a class="link text-decoration-none text-light" href="add_new_contact.php"><i class="fa-solid fa-user-plus fa-sm text-secondary"></i> Add New Contact</a>
                    <a class="link text-decoration-none text-light" href="view_contact.php"><i class="fa-solid fa-users-viewfinder fa-sm text-secondary"></i> View All Contacts</a>
                    <a class="link text-decoration-none text-light" href="update_user_profile.php"><i class="fa-solid fas fa-user-edit fa-sm text-secondary"></i> Update Profile</a>
                    <a class="link text-decoration-none text-light" href="delete_account.php"><i class="fa-solid fa-user-xmark text-secondary"></i> Delete Account</a> -->
                <!-- </div> -->
                <div class="col-lg-12 col-md-12 col-sm-12 h-auto px-0 border border-dark">
                    <div class="h-auto custom_nav bg-dark">
                        <a href="admin_logout.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Logout</a>
                       <?php if($admin_type == '1'){ ?>
                            <a href="add_new_admin_user.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Add New Admin</a>
                      <?php } ?>
                        <a href="view_admin_users.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">View Admin Users</a>
                        <a href="admin_profile.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Profile</a>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 bg-dark mt-4 pt-2 pb-2 ps-4 ms-3 text-light">
                        <form action="search_file.php" method="post">
                            <label for="search" class="custom_search ms-2 pe-2">Search</label>
                            <input type="text" name="search" id="search" class="form-control-sm">
                            <label for=" search_by" class="custom_search ms-3 pe-2">Search By</label>
                            <select type="text" name="search_by" id="search_by" class="form-control-sm">
                                <option value="user-id">User-ID</option>
                                <option value="name">Name</option>
                                <option value="username">Username</option>
                                <option value="email">Email</option>
                            </select>
                            <input type="submit" value="Search" name="btn_search" class="btn btn-primary ms-2">
                        </form>
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
                                        <th class="align-middle">DOB</th>
                                        <th class="align-middle">Image</th>
                                        <th class="align-middle">Active</th>
                                        <th class="align-middle">Password</th>
                                        <th class="align-middle">Show Contacts</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                                        <tr>
                                            <td class="align-middle"><?php echo $row['user_id']; ?></td>
                                            <td class="align-middle"><?php echo $row['user_name']; ?></td>
                                            <td class="align-middle"><?php echo $row['user_username']; ?></td>
                                            <td class="align-middle"><?php echo $row['user_email']; ?></td>
                                            <td class="align-middle"><?php echo $row['user_gender']; ?></td>
                                            <td class="align-middle"><?php echo $row['user_dob']; ?></td>
                                            <td class="custom_image mt-2">
                                                <img class='img-fluid' src="<?php echo "uploaded_file/" . $row['user_image']; ?>" alt='image'>
                                            </td>
                                            <td class="align-middle">
                                                <?php if ($row['user_active'] == 1) {
                                                    echo "Active";
                                                } else {
                                                    echo "In-Active";
                                                } ?></td>
                                            <td class="align-middle">

                                                <form action="change_user_pwd.php" method="post">
                                                    <input type="hidden" name="uid" value="<?php echo $row['user_id'];
                                                                                                    ?>">

                                                    <input type="submit" value="Change" name="change_pwd" class="btn btn-dark bg-secondary">

                                                </form>
                                            </td>

                                            <td class="align-middle">

                                                <form action="show_user_contact.php" method="post" class="">

                                                    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                                                    <input type="submit" value="Show Contact" name="show_contact" class="btn btn-dark bg-secondary">

                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
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