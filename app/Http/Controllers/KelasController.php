<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Kelas;

class KelasController extends Controller
{
    public function View(Request $request){

    	$kelas = Kelas::all();

    	$title = 'Delete Kelas !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Kelas.Kelas",[
            'kelas' => $kelas, 
        ]);
    }

    public function Form($id=0)
    {
    	$kelas = Kelas::find($id);
        
        return view("master.Kelas.Kelas-Input",[
            'kelas' => $kelas
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaKelas'=>'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new Kelas;
            $model->NamaKelas = $request->input('NamaKelas');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Kelas berhasil disimpan.');
                return redirect('kelas');
                
            }else{
                throw new \Exception('Penambahan Data Kelas Gagal');
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
                'NamaKelas'=>'required'
            ]);

            $model = Kelas::find($request->input('id'));

            if ($model) {
                $model->NamaKelas = $request->input('NamaKelas');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Kelas berhasil disimpan.');
                    return redirect('kelas');
                }else{
                    throw new \Exception('Edit Kelas Gagal');
                }
            } else{
                throw new \Exception('Kelas not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = DB::table('kelas')
                    ->where('id','=', $request->id)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete Kelas berhasil.');
        }
        else{
        	alert()->error('Error','Delete Kelas Gagal.');
        }
        return redirect('kelas');
    }
}
