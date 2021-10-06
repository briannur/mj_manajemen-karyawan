@extends('template.base')
@section('content')
<div class="container mt-5" style="width: 33%;">
    <form class="mb-4" action="{{route('updateemployee',['id' => $employees->id])}}" style="height: 597px" method="POST">
        @csrf
        @method('PATCH')
        <h1 class="text-center mb-4">Edit Karyawan</h1>
        @if(!empty($pesan))
            <div class="alert alert-danger">
                {{ $pesan }}
            </div>
        @endif
        <div class="form-group">
        <label for="meja">Meja</label>
        <select name="meja" class="form-control">
        @php 
            $bolean = false;
        @endphp
        @foreach ($avdesk[$namakantor->office_name] as $ofc)
            @if (($namakantor->office_name == $employees->office and !$bolean) and ($ofc-1 == $employees->desk or $ofc+1 == $employees->desk))
                <option selected=selected>{{ $employees->desk }}</option>
                @php 
                    $bolean = true;
                @endphp
            @endif
            <option>{{ $ofc }}</option>
        @endforeach
        </select>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" value="{{ $employees->name }}" class="form-control" name="nama" required>
        </div>
        <div class="form-group">
            <label for="univ">Universitas</label>
            <input type="text" value="{{ $employees->univ }}" class="form-control" name="univ" required>
        </div>
        <div class="form-group">
            <label for="shift">Shift</label>
            <select name="shift" class="form-control">
                @foreach ($shift as $sft)
                <option value="{{ $sft }}" {{ ($employees->shift == $sft) ? 'selected' : '' }}>{{ $sft }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="kantor">Kantor</label>
            <select name="kantor" class="form-control" onchange="deskFunct()" id="nama-kantor">
                @foreach ($offices as $ofc)
                <option value="{{ $ofc->id }}" {{ ($namakantor->office_name == $ofc->office_name) ? 'selected' : '' }}>{{ $ofc->office_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="keterangan">Status</label>
            <select name="keterangan" class="form-control">
                @foreach ($status as $stt)
                <option value="{{ $stt }}" {{ ($employees->status == $stt) ? 'selected' : '' }}>{{ $stt }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="mulai">Tanggal Mulai</label>
            <input type="date" value="{{ $employees->start }}" class="form-control" name="mulai" required>
        </div>
        <div class="form-group">
            <label for="selesai">Tanggal Selesai</label>
            <input type="date" value="{{ $employees->end }}" class="form-control" name="selesai" required>
        </div>
        <button type="submit" id="btn-submit" class="btn btn-primary mt-3">Submit</button>
    </form>
    <form action="{{ route('deleteEmployee',['id' => $employees->id])}}" method="POST">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger mt-3" style="width: 344px;">Hapus</button>
    </form>
    <a href="{{route('admin',['kantor' => $namakantor->office_name,'rand' => $randd])}}"><button class="btn btn-secondary mt-3" style="width: 344px;">Cancel</button></a>
    <span><br><br><br><br></span>
</div>
<script src="{{asset('scripts/jquery-3.5.0.min.js')}}"></script>
<script src="{{asset('scripts/bootstrap.min.js')}}"></script>
<script>
function deskFunct() {
    var officeName = document.getElementById("nama-kantor").value;
    //console.log(data);
    
    $.ajax({ type: "GET",
        url: "{{ url('updateAdminCalls') }}/"+officeName+"/{{ $employees->id }}",
        success: function(result){
           location.reload();
        }});
    }
</script>
@endsection