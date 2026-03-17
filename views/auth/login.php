<?php require "../layouts/header.php"; ?>

<div class="container mt-5">

<h3>Login</h3>

<form method="POST">

<input
type="email"
name="email"
class="form-control mb-3"
placeholder="Email"
required>

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button class="btn btn-primary">
Login
</button>

</form>

<a href="/register">Create Account</a>

<?php if(isset($error)) echo $error; ?>

</div>

<?php require "../layouts/footer.php"; ?>