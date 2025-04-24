@props(['name', 'value' => '', 'rows' => 4, 'placeholder' => ''])

<textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => 'w-full p-2 border rounded-md']) }}>{{ old($name, $value) }}</textarea>
