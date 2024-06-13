<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\TahunAjaran;

class TahunAjaranController extends Controller
{
    public function View(Request $request){

    	$tahunajaran = TahunAjaran::all();

    	$title = 'Delete Tahun Ajaran !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.TahunAjaran.TahunAjaran",[
            'tahunajaran' => $tahunajaran, 
        ]);
    }

    public function Form($id=0)
    {
    	$tahunajaran = TahunAjaran::find($id);
        
        return view("master.TahunAjaran.TahunAjaran-Input",[
            'tahunajaran' => $tahunajaran
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'TahunAjaran'=>'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new TahunAjaran;
            $model->TahunAjaran = $request->input('TahunAjaran');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Tahun Ajaran berhasil disimpan.');
                return redirect('tahunajaran');
                
            }else{
                throw new \Exception('Penambahan Data Tahun Ajaran Gagal');
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
                'TahunAjaran'=>'required'
            ]);

            $model = TahunAjaran::find($request->input('id'));

            if ($model) {
                $model->TahunAjaran = $request->input('TahunAjaran');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Tahun Ajaran berhasil disimpan.');
                    return redirect('tahunajaran');
                }else{
                    throw new \Exception('Edit Tahun Ajaran Gagal');
                }
            } else{
                throw new \Exception('TahunAjaran not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = DB::table('tahunajaran')
                    ->where('id','=', $request->id)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete Tahun Ajaran berhasil.');
        }
        else{
        	alert()->error('Error','Delete Tahun Ajaran Gagal.');
        }
        return redirect('tahunajaran');
    }
}
