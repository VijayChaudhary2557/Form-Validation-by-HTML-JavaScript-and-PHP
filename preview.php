<?php
    session_start();
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
        .img {
            width: 125px;
            border: 2px solid black;
            padding: 4px;
        }
    </style>
</head>
<body>
    <h1 align="center" class="Result"><u><?php if(isset($_SESSION['result'])) {echo $_SESSION['result'];} ?></u></h1>
    <div class="container mt-5 d-flex justify-content-center" >
        <table class="table table-bordered" border="2px" style="width:550px" cell-padding>
            <tr>
                <td>User Name</td>
                <td><?php echo $_SESSION['name']; ?></td>
                <td class="text-center" rowspan="4"><img src="Images/<?php echo $_SESSION['showing'] ?>" class='img'></td>
            </tr>
            <tr>
                <td>Email Id</td>
                <td><?php echo $_SESSION['email']; ?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><?php echo $_SESSION['password']; ?></td>
            </tr>
            <tr>
                <td>Conform Password</td>
                <td><?php echo $_SESSION['cpassword']; ?></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td colspan="2"><?php echo $_SESSION['gender']; ?></td>
            </tr>
            <tr>
                <td>Hobbies</td>
                <td colspan="2">
                    <?php
                        foreach($_SESSION['hobbies'] as $value)
                        {
                            echo "$value ";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>City</td>
                <td colspan="2"><?php echo $_SESSION['city']; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
