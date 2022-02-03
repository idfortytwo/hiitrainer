<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css">
    <link rel="stylesheet" href="/public/css/register.css" type="text/css">

    <script type="text/javascript">
        const user_exists = '<?php /** @var string $userExists */ echo $userExists; ?>';
    </script>
    <script type="module" src="/public/js/register.js" defer></script>
</head>

<body>
<?php include 'header.php'; ?>

<main class="content">

    <div class="register-container">
        <form class="register" action="/register" method="POST">
            <div class="inputs">
                <div class="error-message">
                    <h3>Email already used</h3>
                </div>
                <label>
                    <span>Email</span>
                    <input name="email" type="email" placeholder="email@email.com" required>
                </label>
                <label id="l-pass">
                    <span>Password</span>
                    <input id="pass" name="password" type="password" placeholder="password" required>
                </label>
                <label id="l-pass-conf">
                    <span>Confirm password</span>
                    <input id="pass-conf" name="confirmedPassword" type="password" placeholder="password" required>
                </label>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>

</main>
</body>

</html>
