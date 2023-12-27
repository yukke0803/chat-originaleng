@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        </div>
    </div>

    {{--  チャットルーム  --}}
    <div id="room">
        @foreach($messages as $key => $message)
            {{--   送信したメッセージ  --}}
            @if($message->send == \Illuminate\Support\Facades\Auth::id())
                <div class="send" style="text-align: right">
                    <p>{{$message->message}}</p>
                </div>
 
            @endif
 
            {{--   受信したメッセージ  --}}
            @if($message->receive == \Illuminate\Support\Facades\Auth::id())
                <div class="receive" style="text-align: left">
                    <p>{{$message->message}}</p>
                </div>
            @endif
        @endforeach
    </div>
 
    <form>
        <textarea name="message" style="width:100%"></textarea>
        <button  id="btn_send" onclick='send()'>送信aa</button>
        {{-- <input type="hidden" name="send" value="{{$param['send']}}">
        <input type="hidden" name="receive" value="{{$param['receive']}}">
        <input type="hidden" name="login" value="{{\Illuminate\Support\Facades\Auth::id()}}"> --}}
    </form>

    <input type="hidden" name="send" value="{{$param['send']}}">
    <input type="hidden" name="receive" value="{{$param['receive']}}">
    <input type="hidden" name="login" value="{{\Illuminate\Support\Facades\Auth::id()}}">
 
</div>
 
@endsection
@section('script')
    <script type="text/javascript">
 
       //ログを有効にする
       Pusher.logToConsole = true;

 
       var pusher = new Pusher('4afa55f8efe90ae5021e', {
           cluster  : 'ap3',
           encrypted: true
       });

       // Pusherの接続状態が変更された時に実行される処理
        pusher.connection.bind('state_change', function(states) {
            console.log('Pusher Connection State:', states.current);
        });
 
       //購読するチャンネルを指定
       var pusherChannel = pusher.subscribe('chat');
 
       //イベントを受信したら、下記処理
       pusherChannel.bind('chat_event', function(data) {
 
           let appendText;
           let login = $('input[name="login"]').val();
 
           if(data.send === login){
               appendText = '<div class="send" style="text-align:right"><p>' + data.message + '</p></div> ';
           }else if(data.receive === login){
               appendText = '<div class="receive" style="text-align:left"><p>' + data.message + '</p></div> ';
           }else{
               return false;
           }
 
           // メッセージを表示
           $("#room").append(appendText);
 
           if(data.receive === login){
               // ブラウザへプッシュ通知
               Push.create("新着メッセージ",
                   {
                       body: data.message,
                       timeout: 8000,
                       onClick: function () {
                           window.focus();
                           this.close();
                       }
                   })
           }
       });
 
        $.ajaxSetup({
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
            }});
 
        // メッセージ送信
        const send = () => {
            
            $.ajax({
                type : 'POST',
                url : '/chat/send',
                data : {
                    message : $('textarea[name="message"]').val(),
                    send : $('input[name="send"]').val(),
                    receive : $('input[name="receive"]').val(),
                }
            }).done(function(result){
                $('textarea[name="message"]').val('');
            }).fail(function(result){
            });
        }
        console.log('Pusher Connection State:', pusher.connection.state);
    </script>
@endsection