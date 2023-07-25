<?php
session_start();

$conn = mysqli_connect("localhost","root","","phonebook-project");
if(!$conn){
    echo "Error in Connection" . mysqli_connect_error();
}
else{
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

if(isset($_POST['btn_search'])){
    $search = $_POST['search'];
    $searchBy = $_POST['search_by'];
    

if($searchBy === 'name'){

    $sql = "SELECT contact_details.contact_id,contact_details.contact_name,contact_number.contact_number
    from user_profile
    right join contact_details
    on user_profile.user_id = contact_details.user_id 
    right join contact_number
    on contact_details.contact_id = contact_number.contact_id
    where user_profile.user_id = {$_SESSION['user_id']} and contact_number.contact_number_active=1 
    and contact_details.contact_name LIKE '%$search%'
    order by contact_details.contact_name ASC";

}else if($searchBy === 'number'){

    $sql = "SELECT contact_details.contact_id,contact_details.contact_name,contact_number.contact_number
    from user_profile
    right join contact_details
    on user_profile.user_id = contact_details.user_id 
    right join contact_number
    on contact_details.contact_id = contact_number.contact_id
    where user_profile.user_id = {$_SESSION['user_id']} and contact_number.contact_number_active=1 
    and contact_number.contact_number LIKE '%$search%'
    order by contact_details.contact_name ASC";
    // echo $sql;

}else{
    echo "Invalid Search";
}

$result = mysqli_query($conn, $sql);
$data = mysqli_num_rows($result);

if ($data > 0) {

} else {
    echo 'No records found.';
}
}
} 

}
?>



<!doctype html>
<html lang="en">

<head>
    <title>Search  Contact Details</title>
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
                        <form action="add_new_num_for_existing.php" method="post">
                            <input type="submit" value="Add New Number for Existing Contact" name="add_existing_btn" class="btn btn-dark bg-secondary">
                        </form>
                        <form action="show_deleted_contacts.php" method="post">
                            <input type="hidden" name="cid" value="<?php echo $row['contact_id']; ?>">
                            <input type="submit" value="Show Deleted Contacts" name="del_contact" class="btn btn-dark bg-secondary">
                        </form>
                        <a href="logout.php" class="text-decoration-none text-light btn-logout btn btn-dark bg-secondary">Logout</a>
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
                </div>
                <div class="breakpoints col-lg-10 col-md-9 col-sm-8 h-auto">
                    <div class="container">
                        <div class="row">
                        <div class="col-12 bg-dark mt-3 pt-2 pb-2 ps-4">
                            <form action="" method="post">
                                <label for="search" class="custom_search">Search</label>
                                <input type="text" name="search" id="search" class="form-control-sm">
                                <label for="search_by" class="custom_search ms-3">Search By</label>
                                <select type="text" name="search_by" id="search_by" class="form-control-sm">
                                    <option value="name">Contact Name</option>
                                    <option value="number">Contact Number</option>
                                </select>
                                <input type="submit" value="Search" name="btn_search" class="btn btn-primary">
                            </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mt-4 text-center w-60">
                                        <thead>
                                            <tr class="table-dark text-white">

                                                <th class="align-middle">Contact-Name</th>
                                                <th>Contact-Number</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
  
                                          while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                                <tr>
                                                    <td class="align-middle"><?php echo $row['contact_name']; ?></td>
                                                    <td class="align-middle"><?php echo $row['contact_number']; ?></td>
                                                    <td class="align-middle">
                                                        <form action="update_contact_details.php" method="post" class="d-inline">
                                                            <input type="hidden" name="old_name" value="<?php echo $row['contact_name']; ?>">

                                                            <input type="submit" value="Update" name="submit" class="btn btn-primary">
                                                        </form>
                                                        <form action="delete_contact_details.php" method="post" class="d-inline">
                                                            <input type="hidden" name="con_id" value="<?php echo $row['contact_id']; ?>">
                                                            <input type="hidden" name="contact_name" value="<?php echo $row['contact_name']; ?>">
                                                            <input type="hidden" name="contact_num" value="<?php echo $row['contact_number']; ?>">
                                                            <input type="submit" value="Delete" name="submit" class="btn btn-danger">
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