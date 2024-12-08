<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="outer">
        <h2>Login </h2>
        <form action="backend/login.php" method="POST">
           
            <p>Email</p>
            <input class="in" type="email" name="email" required />
            <p>Password</p>
            <div class="password-container">
                <input class="in" type="password" name="password" id="password" required />
                <i class="eye-icon fas fa-eye" id="toggle-password"></i>
            </div>
            
            <br><br>
            <input type="submit" value="Login" class="submit-btn"/>
        </form>
    </div>
</body>
<script src="assets/main.js"></script>
<body>
</html>