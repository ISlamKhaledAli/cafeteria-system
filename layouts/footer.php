<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/main.js"></script>



<?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            <?php if (isset($_SESSION['success'])): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= addslashes($_SESSION['success']) ?>',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    background: '#ffffff',
                    color: '#064e3b',
                    iconColor: '#10b981',
                    customClass: { popup: 'shadow-lg border-0 rounded-4' }
                });
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong.',
                    text: '<?= addslashes($_SESSION['error']) ?>',
                    confirmButtonColor: '#d97706',
                    confirmButtonText: 'Got it',
                    background: '#ffffff',
                    color: '#7f1d1d',
                    customClass: { popup: 'shadow-lg border-0 rounded-4' }
                });
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
        });
    </script>
<?php endif; ?>
</body>
</html>