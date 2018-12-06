<!doctype html>
    <html>
    <head>
        <title>User Registration Page</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>
    <body>
        <?php include('extra/header.php')?>
        <div id="login">
            <div id="center">
                <div class="title">
                    <h3>Welcome to Matcha!</h3>
                </div>
                <form method="post" id="form" action="register.php">
                    <?php include('errors.php');?>
                    <label>Username</label>
                    <input type="text" name="username">
                    <label>Email</label>
                    <input type="text" name="email">
                    <label>Password</label>
                    <input type="password" name="password">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm">
                    <button type="submit" name="register">Register</button>
                </form>
                <p>Have an account? <a href="login.php">Log in</a></p>
            