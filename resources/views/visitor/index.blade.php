<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <table class="table table-bordered">
            <thead>
                <th> Antrian </th>
                <th> Nama </th>
                <th> Jenis Kelamin </th>
                <th> Tempat Lahir </th>
                <th> Tanggal Lahir </th>
                <th> Poli </th>
            </thead>
            <tbody>
                @foreach ($visitors as $item)
                    <tr>
                        <td> {{ucfirst($item->id)}} </td>
                        <td> {{ucfirst($item->name)}} </td>
                        <td> {{ucfirst($item->jenis_kelamin)}} </td>
                        <td> {{ucfirst($item->place_of_birth)}} </td>
                        <td> {{ucfirst($item->date_of_birth)}} </td>
                        <td> {{ucfirst($item->poli)}} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    
</body>
</html>