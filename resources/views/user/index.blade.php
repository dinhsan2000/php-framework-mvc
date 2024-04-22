<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <thead>
                <tr>
                    <th colspan="50%">Id</th>
                    <th colspan="50%">Name</th>
                    <th colspan="50%">Email</th>
                    <th colspan="50%">Created At</th>
                    <th colspan="50%">Updated At</th>
                    <th colspan="50%">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td colspan="50%">{{ $user->id }}</td>
                        <td colspan="50%">{{ $user->name }}</td>
                        <td colspan="50%">{{ $user->email }}</td>
                        <td colspan="50%">{{ $user->created_at }}</td>
                        <td colspan="50%">{{ $user->updated_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>