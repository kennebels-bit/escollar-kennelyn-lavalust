<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User List</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fb;
            color: #333;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 25px 30px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .activity-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 20px 25px 0;
        }

        .activity-nav a {
            padding: 8px 12px;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            color: #2563eb;
            font-size: 12px;
            text-decoration: none;
        }

        .activity-nav a:hover,
        .activity-nav .active {
            background: #2563eb;
            color: white;
        }

        .table-container {
            padding: 25px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f1f5f9;
        }

        th {
            text-align: left;
            padding: 15px;
            font-size: 14px;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        tbody tr {
            transition: 0.2s;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .id {
            font-weight: bold;
            color: #2563eb;
        }

        .username {
            font-weight: 600;
            color: #334155;
        }

        .email {
            color: #64748b;
        }

        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .header h1 {
                font-size: 23px;
            }

            th,
            td {
                padding: 12px;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <nav class="activity-nav" aria-label="Activity navigation">
        <a href="<?= site_url(); ?>">← Activities</a>
        <a href="<?= site_url('student'); ?>">Student</a>
        <a href="<?= site_url('users'); ?>" class="active">Users</a>
        <a href="<?= site_url('login'); ?>">Products</a>
    </nav>

    <div class="header">
        <h1>User List</h1>
        <p>Registered users in the system</p>
    </div>

    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($users as $user): ?>

                    <tr>
                        <td class="id">
                            <?= html_escape($user['id']); ?>
                        </td>

                        <td>
                            <?= html_escape($user['firstname']); ?>
                        </td>

                        <td>
                            <?= html_escape($user['lastname']); ?>
                        </td>

                        <td class="email">
                            <?= html_escape($user['email']); ?>
                        </td>

                        <td class="username">
                            <?= html_escape($user['username']); ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>