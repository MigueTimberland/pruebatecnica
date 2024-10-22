<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel Characters</title>
</head>
<body>
    <h1>Marvel Characters</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <ul>
        @foreach($characters as $character)
            <li>
                <h2>{{ $character->name }}</h2>
                <img src="{{ $character->thumbnail }}" alt="{{ $character->name }}" style="width:150px;">
            </li>
        @endforeach
    </ul>
</body>
</html>
