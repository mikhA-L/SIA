@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'hint' => null,
    'options' => [],
])

@php
    $id = 'f-' . $name;
    $val = old($name, $value);
    $describedBy = trim(($hint ? $id . '-hint ' : '') . ($errors->has($name) ? $id . '-error' : ''));
    $kelas = ($type === 'select' ? 'form-select' : 'form-control') . ($errors->has($name) ? ' is-invalid' : '');
@endphp

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">
        {{ $label }}@if ($required) <span class="req" aria-hidden="true">*</span>@endif
    </label>

    @if ($type === 'select')
        <select id="{{ $id }}" name="{{ $name }}" class="{{ $kelas }}"
                @if ($required) required @endif
                @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif>
            <option value="">Pilih...</option>
            @foreach ($options as $optValue => $optLabel)
                <option value="{{ $optValue }}" @selected((string) $val === (string) $optValue)>{{ $optLabel }}</option>
            @endforeach
        </select>
    @elseif ($type === 'textarea')
        <textarea id="{{ $id }}" name="{{ $name }}" rows="3" class="{{ $kelas }}"
                  @if ($required) required @endif
                  @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif>{{ $val }}</textarea>
    @else
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" value="{{ $val }}" class="{{ $kelas }}"
               @if ($required) required @endif
               @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif>
    @endif

    @if ($hint)
        <div id="{{ $id }}-hint" class="form-text">{{ $hint }}</div>
    @endif
    @error($name)
        <div id="{{ $id }}-error" class="field-error" role="alert">{{ $message }}</div>
    @enderror
</div>
