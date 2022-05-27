{{--@include('backend.layouts.partials.errors')--}}
<div class="box-body">
    <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('question', 'Question', true) !!}
                <textarea id="question" name="question" rows="5"
                          class="form-control editor"
                          placeholder="Enter Question">{{ old('question', isset($faq->question) ? $faq->question: null) }}</textarea>

                <span id="question-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('question') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('answer', 'Answer', true) !!}
                <textarea id="answer" name="answer" rows="5"
                          class="form-control details_editor editor"
                          placeholder="Enter Answer">{{ old('answer', isset($faq->answer) ? $faq->answer: null) }}</textarea>
                <span id="answer-error" class="form-text text-danger" role="alert">
                                    {{ $errors->first('answer') }}
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
                            @foreach(\App\Support\Configs\Constants::$faq_status as $status)
                                <option value="{{$status}}"
                                        @if (isset($faq) && ($faq->status === $status)) selected @endif
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
            $("#faq_form").validate({
                rules: {
                    question: {
                        required: true,
                    },
                    answer: {
                        required: true,
                    }
                },
            });
        });

    </script>
@endpush



