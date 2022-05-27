<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nSelect('company_id', 'Company', $global_companies,
            old('company_id', isset($blog) ? $blog->company_id : null) , true,
            ['placeholder' => 'Company Name', 'class' => 'form-control select2']) !!}
            <span id="company_id-error" class="help-block">{{ $errors->first('company_id') }}</span>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('user_id', 'User', true) !!}

                <select name="user_id" id="user_id" class="form-control select2" required>
                    <option value="">Select User</option>
                </select>
                <span id="user_id-error" class="help-block">{{ $errors->first('user_id') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('blog_title', 'Blog Title', (isset($blog) ? $blog->blog_title: null), true, ['placeholder' => 'Enter Blog Title']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('blog_type', 'Blog Type', (isset($blog) ? $blog->blog_type: null), true, ['placeholder' => 'Enter Blog Type']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nTextarea('blog_description', 'Blog Description', (isset($blog) ? $blog->blog_description: null), true, ['rows' => 15, 'placeholder' => 'Enter Blog Description']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                {{-- <div class="col-md-12">
                    {!! \Form::nDate('blog_publish_date', 'Publish Date', isset($blog) ? $blog->blog_publish_date:null, true,
                        ['readonly' => 'readonly', 'placeholder' => 'Enter Publish Date', 'class' => 'form-control only_date']) !!}
                </div> --}}
                <input type="hidden" value="{{ isset($blog) ? $blog->blog_publish_date : \Carbon\Carbon::now()}}" name="blog_publish_date">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! \Form::nLabel('blog_status', 'Status', false) !!}
                        <select name="blog_status" id="blog_status" class="form-control">
                            @foreach(\App\Support\Configs\Constants::$user_status as $status)
                                <option value="{{$status}}"
                                        @if (isset($blog) && ($blog->blog_status === $status)) selected @endif
                                >{{$status}}</option>
                            @endforeach
                        </select>
                        <span id="blog_status-error" class="help-block">{{ $errors->first('blog_status') }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! \Form::nLabel('blog_logo', 'Blog Logo', empty($blog)) !!}
                        <input
                            type="file" onchange="imageIsLoaded(this, 'blog_logo_show');"
                            class="form-control"
                            name="blog_logo"
                            id="blog_logo"
                            placeholder="Enter Company Logo"
                            value="{{ old('blog_logo', isset($blog) ? $blog->blog_logo:null) }}"
                        >
                        <span class="text-danger d-block help-block">{{ $errors->first('blog_logo') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
                    <img class="img-responsive" style="max-height:206px; max-width: 460px;"
                         id="blog_logo_show"
                         src="{{isset($blog->blog_logo)?URL::to('/public'.$blog->blog_logo):asset('assets/img/static/blog_default.png')}}"
                         width="{{\Utility::$blogLogoSize['width']}}"
                         height="{{\Utility::$blogLogoSize['height']}}"
                    >

        </div>
    </div>
</div>
<div class="box-footer">
    {!!
        \CHTML::actionButton(
            $reportTitle='..',
            $routeLink='#',
            '',
            $selectButton=['cancelButton','storeButton'],
            $class = ' btn-icon btn-circle ',
            $onlyIcon='yes',
            $othersPram=array()
        )
    !!}
</div>

@push('scripts')
    <script>
        const selected_user_id = '{{old("user_id", (isset($blog)?$blog->user_id:null))}}';

        $(document).ready(function () {

            getUserList();
            $("#company_id").change(function () {
                getUserList();
            });

            formObject = $('form#blog_form');
            formValidator = formObject.validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    user_id: {
                        required: true
                    },
                    blog_title: {
                        required: true
                    },
                    blog_description: {
                        minlength: 200
                    },
                    country_id: {
                        required: true
                    },
                    blog_publish_date: {
                        required: true
                    },
                    blog_logo: {
                        required: {{ isset($blog)?'false':'true' }},
                        extension: "jpg|jpeg|png|ico|bmp|svg|gif"
                    }
                }
            });

            //Start HTML EDITOR
            //bootstrap WYSIHTML5 - text editor
            $("#blog_description").wysihtml5({
                toolbar: {
                    "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
                    "emphasis": true, //Italics, bold, etc. Default true
                    "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                    "html": false, //Button which allows you to edit the generated HTML. Default false
                    "link": false, //Button to insert a link. Default true
                    "image": false, //Button to insert an image. Default true,
                    "color": true, //Button to change color of font
                    "blockquote": true, //Blockquote
                    "size": "sm" //default: none, other options are xs, sm, lg
                }
            });
        });
    </script>
@endpush
