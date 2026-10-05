<!DOCTYPE html>
<html>
<head>
    <title>
        <?= isset($customer) ? 'Edit Customer' : 'Add Customer' ?>
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

<?php if (isset($customer)): ?>

    <h1>Edit Customer</h1>

    <form action="<?= base_url('customers/update/' . $customer['id']) ?>" method="post">

<?php else: ?>

    <h1>Add New Customer</h1>

    <form action="<?= base_url('customers/create') ?>" method="post">

<?php endif; ?>

    <?= csrf_field() ?>

    <?php if (session()->getFlashdata('errors')): ?>

        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

    <label>Full Name:</label><br>

    <input
        type="text"
        name="full_name"
        value="<?= old('full_name', $customer['full_name'] ?? '') ?>"
    >

    <br><br>

    <label>Email:</label><br>

    <input
        type="email"
        name="email"
        value="<?= old('email', $customer['email'] ?? '') ?>"
    >

    <br><br>

    <label>Phone:</label><br>

    <input
        type="text"
        name="phone"
        value="<?= old('phone', $customer['phone'] ?? '') ?>"
    >

    <br><br>

    <button type="submit">
        <?= isset($customer) ? 'Update Customer' : 'Add Customer' ?>
    </button>

</form>

<br>

<a href="<?= base_url('customers') ?>">
    Back to Customer Accounts
</a>

</body>
</html>