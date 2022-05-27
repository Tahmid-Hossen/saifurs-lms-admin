<div class="form-group @error($name) has-error @enderror">
    {!! Form::nLabel($name, $label, $required) !!}

    @php
        $options = ['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : NULL )];

        $msg = $errors->first($name) ?? null;

        if(isset($required) && $required == true)
        $options['required'] = 'required'
    @endphp

    {!! Form::number($name, $default, array_merge($options, $attributes)) !!}
    {!! Form::nError($name, $msg) !!}
</div>
