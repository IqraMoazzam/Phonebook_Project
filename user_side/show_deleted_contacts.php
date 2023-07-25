<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "phonebook-project");
if (!$conn) {
  echo "Error in Connection" . mysqli_connect_error();
} else {
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['del_contact'])) {

    $sql = "SELECT user_profile.user_id, user_profile.user_name,contact_details.contact_id,contact_details.contact_name,contact_number.contact_number
    from user_profile
    right join contact_details
    on user_profile.user_id = contact_details.user_id 
    right join contact_number
    on contact_details.contact_id = contact_number.contact_id
    where user_profile.user_id = '$user_id' and contact_number.contact_number_active=0
    order by contact_details.contact_name ASC";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_num_rows($result);

   
  }
  } else {
    header("location:login.php");
    // echo "User ID not found in session.";
  }

}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['add_btn'])){
    $cid = $_POST['cid'];
    $cnum = $_POST['cnum'];
    $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
if (!$conn) {
  echo "Error in Connection" . mysqli_connect_error();
} else {
  $sql = "UPDATE contact_number SET contact_number_active = 1 where contact_id = '{$cid}' and contact_number='{$cnum}'";
  if (mysqli_query($conn,$sql)){
    header("location:view_contact.php");
  } else {
    echo 'Error' . $sql . "<br>" . mysqli_error($conn);
  }
}
}
}


?>


<!doctype html>
<html lang="en">

<head>
    <title>Show Deleted Contacts</title>
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
                        <p class="h4"><i class="fa-solid fa-address-book fa-sm text-secondary"></i> PhoneBook Directory</p>

                        <a href="logout.php" class="text-decoration-none text-light custom_nav btn btn-dark bg-secondary">Logout</a>
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
                <div class="breakpoints col-lg-10 col-md-9 col-sm-8 h-auto">
                  
                        <div class="container">
                            <div class="row">
                                <div class="col">

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mt-4 text-center w-60">
                                        <thead>
                                            <tr class="table-dark text-white">
                                                <th class="align-middle">Contact-Name</th>
                                                <th>Contact-Numbers</th>
                                                <th>Add</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  if ($data > 0) {
   while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <tr>
                                                  
                                                    <td class="align-middle"><?php echo $row['contact_name']; ?></td>
                                                    <td class="align-middle"><?php echo $row['contact_number']; ?></td>
                                                    <td class="align-middle">

                                                  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                                                  <input type="hidden" name="cid" value="<?php echo $row['contact_id'] ?>">
                                                  <input type="hidden" name="cname" value="<?php echo $row['contact_name'] ?>">
                                                  <input type="hidden" name="cnum" value="<?php echo $row['contact_number'] ?>">
                                                    <input type="submit" name="add_btn" value="Add" class="btn btn-primary">
                                                  </form>
                                                    </td>
                                                </tr>
                                               
                                                <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="3" class="text-center">No Records found</td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
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