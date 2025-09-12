<div id="chatMessageContainer">
   @foreach($mensagens as $msg)
    <div 
        class="message {{ $msg->user_id == auth()->id() ? 'me' : 'you' }}" 
        data-id="{{ $msg->id }}"
    > 
        <strong>{{ $msg->user->name }}:</strong>
        <p>{{ $msg->conteudo }}</p>
    </div>
@endforeach
</div>