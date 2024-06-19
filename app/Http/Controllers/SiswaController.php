<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\UserRole;

class SiswaController extends Controller
{
    public function View(Request $request){

    	$siswa = Siswa::selectRaw("siswa.*, kelas.NamaKelas, tahunajaran.TahunAjaran")
    				->leftJoin('kelas','siswa.Kelas_id','kelas.id')
    				->leftJoin('tahunajaran', 'siswa.TahunAjaran','tahunajaran.id')
    				->get();

    	$title = 'Delete Siswa !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Siswa.Siswa",[
            'siswa' => $siswa, 
        ]);
    }

    public function Form($id=0)
    {
    	$siswa = Siswa::find($id);
    	$kelas = Kelas::all();
    	$tahunajaran = TahunAjaran::all();
        
        return view("master.Siswa.Siswa-Input",[
            'siswa' => $siswa,
            'kelas' => $kelas,
            'tahunajaran' => $tahunajaran
        ]);
    }

    public function FindSiswa(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

        try {
            $siswa = Siswa::selectRaw("siswa.*, kelas.NamaKelas, tahunajaran.TahunAjaran")
                    ->leftJoin('kelas','siswa.Kelas_id','kelas.id')
                    ->leftJoin('tahunajaran', 'siswa.TahunAjaran','tahunajaran.id')
                    ->get();

            $data['success'] = true;
            $data['data'] = $siswa;
        
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NIS'=>'required',
                'NamaSiswa'=>'required',
                'TahunAjaran'=>'required',
                'Email'=>'required',
                'Phone'=>'required',
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new Siswa;
            $model->NIS = $request->input('NIS');
            $model->NamaSiswa = $request->input('NamaSiswa');
			$model->TahunAjaran = $request->input('TahunAjaran');
			$model->Email = $request->input('Email');
			$model->Phone = $request->input('Phone');
			$model->TempatLahir = $request->input('TempatLahir');
			$model->TanggalLahir = $request->input('TanggalLahir');
			$model->Kelas_id = $request->input('Kelas_id');

            $save = $model->save();

            if ($save) {
            	$modelUsers = User::insertGetId([
                    'name' => $request->input('NamaSiswa'),
                    'email' => $request->input('Email'),
                    'password' => Hash::make($request->input('NIS')),
                    'Active' => 'Y',
                ]);
                if ($modelUsers) {
                    $model = new UserRole;
                    $model->userid = $modelUsers;
                    $model->roleid = 3;

                    $saveRole = $model->save();
                    if (!$saveRole) {
                        throw new \Exception('Gagal Menyimpan Data Akses');
                    }

                    alert()->success('Success','Data Siswa berhasil disimpan.');
                	return redirect('siswa');
                }

                
                
            }else{
                throw new \Exception('Penambahan Data Siswa Gagal');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'NIS'=>'required',
                'NamaSiswa'=>'required',
                'TahunAjaran'=>'required',
                'Email'=>'required',
                'Phone'=>'required',
            ]);

            $model = Siswa::find($request->input('id'));

            if ($model) {
                $model->NIS = $request->input('NIS');
	            $model->NamaSiswa = $request->input('NamaSiswa');
				$model->TahunAjaran = $request->input('TahunAjaran');
				$model->Email = $request->input('Email');
				$model->Phone = $request->input('Phone');
				$model->TempatLahir = $request->input('TempatLahir');
				$model->TanggalLahir = $request->input('TanggalLahir');
				$model->Kelas_id = $request->input('Kelas_id');
                $update = $model->update();

                if ($update) {
                	$update = DB::table('users')
                			->where('email','=', $request->input('Email'))
                			->update(
                				[
                					'email'=>$request->input('Email'),
                					'name'=>$request->input('NamaSiswa'),
                				]
                			);
                    alert()->success('Success','Data Siswa berhasil disimpan.');
                    return redirect('siswa');
                }else{
                    throw new \Exception('Edit Siswa Gagal');
                }
            } else{
                throw new \Exception('Siswa not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = DB::table('siswa')
                    ->where('id','=', $request->id)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete Siswa berhasil.');
        }
        else{
        	alert()->error('Error','Delete Siswa Gagal.');
        }
        return redirect('siswa');
    }
}
