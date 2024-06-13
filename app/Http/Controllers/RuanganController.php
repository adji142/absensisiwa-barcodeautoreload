<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function View(Request $request){

    	$ruangan = Ruangan::all();

    	$title = 'Delete Ruangan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Ruangan.Ruangan",[
            'ruangan' => $ruangan, 
        ]);
    }

    public function Form($id=0)
    {
    	$ruangan = Ruangan::find($id);
        
        return view("master.Ruangan.Ruangan-Input",[
            'ruangan' => $ruangan
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaRuangan'=>'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new Ruangan;
            $model->NamaRuangan = $request->input('NamaRuangan');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Ruangan berhasil disimpan.');
                return redirect('ruangan');
                
            }else{
                throw new \Exception('Penambahan Data Ruangan Gagal');
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
                'NamaRuangan'=>'required'
            ]);

            $model = Ruangan::find($request->input('id'));

            if ($model) {
                $model->NamaRuangan = $request->input('NamaRuangan');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Ruangan berhasil disimpan.');
                    return redirect('ruangan');
                }else{
                    throw new \Exception('Edit Ruangan Gagal');
                }
            } else{
                throw new \Exception('Ruangan not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = DB::table('ruangan')
                    ->where('id','=', $request->id)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete Ruangan berhasil.');
        }
        else{
        	alert()->error('Error','Delete Ruangan Gagal.');
        }
        return redirect('ruangan');
    }

}
