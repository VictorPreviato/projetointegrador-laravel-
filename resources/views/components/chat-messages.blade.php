<div id="chatMessageContainer">
    @foreach($mensagens as $msg)
        <div data-id="{{ $msg->id }}" 
             style="margin-bottom:10px; {{ $msg->user_id == auth()->id() ? 'text-align:right;' : '' }}">
            <strong>{{ $msg->user->name }}:</strong>
            <p>{{ $msg->conteudo }}</p>
        </div>
    @endforeach
</div>