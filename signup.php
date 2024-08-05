
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
}

.main-box h4 {
    text-align: center;
    margin-bottom: 1rem;
    color: #fff;
}

.innerdiv {
    display: flex;
    justify-content: space-between;
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

.formdiv fieldset {
    border: none;
    margin-bottom: 1rem;
}

.formdiv fieldset legend {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.formdiv fieldset input[type="radio"] {
    margin-right: 0.5rem;
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

.main-box a button {
    background-color: #007bff;
    color: #fff;
    padding: 0.75rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 1rem;
}

.main-box a button:hover {
    background-color: #0069d9;
}

.login-link 
{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 0.5rem;
    color:  #333;
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
        <h4>Registration Form</h4><br>
        <div class="innerdiv">
            <form action="" method="post" class="formdiv" enctype="multipart/form-data">

                <label for="Name">Name</label>
                <input type="text" name="name" id="" placeholder="Enter Your Name" required />

                <label for="">Mobile No</label>
                <input type="number" name="mobile" id="">

                <label for="">DOB</label>
                <input type="date" name="dob" id="">

                <fieldset>
                    <legend>Gender</legend>
                    <input type="radio" id="male" name="gender" value="Male">
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female">
                    <label for="female">Female</label>
                </fieldset>


                <label for="">Email</label>
                <input type="email" name="email" id="" placeholder="example@gmail.com">

                <label for="">Address </label>
                <input type="textarea" name="address" id="">

                <label for="">Password</label>
                <input type="text" name="password" id="" />

                <label for="">Confirm Password</label>
                <input type="text" name="confirm_password" id="" /><br> <br>

                <label for="photo">Upload Pic</label>
                <input type="file" name="photo" id="" accept=".jpg, .jpeg, .png" required><br><br>


                <button type="submit" name="submit">Submit</button>
            </form>


        </div>

        <!-- <a href="admin.php"><button>Data See</button></a> -->
       <span class="login-link" >Do You Have An Account ? <a href="login.php">Login</a></span>
    </div>





    <!-- PHP Start From here -->

    <?php

    $conn = mysqli_connect("localhost", "root", "", "newweb");
    if ($conn) {
     //   echo "The Database Conection Succesfull";
    } else {
        mysqli_close($conn);
        die("Connection Failed" . mysqli_connect_error());
    }


    // Insert 
    
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $dob = $_POST['dob'];
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $email = $_POST['email'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $photo = $_FILES['photo'];

        // images php 
        $filename = $_FILES["photo"]["name"];
        $uni = uniqid(); // Generates a unique string
        $tempname = $_FILES["photo"]["tmp_name"];
        $folder = "images/" . $uni . "_" . $filename; // Combine the unique string with the original filename
        move_uploaded_file($tempname, $folder);

        // Validation
    
        $sql = "SELECT email FROM signup";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $checkemail = $row['email'];
        //echo "<br> hello ".$checkemail;
        if (
            empty($name) || empty($mobile) || empty($dob) || empty($gender) || empty($email)
            || empty($address) || empty($password) || empty($confirm_password) || empty($photo)
        ) {
            echo '<script>alert("Please fill out all required fields.");</script>';
        } elseif ($password !== $confirm_password) {
            echo '<script>alert("Password do not match");</script>';
            die("Password do not match");
        } elseif ($email == $checkemail) {
            echo  '<script>alert("Already Register");</script>';
            die("Already Register");
        } else {

            // Sql
    
            $sql = "INSERT INTO signup (name,mobile,dob,gender,email,address,password,confirm_password,photo)
                 VALUES ('$name','$mobile','$dob','$gender','$email','$address','$password','$confirm_password','$folder')";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Sign Up Succes");</script>';
                
            } else {
                echo "Insert is Failed";
            }

            $sql = "INSERT INTO user (name,email,password)
            VALUES ('$name','$email','$password')";
            if (mysqli_query($conn, $sql)) {
                //echo "<br> New Record inserted Succesfull";

            } else {
                echo "Insert is Failed"; 
            }
        }
    }

    ?>
</body>

</html>
