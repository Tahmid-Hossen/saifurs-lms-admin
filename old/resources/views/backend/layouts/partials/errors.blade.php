@if ($errors->any())
    <div class="container-fluid" id="error-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

@push('scripts')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#error-box").hide(2000);
            }, 5000);
        });
    </script>
@endpush
