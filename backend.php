<?php
    session_start();
    $conn = mysqli_connect("localhost","root","","php");

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
            $_SESSION["hobbies"] = array(); // Initialize an empty array
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

        $ext=array('image/jpeg', 'image/jpg');  
        
        $typeErr = false;
        $sizeErr = false;

        if($_SESSION["name"]=="")
        {
            $_SESSION["nameErr"] = "Name should be required.";
        }
        else if(preg_match($nameRegex, $_SESSION["name"]))
        {
            $_SESSION["nameErr"] = "";
        }
        else
        {
            $_SESSION["nameErr"] = "Enter valid Name.";
        }

        if($_SESSION["email"]=="")
        {
            $_SESSION["emailErr"] = "Email should be required.";
        }
        else if(preg_match($emailRegex, $_SESSION["email"]))
        {
            $_SESSION["emailErr"] = "";
        }
        else
        {
            $_SESSION["emailErr"] = "Enter valid Email.";
        }


        if($_SESSION["password"]=="")
        {
            $_SESSION["passErr"] = "Password should be required." ;
        }
        else if(preg_match($passRegex, $_SESSION["password"]))
        {
            $_SESSION["passErr"] = "";
        }
        else
        {
            $_SESSION["passErr"] = "Enter valid Password.";

        }


        if($_SESSION["cpassword"]=="")
        {
            $_SESSION["cpassErr"] = "Conform Password should be required." ;
        }
        else if($_SESSION["password"]==$_SESSION["cpassword"])
        {
            $_SESSION["cpassErr"] = "" ;
        }
        else
        {
            $_SESSION["cpassErr"] = "Password not matched." ;
        }

        if($_SESSION["gender"]=="")
        {
            $_SESSION["genderErr"] = "Gender should be required." ;
        }
        else
        {
            $_SESSION["genderErr"] = "" ;
        }

        if($hobbieLen==0)
        {
            $_SESSION["hobbiesErr"] = "Hobbie should be required." ;
        }
        else
        {
            $_SESSION["hobbiesErr"] = "" ;
        }

        if($_SESSION["city"]=="")
        {
            $_SESSION["cityErr"] = "City should be required." ;
        }
        else
        {
            $_SESSION["cityErr"] = "" ;
        }

        if($_SESSION["pname"]=="")
        {
            $_SESSION["photoErr"] = "Photo should be required." ;
        }
        else if(!in_array($_SESSION['type'],$ext))
        {
            $_SESSION['photoErr'] = "Image should be jpeg, jpg";
            $typeErr = true;
        }
        else if($_SESSION["size"] > 1000000)
        {
            $_SESSION['photoErr'] = "Image size should be less than 1 mb";
            $sizeErr = true;
        }
        else
        {
            $_SESSION["photoErr"] = "" ;
            $typeErr = false;
            $sizeErr = false;
        }

        echo "Hobbie:".$_SESSION["hobbiesErr"]."<br>";
        echo "Pname:".$_SESSION["photoErr"]."<br>";
        echo "tloc:".$_SESSION["tloc"]."<br>";
        echo "size:".$_SESSION["size"]."<br>";
        echo "type:".$_SESSION["type"]."<br>";

        if(($_SESSION["name"]!= "" && $_SESSION["email"]!= "" && $_SESSION["password"]!= "" && $_SESSION["cpassword"]!= "" && $_SESSION["gender"]!= "" && $_SESSION["pname"]!= "" && $_SESSION["city"]!= "") && count($_SESSION["hobbies"])!=0 && ($typeErr==false && $sizeErr==false))
        {
            if($_SESSION["nameErr"]=="" && $_SESSION["emailErr"]=="" && $_SESSION["passErr"]=="" && $_SESSION["cpassErr"] == "" && $_SESSION["genderErr"] == "" &&  $_SESSION["hobbiesErr"] == "" && $_SESSION["cityErr"] == "" && $_SESSION["photoErr"]=="")
            {
                $name = $_SESSION["name"];
                $email = $_SESSION["email"];
                $password = $_SESSION["password"];
                $cpassword = $_SESSION["cpassword"];

                $gender = $_SESSION["gender"];
                $city = $_SESSION["city"];
                $pname = $_SESSION["pname"];
                $tloc = $_SESSION["tloc"];
                
                $i=1;

                if(file_exists("Images/".$pname))
                {
                    $temp = explode(".", $pname);
                    $end = ".".end($temp);
                    $nam = rtrim($pname, $end);
                    $tempName = $nam.$i.$end;
                    while(file_exists("Images/".$tempName))
                    {
                        $i++;
                        $tempName = $nam.$i.$end;
                    }
                    $pname = $tempName;
                }

                $query = "Insert into validform values (DEFAULT, '$name', '$email', '$password', '$cpassword', '$gender', '$hobbies', '$city', '$pname')";

                if (mysqli_query($conn, $query))
                {
                    if (move_uploaded_file($tloc,"Images/".$pname))
                    {
                        $_SESSION['result'] = "Form Successfully Submitted";
                        $_SESSION["showing"] = $pname;

                        header("Location: preview.php");
                        exit();
                    }
                    else
                    {
                        echo "Nooo";
                    }
                }
                header("Location: PHPForm.php");
                exit();
            }
            else
            {
                header("Location: PHPForm.php");
                exit();
            }
        }
        else
        {
            header("Location: PHPForm.php");
            exit();
        }

       
    }
?>

