<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Management</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f1f5f9;
        }

        .container {
            width: 90%;
            max-width: 1100px;

            margin: 50px auto;

            background: white;

            padding: 30px;

            border-radius: 15px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 25px;
        }

        h1 {
            margin: 0;

            color: #2563eb;
        }

        .subtitle {
            color: #64748b;
            margin-top: 5px;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .add-btn,
        .logout-btn {
            padding: 10px 18px;

            color: white;

            text-decoration: none;

            border-radius: 8px;

            font-size: 14px;
        }

        .add-btn {
            background: #2563eb;
        }

        .add-btn:hover {
            background: #1d4ed8;
        }

        .logout-btn {
            background: #dc2626;
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        th {
            background: #2563eb;

            color: white;

            padding: 13px;

            text-align: left;
        }

        td {
            padding: 13px;

            border-bottom: 1px solid #e2e8f0;
        }

        tr:hover {
            background: #f8fafc;
        }

        .edit {
            color: #2563eb;

            text-decoration: none;

            margin-right: 10px;
        }

        .delete {
            color: #dc2626;

            text-decoration: none;
        }

        .edit:hover,
        .delete:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <div>
            <h1>Product Management</h1>

            <div class="subtitle">
                Manage your products
            </div>
        </div>

        <div class="buttons">

            <a
                href="<?= site_url('products/create'); ?>"
                class="add-btn">
                + Add Product
            </a>

            <a
                href="<?= site_url('logout'); ?>"
                class="logout-btn">
                Logout
            </a>

        </div>

    </div>

    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Action</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($products as $product): ?>

                <tr>

                    <td>
                        <?= html_escape($product['id']); ?>
                    </td>

                    <td>
                        <?= html_escape($product['product_name']); ?>
                    </td>

                    <td>
                        <?= html_escape($product['description']); ?>
                    </td>

                    <td>
                        ₱<?= number_format($product['price'], 2); ?>
                    </td>

                    <td>
                        <?= html_escape($product['quantity']); ?>
                    </td>

                    <td>
                        <?= html_escape($product['created_at']); ?>
                    </td>

                    <td>

                        <a
                            href="<?= site_url('products/edit/' . $product['id']); ?>"
                            class="edit">
                            Edit
                        </a>

                        <a
                            href="<?= site_url('products/delete/' . $product['id']); ?>"
                            class="delete"
                            onclick="return confirm('Are you sure you want to delete this product?');">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>

</html>