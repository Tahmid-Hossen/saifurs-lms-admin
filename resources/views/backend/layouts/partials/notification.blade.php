<li>
    <a href="{{ route('notification-read', $notification->id) }}">
        <div class="pull-left">
            @if(isset($notification->data['image']))
                <img src="{{ $notification->data['image'] }}" class="img-circle"
                     alt="{{ $notification->data['title'] }}">
            @endif
        </div>
        <h4>
            @if(isset($notification->data['title']))
                {{ $notification->data['title'] }}
            @endif
            <small><i class="fa fa-clock-o"></i>
                {{ str_replace('ago', '', \Carbon\Carbon::parse(($notification->data['time'] ?? date('Y-m-d H:i:s')))->diffForHumans()) }}
            </small>
        </h4>
        <p>@if(isset($notification->data['body'])) {!!  $notification->data['body'] !!} @endif</p>
    </a>
</li>
