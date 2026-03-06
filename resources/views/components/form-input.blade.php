@props(['label', 'name', 'type' => 'text', 'value' => '', 'placeholder' => '', 'required' => false])

<div class="form-group mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }} @if($required) <span class="text-danger">*</span> @endif</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
    @error($name)
        <div class="invalid-feedback">
            <i class="bx bx-radio-circle"></i>
            {{ $message }}
        </div>
    @enderror
</div>