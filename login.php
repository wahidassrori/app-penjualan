<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/custom.css">
    <title>Login</title>
</head>

<body>
    <div class="container-login">
        <form id="login-form">
            <h1>Dashboard</h1>
            <div class="pesan pesan-login"></div>
            <label class="label-ve">Username</label>
            <input class="input-small" type="text" name="username" id="username" required>
            <label class="label-ve">Password</label>
            <input class="input-small" type="password" name="password" id="password" required autocomplete="off">
            <button class="button-login button-small button-green" type="submit">Login</button>
        </form>
    </div>
    <script src="assets/js/script.js"></script>
</body>

</html>