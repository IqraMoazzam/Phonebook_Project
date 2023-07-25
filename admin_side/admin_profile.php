<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header("location: admin_login.php");
}
// echo $_SESSION['admin_user_id'];
// die();
$conn = mysqli_connect("localhost", "root", "", "phonebook-project");
if (!$conn) {
    echo "Error in Connection" . mysqli_connect_error();
} else {
    $sql = "select * from admin_users where admin_user_id = '{$_SESSION['admin_user_id']}'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_num_rows($result);
    if ($data > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_user_id'] = $row['admin_user_id'];
    } else {
        echo "Error" . $sql . "<br>" . mysqli_error($conn);
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <title>Admin Profile</title>
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
            height: 565px;
            /* border: 2px solid pink; */

        }

        .breakpoints {
            height: 627px;

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
            /* border: 2px solid blue; */
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
                <div class="breakpoints col-lg-2 col-md-3 col-sm-4 d-flex gap-2 flex-column bg-dark pt-1 ps-2 ">
                    <div class="custom_image mt-2">
                        <img class='img-fluid' src="<?php echo "uploaded_file/" . $row['admin_user_image']; ?>" alt='image'>
                    </div>
                    <div>
                        <a href="admin_profile.php" class="h5 text-light bg-dark ps-3 text-decoration-none">Hello, Admin</a>
                    </div>
                    <!-- <a class="link text-decoration-none text-light" href="home.php"><i class="fa-solid fa-house-user fa-sm text-secondary"></i> Home</a>
                    <a class="link text-decoration-none text-light" href="add_new_contact.php"><i class="fa-solid fa-user-plus fa-sm text-secondary"></i> Add New Contact</a>
                    <a class="link text-decoration-none text-light" href="view_contact.php"><i class="fa-solid fa-users-viewfinder fa-sm text-secondary"></i> View All Contacts</a>
                    <a class="link text-decoration-none text-light" href="update_user_profile.php"><i class="fa-solid fas fa-user-edit fa-sm text-secondary"></i> Update Profile</a>
                    <a class="link text-decoration-none text-light" href="delete_account.php"><i class="fa-solid fa-user-xmark text-secondary"></i> Delete Account</a> -->
                </div>
                <div class="col-lg-10 col-md-9 col-sm-8 h-auto border px-0 border border-dark">
                    <div class="h-auto custom_nav bg-dark">
                        <a href="admin_logout.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Logout</a>
                        <?php
                        if ($row['admin_user_type'] == "1") {
                        ?>
                            <a href="add_new_admin_user.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">Add New Admin</a>
                        <?php } ?>
                        <a href="view_admin_users.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">View Admin Users</a>
                        <a href="view_all_users.php" class=" h4 text-decoration-none text-light btn_logout btn btn-dark bg-secondary">View All Users</a>
                    </div>

                    <div class="container custom_container">
                        <table class="table table-bordered mt-5">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Name</td>
                                    <td><?php echo $row['admin_user_name']; ?></td>
                                    <td>
                                        <form action="update_admin_name.php" method="post">
                                            <input type="hidden" name="name" value="<?php echo $row['admin_user_name']; ?>">
                                            <input type="hidden" name="admin_id" value="<?php echo $row['admin_user_id']; ?>">
                                            <button class="btn btn-dark bg-secondary" type="submit" name="edit_name">Edit</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Username</td>
                                    <td><?php echo $row['admin_user_username']; ?></td>
                                    <td>
                                        <form action="update_admin_uname.php" method="post">
                                            <input type="hidden" name="uname" value="<?php echo $row['admin_user_username']; ?>">
                                            <input type="hidden" name="admin_id" value="<?php echo $row['admin_user_id']; ?>">
                                            <button class="btn btn-dark bg-secondary" type="submit" name="edit_username">Edit</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email</td>
                                    <td><?php echo $row['admin_user_email']; ?></td>
                                    <td>
                                        <form action="update_admin_email.php" method="post">
                                            <input type="hidden" name="email" value="<?php echo $row['admin_user_email']; ?>">
                                            <input type="hidden" name="admin_id" value="<?php echo $row['admin_user_id']; ?>">
                                            <button class="btn btn-dark bg-secondary" type="submit" name="edit_email">Edit</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Password</td>
                                    <td>
                                        <form action="update_admin_password.php" method="post">
                                            <input type="hidden" name="admin_id" value="<?php echo $row['admin_user_id']; ?>">
                                            <button class="btn btn-dark bg-secondary" type="submit" name="edit_password">Change Password</button>
                                        </form>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Admin Type</td>
                                    <td>
                                        <?php
                                        if ($row['admin_user_type'] == 1) {
                                            echo "Super Type";
                                        } else {
                                            echo "Sub Type";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Gender</td>
                                    <td><?php echo $row['admin_user_gender']; ?></td>
                                    <td>
                                        <form action="update_admin_gender.php" method="post">
                                            <input type="hidden" name="a_gender" value="<?php echo $row['admin_user_gender']; ?>">
                                            <input type="hidden" name="admin_id" value="<?php echo $row['admin_user_id']; ?>">
                                            <button class="btn btn-dark bg-secondary" type="submit" name="edit_gender">Edit</button>
                                        </form>
                                    </td>
                                </tr>
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