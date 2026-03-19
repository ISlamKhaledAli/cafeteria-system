 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="/cafeteria-system-develop/assets/js/main.js"></script>

<script>
    <?php if (isset($_SESSION['success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?= addslashes($_SESSION['success']) ?>',
            timer: 3000,
            showConfirmButton: false,
            background: '#ffffff',
            color: '#1f2937'
        });
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= addslashes($_SESSION['error']) ?>',
            confirmButtonColor: '#d97706'
        });
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
</script>

</body>
</html>