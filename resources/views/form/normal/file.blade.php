@php
    if (preg_match('/(.+)\[(.+)\]/i', $name) > 0)
        $multipartName = preg_replace('/(.+)\[(.+)\]/i', '$1.$2', $name, 1);
@endphp
<div class="form-group @error(($multipartName ?? $name)) has-error @enderror">
    {!! Form::nLabel($name, $label, $required, ['class' => 'd-block mb-2']) !!}
    <div class="custom-file">
        @php

            $options = ['class' => 'form-control' . ($errors->has(($multipartName ?? $name)) ? ' is-invalid' : NULL )];

            $msg = $errors->first(($multipartName ?? $name)) ?? null;

            if(isset($required) && $required == true)
            $options['required'] = 'required'
        @endphp

        {!! Form::file($name, array_merge($options, $attributes)) !!}

        {!! Form::nError(($multipartName ?? $name), $msg) !!}

        @if(($preview[0] ?? false))
            <div class="img-thumbnail my-2 mx-2" style="text-align: center; width: 100%">
                <img id="{{$name}}_preview" src="{{ asset(($preview[2] ?? '/img/icon.png')) }}"
                     height="{{ ($preview[1] ?? 89) }}" alt="">
            </div>
            <script>
                document.getElementById("{{$name}}").addEventListener("change", function () {
                    var i = this;
                    if (i.files && i.files[0]) {
                        var r = new FileReader();
                        r.onload = function (e) {
                            document.getElementById("{{$name}}_preview").setAttribute('src', e.target.result);
                        };
                        r.readAsDataURL(i.files[0]);
                        document.getElementById("{{$name}}_label").innerText = (i.files[0].name ?? "Choose a file");
                    }
                });
            </script>
        @endif
    </div>
</div>
