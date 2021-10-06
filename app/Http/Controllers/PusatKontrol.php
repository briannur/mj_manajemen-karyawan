<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Office;
use App\Employee;
use App\Admincall;
use App\Usercall;
// use DataTables;

class PusatKontrol extends Controller
{
    public function loginAdmin()
    {
        return view('login-admin');
    }

    public function authAdmin(Request $request)
    {
        $admin = Admincall::first();
        $rand = Str::random(10000);
        
        if ($admin->password == $request->password) {
            return redirect(route('admin',['kantor' => $admin->office_name,'rand' => $rand]));
        } else {
            return view('login-admin');
        }
        
    }

    public function admin(Request $request, $kantor, $rand)
    {
        $date = Carbon::now()->format('Y-m-d');
        $tglmerah = Carbon::now()->addDays(7)->format('Y-m-d');
        $offices = Office::all();
        $admincall = Admincall::first();
        $employees = Employee::where('office',$admincall->office_name)->where('status','aktif')->where('end','>=',$date)->count();
        $list = Employee::where('office',$admincall->office_name)->where('end','>=',$date)->get();
        $randd = Str::random(10000);

        $na = Employee::where('office',$admincall->office_name)->where('status','aktif')->where('end','>=',$date)->pluck('desk')->toArray();

        return view('admin',compact('offices','admincall','employees','list','randd','tglmerah','date','na'));
    }

    public function inputEmployee(Request $request, $rand)
    {
        $offices = Office::all();
        $shift = ["07.00 - 10.00","13.00 - 17.00"];
        $namakantor = Admincall::first();
        $randd = Str::random(10000);
        $date = Carbon::now()->format('Y-m-d');
        $officelist = Office::pluck('office_name')->toArray();
        
        // asosiatif array no meja yang kosong dari masing-masing kantor
        $avdesk = array();
        // foreach($officelist as $ofc){
        $i = 0;
        for($j = 1; $j <= Office::where('office_name',$namakantor->office_name)->pluck('capacity')->first(); $j++) {
            if(!in_array($j,Employee::where('office',$namakantor->office_name)->where('status','aktif')->where('end','>=',$date)->pluck('desk')->toArray())) {
                $avdesk[$namakantor->office_name][$i] = $j;
                $i++;
            };
        };
        // };
         
        return view('tambah-employee',compact('offices','shift','namakantor','randd','avdesk','date'));
    }

    public function inputOffice($rand)
    {
        $namakantor = Admincall::first();
        $rand = Str::random(10000);

        return view('tambah-office',compact('namakantor','rand'));
    }

    public function createOffice(Request $request)
    {
        Office::create([
            'office_name' => $request->nama_kantor,
            'capacity' => $request->kapasitas
        ]);

        $namakantor = Admincall::first();
        $rand = Str::random(10000);

        return redirect(route('admin',['kantor' => $namakantor->office_name,'rand' => $rand]));
    }

    public function updateCapacity(Request $request,$kantor,$rand)
    {
        $namakantor = Admincall::first();
        
        Office::where('office_name',$namakantor->office_name)->update([
            'capacity' => $request->kapasitas,
        ]);

        Admincall::first()->update([
            'capacity' => $request->kapasitas,
        ]);

        
        $rand = Str::random(10000);

        return redirect(route('admin',['kantor' => $namakantor->office_name,'rand' => $rand]));
    }

    public function createEmployee(Request $request)
    {
        $namakantor = Admincall::first();
        $rand = Str::random(10000);
        $randd = Str::random(10000);
        $date = Carbon::now()->format('Y-m-d');
        $offices = Office::all();
        $shift = ["07.00 - 10.00","13.00 - 17.00"];

        $exist = Office::where('office_name',$request->kantor)->exists();
        $desk = Employee::where('office',$request->kantor)->where('status','aktif')->where('end','>=',$date)->where('desk',$request->meja)->exists();

        if ($exist) {
            if (!$desk) {
                Employee::create([
                    'desk' => $request->meja,
                    'name' => $request->nama,
                    'univ' => $request->univ,
                    'shift' => $request->shift,
                    'office' => $request->kantor,
                    'status' => $request->status,
                    'start' => $request->mulai,
                    'end' => $request->selesai
                ]);
    
                return redirect(route('admin',['kantor' => $namakantor->office_name,'rand' => $rand]));
            } else {
                return view('tambah-employee',compact('offices','shift','namakantor','randd'),['pesan' => "Data yang anda masukkan sudah ada"]);
            }

        } 
        else {
            return view('tambah-employee',compact('offices','shift','namakantor','randd'),['pesan' => "Data yang anda masukkan sudah ada"]);
        }
        
    }

    public function adminCall(Request $request)
    {
        $namakantor = Admincall::first();

        Admincall::first()->update([
            'office_name' => $request->nama_kantor,
            'capacity' => $request->kapasitas
        ]);
        
        
        $rand = Str::random(10000);

        return redirect(route('admin',['kantor' => $request->nama_kantor,'rand' => $rand]));
    }

    public function adminCallAjax(Request $request)
    {
        $office = Office::where('office_name', $request->office_name)->first();
        $date = Carbon::now()->format('Y-m-d');

        Admincall::first()->update([
            'office_name' => $office->office_name,
            'capacity' => $office->capacity
        ]);

        // office_name : officeName,
        // name : name,
        // universitas : universitas,
        // shift : shift,
        // tanggal_mulai : tanggalMulai,
        // tanggal_selesai : tanggalSelesai,

    

        $request->session()->put('name', $request->get('name'));
        $request->session()->put('universitas', $request->get('universitas'));
        $request->session()->put('shift', $request->get('shift'));
        $request->session()->put('tanggal_mulai', $request->get('tanggal_mulai'));
        $request->session()->put('tanggal_selesai', $request->get('tanggal_selesai'));
        
        return json_encode($request->all());
    }

    function updateAdminCall($idOffice){
        $office = Office::find($idOffice);
        Admincall::first()->update([
            "office_name" => $office->office_name,
            "capacity" => $office->capacity
        ]);

        return json_encode($office);
    }

    public function editEmployee($id)
    {
        $employees = Employee::findOrFail($id);
        $shift = ["07.00 - 10.00","13.00 - 17.00"];
        $status = ["aktif", "non-aktif"];
        $offices = Office::all();
        $namakantor = Admincall::first();
        $randd = Str::random(10000);
        $idsoffice = 

        $date = Carbon::now()->format('Y-m-d');

        // asosiatif array no meja yang kosong dari masing-masing kantor
        $avdesk = array();
        // foreach($officelist as $ofc){
        $i = 0;
        for($j = 1; $j <= Office::where('office_name',$namakantor->office_name)->pluck('capacity')->first(); $j++) {
            if(!in_array($j,Employee::where('office',$namakantor->office_name)->where('status','aktif')->where('end','>=',$date)->pluck('desk')->toArray())) {
                $avdesk[$namakantor->office_name][$i] = $j;
                $i++;
            };
        };

        return view('edit-employee',compact('employees','shift','status','offices','namakantor','randd','avdesk'));
    }

    public function updateEmployee(Request $request, $id)
    {
        // Employee::findOrFail($id)->update([
        //     'desk' => $request->meja,
        //     'name' => $request->nama,
        //     'univ' => $request->univ,
        //     'shift' => $request->shift,
        //     'office' => $request->kantor,
        //     'status' => $request->keterangan,
        //     'start' => $request->mulai,
        //     'end' => $request->selesai
        // ]);

        $namakantor = Admincall::first();
        $rand = Str::random(10000);
        
        $employees = Employee::findOrFail($id);
        $randd = Str::random(10000);
        $date = Carbon::now()->format('Y-m-d');
        $offices = Office::all();
        $shift = ["07.00 - 10.00","13.00 - 17.00"];
        $status = ["aktif", "non-aktif"];
        $theofc = Office::where('id',$request->kantor)->first();

        $desk = Employee::where('office',$request->kantor)->where('status','aktif')->where('end','>=',$date)->where('desk',$request->meja)->exists();
        $self = Employee::where('id', $id)->where('office',$request->kantor)->where('status','aktif')->where('end','>=',$date)->where('desk',$request->meja)->exists();
        
        if(!$desk) {
            Employee::findOrFail($id)->update([
                'desk' => $request->meja,
                'name' => $request->nama,
                'univ' => $request->univ,
                'shift' => $request->shift,
                'office' => $theofc->office_name,
                'status' => $request->keterangan,
                'start' => $request->mulai,
                'end' => $request->selesai
            ]);
        } elseif($self){
            Employee::findOrFail($id)->update([
                'desk' => $request->meja,
                'name' => $request->nama,
                'univ' => $request->univ,
                'shift' => $request->shift,
                'office' => $request->kantor,
                'status' => $request->keterangan,
                'start' => $request->mulai,
                'end' => $request->selesai
            ]);
        } else {
            return view('edit-employee',compact('employees','shift','status','offices','namakantor','randd'),['pesan' => "Data yang anda masukkan sudah ada"]);
        }

        return redirect(route('admin',['kantor' => $namakantor->office_name,'rand' => $rand]));
    }

    public function getUser()
    {
        $firstOffice = Usercall::first();

        return redirect(route('user',['kantor' => $firstOffice->office_name]));
    }

    public function user(Request $request, $kantor)
    {
        $date = Carbon::now()->format('Y-m-d');
        $tglmerah = Carbon::now()->addDays(7)->format('Y-m-d');

        $offices = Office::all();
        $usercall = Usercall::first();

        $employees = Employee::where('office',$kantor)->where('status','aktif')->where('end','>=',$date)->count();
        $list = Employee::where('office',$kantor)->where('status','aktif')->where('end','>=',$date)->get();

        $na = Employee::where('office',$kantor)->where('status','aktif')->where('end','>=',$date)->pluck('desk')->toArray();

        return view('user',compact('offices','usercall','employees','list','tglmerah','date', 'na'));
    }

    public function userCall(Request $request)
    {

        Usercall::first()->update([
            'office_name' => $request->nama_kantor,
            'capacity' => $request->kapasitas
        ]);
        
        $namakantor = Usercall::first();

        return redirect(route('user',['kantor' => $request->nama_kantor]));
    }

    public function assignDesk(Request $request, $rand)
    {
        $offices = Admincall::first();
        $rand = Str::random(10000);
        $randd = Str::random(10000);
        $namakantor = Admincall::first();
        $date = Carbon::now()->format('Y-m-d');
        $shift = ["07.00 - 10.00","13.00 - 17.00"];
        $desknum = $request->get('desknum');

        return view('assign-desk',compact('offices','shift','namakantor','randd','desknum'));
    }

    public function deletEmployee($id) {
        $namakantor = Admincall::first();
        $rand = Str::random(10000);

        $employee = Employee::find($id);
        $employee->delete();

        return redirect(route('admin',['kantor' => $namakantor->office_name,'rand' => $rand]));
    }
}
