@extends('template.base')
@section('content')
<div class="container mt-5" style="width: 33%;">
    <form class="mb-4" action="{{route('createemployee')}}" style="height: 533px" method="POST">
        @csrf
        <h1 class="text-center mb-4">Tambah Karyawan</h1>

        <div class="form-group">
            <label for="meja">Meja</label>
            <input type="number" class="form-control" value="{{$desknum}}" name="meja" readonly>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="form-group">
            <label for="univ">Universitas</label>
            <input type="text" class="form-control" name="univ" required>
        </div>
        <div class="form-group">
            <label for="shift">Shift</label>
            <select name="shift" class="form-control">
                @foreach ($shift as $sft)
                <option value="{{ $sft }}" {{ (old('shift') == $sft) ? 'selected' : '' }}>{{ $sft }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="kantor">Kantor</label>
            <input type="text" class="form-control" value="{{$namakantor->office_name}}" name="kantor" readonly>
        </div>

        <input type="hidden" value="aktif" name="status">

        <div class="form-group">
            <label for="mulai">Tanggal Mulai</label>
            <input type="date" class="form-control" name="mulai" required>
        </div>
        <div class="form-group">
            <label for="selesai">Tanggal Selesai</label>
            <input type="date" class="form-control" name="selesai" required>
        </div>
        <button type="submit" id="btn-submit" class="btn btn-primary mt-3">Submit</button>
    </form>
    <a href="{{route('admin',['kantor' => $namakantor->office_name,'rand' => $randd])}}"><button class="btn btn-secondary mt-3" style="width: 344px;">Cancel</button></a>
    <span><br><br><br><br></span>
</div>
<script src="{{asset('scripts/jquery-3.5.0.min.js')}}"></script>
<script src="{{asset('scripts/bootstrap.min.js')}}"></script>
@endsection