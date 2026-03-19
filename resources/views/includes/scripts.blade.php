<script src="/assets/static/js/components/dark.js"></script>
<script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<script src="/assets/compiled/js/app.js"></script>

<!-- Need: Apexcharts -->
<script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="/assets/static/js/pages/dashboard.js"></script>


<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/static/js/pages/simple-datatables.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data peserta ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form tersembunyi
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
    // Konfigurasi Toast SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Cek Session Success
    @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    @endif

    // Cek Session Error
    @if (session('error'))
        Toast.fire({
            icon: 'error',
            title: "{{ session('error') }}"
        });
    @endif

    // Cek Validasi Error (dari $request->validate)
    @if ($errors->any())
        Toast.fire({
            icon: 'error',
            title: "Terjadi kesalahan pada input data!"
        });
    @endif
</script>
