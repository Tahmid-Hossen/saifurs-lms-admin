<div class="custom-control custom-checkbox mb-2">

    <input id="customCheck1" class="custom-control-input" type="checkbox">
    <label class="custom-control-label" for="customCheck1">Unchecked</label>
</div>
<div class="form-group @error($name) has-error @enderror">
    {!! Form::nLabel($name, $label, $required) !!}

    @php
        $options = ['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : NULL )];

        $msg = $errors->first($name) ?? null;

        if(isset($required) && $required == true)
        $options['required'] = 'required'
    @endphp



    {!! Form::nError($name, $msg) !!}
</div>
