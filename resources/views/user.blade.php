@extends('template.base')
@section('content')
<div class="btn-group" role="group" aria-label="Basic example">

    @foreach($offices as $ofs)
	<form action="{{route('usercall')}}" method="POST">
		@csrf
		@method('PATCH')
		<input type="hidden" value="{{$ofs->office_name}}" name="nama_kantor">
		<input type="hidden" value="{{$ofs->capacity}}" name="kapasitas">
        <button type="submit" class="btn btn-success" title="{{$ofs->office_name}}">Office {{$ofs->id}}</button>
	</form>
    @endforeach
</div>

<hr class="rounded">

<h4>{{$usercall->office_name}}</h4>

<span>Kapasitas :</span>
<span>{{$usercall->capacity}}</span>

<span>Jumlah Kursi Kosong</span>
<span>{{$usercall->capacity - $employees}}</span>
<div class="table-responsive">
	<table class="table table-striped" id="table_employee">
		<thead>
			<tr>
				<th>No. Meja</th>
				<th>Nama</th>
				<th>Universitas</th>
				<th>Shift</th>
				<th>Tgl Mulai</th>
				<th>Tgl Selesai</th>
			</tr>
		</thead>
        <tbody>
        @foreach ($list as $lt)
            @if ($lt->end <= $tglmerah and $lt->end >= $date)
                <tr>
                    <th style="background-color: red;">{{$lt->desk}}</th>
                    <th style="background-color: red;">{{$lt->name}}</th>
                    <th style="background-color: red;">{{$lt->univ}}</th>
                    <th style="background-color: red;">{{$lt->shift}}</th>
                    <th style="background-color: red;">{{$lt->start}}</th>
                    <th style="background-color: red;">{{$lt->end}}</th>
                </tr>
                @else
                <tr>
                    <th>{{$lt->desk}}</th>
                    <th>{{$lt->name}}</th>
                    <th>{{$lt->univ}}</th>
                    <th>{{$lt->shift}}</th>
                    <th>{{$lt->start}}</th>
                    <th>{{$lt->end}}</th>
                </tr>
                @endif
            @endforeach
            @for ($i = 1; $i <= $usercall->capacity; $i++)
                @if(in_array($i,$na))
                    <!-- do nothing -->
                @else
                <tr>
                    <th>{{$i}}</th>
                    <th colspan="5" style="text-align:center">-</th>
                </tr>
                @endif
            @endfor
        </tbody>
	</table>
</div>

<!-- <script type="text/javascript">

var cell = $('dt'); 

cell.each(function() {
    cell.find('dt').each(function(i) {
        var cell_value = $(this).find('dt'),
            end = $ths.eq(5).getdate();
        }
    );
    var today = new Date(today);
    var check = end.getTime() - today.getTime() / (1000 * 3600 * 24);

    if (check > 14)
        $(this).parent().css({'background' : 'red'});
    }
);
</script> -->
<!-- <style type="text/css">
                    .table dt {
                        background-color: <?php //echo ((strtotime("$lt->end")-strtotime("now"))/(60 * 60 * 24) < 7) ? 'red' : ''?>;
                    }
                </style> -->
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
