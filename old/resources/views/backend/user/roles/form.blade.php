<div class="box-body">
    {!! \Form::nText('name', 'Role Name', (isset($roleDetails) ? $roleDetails->name : null) , true) !!}
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            formObject = $("form#roles");
            formObject.validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    }
                }
            });
        });
    </script>
@endpush
