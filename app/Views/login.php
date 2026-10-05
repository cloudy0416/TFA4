<!DOCTYPE html>
<html>
<head>
    <title>Login - POS System</title>
</head>

<body>

<h1>POS System Login</h1>

<?php if (session()->getFlashdata('error')): ?>

    <p>
        <?= esc(session()->getFlashdata('error')) ?>
    </p>

<?php endif; ?>

<form action="<?= base_url('login/authenticate') ?>" method="post">

    <?= csrf_field() ?>

    <label for="username">
        Username:
    </label>

    <br>

    <input
        type="text"
        id="username"
        name="username"
        value="<?= old('username') ?>"
        required
    >

    <br><br>

    <label for="password">
        Password:
    </label>

    <br>

    <input
        type="password"
        id="password"
        name="password"
        required
    >

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

</body>
</html>