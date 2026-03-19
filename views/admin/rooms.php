<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container-fluid py-4 px-4" style="background-color: #fcfcfc; min-height: 100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold mb-1 text-dark"><i class="bi bi-door-open text-warning me-2"></i>Manage Rooms</h2>
            <p class="text-muted small">Add, edit, or remove delivery rooms.</p>
        </div>
        
        <div class="d-flex gap-3 align-items-center">
            <div class="position-relative">
                <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                <input type="text" id="roomSearch" class="form-control ps-5 bg-white border" placeholder="Search rooms..." 
                       style="border-radius: 8px; border-color: #eaeaea !important; box-shadow: 0 1px 3px rgba(0,0,0,0.02); width: 250px;">
            </div>
            <button class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addRoomModal" style="background-color: #d97706; border: none; color: white;">
                <i class="bi bi-plus-circle me-2"></i>Add Room
            </button>
        </div>
    </div>

    <div class="card border border-light shadow-sm" style="border-radius: 12px; overflow: hidden; border-color: #f0f0f0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #fafafa;">
                        <tr class="text-muted" style="font-size: 0.75rem; letter-spacing: 0.8px; text-transform: uppercase;">
                            <th class="ps-4 py-3 fw-bold border-bottom">ID</th>
                            <th class="py-3 fw-bold border-bottom">Room Name</th>
                            <th class="text-end pe-4 py-3 fw-bold border-bottom">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="roomsTableBody" class="bg-white">
                        <?php if(!empty($rooms)): foreach ($rooms as $room): ?>
                            <tr style="transition: all 0.2s ease;">
                                <td class="ps-4 fw-bold text-muted">#<?= htmlspecialchars($room['id']) ?></td>
                                <td class="fw-bold text-dark fs-6"><?= htmlspecialchars($room['name']) ?></td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                                style="width: 35px; height: 35px;" 
                                                onclick="editRoom(<?= $room['id'] ?>, '<?= addslashes(htmlspecialchars($room['name'])) ?>')">
                                            <i class="fas fa-pen text-muted" style="font-size: 0.8rem;"></i>
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                                style="width: 35px; height: 35px;" 
                                                onclick="confirmDeleteRoom(<?= $room['id'] ?>)">
                                            <i class="fas fa-trash text-danger" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="3" class="text-center py-5 text-muted"><i class="bi bi-door-closed fs-1 opacity-25 d-block mb-3"></i>No rooms found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Add New Room</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=admin-add-room" method="POST">
                <div class="modal-body py-4 px-4">
                    <div class="mb-2">
                        <label class="form-label fw-semibold small text-muted text-uppercase">Room Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3 px-3 py-2 bg-light border-0 shadow-none" required placeholder="e.g. 101, Lobby">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white rounded-pill px-4 fw-bold" style="background-color: #d97706;">Save Room</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editRoomModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Edit Room</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=admin-edit-room" method="POST">
                <input type="hidden" name="id" id="edit-room-id">
                <div class="modal-body py-4 px-4">
                    <div class="mb-2">
                        <label class="form-label fw-semibold small text-muted text-uppercase">Room Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit-room-name" class="form-control rounded-3 px-3 py-2 bg-light border-0 shadow-none" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white rounded-pill px-4 fw-bold" style="background-color: #d97706;">Update Room</button>
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

document.getElementById('roomSearch')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#roomsTableBody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

function confirmDeleteRoom(id) {
    Swal.fire({
        title: 'Delete Room?',
        text: "Are you sure you want to delete this room?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?page=admin-delete-room';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id';
            input.value = id;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>