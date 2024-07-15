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

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\UserRole;

class GuruController extends Controller
{
    public function View(Request $request){

    	$guru = Guru::selectRaw("guru.*,matapelajaran.NamaMataPelajaran")
    				->leftJoin('matapelajaran','guru.mapel_id','matapelajaran.id')->get();
    	$mapel = MataPelajaran::all();

    	$title = 'Delete Guru !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Guru.Guru",[
            'guru' => $guru, 
            'mapel' => $mapel
        ]);
    }

    public function Form($id=0)
    {
    	$guru = Guru::find($id);
    	$mapel = MataPelajaran::all();
        
        // var_dump($id);
        return view("master.Guru.Guru-Input",[
            'guru' => $guru, 
            'mapel' => $mapel
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NIK'=>'required',
                'NamaGuru' => 'required',
                'Email' => 'required',
                'Phone' => 'required',
                'mapel_id' => 'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new Guru;
            $model->NIK = $request->input('NIK');
            $model->NamaGuru = $request->input('NamaGuru');
            $model->Email = $request->input('Email');
            $model->Phone = $request->input('Phone');
            $model->TempatLahir = $request->input('TempatLahir');
            $model->TanggalLahir = $request->input('TanggalLahir');
            $model->mapel_id = $request->input('mapel_id');

            $save = $model->save();

            if ($save) {

                $modelUsers = User::insertGetId([
                    'name' => $request->input('NamaGuru'),
                    'email' => $request->input('Email'),
                    'password' => Hash::make($request->input('NIK')),
                    'Active' => 'Y',
                ]);
                if ($modelUsers) {
                    $model = new UserRole;
                    $model->userid = $modelUsers;
                    $model->roleid = 2;

                    $saveRole = $model->save();
                    if (!$saveRole) {
                        throw new \Exception('Gagal Menyimpan Data Akses');
                    }

                    alert()->success('Success','Data User Berhasil disimpan.');
                    return redirect('guru');
                }
                
            }else{
                throw new \Exception('Penambahan Data Guru Gagal');
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
                'NIK'=>'required',
                'NamaGuru' => 'required',
                'Email' => 'required',
                'Phone' => 'required',
                'mapel_id' => 'required'
            ]);

            $model = Guru::find($request->input('id'));

            if ($model) {
                $model->NIK = $request->input('NIK');
	            $model->NamaGuru = $request->input('NamaGuru');
	            $model->Email = $request->input('Email');
	            $model->Phone = $request->input('Phone');
	            $model->TempatLahir = $request->input('TempatLahir');
	            $model->TanggalLahir = $request->input('TanggalLahir');
	            $model->mapel_id = $request->input('mapel_id');
                $update = $model->update();

                if ($update) {
                    $update = DB::table('users')
                            ->where('email','=', $request->input('Email'))
                            ->update(
                                [
                                    'email'=>$request->input('Email'),
                                    'name'=>$request->input('NamaGuru'),
                                ]
                            );
                    alert()->success('Success','Data Guru berhasil disimpan.');
                    return redirect('guru');
                }else{
                    throw new \Exception('Edit Guru Gagal');
                }
            } else{
                throw new \Exception('Guru not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = DB::table('guru')
                    ->where('id','=', $request->id)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete Guru berhasil.');
        }
        else{
        	alert()->error('Error','Delete Guru Gagal.');
        }
        return redirect('guru');
    }
}
