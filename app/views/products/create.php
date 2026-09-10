<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            color: #1e293b;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
            font-weight: bold;
            color: #334155;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        button {
            margin-top: 25px;
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back {
            display: inline-block;
            margin-left: 10px;
            color: #475569;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Add Product</h1>

    <form action="<?= site_url('products/store'); ?>" method="POST">

        <label>Product Name</label>
        <input
            type="text"
            name="product_name"
            required
        >

        <label>Description</label>
        <textarea
            name="description"
            required
        ></textarea>

        <label>Price</label>
        <input
            type="number"
            name="price"
            step="0.01"
            min="0"
            required
        >

        <label>Quantity</label>
        <input
            type="number"
            name="quantity"
            min="0"
            required
        >

        <button type="submit">
            Save Product
        </button>

        <a href="<?= site_url('products'); ?>" class="back">
            Cancel
        </a>

    </form>

</div>

</body>
</html>