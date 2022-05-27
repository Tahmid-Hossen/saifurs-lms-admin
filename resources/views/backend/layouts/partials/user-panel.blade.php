<div class="user-panel">
    <div class="pull-left image">
        @if(isset(auth()->user()->member_image->file_image_name))
            <img
                src="/{{ \Utility::$fileUploadPathMemberImage }}/{{ auth()->user()->member_image->file_image_name }}"
                class="img-circle" alt="{{auth()->user()->username}}">
        @else
            <img src="{{asset('/assets/dist/img/default-profile-icon-16.jpg')}}" class="img-circle" alt="Profile Photo">
        @endif
    </div>
    <div class="pull-left info">
        <p>{{auth()->user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
</div>
