@props(['label', 'name', 'type' => 'text', 'value' => '', 'required' => false])

<div>
    <label for="{{ $name }}">
        {{ $label }}
        @if($required)<span class="req">*</span>@endif
    </label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        @class(['border-rose-500' => $errors->has($name)])
    >
    @error($name)
        <p style="color: var(--rose, #e11d48); font-size: 0.75rem; margin: 4px 0 0;">{{ $message }}</p>
    @enderror
</div>