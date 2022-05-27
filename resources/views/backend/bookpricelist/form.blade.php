{{--@include('backend.layouts.partials.errors')--}}
<div class="box-body">
    <!-- end row -->
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                {!! \Form::nLabel('book_name', 'Book Name', true) !!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="book_name"
                    id="book_name"
                    placeholder="Enter Book Name"
                    value="{{ old('book_name', isset($bookpricelist) ? $bookpricelist->book_name: null) }}"
                    autofocus
                >
                <span id="book_name-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('book_name') }}
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! \Form::nLabel('cover_price', 'Cover Price', false) !!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="cover_price"
                    id="cover_price"
                    placeholder="Enter Cover Price"
                    value="{{ old('cover_price', isset($bookpricelist) ? $bookpricelist->cover_price: null) }}"
                    autofocus
                >
                <span id="cover_price-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('cover_price') }}
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! \Form::nLabel('retail_price', 'Retail Price', false) !!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="retail_price"
                    id="retail_price"
                    placeholder="Enter Retail Price"
                    value="{{ old('retail_price', isset($bookpricelist) ? $bookpricelist->retail_price: null) }}"
                    autofocus
                >
                <span id="retail_price-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('retail_price') }}
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! \Form::nLabel('wholesale', 'Wholesale', false) !!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="wholesale"
                    id="wholesale"
                    placeholder="Enter Wholesale Price"
                    value="{{ old('wholesale', isset($bookpricelist) ? $bookpricelist->wholesale: null) }}"
                    autofocus
                >
                <span id="retail_price-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('wholesale') }}
                </span>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('status', 'Status', false) !!}
                        <select name="status" id="status" class="form-control view-color">
                            @foreach(\App\Support\Configs\Constants::$book_price_list_status as $status)
                                <option value="{{$status}}"
                                        @if (isset($bookpricelist) && ($bookpricelist->status === $status)) selected @endif
                                >{{str_replace("-","",$status)}}</option>
                            @endforeach
                        </select>
                        <span class="form-text text-danger" role="alert">{{ $errors->first('status') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='#',
        null,
        $selectButton=['cancelButton','storeButton'],
        $class = ' btn-icon btn-circle ',
        $onlyIcon='yes',
        $othersPram=array()
    )
!!}
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $("#book_price_form").validate({
                rules: {
                    book_name: {
                        required: true,
                    },
                    cover_price: {
                        min: 1,
                        number: true
                    },
                    retail_price: {
                        min: 1,
                        number: true
                    },
                    wholesale: {
                        min: 1,
                        number: true
                    }

                },
            });
        });

    </script>
@endpush



