<?php 
session_start();

$conn = mysqli_connect("localhost", "root", "", "newweb");
if ($conn) {
   // echo "The Database Conection Succesfull";
} else {
    mysqli_close($conn);
    die("Connection Failed" . mysqli_connect_error());
}

$id = $_GET['id'];

 // Session for login and logout
 $username_profile = $_SESSION['email'];
 if ($username_profile == true) {
     # code...
 }
 else
 {
     header('location:login.php');
 }


// display
$sql = "SELECT * FROM signup WHERE id=$id";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);


if (isset($_POST['update_form'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $photo = $_FILES['photo'];

   // Specify the path to the previous image
    $previousImagePath = "images/previous_image.jpg"; // Replace with your actual path

    // Delete the previous image if it exists
    if (file_exists($previousImagePath)) {
        unlink($previousImagePath);
    }

    // images php 
    $filename = $_FILES["photo"]["name"];
    $tempname = $_FILES["photo"]["tmp_name"];
    $folder = "images/" . $filename;
    move_uploaded_file($tempname, $folder);

    // Validation

    // echo "<script>alert('hello')</script>";

    $sql_upt = "UPDATE signup  SET name='$name' ,mobile = '$mobile',dob = '$dob', email='$email' ,address = '$address',password = '$password',confirm_password = '$confirm_password',photo='$folder'  WHERE id=$id";
    $sql_upt_log = "UPDATE user  SET name='$name', email='$email' ,password = '$password' WHERE id=$id";
    $res_upt = mysqli_query($conn, $sql_upt);
    $res_upt_log = mysqli_query($conn, $sql_upt_log);



    if ($res_upt && $res_upt_log) {
      //  echo '<script>alert(Update Succesfull.");</script>';
        echo ("<script Langage='JavaScript'>
        window.alert(\"Updated Successfull\");
        // window.open(\"welcome.php\",\"_top\");</script>");
        // header("Location: welcome.php");
        // exit();
    }
    else {
        echo ("<script Langage='JavaScript'>
        window.alert(\"Updated Failed\");</script>");
    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
       
        background-color: #f0f0f0;
    }

    .main-box {
        background-color: yellowgreen;
        width: 50%;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .main-box h4 {
        text-align: center;
        margin-bottom: 1rem;
        color: #fff;
    }

    .innerdiv {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .formdiv {
        background-color: #fff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        flex: 1;
    }

    .formdiv label {
        margin-bottom: 0.5rem;
        color: #333;
    }

    .formdiv input[type="text"],
    .formdiv input[type="number"],
    .formdiv input[type="date"],
    .formdiv input[type="email"],
    .formdiv input[type="textarea"],
    .formdiv input[type="file"] {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .formdiv button[type="submit"] {
        background-color: #28a745;
        color: #fff;
        padding: 0.75rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .formdiv button[type="submit"]:hover {
        background-color: #218838;
    }

    .button-container {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .button-container a button {
        background-color: #007bff;
        color: #fff;
        padding: 0.75rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: block;
    }

    .button-container a button:hover {
        background-color: #0069d9;
    }

    @media (max-width: 768px) {
        .main-box {
            width: 90%;
        }

        .innerdiv {
            flex-direction: column;
            align-items: center;
        }

        .formdiv {
            width: 100%;
        }
    }
</style>

<body>
    <div class="main-box">
        <h4>UPDATE FORM</h4><br>
        <div class="innerdiv">
            <form action="" method="post" class="formdiv" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?php echo $row['id']; ?>" required />

                <label for="Name">Name</label>
                <input type="text" name="name" value="<?php echo $row['name']; ?>" id="" placeholder="Enter Your Name"
                    required />

                <label for="">Mobile No</label>
                <input type="number" value="<?php echo $row['mobile']; ?>" name="mobile" id="">

                <label for="">DOB</label>
                <input type="date" value="<?php echo $row['dob']; ?>" name="dob" id="">

                <label for="">Email</label>
                <input type="email" value="<?php echo $row['email']; ?>" name="email" id=""
                    placeholder="example@gmail.com">

                <label for="">Address </label>
                <input type="textarea" value="<?php echo $row['address']; ?>" name="address" id="">

                <label for="">Password</label>
                <input type="text" value="<?php echo $row['password']; ?>" name="password" id="" />

                <label for="">Confirm Password</label>
                <input type="text" value="<?php echo $row['confirm_password']; ?>" name="confirm_password" id="" /><br>
                <br>

                <label for="photo">Upload Pic</label>
                <input type="file" value="<?php echo $row['photo']; ?>" name="photo" id=""
                    accept=".jpg, .jpeg, .png"><br><br>

                    <a href="welcome.php"><button type="submit" name="update_form">UPDATE</button></a>
            </form>
        </div>
        <div class="button-container">
            <a href="welcome.php"><button class="cancel-btn">Cancel</button></a>
        </div>
    </div>

    <!-- PHP Start From here -->

    
</body>
</html>
