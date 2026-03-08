 @foreach ($jadwals as $j)
        <div class="modal fade" id="editModal{{ $j->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('admin.jadwal.update', $j->id) }}" method="POST" class="modal-content ">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Jadwal</h5>
                    </div>
                    <div class="modal-body">
                        <select name="tutor_id" class="form-control mb-2" required>
                            @foreach ($tutors as $tutor)
                                <option value="{{ $tutor->id }}" {{ $j->tutor_id == $tutor->id ? 'selected' : '' }}>
                                    {{ $tutor->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="hari" class="form-control mb-2" required>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                                <option value="{{ $h }}" {{ $j->hari == $h ? 'selected' : '' }}>
                                    {{ $h }}</option>
                            @endforeach
                        </select>

                        <div class="row">
                            <div class="col">
                                <input type="time" name="start_time" class="form-control mb-2"
                                    value="{{ $j->start_time }}" required>
                            </div>
                            <div class="col">
                                <input type="time" name="end_time" class="form-control mb-2" value="{{ $j->end_time }}"
                                    required>
                            </div>
                        </div>

                        <input type="text" name="room" class="form-control" value="{{ $j->room }}"
                            placeholder="Nama Ruangan" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach