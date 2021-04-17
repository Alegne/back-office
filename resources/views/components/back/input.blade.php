@props([
    'input',
    'name',
    'required' => false,
    'title',
    'rows' => 3,
    'title',
    'label',
    'options',
    'value' => '',
    'Values',
    'multiple' => false,
    'col' => '',
    'maxlength' => 255
])

<div class="form-group {{ $col ? $col : '' }}">

    @isset($title)
        <label for="{{ $name }}">@lang($title)</label>
    @endisset

    @if ($input === 'textarea')
        <textarea
            class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
            rows="{{ $rows }}"
            id="{{ $name }}"
            name="{{ $name }}"
            @if ($required) required @endif>{{ old($name, $value) }}</textarea>

    @elseif ($input === 'checkbox')
        <div class="custom-control custom-checkbox">
            <input
                class="custom-control-input {{ $name }}"
                id="{{ $name }}"
                name="{{ $name }}"
                type="checkbox"
                {{ $value ? 'checked' : '' }}>
            <label
                class="custom-control-label"
                for="{{ $name }}">
                {{ __($label) }}
            </label>
        </div>

      @elseif ($input === 'select')
        <select
            @if($required) required @endif
            class="form-control select-single {{ $errors->has($name) ? ' is-invalid' : '' }}"
            name="{{ $name }}"
            id="{{ $name }}">
            @foreach($options as $id => $option)
                {{--ID:{{ $id }} Option:{{ $option }} Value:{{ $value }}--}}
                <option
                    value="{{ $id }}"
{{--                    value="{{ $option }}"--}}
                    @if ($value != '')

                        {{--@dd($value)--}}

                        {{ old($name) ? (old($name) == $id ? 'selected' : '') : ($id == $value ? 'selected' : '') }}
                    @else
                        False {{ $value }}
                    @endif>
{{--                    {{ old($name) ? (old($name) == $option ? 'selected' : '') : ($option == $value ? 'selected' : '') }}>--}}
                    {{ $option }}
                </option>
            @endforeach
        </select>

    @elseif ($input === 'selectMultiple')
        <select
            multiple
            @if($required) required @endif
            class="form-control select-multiple {{ $errors->has($name) ? ' is-invalid' : '' }}"
            name="{{ $name }}[]"
            id="{{ $name }}">
            @foreach($options as $id => $title)
                <option
                    value="{{ $id }}"
                    {{ old($name) ? (in_array($id, old($name)) ? 'selected' : '') :
                                    ($values->contains('id', $id) ? 'selected' : '') }}>
                    {{ $title }}
                </option>
            @endforeach
        </select>

    @elseif ($input === 'date')
        <input type="date"
            class="form-control input-date {{ $name }} {{ $errors->has($name) ? ' is-invalid' : '' }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($required) required @endif>

    @elseif ($input === 'email')
        <input type="email"
            class="form-control input-date {{ $name }} {{ $errors->has($name) ? ' is-invalid' : '' }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($required) required @endif>

    @elseif ($input === 'number')
        <input type="number"
            class="form-control input-date {{ $name }} {{ $errors->has($name) ? ' is-invalid' : '' }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            maxlength="{{ $maxlength }}"
            @if($required) required @endif>

    @elseif ($input === 'url')
        <input type="url"
            class="form-control input-date {{ $name }} {{ $errors->has($name) ? ' is-invalid' : '' }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="https://example.com"
            pattern="https://.*"
            @if($required) required @endif>

    @else
        <input
            type="text"
            class="form-control {{ $name }} {{ $errors->has($name) ? ' is-invalid' : '' }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            maxlength="{{ $maxlength }}"
            @if($required) required @endif>

    @endif

    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif

</div>

