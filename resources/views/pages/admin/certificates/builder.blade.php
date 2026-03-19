@extends('layouts.app')
@section('title', 'Template Sertifikat')

@section('content')
    <section class="section">
        <div class="builder-container" style="display: flex; gap: 20px;">
            <div class="canvas-area">
                <canvas id="canvas"></canvas>
            </div>

            <div class="toolbar" style="width: 300px;">
                <h4>Tambah Elemen</h4>
                <div class="btn-group-vertical">
                    <button id="addNama" class="btn btn-primary">Tambah Nama</button>
                    <button id="addNomor" class="btn btn-secondary">Tambah Nomor</button>
                    <button id="addTanggal" class="btn btn-info">Tambah Tanggal</button>
                </div>

                <hr>

                <div id="controls" style="display:none;">
                    <h4>Pengaturan Objek</h4>
                    <label>Font Size:</label>
                    <input type="number" id="fontSize" class="form-control">
                </div>

                <button id="save" class="btn btn-success mt-4">Simpan Template</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const canvas = new fabric.Canvas('canvas');

        fabric.Image.fromURL("{{ asset('storage/' . $template->background) }}", function(img) {

            // samakan ukuran canvas dengan gambar
            canvas.setWidth(img.width);
            canvas.setHeight(img.height);

            // set background tanpa scaling
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                originX: 'left',
                originY: 'top'
            });

        });
        document.getElementById('addNama').onclick = function() {
            const text = new fabric.IText('Nama Peserta', {
                left: 500,
                top: 350,
                fill: '#000'
            });
            text.field = "nama";
            canvas.add(text);
        }

        document.getElementById('addNomor').onclick = function() {
            const text = new fabric.IText('Nomor Sertifikat', {
                left: 500,
                top: 420,
            });
            text.field = "nomor";
            canvas.add(text);
        }

        document.getElementById('addTanggal').onclick = function() {
            const text = new fabric.IText('Tanggal', {
                left: 500,
                top: 480,
            });
            text.field = "tanggal";
            canvas.add(text);
        }


        canvas.on('selection:created', showControls);
        canvas.on('selection:updated', showControls);
        canvas.on('selection:cleared', () => {
            document.getElementById('controls').style.display = 'none';
        });

        function showControls(e) {
            const obj = e.selected[0];
            document.getElementById('controls').style.display = 'block';
            document.getElementById('fontSize').value = obj.fontSize;
        }

        // Update properti saat input diubah
        document.getElementById('fontSize').oninput = function() {
            canvas.getActiveObject().set('fontSize', parseInt(this.value));
            canvas.renderAll();
        };

        document.getElementById('save').onclick = function() {

            let fields = {};

            canvas.getObjects().forEach(obj => {
                if (obj.field) {

                    const realFontSize = obj.fontSize * obj.scaleY;

                    fields[obj.field] = {
                        x: obj.left,
                        y: obj.top,
                        fontSize: realFontSize
                    }

                    obj.scaleX = 1;
                    obj.scaleY = 1;
                    obj.fontSize = realFontSize;
                }
            });

            fetch("{{ route('admin.certificate-template.builder.save', $template->id) }}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        fields: fields
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert("Template berhasil disimpan");
                })

        }
    </script>
@endpush
