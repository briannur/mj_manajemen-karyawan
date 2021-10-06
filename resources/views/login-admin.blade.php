@extends('template.base')
@section('content')
<div class="container mt-5" style="width: 33%;">
    <form class="mb-4" action="{{route('authadmin')}}" method="POST">
        @csrf
        @method('POST')
        <h1 class="text-center mb-4">Admin</h1>
        <div class="form-group">
            <label for="nama_kantor">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" id="btn-submit" class="btn btn-primary mt-3">Masuk</button>
        <span><br><br><br><br></span>
    </form>
</div>
<script src="{{asset('scripts/jquery-3.5.0.min.js')}}"></script>
<script src="{{asset('scripts/bootstrap.min.js')}}"></script>
@endsection