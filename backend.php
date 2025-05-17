<?php
session_start();
$conn = mysqli_connect("sql12.freesqldatabase.com","sql12779399","kA4qNbKN3B","sql12779399");

if (isset($_POST["submit"])) {
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $_POST["password"];
    $_SESSION["cpassword"] = $_POST["cpassword"];
    $_SESSION["gender"] = $_POST["gender"];

    if (isset($_POST["hobbie"])) {
        $_SESSION["hobbies"] = $_POST["hobbie"];
        $hobbieLen = count($_SESSION["hobbies"]);
    } else {
        $_SESSION["hobbies"] = array(); 
        $hobbieLen = 0;
    }
    $hobbies = json_encode($_SESSION["hobbies"]);

    $_SESSION["city"] = $_POST["city"];

    $_SESSION["pname"] = $_FILES["photo"]["name"];
    $_SESSION["tloc"] = $_FILES['photo']['tmp_name'];
    $_SESSION["size"] = $_FILES['photo']['size'];
    $_SESSION["type"] = $_FILES['photo']['type'];

    $nameRegex = "/^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/";
    $emailRegex = "/^([\w]*[\w\.]*(?!\.)@gmail.com)/";
    $passRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";
    $ext = array('image/jpeg', 'image/jpg');

    $typeErr = false;
    $sizeErr = false;

    // Validation
    $_SESSION["nameErr"] = ($_SESSION["name"] == "") ? "Name should be required." :
                            (!preg_match($nameRegex, $_SESSION["name"]) ? "Enter valid Name." : "");

    $_SESSION["emailErr"] = ($_SESSION["email"] == "") ? "Email should be required." :
                             (!preg_match($emailRegex, $_SESSION["email"]) ? "Enter valid Email." : "");

    $_SESSION["passErr"] = ($_SESSION["password"] == "") ? "Password should be required." :
                             (!preg_match($passRegex, $_SESSION["password"]) ? "Enter valid Password." : "");

    $_SESSION["cpassErr"] = ($_SESSION["cpassword"] == "") ? "Conform Password should be required." :
                              ($_SESSION["password"] != $_SESSION["cpassword"] ? "Password not matched." : "");

    $_SESSION["genderErr"] = ($_SESSION["gender"] == "") ? "Gender should be required." : "";

    $_SESSION["hobbiesErr"] = ($hobbieLen == 0) ? "Hobbie should be required." : "";

    $_SESSION["cityErr"] = ($_SESSION["city"] == "") ? "City should be required." : "";

    if ($_SESSION["pname"] == "") {
        $_SESSION["photoErr"] = "Photo should be required.";
    } elseif (!in_array($_SESSION["type"], $ext)) {
        $_SESSION["photoErr"] = "Image should be jpeg, jpg";
        $typeErr = true;
    } elseif ($_SESSION["size"] > 1000000) {
        $_SESSION["photoErr"] = "Image size should be less than 1 mb";
        $sizeErr = true;
    } else {
        $_SESSION["photoErr"] = "";
    }

    // Final validation check
    if (
        $_SESSION["nameErr"] == "" &&
        $_SESSION["emailErr"] == "" &&
        $_SESSION["passErr"] == "" &&
        $_SESSION["cpassErr"] == "" &&
        $_SESSION["genderErr"] == "" &&
        $_SESSION["hobbiesErr"] == "" &&
        $_SESSION["cityErr"] == "" &&
        $_SESSION["photoErr"] == "" &&
        $typeErr == false &&
        $sizeErr == false
    ) {
        // All validations passed
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $password = $_SESSION["password"];
        $cpassword = $_SESSION["cpassword"];
        $gender = $_SESSION["gender"];
        $city = $_SESSION["city"];
        $pname = $_SESSION["pname"];
        $tloc = $_SESSION["tloc"];

        // Handle duplicate filenames
        $i = 1;
        if (file_exists("Images/" . $pname)) {
            $temp = explode(".", $pname);
            $end = "." . end($temp);
            $nam = rtrim($pname, $end);
            $tempName = $nam . $i . $end;
            while (file_exists("Images/" . $tempName)) {
                $i++;
                $tempName = $nam . $i . $end;
            }
            $pname = $tempName;
        }

        // Insert query
        $query = "INSERT INTO validform VALUES (DEFAULT, '$name', '$email', '$password', '$cpassword', '$gender', '$hobbies', '$city', '$pname')";
        if (mysqli_query($conn, $query)) {
            if (move_uploaded_file($tloc, "Images/" . $pname)) {
                $_SESSION['result'] = "Form Successfully Submitted";
                $_SESSION["showing"] = $pname;

                header("Location: preview.php");
                exit(); // Stop execution
            } else {
                $_SESSION["uploadErr"] = "Failed to upload file.";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION["dbErr"] = "Database error: " . mysqli_error($conn);
            header("Location: index.php");
            exit();
        }
    } else {
        // Validation failed
        header("Location: index.php");
        exit();
    }
}
?>
