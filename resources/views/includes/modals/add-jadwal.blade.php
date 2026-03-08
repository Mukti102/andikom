<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.jadwal.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div class="modal-header"><h5 class="modal-title">Tambah Jadwal</h5></div>
            <div class="modal-body">
                <select name="tutor_id" class="form-control mb-2" required>
                    <option value="">Pilih Tutor</option>
                    @foreach($tutors as $tutor)
                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                    @endforeach
                </select>
                <select name="hari" class="form-control mb-2" required>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                        <option value="{{ $h }}">{{ $h }}</option>
                    @endforeach
                </select>
                <div class="row">
                    <div class="col"><input type="time" name="start_time" class="form-control mb-2" required></div>
                    <div class="col"><input type="time" name="end_time" class="form-control mb-2" required></div>
                </div>
                <input type="text" name="room" class="form-control" placeholder="Nama Ruangan" required>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
