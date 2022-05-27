<div class="box-body">
    {!! \Form::nText('name', 'Permission Name', (isset($permissionDetails) ? $permissionDetails->name : null) , true) !!}
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            formObject = $("form#permissions");
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
