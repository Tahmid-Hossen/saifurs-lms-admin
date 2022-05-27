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
            <div class="col-md-12">
                {!! \Form::nText('book_name', 'Title', isset($book) ? $book->book_name: null, true)!!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nText('edition', 'Edition', isset($book) ? $book->edition: null, true)!!}
            </div>
            <div class="col-md-6">
                {!! \Form::nText('publisher', 'Publisher', isset($book) ? $book->publisher: null, true)!!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nSelect('book_category', 'Category', $categories, (isset($book) ? $book->book_category_id: null), true,
                    ['class' => 'form-control'])!!}
            </div>
            <div class="col-md-6">
                {!! \Form::nText('contributor', 'Contributors', isset($book) ? $book->contributor: null, false)!!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nSelect('country', 'Country', $countries, (isset($book) ? $book->country: null), true,
                    ['class' => 'form-control'])!!}
            </div>
            <div class="col-md-6">
                {!! \Form::nSelect('language', 'Language', \Utility::$languageList, isset($book) ? $book->language : 1, true, ['placeholder' => 'Select a Language']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nText('isbn_number', 'ISBN Number', isset($book) ? $book->isbn_number: null, true)!!}
            </div>
            <div class="col-md-6">
                {!! \Form::nText('publish_date', 'Publish Date', isset($book) ? $book->publish_date->format('Y-m-d'): date('Y-m-d'), true,
                    ['class' => 'form-control input-date', 'readonly' => 'readonly'])!!}
            </div>
        </div>
    </section>
    <h3>Author Information</h3>
    <section>
        <div class="col-md-12">
            {!! \Form::nText('author', 'Author Name', isset($book) ? $book->author: null, true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('author_info', 'Author Details', isset($book) ? $book->author_info: null, true) !!}
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
                    {!! \Form::nError('is_sellable', $errors->first('is_sellable')) !!}
                </div>
            </div>
            <div class="col-md-2">
                {!! \Form::nNumber('quantity', 'Quantity', isset($book) ? $book->quantity: 0, true, ['min' => 0]) !!}
            </div>
            <div class="col-md-2">
                {!! \Form::nNumber('book_price', 'Price', isset($book) ? $book->book_price: null, true, ['min' => 0]) !!}
            </div>
            <div class="col-md-2" style="margin-bottom:15px!important">
                {!! \Form::nNumber('discount_price', 'Discount Price', isset($book) ? $book->discount_price: null, false,['min' => 0]) !!}
                <input type="checkbox" value="1" name="ragular_price_flag" id="ragular_price_flag" <?php if(isset($book->ragular_price_flag) && $book->ragular_price_flag==1){ echo 'checked'; } ?>
                onchange="checkRequired('ragular_price_flag','discount_price');"/> <label>Display</label>
            </div>
            <div class="col-md-2">
                {!! \Form::nNumber('special_price', 'Special Discount Price', isset($book) ? $book->special_price: null, false,['min' => 0]) !!}
                <input type="checkbox" value="1" name="special_price_flag" id="special_price_flag" <?php if(isset($book->special_price_flag) && $book->special_price_flag==1){ echo 'checked'; } ?>
                onchange="checkRequired('special_price_flag','special_price');"/> <label>Display</label>
            </div>
            
        </div>
        <div class="row">
        	<div class="col-md-6">
                {!! \Form::nNumber('page_number', 'Total Pages', isset($book) ? $book->pages: 1, false, [
        'min' => 0, 'step' => '1'])!!}
            </div>
            <div class="col-md-6">
                @if(isset($book))
                    {!! \Form::hidden('existing_image[0]', (isset($book) ? $book->photo[0] : null)) !!}
                    <img src="{{ asset('/public/'.$book->photo[0]) }}" height="100px" width="100px" alt="Book Image">
                @endif

                {!! Form::nFile('photo[0]',
                'Cover Image (Max: ' .\Utility::$bookImageSize['width'] . 'X' .\Utility::$bookImageSize['height'] .')',
                 null, empty($book->photo[0]), [false, 128, (isset($book) ? $book->photo[0] : '/assets/img/book_default.jpg')]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! \Form::nTextarea('book_description', 'Summary', isset($book) ? $book->book_description: null, false,
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
    <h3>Preview PDF</h3>
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! \Form::nLabel('file', 'Upload PDF file (Maximum PDF file size is 15 MB)', false) !!}
                    <input
                        type="file"
                        class="form-control view-color"
                        name="file"
                        id="file"
                        placeholder="Choose File"
                        value="{{ old('file', isset($book) ? $book->file : null) }}"
                        autofocus
                    >
                    @if (isset($book->file))
                        <input type="hidden" name="previous_pdf" value="{{ $book->file }}">
                        <a href="{{url('/public/').$book->file}}" target="_blank">
                            <i class="fa fa-eye" aria-hidden="true"></i> View Existing File
                        </a>
                    @endif
                    <span class="form-text text-danger" role="alert">
                    {{ $errors->first('file') }}
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
	function checkRequired(thisid,divid){
		//if($("#"+thisid ).prop( "checked", true )){
		//var thisCheck = $;
		if ($("#"+thisid).is(':checked')){
			$('#'+divid).attr('required', true);
			$('#'+divid).css('border', '1px solid red');
			
		}
		else{
			$('#'+divid).removeAttr('required');
			$('#'+divid).css('border', '1px solid #d2d6de');
		}
	}
	
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
                                formValidator.element("#publisher") &&
                                formValidator.element("#contributor") &&
                                formValidator.element("#book_category") &&
                                formValidator.element("#country") &&
                                formValidator.element("#language") &&
                                formValidator.element("#isbn_number") &&
                                formValidator.element("#publish_date"));
                        }
                        // Step 2 form validation
                        if (currentIndex === 1) {
                            return !!(
                                formValidator.element("#author") &&
                                formValidator.element("#author_info"));

                        }
                        // Step 3 form validation
                        if (currentIndex === 2) {
                            return !!(
                                formValidator.element("#is_sellable_yes") &&
                                /*                                formValidator.element("#is_sellable_no") &&*/
                                formValidator.element("#book_price") &&
                                /*                                formValidator.element("#photo") &&*/
                                
								formValidator.element("#special_price") &&
								formValidator.element("#discount_price") &&
								
                                formValidator.element("#book_description") &&
                                formValidator.element("#book_keywords"));
                        }
                        // Step 2 form validation
                        if (currentIndex === 3) {
                            return !!(
                                formValidator.element("#file"));
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
                        required: true,
                        minlength: 1,
                        maxlength: 255
                    },
                    publisher: {
                        required: true,
                        minlength: 1,
                        maxlength: 255
                    },
                    author: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    author_info: {
                        required: true
                    },
                    contributor: {
                        minlength: 3,
                        maxlength: 255
                    },
                    book_category: {
                        required: true,
                        digits: true,
                    },
                    country: {
                        required: true
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
                        required: true,
                        minlength: 5,
                        maxlength: 15
                    },
                    /*                   'photo[0]': {
                                            required: {{ (empty($book))?'true':'false'}},
                        extension: "jpg|jpeg|png|ico|bmp|svg",
                    },*/
                    book_description: {
                        minlength: 3
                    },
                    file: {
                        extension: "pdf",
                    },
                    messages: {
                        file:{
                            extension:"Please upload a PDF file",
                    }
                },

                }
            });

        });

    </script>
@endpush
