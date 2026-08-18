<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile - Kennelyn Escollar</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #1a1a2e;
            color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            color: #ff6b35;
        }
        nav a {
            color: #ff6b35;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }
        .card {
            background: #16213e;
            padding: 40px;
            border-radius: 12px;
            text-align: left;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
            min-width: 300px;
        }
        .card p {
            margin: 8px 0;
        }
        .card strong {
            color: #ff6b35;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Student Information</h1>
        <p><strong>Student ID:</strong> <?= $student_id ?></p>
        <p><strong>Name:</strong> <?= $name ?></p>
        <p><strong>Course:</strong> <?= $course ?></p>
        <p><strong>Year Level:</strong> <?= $year ?></p>
        <p><strong>Section:</strong> <?= $section ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
        <nav>
            <a href="<?= site_url('student') ?>">Home</a> |
            <a href="<?= site_url('student/profile') ?>">Student Profile</a>
        </nav>
    </div>
</body>
</html>