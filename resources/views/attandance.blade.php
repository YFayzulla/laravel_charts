<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>December Attendance Table</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">December 2024</h2>
    <table class="table table-bordered text-center">
        <thead>
        <tr>
            <th>Name</th>
            @for ($i = 1; $i <= 31; $i++)
                <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $name => $days)
            <tr>
                <td>{{ $name }}</td>
                @for ($i = 1; $i <= 31; $i++)
                    @php
                        $day = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $status = $days[$day] ?? '';
                        // Example condition to highlight cells; you can adjust this based on your needs
                        $isDanger = $status === 'Absent'; // Change this condition as needed
                    @endphp
                    <td class="{{ $isDanger ? 'bg-danger text-white' : '' }}">
                        {{ $status }}
                    </td>
                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>




