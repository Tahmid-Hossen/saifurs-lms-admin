<style>
    .modal-body {
        height: 85vh !important;
        overflow-y: scroll;
    }

</style>
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Assign Student</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    @include('backend.course.course-batches.course-batch-student-list-table')
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
