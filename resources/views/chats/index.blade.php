<!DOCTYPE html>

<html>

<body>

<h1> Test Chats Index </h1>

@if (session('error'))
    <strong>{{ session('error') }}</strong>
@endif

<ul>
    @foreach ($chats as $chat)
    <li>{{ $chat->filename }}</li>
    @endforeach
</ul>

</body>

</html>