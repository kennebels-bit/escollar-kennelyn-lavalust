<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Product Management</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f1f5f9;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 400px;
            background: white;

            padding: 35px;

            border-radius: 15px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.10);
        }

        h1 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;

            font-weight: bold;
            color: #334155;
        }

        input {
            width: 100%;

            padding: 12px;

            margin-bottom: 18px;

            border: 1px solid #cbd5e1;
            border-radius: 8px;

            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        button {
            width: 100%;

            padding: 12px;

            background: #2563eb;
            color: white;

            border: none;
            border-radius: 8px;

            font-size: 16px;

            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;

            padding: 10px;

            border-radius: 8px;

            margin-bottom: 18px;

            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <h1>Welcome Back</h1>

        <p class="subtitle">
            Login to Product Management
        </p>

        <?php if (isset($error)): ?>

            <div class="error">
                <?= html_escape($error); ?>
            </div>

        <?php endif; ?>

        <form action="<?= site_url('login'); ?>" method="POST">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Enter username"
                required>

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                required>

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</body>

</html>