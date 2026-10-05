<!DOCTYPE html>
<html>
<head>
    <title>
        <?= isset($user) ? 'Edit User' : 'Add User' ?>
    </title>
</head>

<body>

<nav>
    <a href="<?= base_url('/') ?>">Home</a> |
    <a href="<?= base_url('about') ?>">About</a> |
    <a href="<?= base_url('customers') ?>">Customer Accounts</a> |
    <a href="<?= base_url('users') ?>">User Accounts</a>
    <a href="<?= base_url('logout') ?>">Logout</a>
</nav>

<hr>

<h1>
    <?= isset($user) ? 'Edit User Account' : 'Add New User' ?>
</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (isset($user)): ?>

    <form
        action="<?= base_url('users/update/' . $user['id']) ?>"
        method="post"
        enctype="multipart/form-data"
    >

<?php else: ?>

    <form
        action="<?= base_url('users/create') ?>"
        method="post"
        enctype="multipart/form-data"
    >

<?php endif; ?>

    <?= csrf_field() ?>

    <label for="username">Username:</label><br>

    <input
        type="text"
        id="username"
        name="username"
        value="<?= old('username', $user['username'] ?? '') ?>"
    >

    <br><br>

    <label for="full_name">Full Name:</label><br>

    <input
        type="text"
        id="full_name"
        name="full_name"
        value="<?= old('full_name', $user['full_name'] ?? '') ?>"
    >

    <br><br>

    <label for="role">Role:</label><br>

    <input
        type="text"
        id="role"
        name="role"
        value="<?= old('role', $user['role'] ?? '') ?>"
    >

    <br><br>

    <label for="avatar">Profile Picture:</label><br>

    <input
        type="file"
        id="avatar"
        name="avatar"
        accept=".jpg,.jpeg,.png"
    >

    <br>

    <small>
        JPG or PNG only. Maximum size: 2MB.
    </small>

    <br><br>

    <?php if (isset($user) && ! empty($user['avatar'])): ?>

        <p>Current Avatar:</p>

        <img
            src="<?= base_url('uploads/' . $user['avatar']) ?>"
            width="150"
            height="150"
            alt="Current Avatar"
        >

        <br><br>

    <?php endif; ?>

    <button type="submit">
        <?= isset($user) ? 'Update User' : 'Add User' ?>
    </button>

</form>

<br>

<a href="<?= base_url('users') ?>">Back to Users</a>

</body>
</html>