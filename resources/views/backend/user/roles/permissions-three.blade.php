

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
                                    <input type="checkbox" class="checkAll" id="checkAll" onclick="allCheck()" > 
                                </span>
                            </div>
                        </div>
                    </li>
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div class="row">
                                <div class="col-xs-8 col-sm-8"></div>
                                <div class="col-xs-4 col-sm-4" style="padding: 3px;">
                                    <input type="checkbox" class="checkAll" id="checkAll" onclick="allCheck()" > 
                                </div>
                            </div> --}}
                            
                            <?php
                                $sl = 1;
                                $count = 1;
                                $class = "checkbox";
                            ?>
                            @forelse($permissionData as $key => $value)
                                <div class="box direct-chat m-0">
                                    <div class="box-header with-border">
                                        <div class="row">
                                            <div class="col-xs-8 col-sm-8">
                                                <h4>
                                                    <a class="" data-toggle="collapse" href="#collapseExample{{ $sl }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                        {{$key}}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="col-xs-4 col-sm-4" >
                                                
                                                <input type="checkbox" id="checkAll" class="vehicle{{ $sl }}" onclick="myFunction('{{$key}}')" style="display:block; float: right"/>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapseExample{{ $sl }}">
                                        @forelse ($value as $item)
                                            @if(!empty($item['name']))
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xs-8 col-sm-8"><label for="vehicle"> {{ isset($item['name'])?$item['name']:null }}</label></div>
                                                    <div class="col-xs-4 col-sm-4">
                                                        <input type="checkbox" class="{{$key}}" 
                                                            name="permissions[]" 
                                                            value="{{ isset($item['id'])?$item['id']:null }}" 
                                                            style="display:block; float: right"
                                                            @if (in_array($item['id'], $rolePermissions))
                                                            checked
                                                            @endif/>
                                                    </div>
                                                </div>
                                                <br>
                                            @endif
                                        @empty
                                            <p>There is no permission added to this role.</p>
                                        @endforelse
                                    </div>
                                </div>
                            @php
                                $sl++;
                            @endphp
                            
                            @empty
                                <p>There is no permission added to this role.</p>    
                            @endforelse
                            
                        </div>
                    </div>
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

    function myFunction(sl){
        var ClassName = sl;
        var checklength = $('.'+ClassName+':checked').length ;
        var totallength = $("."+ClassName).length ;
        
        if (checklength == totallength) {
            console.log('ok');
            $("."+ClassName).prop('checked', false);
        }
        else{
            console.log('not ok');
            $("."+ClassName).prop('checked', true);
        }
    }

    function allCheck(){
        var checklength = $('input:checkbox:checked').length ;
        var totallength = $("input:checkbox").length ;
        var totallength = --totallength;
        if (checklength == totallength) {
            console.log('ok');
            $("input:checkbox").prop('checked', false);
        }
        else{
            console.log('not ok');
            $("input:checkbox").prop('checked', true);
        }
    }
</script>
