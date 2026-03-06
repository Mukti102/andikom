<div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('admin.users.store')}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="08xxx">
                    </div>
                    <div class="form-group mt-2">
                        <label>Role</label>
                        <select name="role" class="form-select">
                            <option value="peserta">Peserta (Biru)</option>
                            <option value="admin">Admin (Hijau)</option>
                            <option value="pengajar">Pengajar (Kuning)</option>
                            <option value="pimpinan">Pimpinan (Merah)</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label>Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label>Phone</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label>Role</label>
                        <select name="role" id="edit_role" class="form-select">
                            <option value="user">Peserta (Biru)</option>
                            <option value="admin">Admin (Hijau)</option>
                            <option value="pengajar">Pengajar (Kuning)</option>
                            <option value="pimpinan">Pimpinan (Merah)</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>Password <small class="text-muted">(Leave blank if not changing)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="********">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Update User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
