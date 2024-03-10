<!DOCTYPE html>
<html lange="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="regislog.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.cdnfonts.com/css/8bit-wonder" rel="stylesheet">
</head>
<body>

        <?php
            if(isset($_POST["register"])){
                $email = $_POST["email"];
                $firstname = $_POST["firstname"];
                $lastname =$_POST["lastname"];
                $password = $_POST["password"];
                $repeat_password = $_POST["repeat_password"];
                $contact = $_POST["contact"];
                $country = $_POST["country"];
                $province = $_POST["province"];
                $state = $_POST["state"];
                $citymuni =$_POST["city/municipality"];
                $barangay = $_POST["barangay"];
                $lotblk = $_POST["lot/blk"];
                $street = $_POST["street"];
                $subdivision = $_POST["subdivision"];
            
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $errors = array();
                if (empty($email) OR empty($firstname) OR empty($lastname) OR empty($password) OR empty($repeat_password) OR empty($country) OR empty($province) OR empty($state) OR empty($citymuni) OR empty($barangay) OR empty($lotblk) OR empty($street)) {
                    array_push($errors, "All fields are required");
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }

                if(strlen($password)<8) {
                    array_push($errors, "Password must be at least 8 characters long");
                }

                if ($password!= $repeat_password) {
                    array_push($errors, "Password does not match");
                }
                require_once "regisdatabase.php";
                $sql = "SELECT * FROM registration WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if ($rowCount>0) {
                    array_push($errors, "Email Already Exist!");
                }
                if (count($errors)>0) {
                    foreach($errors as $error) {
                        echo "<div class='alert alert-danger'> $error </div>";
                        }
                    } else {
                        $sql = "INSERT INTO registration (firstname, lastname, password, contact, country, province, state, city_municipality, barangay,
                        lot_blk, street, subdivision,  password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,)";
                        $stmt = mysqli_stmt_init($conn);
                        $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                        if ($preparestmt) {
                            mysqli_stmt_bind_param($stmt, "sssssssssssssss", $email,
                            $firstname,
                            $lastname,
                            $password,
                            $contact,
                            $country,
                            $province,
                            $state,
                            $citymuni,
                            $barangay,
                            $lotblk,
                            $street,
                            $subdivision,
                            $passwordHash);
                            mysqli_stmt_execute($stmt);
                            echo "<div class='alert alert-success'>You are Registered Successfully!</div>";
                        } else {
                            die("Something went wrong");
                        }
                    }
                }
            ?>

        <div class="container" id="container-registration">
        <div class="glyph">Registration</div>
        <form class="row g-3">
            <div class="col-md-6">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" name="firstname">
            </div>
            <div class="col-md-6">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" name="lastname">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
            </div>
            <div class="col-md-6">
                <label for="contact" class="form-label">Contact #</label>
                <input type="text" class="form-control" name="contact">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="col-md-6">
                <label for="repeat_password" class="form-label">Repeat Password</label>
                <input type="password" class="form-control" name="repeat_password">
            </div>
            &emsp;&emsp;&emsp;&emsp;&nbsp;
            <h2>-------------------ADDRESS-------------------</h2>
            <div class="col-12">
                <label for="country" class="form-label">Country</label>
                <select name="country" class="form-select">
                <option selected>Choose...</option>
                <option>...</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="province" class="form-label">Province</label>
                <select name="province" class="form-select">
                <option selected>Choose...</option>
                <option>...</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="city_municipality" class="form-label">City/Municipality</label>
                <select name="city_municipality" class="form-select">
                <option selected>Choose...</option>
                <option>...</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="barangay" class="form-label">Barangay</label>
                <select name="barangay" class="form-select">
                <option selected>Choose...</option>
                <option>...</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="lot_blk" class="form-label">Lot/Blk</label>
                <input type="text" class="form-control" name="lot_blk">
            </div>
            <div class="col-md-4">
                <label for="street" class="form-label">Street</label>
                <input type="text" class="form-control" name="street">
            </div>
            <div class="col-md-4">
                <label for="subdivision" class="form-label">Subdivision</label>
                <input type="text" class="form-control" name="subdivision">
            </div>
            <div class="to-register">
                <p>Already have an account? <a id="login-link" href="index.php">Login</a></p>
            </div>
            <div class="form-btn">
                <input type="submit" id="register" name="register" value="Register" style="    
                font-family: 'Rubik Mono One', monospace;
                border-radius: 100px;
                border: none;
                background: linear-gradient(silver, black, red);
                color: white;
                cursor: pointer;
                height: 40px;
                width: 230px; 
                ">
            </div>
</form>

    </div>
</body>
</html>