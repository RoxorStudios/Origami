@if(session('status'))
    <div class="message message-light">
        {{ session('status') }}
    </div>
@endif
