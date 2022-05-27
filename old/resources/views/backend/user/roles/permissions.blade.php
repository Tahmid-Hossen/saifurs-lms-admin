

<style>
    .modal-body {
        height:70vh;
        overflow:auto;
    }
</style>
<form action="{{route('roles.permissions.store', $role->id)}}" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><i class="fa fa-key"></i> Assign Permission</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group list-group-flush">
                    {{csrf_field()}}
                    <li class="list-group-item bg-secondary">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-left text-bold">Name</span>
                            </div>
                            <div class="col-md-6">
                <span style="display:block; float: right">
                    <input type="checkbox" class="selectAllCheck">
                </span>
                            </div>
                        </div>
                    </li>
                    @forelse($permissions as $permission)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="text-left">{{$permission->name}}</span>
                                </div>
                                <div class="col-md-6">
                <span style="display:block; float: right">
                    <input type="checkbox" name="permissions[]" class="selectCheck"
                           @if (in_array($permission->id, $rolePermissions))
                           checked
                           @endif
                           value="{{$permission->id}}"/>
                </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="text-left">No Permission assign for this role.</span>
                                </div>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>

<script type="text/javascript">
    jQuery(document).ready(function () {
        // add multiple select / deselect functionality
        $(".selectAllCheck").click(function () { //"select all" change
            $(".selectCheck").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change
        $('.selectCheck').change(function () {
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if (false == $(this).prop("checked")) { //if this item is unchecked
                $(".selectAllCheck").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.selectCheck:checked').length == $('.selectCheck').length) {
                $(".selectAllCheck").prop('checked', true);
            }
        });
    });
</script>
