<div class="form-group row {{ $errors->has($field) ? ' has-error' : '' }}">
    <label class="col-sm-2 col-form-label text-right">{{ field_name($field, $model) }}</label>
    <div class="col-sm-10">
        @unless(isset($disabled) && $disabled)
        <label class="form-check-inline">
            <input type="radio" name="{{ $field }}" id="{{ $field }}1"
                   value="0" {{ checked(old($field, (!is_string($model)) ? $model->{$field} : 0), 0) }}>
            Nein
        </label>
        <label class="form-check-inline">
            <input type="radio" name="{{ $field }}" id="{{ $field }}2"
                   value="1" {{ checked(old($field, (!is_string($model)) ? $model->{$field} : 0), 1) }}>
            Ja
        </label>
        @else
            <p class="form-control-plaintext">
                @if ($model->{$field})
                    Ja
                @else
                    Nein
                @endif
            </p>
        @endunless
    </div>
</div>
