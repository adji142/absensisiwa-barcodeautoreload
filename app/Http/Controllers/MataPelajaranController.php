<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function View(Request $request){

    	$matapelajaran = MataPelajaran::all();

    	$title = 'Delete MataPelajaran !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.MataPelajaran.MataPelajaran",[
            'matapelajaran' => $matapelajaran, 
        ]);
    }

    public function Form($id=0)
    {
    	$matapelajaran = MataPelajaran::find($id);
        
        return view("master.MataPelajaran.MataPelajaran-Input",[
            'matapelajaran' => $matapelajaran
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaMataPelajaran'=>'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new MataPelajaran;
            $model->NamaMataPelajaran = $request->input('NamaMataPelajaran');
            $model->Keterangan = $request->input('Keterangan');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data MataPelajaran berhasil disimpan.');
                return redirect('matapelajaran');
                
            }else{
                throw new \Exception('Penambahan Data MataPelajaran Gagal');
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
                'NamaMataPelajaran'=>'required'
            ]);

            $model = MataPelajaran::find($request->input('id'));

            if ($model) {
                $model->NamaMataPelajaran = $request->input('NamaMataPelajaran');
                $model->Keterangan = $request->input('Keterangan');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data MataPelajaran berhasil disimpan.');
                    return redirect('matapelajaran');
                }else{
                    throw new \Exception('Edit MataPelajaran Gagal');
                }
            } else{
                throw new \Exception('MataPelajaran not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = DB::table('matapelajaran')
                    ->where('id','=', $request->id)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete MataPelajaran berhasil.');
        }
        else{
        	alert()->error('Error','Delete MataPelajaran Gagal.');
        }
        return redirect('matapelajaran');
    }
}
