<?php
    session_start();

    function checking($hobby)
    {
        if(in_array($hobby, $_SESSION["hobbies"]))
            return "checked";
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .err {
            color: #dc3545;
            font-size: 14px;
        }

        .container {
            border: 3px solid black;
        }
        .smt input {
            background-color: #be0027;
            width: 150px;
            border: 3px solid #d20962;
            border-radius: 10px;
        }
        .container {
            width: 800px;
            margin: 20px auto;
            padding: 10px;
            border-radius: 20px;
            border:5px solid #00205b;
            /* background-color: white; */
        }
        body {
            background-color: #f3f4f7;
        }

        .photoShow img {
            width: 150px;
            margin: 20px;
            border: 3px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 align="center"><u>Form Validation</u></h2>

        <form action="backend.php" method="post" id="myForm" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name: </label>
                <input type="text" name="name" class="form-control <?php echo isset($_SESSION["nameErr"]) && $_SESSION["nameErr"]=="" ? "is-valid" : '';?>" id="name" placeholder="Enter Name..." onchange="validation(this)" value="<?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : ''; ?>" required>
                <div class="err invalid-feedback"> <?php echo isset($_SESSION["nameErr"]) ? $_SESSION["nameErr"] : "" ?> </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email: </label>
                <input type="email" name="email" class="form-control <?php echo isset($_SESSION["emailErr"]) && $_SESSION["emailErr"]=="" ? "is-valid" : '';?>" id="email" placeholder="Enter Email..." onchange="validation(this)" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : ''; ?>" required>
                <div class="err "> <?php echo isset($_SESSION["emailErr"]) ? $_SESSION["emailErr"] : "" ?> </div>

            </div>
            <div class="mb-3 mt-3">
                <label for="password" class="form-label">Password: </label>
                <input type="password" name="password" class="form-control <?php echo isset($_SESSION["passErr"]) && $_SESSION["passErr"]=="" ? "is-valid" : '';?>" id="password" placeholder="Enter Password..." onchange="validation(this)" value="<?php echo isset($_SESSION["password"]) ? $_SESSION["password"] : ''; ?>" required>
                <div class="err"> <?php echo isset($_SESSION["passErr"]) ? $_SESSION["passErr"] : "" ?> </div>
                
            </div>
            <div class="mb-3 mt-3">
                <label for="cpassword" class="form-label">Confirm Password: </label>
                <input type="password" name="cpassword" class="form-control <?php echo isset($_SESSION["cpassErr"]) && $_SESSION["cpassErr"]=="" ? "is-valid" : '';?>" id="cpassword" placeholder="Re Enter Password..." onchange="validation(this)" value="<?php echo isset($_SESSION["cpassword"]) ? $_SESSION["cpassword"] : ''; ?>" required>
                <div class="err invalid-feedback"><?php echo isset($_SESSION["cpassErr"]) ? $_SESSION["cpassErr"] : "" ?></div>
            </div>
            <div class="mb-3 mt-3">
                <label for="gender" class="form-label">Gender: </label>
                <div class="form-controler">
                    <input type="radio" name="gender" class="gender" value="Male" <?php echo (isset($_SESSION["gender"]) && $_SESSION["gender"] == 'Male') ? 'checked' : ''; ?> required>
                    <label class="form-label">Male</label>
                    <input type="radio" name="gender" class="gender" value="Female" <?php echo (isset($_SESSION["gender"]) && $_SESSION["gender"] == 'Female') ? 'checked' : ''; ?> required>
                    <label class="form-label">Female</label>
                    <input type="radio" name="gender" class="gender" value="Other" <?php echo (isset($_SESSION["gender"]) && $_SESSION["gender"] == 'Other') ? 'checked' : ''; ?> required>
                    <label class="form-label">Other</label>
                </div>
                <div class="err invalid-feedback"><?php echo isset($_SESSION["genderErr"]) ? $_SESSION["genderErr"] : "" ?></div>
            </div>
            <div class="mb-3 mt-3">
                <label for="hobbie" class="form-label">Hobbies: </label>
                <div class="form-controler">
                    <input name="hobbie[]" type="checkbox" class="hobbie" value="PUBG" <?php if(isset($_SESSION["hobbies"])) { echo checking("PUBG");} ?>>
                    <label class="form-label">PUBG</label>
                    <input name="hobbie[]" type="checkbox" class="hobbie" value="BGMI" <?php if(isset($_SESSION["hobbies"])) { echo checking("BGMI");} ?>>
                    <label class="form-label">BGMI</label>
                    <input name="hobbie[]" type="checkbox" class="hobbie" value="Free-Fire" <?php if(isset($_SESSION["hobbies"])) { echo checking("Free-Fire");} ?>>
                    <label class="form-label">Free-Fire</label>
                </div>
                <div class="err"><?php echo isset($_SESSION["hobbiesErr"]) ? $_SESSION["hobbiesErr"] : "" ?></div>
            </div>

            <div class="mb-3 mt-3">
                <label for="city" class="form-label">City: </label>
                <select class="form-select <?php echo isset($_SESSION["cityErr"]) && $_SESSION["cityErr"]=="" ? "is-valid" : '';?>" name="city" id="city" onchange="validation(this)" aria-describedby="validationServer04Feedback" required>
                    <option selected disabled value="">Select City</option>
                    <option value="Agra" <?php echo (isset($_SESSION["city"]) && $_SESSION["city"] == 'Agra') ? 'selected' : ''; ?>>Agra</option>
                    <option value="Mathura" <?php echo (isset($_SESSION["city"]) && $_SESSION["city"] == 'Mathura') ? 'selected' : ''; ?>>Mathura</option>
                    <option value="Hathras" <?php echo (isset($_SESSION["city"]) && $_SESSION["city"] == 'Hathras') ? 'selected' : ''; ?>>Hathras</option>
                </select>
                
                <div class="err"><?php echo isset($_SESSION["cityErr"]) ? $_SESSION["cityErr"] : "" ?></div>
            </div>

            <div class="mb-3 mt-3">
                <label for="photo" class="form-label">Photo: </label>
                <input type="file" class="form-control" name="photo" id="photo" accept="image/*" onchange="myFun(this);">
                <div class="err"><?php echo isset($_SESSION["photoErr"]) ? $_SESSION["photoErr"] : "" ?></div>
            </div>
            <div class="smt" align="center">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit">
            </div>
        </form>
    </div>

<script>

</script>

</body>
</html>
<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        let citySelect = document.getElementById('city');
        if (citySelect.value === '') {
            event.preventDefault();
        } 
    });
    let password;

    function validation(ele)
    {
        let name = ele.name;
        let value = ele.value;
        let err = ele.parentElement.lastElementChild;

        if (name == "name")
        {
            let nameRegex = /^[a-zA-Z]+(?:\s+[a-zA-Z]+)*$/;
            if(nameRegex.test(value))
            {
                err.innerText = "";
                ele.classList.remove('is-invalid');
                ele.classList.add('is-valid');
            }
            else
            {
                err.innerText = "Enter Valid Name";
                ele.classList.add('is-invalid');
                ele.classList.remove('is-valid');
            }
        }
        else if (name == "email")
        {
            let emailRegex = /^[a-zA-Z0-9]*[a-zA-Z]+[0-9]*@gmail\.com$/;
            if(emailRegex.test(value))
            {
                err.innerText = "";
                ele.classList.remove('is-invalid');
                ele.classList.add('is-valid');
            }
            else
            {
                err.innerText = "Enter Valid Email";
                ele.classList.remove('is-valid');
                ele.classList.add('is-invalid');
            }
        }
        else if (name == "password")
        {
            let passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
            let cpassword = document.querySelector('#cpassword');
            password = value;
            if(cpassword.value == "")
            {
                password = value;
            }
            else
            {
                password = value;
                if(cpassword.value == value)
                {
                    cpassword.parentNode.lastElementChild.innerHTML = "";
                    cpassword.classList.remove('is-invalid');
                    cpassword.classList.add('is-valid');
                }
                else
                {
                    cpassword.parentNode.lastElementChild.innerHTML = "Password not matched";
                    cpassword.classList.remove('is-valid');
                    cpassword.classList.add('is-invalid');
                }
            }
            if(passRegex.test(value))
            {
                err.innerText = "";
                ele.classList.remove('is-invalid');
                ele.classList.add('is-valid');
            }
            else
            {
                err.innerText = "Enter valide Password";
                ele.classList.remove('is-valid');
                ele.classList.add('is-invalid');
            }
        }
        else if (name == "cpassword")
        {
            password = document.querySelector("#password").value;

            if(value == password)
            {
                err.innerHTML = "";
                ele.classList.add('is-valid');
                ele.classList.remove('is-invalid');
            }
            else
            {
                err.innerHTML = "Password not matched";
                ele.classList.remove('is-valid');
                ele.classList.add('is-invalid');
            }
        }
        else if (name == "city")
        {
            if(ele.value=="")
            {
                ele.classList.remove('is-valid');
                ele.classList.add('is-invalid');
            }
            else
            {
                ele.classList.add('is-valid');
                ele.classList.remove('is-invalid');
            }
        }
    }

    console.log(password);


</script>

