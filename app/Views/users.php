<!DOCTYPE html>
<html>
<head>
    <title>User Accounts</title>
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

<h1>User Accounts</h1>

<a href="<?= base_url('users/new') ?>">Add New User</a>

<br><br>

<table border="1" cellpadding="10">

    <thead>

        <tr>
            <th>Avatar</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Action</th>
        </tr>

    </thead>

    <tbody>

        <?php foreach ($users as $user): ?>

            <tr>

                <td>

                    <?php if (! empty($user['avatar'])): ?>

                        <img
                            src="<?= base_url('uploads/' . $user['avatar']) ?>"
                            width="100"
                            height="100"
                            alt="User Avatar"
                        >

                    <?php else: ?>

                        <img
                            src="<?= base_url('uploads/placeholder.png') ?>"
                            width="100"
                            height="100"
                            alt="Placeholder Avatar"
                        >

                    <?php endif; ?>

                </td>

                <td>
                    <?= esc($user['username']) ?>
                </td>

                <td>
                    <?= esc($user['full_name']) ?>
                </td>

                <td>
                    <?= esc($user['role']) ?>
                </td>

                <td>
                    <a href="<?= base_url('users/edit/' . $user['id']) ?>">
                        Edit
                    </a>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>

</body>
</html>