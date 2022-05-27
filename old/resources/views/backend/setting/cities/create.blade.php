@extends('backend.layouts.master')
@section('title')
    Create/Add City
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-map-pin"></i>
                City
                <small>Control Panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create </h3>
                    </div>
                <!-- form start -->
                <form class="horizontal-form" id="city_form" role="form" method="POST" action="{{ route('cities.store') }}" enctype="multipart/form-data">
                   @csrf
                    @include('backend.setting.cities.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        var selected_state_id = '{{old("state_id", (isset($userDetails)?$userDetails->state_id:null))}}';
        getProvinceList();
        getCityList();
        $(document).ready(function() {
            jQuery.validator.addMethod("noSpace", function(value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

            $("city_form").validate({
                rules: {
                    city_name: {
                        required: true
                    },
                    state_id: {
                        required: true
                    },
                    country_id: {
                        required: true
                    }
                }
            });
        });

        function getProvinceList(){
            var country_id = $('#country_id').val();
            var pickToken = '{{csrf_token()}}';
            if(country_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('states.get-state-list')}}',
                    data:{
                        country_id : country_id,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#state_id").empty();
                            $("#state_id").append('<option value="">Please Select state</option>');
                            $.each(res.data,function(key,value){
                                if(selected_state_id == value.id){
                                    stateSelectedStatus = ' selected ';
                                }else{
                                    stateSelectedStatus = '';
                                }
                                $("#state_id").append('<option value="'+value.id+'" '+stateSelectedStatus+'>'+value.state_name+'</option>');
                            });
                        }else{
                            $("#state_id").empty();
                            $("#state_id").append('<option value="">Please Select state</option>');
                        }
                    }
                });
            }else{
                $("#province_id").empty();
                $("#province_id").append('<option value="">Please Select Province</option>');
            }
        }
    </script>
@endsection
