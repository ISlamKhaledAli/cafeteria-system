<?php require "../layouts/header.php"; ?>

<div class="container mt-5">

<h3>Register</h3>

<form method="POST" enctype="multipart/form-data">

<input
name="name"
class="form-control mb-3"
placeholder="Name"
required>

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

<input
name="room"
class="form-control mb-3"
placeholder="Room">

<input
name="extension"
class="form-control mb-3"
placeholder="Extension">

<input
type="file"
name="image"
class="form-control mb-3">

<button class="btn btn-success">
Register
</button>

</form>

</div>

<?php require "../layouts/footer.php"; ?>