<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('book_id', 'Book', true) !!}
                <select name="book_id" id="book_id" class="form-control" required>
                    <option value="" @if (isset($bookRatingComment) && ($bookRatingComment->book_id === "")) selected @endif>Select Book</option>
                    @foreach($books as $book)
                        <option
                            value="{{$book->book_id}}"
                            @if (isset($bookRatingComment) && ($bookRatingComment->book_id === $book->book_id)) selected @endif
                        >{{$book->book_name}}</option>
                    @endforeach
                </select>
                <span id="book_id-error" class="help-block">{{ $errors->first('book_id') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            {!! Form::nSelectRange('book_rating', 'Rating', 1,5,isset($bookRatingComment) ? $bookRatingComment->book_rating: null, true) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('book_comment', 'Comment') !!}<br>
                <textarea id="book_comment" name="book_comment" rows="5" class="form-control" placeholder="Enter Book Comment">{{ old('book_comment', isset($bookRatingComment) ? $bookRatingComment->book_comment: null) }}</textarea>
                <span id="book_comment-error" class="help-block">{{ $errors->first('book_comment') }}</span>
            </div>
        </div>
    </div>
    @if (isset($bookRatingComment))
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('is_approved', 'IS Approved', true) !!}
                <select name="is_approved" id="is_approved" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$answer_featured as $featured)
                        <option value="{{$featured}}"
                                @if (isset($bookRatingComment) && ($bookRatingComment->is_approved === $featured)) selected @endif
                        >{{$featured}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('book_rating_comment_status', 'Status', true) !!}
                <select name="book_rating_comment_status" id="book_rating_comment_status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$user_status as $status)
                        <option value="{{$status}}"
                                @if (isset($bookRatingComment) && ($bookRatingComment->book_rating_comment_status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="box-footer">
    {!!
        CHTML::actionButton(
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
