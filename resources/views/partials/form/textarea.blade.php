<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="input{{ ucfirst($field) }}">{{ field_name($field, $model) }}</label>

    <div class="col-sm-10">
        @if(isset($disabled) && $disabled)
            <p class="form-control-static">{{ $model->{$field} }}</p>
        @else
            <textarea class="form-control"
                      name="{{ $field }}" id="input{{ ucfirst($field) }}" cols="30"
                      rows="{{ $rows ?? 10 }}">{{ old($field, (!is_string($model) ? $model->{$field} : null)) }}</textarea>

            @if ($errors->has($field))
                <span class="help-block">
                    <strong>{{ $errors->first($field) }}</strong>
                </span>
            @endif
        @endif
    </div>
</div>
