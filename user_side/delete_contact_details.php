<?php
session_start();
if(isset($_SESSION['user_id'])){
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['sub'])){
    $cname = $_POST['cname'];
    $cid = $_POST['cid'];
    $cnum = $_POST['cnum'];

$conn = mysqli_connect("localhost","root","","phonebook-project");
if(!$conn){
    echo "Error in Connection" . mysqli_connect_error();
}
else{

    // echo "testing" . $cname . " " . $cid;
    // die;
    // $sql = "DELETE from contact_number where contact_id = {$cid} and contact_number = '{$cnum}'";
    $sql = "UPDATE contact_number SET contact_number_active = 0 where contact_id = '{$cid}' and contact_number='{$cnum}'";


    // $sql = "DELETE from contact_details where contact_id = (SELECT contact_id from contact_details where user_id = '{$_SESSION['user_id']}'
    //     and contact_name = '$cname')";
    if(mysqli_query($conn,$sql)){
        header("location:view_contact.php");

    }else{
        echo "Error" . $sql . "<br>" . mysqli_error($conn);
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
    <title>Delete Contact Details</title>
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

        .breakpoints{
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
                         <a href="logout.php" class="text-decoration-none text-light custom_nav">Logout</a></p>                    </div>
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
                    <a class="link text-decoration-none text-light" href="choose_csv_file.php"><i class="fa-solid fa-file-csv fa-sm text-secondary"></i> Choose CSV File</a>

                </div>
                <div class="breakpoints col-lg-10 col-md-9 col-sm-8 h-auto adjust_form">
                <div class="modal mt-5 h-100" tabindex="-1" id="modal_id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Deletion</h5>
                    </div>
                    <div class="modal-body mt-3">
                        <div class="h5">Are you Sure you want to delete this Contact?</div>
                        <div class="row">
                            <div class="col-2">

                            </div>
                            <div class="col-3">
                            <div class="pb-3 pt-2 fw-bold">Name</div>
                            <div class="fw-bold">Number</div>
                                
                            </div>
                            <div class="col-2">
                            <div class="pb-3 pt-2 ">:</div>
                            <div class="">:</div>
                            </div>
                            <div class="col-4">
                             <div class="pb-3 pt-2">
                                    <?php echo $_POST['contact_name']; ?>
                                </div>
                                <div>
                                    <?php echo $_POST['contact_num']; ?>
                                </div>
                            </div>
                            <div class="col-1">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-5">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <?php 
                        echo "<input type='hidden' name='cname' value='{$_POST['contact_name']}'>";
                        echo "<input type='hidden' name='cid' value='{$_POST['con_id']}'>";
                        echo "<input type='hidden' name='cnum' value='{$_POST['contact_num']}'>";
                        
                        ?>
                        
                        <input type="submit" id="yes" value="Yes" name="sub" class="btn btn-primary" data-bs-dismiss="modal">
                        <button type="button" id="no" class="btn btn-danger">No</button>
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
<!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script> -->
<script>
        let my_modal = new bootstrap.Modal(document.getElementById('modal_id'));
        my_modal.show();
        document.getElementById('no').addEventListener('click', function() {

            my_modal.hide();
            window.location.replace("view_contact.php");
        });

        document.getElementById('yes').addEventListener('click', function() {
            window.location.replace("view_contact.php");
            // alert('testing');
        });

        // $(document).ready(function(){ 
        //     $(document).on('click','del_btn',function(e){
        //         e.preventDefault();
        //         alert('testing');
        //     });

        // });
    </script>
</body>

</html>
