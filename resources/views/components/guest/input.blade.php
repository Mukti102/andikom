@props(['label', 'name', 'type' => 'text', 'value' => '', 'required' => false])

<div class="form-group-wrapper">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if ($required)
            <span class="req text-rose-500">*</span>
        @endif
    </label>

    <div @class([
        'input-file-container' => $type === 'file',
        'has-error' => $errors->has($name),
    ])>
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
            @if ($type !== 'file') value="{{ old($name, $value) }}" @endif {{ $required ? 'required' : '' }}
            @if ($type === 'file' && str_contains($name, 'photo')) accept="image/*" @endif @class([
                'form-input',
                'file-input-custom' => $type === 'file',
                'border-rose-500' => $errors->has($name),
            ])>

        @if ($type === 'file')
            <div class="file-custom-icon">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Pilih file atau drag ke sini</span>
            </div>
        @endif
    </div>

    @error($name)
        <p class="error-message">{{ $message }}</p>
    @enderror
</div>
<style>
    /* Container Utama */
    .form-group-wrapper {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }

    /* Styling Khusus Input File */
    .input-file-container {
        position: relative;
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        background-color: #f9fafb;
    }

    .input-file-container:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    .file-input-custom {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        /* Sembunyikan input asli tapi tetap bisa diklik */
        cursor: pointer;
        z-index: 2;
    }

    .file-custom-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #6b7280;
        pointer-events: none;
        /* Agar klik tembus ke input file di bawahnya */
    }

    .file-custom-icon i {
        font-size: 2rem;
        margin-bottom: 8px;
    }

    .file-custom-icon span {
        font-size: 0.875rem;
    }

    /* Error State */
    .has-error.input-file-container {
        border-color: #e11d48;
        background-color: #fff1f2;
    }

    .error-message {
        color: #e11d48;
        font-size: 0.75rem;
        margin-top: 4px;
    }
</style>
<script>
    document.querySelectorAll('.file-input-custom').forEach(input => {
        input.addEventListener('change', function(e) {
            let fileName = e.target.files[0].name;
            let container = this.parentElement.querySelector('.file-custom-icon span');
            container.innerText = "File terpilih: " + fileName;
            container.style.color = "#3b82f6"; // Beri warna biru jika file terpilih
            container.style.fontWeight = "bold";
        });
    });
</script>
