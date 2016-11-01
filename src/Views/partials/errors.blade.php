@if($errors->any())
    <div class="message message-error">
        <ul>
            {!! implode('', $errors->all('<li>:message</li>')) !!}
        </ul>
    </div>
@endif
