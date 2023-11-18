<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
    <table>
        <thead>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
            <tr>
                <td>
                    <select>
                        <option>A</option>
                        <option>B</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>