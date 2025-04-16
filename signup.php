<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $role]);

    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup - ProWork</title>
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
        input, select {
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
        a { display: block; text-align: center; margin-top: 15px; color: #047857; text-decoration: none; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Create Account</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Email Address" required />
        <input type="password" name="password" placeholder="Password" required />
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="client">Client</option>
            <option value="freelancer">Freelancer</option>
        </select>
        <button type="submit">Signup</button>
    </form>
    <a href="login.php">Already have an account? Login</a>
</div>

</body>
</html>
