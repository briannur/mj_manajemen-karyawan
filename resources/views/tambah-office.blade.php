@extends('template.base')
@section('content')
<div class="container mt-5" style="width: 33%; height: 400px;">
    <form class="mb-4" style="height: 57%;" action="{{route('createoffice')}}" method="POST">
        @csrf
        <h1 class="text-center mb-4">Tambah Kantor</h1>
        <div class="form-group">
            <label for="nama_kantor">Nama Kantor</label>
            <input type="text" class="form-control" name="nama_kantor" required>
        </div>
        <div class="form-group">
            <label for="kapasitas">Kapasitas</label>
            <input type="number" class="form-control" name="kapasitas" required>
        </div>
        <button type="submit" id="btn-submit" class="btn btn-primary mt-3">Submit</button>
    </form>
    <a href="{{route('admin',['kantor' => $namakantor->office_name,'rand' => $rand])}}"><button class="btn btn-secondary mt-3" style="width: 344px;">Cancel</button></a>
</div>
<script src="{{asset('scripts/jquery-3.5.0.min.js')}}"></script>
<script src="{{asset('scripts/bootstrap.min.js')}}"></script>
@endsection