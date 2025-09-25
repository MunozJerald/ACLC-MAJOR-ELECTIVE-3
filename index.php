<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <?php
        include "database.php";

        $message = "";

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if(!empty($email) && !empty($password)){
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO user_tbl (email, password) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $email, $hashedPassword);

                if($stmt->execute()){

                    $message = "<div class='alert alert-success text-center'>Sign Up successful!</div>";
                }
                else{
                    $message = "<div class='alert alert-danger text-center'>Error: ". $conn->error ."</div>";
                }
            }
            else{
                $message = "<div class='alert alert-danger text-center'>Please fill in all the fields</div>";
            }
        }
    ?>

    <div class="card shadow p-4">
        <h3 class="text-center mb-4">Sign Up</h3>
        <?php if($message) {echo $message; }?>
        <form method="POST">
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label">Show password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100" >Sign Up</button>
        </form>
    </div>
</body>
</html>