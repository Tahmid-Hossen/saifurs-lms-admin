<div class="container-fluid">
    <div class="row">
        @if (session()->has('message'))
            <div class="col-md-12 message">
                <div class="alert alert-success alert-dismissible message" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-check-circle"></i> {{ session('message') }}
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="col-md-12 message">
                <div class="alert alert-danger alert-dismissible message" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-check-exclamation"></i> {{ session('error') }}
                </div>
            </div>
        @endif
        <div class="col-md-12">
            @include('flash::message')
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $(".message").hide(2000);
            }, 5000);
        });
    </script>
@endpush
