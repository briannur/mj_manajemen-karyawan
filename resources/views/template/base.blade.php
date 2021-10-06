<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/../style/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://1.bp.blogspot.com/-ZGEyTmKb5P4/X4pv8H5zMjI/AAAAAAAAD0w/Ehhy0eLdRTUAQAb5IpH5PoewL5nt3w9nQCLcBGAsYHQ/s32-pf-e90/favicon.jpg">
    <title>Manajemen Karyawan Magang Jogja</title>
</head>
<body @yield('exec')>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <img width="35%" height="35%" src="{{ asset('M1.png') }}" class="size-large" alt="magang jogja m1" loading="lazy">
            <a class="navbar-brand" href="#">Manajemen Karyawan</a>
        </div>
    </nav>
    <div class="container bg-content mt-5">
        @yield('content')
    </div>
    @yield('script')
</body>
</html>