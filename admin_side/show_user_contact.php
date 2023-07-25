<?php
session_start();
if(isset($_SESSION['admin_user_id'])){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['show_contact'])) {
        $user_id = $_POST['id'];

        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error in Connection" . mysqli_connect_error();
        } else {
            if (isset($_SESSION['admin_user_id'])) {
                $admin_id = $_SESSION['admin_user_id'];

                $sql = "SELECT user_profile.user_id, user_profile.user_name,contact_details.contact_id,contact_details.contact_name,contact_number.contact_number,contact_details.contact_active,contact_number.contact_number_active
                from user_profile
                right join contact_details
                on user_profile.user_id = contact_details.user_id 
                right join contact_number
                on contact_details.contact_id = contact_number.contact_id
                where user_profile.user_id = $user_id
                order by contact_details.contact_name ASC";

                $result = mysqli_query($conn, $sql);
                $data = mysqli_num_rows($result);
            } else {
                header("location:admin_login.php");
            }
        }
    }
}
}else{
    header("location:admin_login.php");
}
?>

<!-- Rest of the HTML code -->


<!doctype html>
<html lang="en">

<head>
    <title>View All Contacts</title>
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
            /* border: 2px solid purple; */
        }

        .navbar {
            height: 55px;
            border: 1px solid black;

        }

        .breakpoints {
            height: 573px;
            /* border: 2px solid black; */
        }

        .custom_form {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            /* border: 2px solid green; */

        }

        .custom_search {
            color: white;
            /* border: 2px solid red; */
            margin-right: 10px;
            font-weight: bold;
        }
       
    </style>
</head>

<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid text-light">
                <div class="row w-100">
                    <div class="col-3">
                        <p class="h4"><i class="fa-solid fa-address-book fa-sm text-secondary"></i> PhoneBook Directory</p>
                    </div>
                    <div class="col-9 bg-dark custom_form">

                        <a href="admin_logout.php" class="text-decoration-none text-light btn-logout btn btn-dark bg-secondary">Logout</a>
                    </div>

                </div>
            </div>
        </nav>
    </header>
    <!-- Body -->
    <main>
        <div class="container-fluid">
            <div class="row">
            
                <div class="breakpoints col-lg-12 col-md-12 col-sm-12 h-auto">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 bg-dark mt-3 pt-2 pb-2 ps-4">
                                <form action="search_file.php" method="post">
                                    <label for="search" class="custom_search">Search</label>
                                    <input type="text" name="search" id="search" class="form-control-sm">
                                    <label for=" search_by" class="custom_search ms-3">Search By</label>
                                    <select type="text" name="search_by" id="search_by" class="form-control-sm">
                                        <option value="name">Contact Name</option>
                                        <option value="number">Contact Number</option>
                                    </select>
                                    <input type="submit" value="Search" name="btn_search" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                        <div class="col-12">
                            <?php if ($data > 0) { ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mt-4 text-center w-60">
                                        <thead>
                                            <tr class="table-dark text-white">

                                                <th class="align-middle">Contact-Name</th>
                                                <th>Contact-Numbers</th>
                                                <th>Active</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($result)) {
                                            ?>

                                                <tr>
                                                    <td class="align-middle"><?php echo $row['contact_name']; ?></td>
                                                    <td class="align-middle"><?php echo $row['contact_number']; ?></td>
                                                    <td class="align-middle">
                                                        <?php
                                                        if ($row['contact_active'] == 1) {
                                                            echo "Active";
                                                        } else {
                                                            echo "In-Active";
                                                        }
                                                        ?>
                                                    <td class="align-middle">
                                                        <form action="update_contact_details.php" method="post" class="d-inline">
                                                            <input type="hidden" name="oldname" value="<?php echo $row['contact_name']; ?>">
                                                            <input type="hidden" name="oldnumber" value="<?php echo $row['contact_number']; ?>">
                                                            <input type="hidden" name="uid" value="<?php echo $row['user_id']; ?>">

                                                            <input type="submit" value="Update" name="submit" class="btn btn-primary">
                                                        </form>
                                                        <form action="delete_contact_details.php" method="post" class="d-inline">
                                                            <input type="hidden" name="u_id" value="<?php echo $row['user_id']; ?>">
                                                            <!-- <input type="hidden" name="c_num_id" value="<?php //echo $row['contact_number_id'];
                                                                                                                ?>"> -->
                                                            <input type="hidden" name="con_id" value="<?php echo $row['contact_id']; ?>">
                                                            <input type="hidden" name="contact_name" value="<?php echo $row['contact_name']; ?>">
                                                            <input type="hidden" name="contact_num" value="<?php echo $row['contact_number']; ?>">
                                                            <input type="submit" value="Delete" name="submit" class="btn btn-danger">

                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <div class="text-center mt-4">
                                    <h4>No Records found</h4>
                                </div>
                            <?php } ?>

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