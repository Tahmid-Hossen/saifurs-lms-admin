<div class="box-body">
    <div class="row">
        @role(\Utility::SUPER_ADMIN)
        <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @endrole">
            {!! \Form::nSelect('company_id', 'Select Company', $global_companies, isset($category) ? $category->company_id: null, true,
[ 'class' => 'form-control', 'placeholder' => 'Select an Option']) !!}
        </div>
        @else
            <input type="hidden" name="company_id" id="company"
                   value="{{auth()->user()->userDetails->company_id}}">
            @endrole
        <div class="@role(\Utility::SUPER_ADMIN)col-md-4 @else col-md-6 @endrole">
            {!! \Form::nText('name', 'Category Name',
                (isset($category) ? $category->book_category_name: null),
            true) !!}
        </div>
        <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
            {!! \Form::nSelect('status', 'Category Status',
                \Utility::$statusText, (isset($category) ? array_search($category->book_category_status, \Utility::$statusText): 1),
            true, ['class' => 'form-control']) !!}
        </div>
    </div>

</div>
<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='#',
        isset($category) ? $category->book_category_id : null,
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
           $("form#category_form").validate();
        });
    </script>
    @endpush

