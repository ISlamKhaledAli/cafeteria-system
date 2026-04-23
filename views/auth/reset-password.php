<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; display:flex; justify-content:center; align-items:center; height:100vh;}
        .box { background:#fff; padding:30px; border-radius:10px; width:300px;}
        input { width:100%; padding:10px; margin:10px 0;}
        button { width:100%; padding:10px; background:#333; color:#fff; border:none;}
        .msg { color:red; margin-bottom:10px;}
    </style>
</head>
<body>

<div class="box">
    <h3>Reset Password</h3>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="msg"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Update Password</button>
    </form>
</div>

</body>
</html>