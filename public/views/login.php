<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css">
    <link rel="stylesheet" href="/public/css/register.css" type="text/css">

    <script type="text/javascript">
        const email_incorrect = '<?php /** @var string $emailIncorrect */ echo $emailIncorrect; ?>';
        const password_incorrect = '<?php /** @var string $passwordIncorrect */ echo $passwordIncorrect; ?>';
    </script>
    <script type="module" src="/public/js/login.js" defer></script>
</head>

<body>
<?php include 'header.php'; ?>

<main class="content">

    <div class="register-container">
        <form class="register" action="/login" method="POST">
            <div class="inputs">
                <div id="email-message" class="error-message">
                    <h3>No such email</h3>
                </div>
                <div id="password-message" class="error-message">
                    <h3>Wrong password</h3>
                </div>
                <label>
                    <span>Email</span>
                    <input name="email" type="email" placeholder="email@email.com" required>
                </label>
                <label id="l-pass">
                    <span>Password</span>
                    <input id="pass" name="password" type="password" placeholder="password"required>
                </label>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>

</main>
</body>

</html>
