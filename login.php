<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        // JS redirect based on role
        echo "<script>
            let role = '{$user['role']}';
            if(role === 'client') {
                window.location.href = 'dashboard_client.php';
            } else {
                window.location.href = 'dashboard_freelancer.php';
            }
        </script>";
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - ProWork</title>
    <style>
        body { background: #f0fdf4; font-family: Arial; }
        .form-container {
            max-width: 400px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #047857; }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            background: #047857;
            color: white;
            padding: 12px;
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }
        .error { color: red; text-align: center; margin-top: 10px; }
        a { display: block; text-align: center; margin-top: 15px; color: #047857; text-decoration: none; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login to ProWork</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>
    <a href="signup.php">Don't have an account? Signup</a>
</div>

</body>
</html>
