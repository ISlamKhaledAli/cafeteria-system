<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold"><i class="bi bi-door-open text-warning me-2"></i>Manage Rooms</h2>
        </div>
        <div class="col-md-6 text-md-end">
            <button class="btn btn-warning rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                <i class="bi bi-plus-circle me-2"></i>Add Room
            </button>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th class="py-3">Room Name</th>
                            <th class="text-end pe-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($rooms)): foreach ($rooms as $room): ?>
                            <tr>
                                <td class="ps-4 fw-bold">#<?= htmlspecialchars($room['id']) ?></td>
                                <td><?= htmlspecialchars($room['name']) ?></td>
                                <td class="text-end pe-4 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;" onclick="editRoom(<?= $room['id'] ?>, '<?= addslashes(htmlspecialchars($room['name'])) ?>')">
                                        <i class="fas fa-edit text-primary" style="font-size: 0.8rem;"></i>
                                    </button>
                                    <form action="index.php?page=admin-delete-room" method="POST" class="d-inline border-0 p-0 m-0">
                                        <input type="hidden" name="id" value="<?= $room['id'] ?>">
                                        <button type="button" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;" onclick="if(confirm('Are you sure you want to delete this room?')) this.form.submit();">
                                            <i class="fas fa-trash text-danger" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="3" class="text-center py-4">No rooms found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

 <div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Room</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=admin-add-room" method="POST">
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Room Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-pill px-3 py-2" required placeholder="e.g. 101, Lobby">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">Save Room</button>
                </div>
            </form>
        </div>
    </div>
</div>

 <div class="modal fade" id="editRoomModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Room</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=admin-edit-room" method="POST">
                <input type="hidden" name="id" id="edit-room-id">
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Room Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit-room-name" class="form-control rounded-pill px-3 py-2" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">Update Room</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editRoom(id, name) {
    document.getElementById('edit-room-id').value = id;
    document.getElementById('edit-room-name').value = name;
    new bootstrap.Modal(document.getElementById('editRoomModal')).show();
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
