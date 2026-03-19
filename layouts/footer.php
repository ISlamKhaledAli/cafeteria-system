<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/main.js"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#ffffff',
        color: '#1f2937',
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    <?php if (isset($_SESSION['success'])): ?>
        Toast.fire({
            icon: 'success',
            title: '<?= addslashes($_SESSION['success']) ?>'
        });
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Action Failed',
            text: '<?= addslashes($_SESSION['error']) ?>',
            confirmButtonColor: '#d97706',
            background: '#ffffff',
            customClass: {
                popup: 'rounded-4 shadow-lg border-0'
            }
        });
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
</script>

</body>
</html>