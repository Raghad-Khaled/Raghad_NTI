<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <table class="table">
        <thead>
          <tr>

            @foreach ($users[0] as $key => $value)
            <th scope="col"> {{ $key }}</th>
            @endforeach

    </tr>
    </thead>
    <tbody>

    @foreach ($users as $user)
    <tr>
       @foreach ($user as $key => $value)
           <td>{{$value}}</td>
       @endforeach
    </tr>
    @endforeach
</body>
</html>