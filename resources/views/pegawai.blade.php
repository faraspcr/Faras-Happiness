<!DOCTYPE html>
<html>
<head>
    <title>Pegawai Page</title>
</head>
<body>

              {{-- $nama ['name']          = 'faras';
            $umur ['umur']          = $age; --}}
            <h1 class="display-6 mb-2">{{$name}}</h1>
            <p class="lead mb-0">{{$umur}}</p>
         @foreach ($hobi as  $item)
            <li class="list-group-item">{{ $item }}</li>
         @endforeach
        <p class="lead mb-0">{{$wisuda}}</p>
        <p class="lead mb-0">{{$time_to_study_left}}</p>

        @if ($current_semester < 3)
            <h2>Masih Awal, Kejar TAK</h2>
        @elseif ($current_semester >3)
            <h2>Jangan main-main, kurang-kurangi main game</h2>
        @endif

     <p class="lead mb-0">{{$future_goal}}</p>
</body>
</html>
