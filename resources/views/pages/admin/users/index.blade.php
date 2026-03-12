@extends('layouts.app')
@section('title', 'User Management')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">User Management</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    <i class="bi bi-plus"></i> Add User
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-3">
                                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/images/faces/1.jpg') }}"
                                                alt="nav" class="rounded-circle">
                                        </div>
                                        <p class="font-bold mb-0">{{ $user->name }}</p>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '-' }} </td>
                                <td>
                                    {{-- Logika Warna Berdasarkan Role dari Dokumen  --}}
                                    @if ($user->role == 'admin')
                                        <span class="badge bg-success">Admin</span> {{-- Hijau Putih --}}
                                    @elseif($user->role == 'user')
                                        <span class="badge bg-primary">Peserta</span> {{-- Biru Putih --}}
                                    @elseif($user->role == 'tutor')
                                        <span class="badge bg-warning text-dark">Pengajar</span> {{-- Kuning Putih --}}
                                    @elseif($user->role == 'owner')
                                        <span class="badge bg-info">Pimpinan</span> {{-- Merah Putih --}}
                                    @endif
                                </td>
                                <td>
                                    {{-- Tombol Edit dengan Data Attributes untuk JavaScript --}}
                                    <button class="btn btn-sm btn-outline-warning btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit" data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone }}" data-role="{{ $user->role }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- Tombol Delete --}}
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-bs-toggle="modal"
                                        data-bs-target="#modalDelete" data-id="{{ $user->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @include('includes.modals.user')

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // LOGIKA UNTUK MODAL EDIT
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const phone = this.getAttribute('data-phone');
                const role = this.getAttribute('data-role');

                // 1. Update URL Action Form (Mengisi parameter ID ke Route)
                // Sesuaikan '/admin/users/' dengan prefix route Anda
                document.getElementById('editForm').action = '/admin/users/' + id;

                // 2. Isi data ke input modal
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_phone').value = phone;
                document.getElementById('edit_role').value = role;
            });
        });

        // LOGIKA UNTUK MODAL DELETE
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                // Update URL Action Form Delete
                document.getElementById('deleteForm').action = '/admin/users/' + id;
            });
        });

    });
</script>
