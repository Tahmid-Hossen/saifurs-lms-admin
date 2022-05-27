@include('backend.layouts.partials.errors')
<input type="hidden" name="is_ebook" value="NO">
<input type="hidden" name="status" value="{{ old('status', isset($book) ? $book->book_status: 'ACTIVE') }}">

<div class="box-body">
    <h3>Basic Information</h3>
    <section>
        <div class="row">
            @role(\Utility::SUPER_ADMIN)
            <div class="col-md-6">
                {!! \Form::nSelect('company', 'Select Company', $global_companies, isset($book) ? $book->company_id: null, true,
    [ 'class' => 'form-control', 'placeholder' => 'Select an Option']) !!}
            </div>
            @else
                <input type="hidden" name="company" id="company"
                       value="{{auth()->user()->userDetails->company_id}}">
                @endrole
                <div class="@role(\Utility::SUPER_ADMIN) col-md-6 @else col-md-12 @endrole">
                    {!! \Form::nSelect('branch', 'Select Branch', [], null, false,
                    ['placeholder' => 'Select Company First', 'class' => 'form-control custom-select']) !!}
                </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nText('book_name', 'Name', isset($book) ? $book->book_name: null, true)!!}
            </div>
            <div class="col-md-6">
                {!! \Form::nText('edition', 'Edition', isset($book) ? $book->edition: null, false)!!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nText('author', 'Author', isset($book) ? $book->author: null, true) !!}
            </div>
            <div class="col-md-6">
                {!! \Form::nText('contributor', 'Contributors', isset($book) ? $book->contributor: null, false)!!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nSelect('book_category', 'Category', $categories, (isset($book) ? $book->book_category_id: null), true,
                    ['class' => 'form-control'])!!}
            </div>
            <div class="col-md-6">
                {!! \Form::nSelect('language', 'Language', \Utility::$languageList, isset($book) ? $book->language : 1, true, ['placeholder' => 'Select a Language']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nText('isbn_number', 'ISBN Number', isset($book) ? $book->isbn_number: null, false)!!}
            </div>
            <div class="col-md-6">
                {!! \Form::nText('publish_date', 'Publish Date', isset($book) ? $book->publish_date->format('Y-m-d'): date('Y-m-d'), true,
                    ['class' => 'form-control input-date', 'readonly' => 'readonly'])!!}
            </div>
        </div>
    </section>
    <h3>Other Information</h3>
    <section>
        <div class="row">
            <div class="col-md-4">
                {!! \Form::nLabel('is_sellable', 'Is it sellable outside course?', true) !!}
                <div class="form-group">
                    <div class="checkbox-inline">
                        {!! \Form::radio('is_sellable', \Utility::$featuredStatusText[1],
                        true,
                         ['id' => 'is_sellable_yes']) !!}
                        {!! \Form::nLabel('is_sellable_yes', 'YES', false, ['class' => ' control-label']) !!}
                    </div>
                    {{--<div class="checkbox-inline">
                        {!! \Form::radio('is_sellable', \Utility::$featuredStatusText[0],
                        isset($book) ? ($book->is_sellable == \Utility::$featuredStatusText[0]) : null,
                         ['id' => 'is_sellable_no']) !!}
                        {!! \Form::nLabel('is_sellable_no', 'NO', false, ['class' => ' control-label']) !!}
                    </div>--}}
                    {!! \Form::nError('is_sellable', $errors->first('is_sellable')) !!}
                </div>
            </div>
            <div class="col-md-4">
                {!! \Form::nNumber('book_price', 'Price', isset($book) ? $book->book_price: null, false, ['min' => 0, 'step' => '0.01']) !!}
            </div>
            <div class="col-md-4">
                {!! \Form::nNumber('page_number', 'Total Pages', isset($book) ? $book->pages: 1, false, [
        'min' => 0, 'step' => '1'])!!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(isset($book))
                    {!! \Form::hidden('existing_image[0]', (isset($book) ? $book->photo[0] : null)) !!}
                @endif

                {!! Form::nFile('photo[0]',
                'Cover Image (Max: ' .\Utility::$bookImageSize['width'] . 'X' .\Utility::$bookImageSize['height'] .')',
                 null, empty($book->photo[0]), [false, 128, (isset($book) ? $book->photo[0] : '/assets/img/book_default.jpg')]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! \Form::nTextarea('book_description', 'Description', isset($book) ? $book->book_description: null, false,
                    ['rows' => 3, 'class' => 'form-control custom-editor']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! \Form::nLabel('book_keywords', 'Keywords (Minimum 3 items)', true)!!}
                    <select class="form-control custom-tags" multiple id="book_keywords" name="book_keywords[]">
                        @foreach($keywords as $id => $keyword)
                            <option value="{{ $id }}" label="{{ $keyword }}"
                                    @if(isset($book))
                                    @foreach($book->keywords as $phase)
                                    @if($id == $phase->keyword_id) selected @endif
                                    @endforeach
                                    @elseif(!empty(old('book_keywords')))
                                    @foreach(old('book_keywords') as $phase)
                                    @if($id == $phase) selected @endif
                                @endforeach
                                @endif
                            >
                                {{ $keyword }}
                            </option>
                        @endforeach
                    </select>
                    <span id="book_keywords-error" class="d-block text-danger">
                    @error('book_keywords')
                        {{ $message }}
                        @enderror
                </span>

                </div>
            </div>
        </div>
    </section>
    <h3>Preview Image</h3>
    <section>
        <div class="row">
            @for($i=1; $i<=10; $i++)
                <div class="col-md-12">
                    @if(isset($book->photo[$i]))
                        {!! \Form::hidden('existing_image['. $i.']', (isset($book->photo[$i]) ? $book->photo[$i] : null)) !!}
                    @endif

                    {!! Form::nFile('photo[' .$i.']',
                    'Inner Sample Page (Max: ' .\Utility::$bookImageSize['width'] . 'X' .\Utility::$bookImageSize['height'] .')',
                     null, false, [false, 128, (isset($book->photo[$i]) ? $book->photo[$i] : '/assets/img/book_default.jpg')]) !!}
                </div>
            @endfor
        </div>
    </section>

</div>

@push('scripts')
    <script>
        const selected_branch_id = '{{(empty(old('branch')) ? (isset($book)  ? $book->branch_id  : null) : old('branch')) }}';

        $(document).ready(function () {
            formObject = $('form#books_form');

            //Jquery Steps
            $('.box-body').steps({
                startIndex: 0,
                onStepChanging: function (event, currentIndex, newIndex) {
                    if (currentIndex < newIndex) {
                        // Step 1 form validation
                        if (currentIndex === 0) {
                            return !!(formValidator.element("#company") &&
                                formValidator.element("#branch") &&
                                formValidator.element("#book_name") &&
                                formValidator.element("#edition") &&
                                formValidator.element("#author") &&
                                formValidator.element("#contributor") &&
                                formValidator.element("#book_category") &&
                                formValidator.element("#language") &&
                                formValidator.element("#isbn_number") &&
                                formValidator.element("#publish_date"));
                        }
                        // Step 2 form validation
                        if (currentIndex === 1) {
                            return !!(
                                formValidator.element("#is_sellable_yes") &&
                                /*                                formValidator.element("#is_sellable_no") &&*/
                                formValidator.element("#book_price") &&
                                /*                                formValidator.element("#photo") &&*/
                                formValidator.element("#book_price") &&
                                formValidator.element("#book_description") &&
                                formValidator.element("#book_keywords"));
                        }
                        // Always allow step back to the previous step even if the current step is not valid.
                    } else {
                        return true;
                    }
                },
                onFinished: function (event, currentIndex) {
                    formObject.submit();
                }
            });

            getBranchDropdown($("#company"), $("#branch"), selected_branch_id);
            $("#company").trigger("change");

            $('#company').change(function () {
                getBranchDropdown($(this), $("#branch"), selected_branch_id);
            });

            $('#branch').select2({width: "100%", placeholder: "Please Select an option"});

            //tag created
            $('.custom-tags').select2({'width': '100%', placeholder: 'Select an option', tags: true});

            //Date picker
            $('.input-date').daterangepicker({
                startDate: moment(),
                //maxDate:moment(),
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: true,
                autoApply: true,
                locale: {format: "YYYY-MM-DD"}
            });

            //Editor
            $(".custom-editor").wysihtml5({
                toolbar: {
                    "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
                    "emphasis": true, //Italics, bold, etc. Default true
                    "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                    "html": false, //Button which allows you to edit the generated HTML. Default false
                    "link": true, //Button to insert a link. Default true
                    "image": false, //Button to insert an image. Default true,
                    "color": false, //Button to change color of font
                    "blockquote": false, //Blockquote
                    "size": "sm" //default: none, other options are xs, sm, lg
                }
            });
            $('#is_sellable_yes').change(function () {
                $('#book_price').attr('readonly', false);
            });
            $('#is_sellable_no').change(function () {
                $('#book_price').attr('readonly', true);
            });
            formValidator = formObject.validate({
                rules: {
                    book_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                    },
                    edition: {
                        minlength: 1,
                        maxlength: 255
                    },
                    author: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    contributor: {
                        minlength: 3,
                        maxlength: 255
                    },
                    book_category: {
                        required: true,
                        digits: true,
                    },
                    language: {
                        required: true,
                        digits: true
                    },
                    page_number: {
                        required: true,
                        digits: true
                    },
                    company: {
                        required: true,
                        digits: true
                    },
                    branch: {
                        required: false,
                        digits: true
                    },
                    is_sellable: {
                        required: true
                    },
                    book_price: {
                        required: function () {
                            return ($("#is_sellable_yes").prop("checked"));
                        },
                        number: true,
                        min: function () {
                            return ($("#is_sellable_no").prop("checked")) ? 1 : 0;
                        }
                    },
                    publish_date: {
                        required: true,
                        date: true,
                    },
                    isbn_number: {
                        minlength: 10,
                        maxlength: 255
                    },
                    /*                    'photo[0]': {
                                            required: {{ (empty($book))?'true':'false'}},
                        extension: "jpg|jpeg|png|ico|bmp|svg",
                    },*/
                    book_description: {
                        minlength: 3
                    }
                }
            });

        });

    </script>
@endpush
