<form action="{{route('users.permissions.store', $user->id)}}" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Assign Permission</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">

                {{csrf_field()}}
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th><input
                                type="checkbox"
                                class="selectAllCheck"
                            ></th>
                    </tr>

                    @forelse($permissions as $permission)
                        <tr>
                            <td>{{$permission->name}}</td>
                            <td><input type="checkbox" name="permissions[]" class="selectCheck"
                                       @if (in_array($permission->id, $userPermissions))
                                       checked
                                       @endif
                                       value="{{$permission->id}}"/></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">
                                There is no permission.
                            </td>
                        </tr>
                    @endforelse
                </table>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn blue">Save changes</button>
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
