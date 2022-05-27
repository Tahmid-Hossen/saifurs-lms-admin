<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', 'Category Name',
                (isset($category) ? $category->book_category_name: null),
            true) !!}
        </div>
        <div class="col-md-6">
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

