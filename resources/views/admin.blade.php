@extends('template.base')
@section('content')
<div class="btn-group" role="group" aria-label="Basic example">

    @foreach($offices as $ofs)
	<form action="{{route('admincall')}}" method="POST">
		@csrf
        @method('PATCH')
		<input type="hidden" value="{{$ofs->office_name}}" name="nama_kantor">
		<input type="hidden" value="{{$ofs->capacity}}" name="kapasitas">
        <button type="submit" class="btn btn-success" title="{{$ofs->office_name}}">Office {{$loop->iteration}}</button>
    </form>
    @endforeach

    <a href="{{route('inputoffice',['rand' => $randd])}}">
		<button class="btn btn-success btn-circle" title="Tambah Kantor">+</button>
	</a>
</div>

<hr class="rounded">

<h4>{{$admincall->office_name}}</h4>

<form action="{{route('updatecapacity',['kantor' => $admincall->office_name,'rand' => $randd])}}" method="POST">
    @csrf
    @method('PATCH')
    <span>Kapasitas :</span>
    <input type="number" value="{{$admincall->capacity}}" name="kapasitas">
    <button class="btn nonav">Update</button>
</form>
        
<a href="{{route('inputemployee',['rand' => $randd])}}">
    <button class="btn nonav">Tambah</button>
</a>

<span>Jumlah Kursi Kosong</span>
<span>{{$admincall->capacity - $employees}}</span>
        
<div class="table-responsive">
	<table class="table table-striped data-table" id="table_employee">
		<thead>
			<tr>
				<th>No. Meja</th>
				<th>Nama</th>
				<th>Universitas</th>
				<th>Shift</th>
				<th>Status</th>
				<th>Tgl Mulai</th>
				<th>Tgl Selesai</th>
				<th>Aksi</th>
			</tr>
		</thead>
        <tbody>
            @foreach ($list as $lt)
            @if ($lt->end <= $tglmerah and $lt->end >= $date)
                <tr>
                    <th style="background-color: #e82323;">{{$lt->desk}}</th>
                    <th style="background-color: #e82323;">{{$lt->name}}</th>
                    <th style="background-color: #e82323;">{{$lt->univ}}</th>
                    <th style="background-color: #e82323;">{{$lt->shift}}</th>
                    <th style="background-color: #e82323;">{{$lt->status}}</th>
                    <th style="background-color: #e82323;">{{$lt->start}}</th>
                    <th style="background-color: #e82323;">{{$lt->end}}</th>
                    <th style="background-color: #e82323;">
                    <a href="{{route('editemployee',['id' => $lt->id])}}"><button class="btn nonav">Edit</button></a>
                    </th>
                </tr>
                @else
                <tr>
                    <th>{{$lt->desk}}</th>
                    <th>{{$lt->name}}</th>
                    <th>{{$lt->univ}}</th>
                    <th>{{$lt->shift}}</th>
                    <th>{{$lt->status}}</th>
                    <th>{{$lt->start}}</th>
                    <th>{{$lt->end}}</th>
                    <th>
                        <a href="{{route('editemployee',['id' => $lt->id])}}"><button class="btn nonav">Edit</button></a>
                    </th>
                </tr>
                @endif
            @endforeach
            @for ($i = 1; $i <= $admincall->capacity; $i++)
                @if(in_array($i,$na))
                    <!-- do nothing -->
                @else
                <tr>
                    <th style="background-color: #5af542">{{$i}}</th>
                    <th colspan="6" style="text-align:center; background-color: #5af542" >Meja Kosong</th>
                    <th style="background-color: #5af542">
                        <a href="{{route('inputtodesk',['rand' => $randd])}}?desknum={{$i}}"><button class="btn nonav">Tambah</button></a>
                    </th>
                </tr>
                @endif
            @endfor
        </tbody>
	</table>
</div>
@endsection

@section('script')
<script>
    function sortTable() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("table_employee");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TH")[0];
                y = rows[i + 1].getElementsByTagName("TH")[0];
                if (Number(x.innerHTML) > Number(y.innerHTML)) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
</script>    
@endsection

@section('exec')
    onload="sortTable()"
@endsection