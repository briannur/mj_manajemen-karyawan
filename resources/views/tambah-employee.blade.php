@extends('template.base')
@section('content')
<div class="container mt-5" style="width: 33%;">
    <form class="mb-4" action="{{route('createemployee')}}" style="height: 533px" method="POST">
    @csrf
    <h1 class="text-center mb-4">Tambah Karyawan</h1>
    @if(!empty($pesan))
        <div class="alert alert-danger">
            {{ $pesan }}
        </div>
    @endif
    <div class="form-group">
    <label for="meja">Meja</label>
    <select name="meja" class="form-control">
    @foreach ($avdesk[$namakantor->office_name] as $ofc)
        <option>{{ $ofc }}</option>
    @endforeach
    </select>
    </div>
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" name="nama" id="nama" required value="@if(session()->has('name')) {{ session()->pull('name') }} @endif">
    </div>
    <div class="form-group">
        <label for="univ">Universitas</label>
        <input type="text" class="form-control" name="univ" id="universitas" required value="@if(session()->has('universitas')) {{ session()->pull('universitas') }} @endif ">
    </div>
    <div class="form-group">
        <label for="shift">Shift</label>
        <select name="shift" class="form-control" id="shift">
        @foreach ($shift as $sft)
            <option value="{{ $sft }}" @if(session()->has('shift')) @if(session()->get('shift') == $sft) {{ 'selected' }} @endif @endif>{{ $sft }}</option>
        @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="kantor">Kantor</label>
        <select id="nama-kantor" name="kantor" class="form-control" onchange="deskFunct()">
        @foreach ($offices as $ofc)
            <option {{$ofc->office_name == $namakantor->office_name ? 'selected = selected' : ''}}>{{ $ofc->office_name }}</option>
        @endforeach
        </select>
    </div>

    <input type="hidden" value="aktif" name="status">

    <div class="form-group">
        <label for="mulai">Tanggal Mulai</label>
        <input type="date" class="form-control" name="mulai" id="tanggalMulai" required value="{{ session()->pull('tanggal_mulai') }}">
    </div>
    <div class="form-group">
        <label for="selesai">Tanggal Selesai</label>
        <input type="date" class="form-control" name="selesai" id="tanggalSelesai" required value="{{ session()->pull('tanggal_selesai') }}">
    </div>
    <button type="submit" id="btn-submit" class="btn btn-primary mt-3">Submit</button>
</form>
<a href="{{route('admin',['kantor' => $namakantor->office_name,'rand' => $randd])}}"><button class="btn btn-secondary mt-3" style="width: 344px;">Cancel</button></a>
<span><br><br><br><br></span>
</div>
<script src="{{asset('scripts/jquery-3.5.0.min.js')}}"></script>
<script src="{{asset('scripts/bootstrap.min.js')}}"></script>
<script>
function deskFunct() {
    var officeName = document.getElementById("nama-kantor").value;
    var name = $("#nama").val();
    var universitas = $("#universitas").val();
    var shift = $("#shift").val();
    var tanggalMulai = $("#tanggalMulai").val();
    var tanggalSelesai = $("#tanggalSelesai").val();
    
    let data = {
        _token : "{{ csrf_token() }}",
        office_name : officeName,
        name : name,
        universitas : universitas,
        shift : shift,
        tanggal_mulai : tanggalMulai,
        tanggal_selesai : tanggalSelesai,
    }
    
    console.log(data);
    
    $.ajax({ type: "PATCH",
        url: "{{ route('admincallajax') }}",
        data: data,
        success: function(result){
            window.location = "{{route('inputemployee',['rand' => $randd])}}"
        }});
    }
    </script>
    @endsection