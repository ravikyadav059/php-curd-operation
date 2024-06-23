<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        h4 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            border-radius: 50%;
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

        button[name="delete"] {
            background-color: #e74c3c;
        }

        button[name="delete"]:hover {
            background-color: #c0392b;
        }

        form {
            display: inline-block;
        }

        @media (max-width: 600px) {

            table,
            th,
            td {
                display: block;
            }

            th,
            td {
                width: 100%;
                box-sizing: border-box;
            }

            th {
                background-color: transparent;
                color: #666;
            }

            tr {
                margin-bottom: 10px;
                display: block;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            td {
                display: flex;
                justify-content: space-between;
                padding: 10px 5px;
            }

            td img {
                margin-right: 10px;
            }

            td button {
                margin-top: 5px;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <h4>Admin</h4>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "newweb");
    if ($conn) {
        echo "<script>alert('The Database Connection Successful')</script>";
    } else {
        mysqli_close($conn);
        die("Connection Failed" . mysqli_connect_error());
    }

    // Session for login and logout
    $username_profile = $_SESSION['email'];
    if ($username_profile == true) {
        # code...
    }
    else
    {
        header('location:login.php');
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['delete_id'];
        $delete_query = "DELETE FROM signup WHERE id=$id";
        $delete_query_login = "DELETE FROM user WHERE id=$id";
        $result = mysqli_query($conn, $delete_query);
        $result_login = mysqli_query($conn, $delete_query_login);
        if ($result && $result_login) {
            echo "Delete successful";
        } else {
            echo "Delete failed";
        }
    }

    $sql = "SELECT * FROM signup";
    $res = mysqli_query($conn, $sql);
    echo "<br><br><table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Photo</th>";
    echo "<th>Name</th>";
    echo "<th>Gender</th>";
    echo "<th>Dob</th>";
    echo "<th>Mobile</th>";
    echo "<th>Email</th>";
    echo "<th>Address</th>";
    echo "<th>Operation</th>";
    echo "</tr>";

    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><img src='" . $row['photo'] . "' height='100px' width='100px'></td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['dob'] . "</td>";
        echo "<td>" . $row['mobile'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['address'] . "</td>";
        echo '<td><form method="post">
        <input type="hidden" name="delete_id" value="' . $row["id"] . '">
        <button type="submit" name="delete">DELETE</button>
        </form></td>';
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>

</html>