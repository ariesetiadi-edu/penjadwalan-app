<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengajuan Jadwal Dibatalkan</title>
</head>

<body>
    <h1>Pengajuan Jadwal Dibatalkan</h1>
    <br>
    <div>
        <h3>Deskripsi Jadwal :</h3>
        <table border="0">
            <tr>
                <td>Ruangan</td>
                <td>:</td>
                <td>{{ $schedule->room->name  }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ dateFormat($schedule->date) }}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>:</td>
                <td>{{ timeFormat($schedule->start) }} - {{ timeFormat($schedule->end) }}</td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td>{{ $schedule->description }}</td>
            </tr>
        </table>
        <hr>
        <h3>Dibatalkan Oleh :</h3>
        <table border="0">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $schedule->borrower['name'] }}</td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>:</td>
                <td>{{ $schedule->borrower->division->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $schedule->borrower['email'] }}</td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>:</td>
                <td>{{ $schedule->borrower['phone'] }}</td>
            </tr>
        </table>
        <hr>
        <h3>Alasan Pembatalan :</h3>
        <p>{{ $cancelMessage }}</p>
    </div>
</body>

</html>
