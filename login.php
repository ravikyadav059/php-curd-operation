<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        h4 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        input[type="email"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"] {
            background-color: #3498db;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        a button {
            background-color: #2ecc71;
            text-decoration: none;
        }

        a button:hover {
            background-color: #27ae60;
        }

        @media (max-width: 600px) {
            form {
                width: 90%;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <h4>Login</h4>
        Email: <input type="email" name="email" id=""><br>
        Password: <input type="password" name="password" id=""><br>
        <button type="submit" name="login">Login</button>
        <a href="signup.php"><button type="button">Registration</button></a>
    </form>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "newweb");
    if ($conn) {
        // echo "<script>alert('The Database Connection Successful')</script>";
    } else {
        mysqli_close($conn);
        die("Connection Failed" . mysqli_connect_error());
    }

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (empty($email) || empty($password)) {
            echo '<script> alert("Fill input"); </script>';
        }

        $sql = "SELECT email, password FROM user WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

            //jay

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            // setcookie("ID",$row['id']); //jay
            setcookie("EMAIL",$row['email']); //jay

            if ($password === $row['password']) {
                echo '<script>window.location = "welcome.php";</script>';
            } else {
                echo '<script> alert("Login Failed");</script>';
            }
        } else {
            echo '<script> alert("Email not found.");</script>';
        }


        // new added and try start
        $sql_signup = "SELECT * FROM signup WHERE email='$email'";
        $result_signup = mysqli_query($conn,$sql_signup);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

        }

         // new added and try end
        
    }
    ?>
</body>

</html>
