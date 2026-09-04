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
       <p><strong>Address:</strong> <?= $address ?></p>
        <p><strong>Contact Number:</strong> <?= $contact ?></p>
        <p><strong>Skills:</strong> <?= $skills ?></p>
        <p><strong>Hobbies:</strong> <?= $hobbies ?></p>    
        <p><strong>About Me:</strong> <?= $description ?></p>
        <p><strong>Social Media:</strong>
        <a href="<?= $facebook ?>" target="_blank" style="color:#ff6b35;">Facebook</a> |
        <a href="<?= $github ?>" target="_blank" style="color:#ff6b35;">GitHub</a>
</p>
        <nav>
            <a href="<?= site_url('student') ?>">Home</a> |
            <a href="<?= site_url('student/profile') ?>">Student Profile</a>
        </nav>
    </div>
</body>
</html><?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile - Kennelyn Escollar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #ffdde1 0%, #ffe8f0 40%, #fff0f6 100%);
            color: #5b3a4a;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 30px 16px;
        }
        .card {
            background: #fffafc;
            padding: 40px 44px;
            border-radius: 28px;
            box-shadow: 0 10px 40px rgba(255, 133, 161, 0.25);
            border: 1px solid #ffd6e3;
            width: 100%;
            max-width: 460px;
        }
        .avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffb6c9, #ff8fa8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 16px;
            box-shadow: 0 6px 16px rgba(255, 143, 168, 0.4);
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: #e05a7d;
            font-size: 26px;
            margin: 0 0 24px;
            text-align: center;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px dashed #ffdbe6;
            font-size: 14.5px;
        }
        .info-row:last-of-type {
            border-bottom: none;
        }
        .info-row .label {
            color: #b5495b;
            font-weight: 700;
            white-space: nowrap;
        }
        .info-row .value {
            text-align: right;
            color: #5b3a4a;
        }
        .about {
            margin-top: 18px;
            background: #fff0f5;
            border-radius: 16px;
            padding: 16px 18px;
            font-size: 14px;
            line-height: 1.6;
        }
        .about .label {
            display: block;
            color: #b5495b;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .socials {
            margin-top: 20px;
            text-align: center;
        }
        .socials a {
            display: inline-block;
            color: #ffffff;
            background: linear-gradient(135deg, #ffb6c9, #ff8fa8);
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            padding: 9px 20px;
            border-radius: 999px;
            margin: 0 5px;
            box-shadow: 0 4px 12px rgba(255, 143, 168, 0.35);
        }
        nav {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 26px;
        }
        nav a {
            color: #e05a7d;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            background: #fff0f5;
            border: 1.5px solid #ffb6c9;
            padding: 10px 22px;
            border-radius: 999px;
            transition: all 0.2s ease;
        }
        nav a:hover {
            background: #ff8fa8;
            color: #ffffff;
            border-color: #ff8fa8;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="avatar">🎀</div>
        <h1>Student Information</h1>

        <div class="info-row"><span class="label">Student ID</span><span class="value"><?= $student_id ?></span></div>
        <div class="info-row"><span class="label">Name</span><span class="value"><?= $name ?></span></div>
        <div class="info-row"><span class="label">Course</span><span class="value"><?= $course ?></span></div>
        <div class="info-row"><span class="label">Year Level</span><span class="value"><?= $year ?></span></div>
        <div class="info-row"><span class="label">Section</span><span class="value"><?= $section ?></span></div>
        <div class="info-row"><span class="label">Email</span><span class="value"><?= $email ?></span></div>
        <div class="info-row"><span class="label">Address</span><span class="value"><?= $address ?></span></div>
        <div class="info-row"><span class="label">Contact Number</span><span class="value"><?= $contact ?></span></div>
        <div class="info-row"><span class="label">Skills</span><span class="value"><?= $skills ?></span></div>
        <div class="info-row"><span class="label">Hobbies</span><span class="value"><?= $hobbies ?></span></div>

        <div class="about">
            <span class="label">About Me 💌</span>
            <?= $description ?>
        </div>

        <div class="socials">
            <a href="<?= $facebook ?>" target="_blank">Facebook</a>
            <a href="<?= $github ?>" target="_blank">GitHub</a>
        </div>

        <nav>
            <a href="<?= site_url('student') ?>">🏠 Home</a>
            <a href="<?= site_url('student/profile') ?>">🎀 Profile</a>
        </nav>
    </div>
</body>
</html>