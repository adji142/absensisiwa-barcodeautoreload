<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\JamPelajaran;

class JamPelajaranController extends Controller
{
    public function View(Request $request){

    	$jampelajaran = JamPelajaran::all();

    	$title = 'Delete Jam Pelajaran !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.JamPelajaran.JamPelajaran",[
            'jampelajaran' => $jampelajaran, 
        ]);
    }

    public function ViewJson(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        $jampelajaran = JamPelajaran::all();

        $data['data']= $jampelajaran;
        return response()->json($data);
    }

    public function Form($id=0)
    {
    	$jampelajaran = JamPelajaran::find($id);
        
        return view("master.JamPelajaran.JamPelajaran-Input",[
            'jampelajaran' => $jampelajaran
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'JamMulai'=>'required',
                'JamSelesai'=>'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new JamPelajaran;
            $model->Deskripsi = $request->input('Deskripsi');
            $model->JamMulai = $request->input('JamMulai');
            $model->JamSelesai = $request->input('JamSelesai');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Jam Pelajaran berhasil disimpan.');
                return redirect('jampelajaran');
                
            }else{
                throw new \Exception('Penambahan Data Jam Pelajaran Gagal');
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
                'JamMulai'=>'required',
                'JamSelesai'=>'required'
            ]);

            $model = JamPelajaran::find($request->input('id'));

            if ($model) {
                $model->Deskripsi = $request->input('Deskripsi');
                $model->JamMulai = $request->input('JamMulai');
                $model->JamSelesai = $request->input('JamSelesai');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Jam Pelajaran berhasil disimpan.');
                    return redirect('jampelajaran');
                }else{
                    throw new \Exception('Edit Jam Pelajaran Gagal');
                }
            } else{
                throw new \Exception('Jam Pelajaran not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = DB::table('jampelajaran')
                    ->where('id','=', $request->id)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete Jam Pelajaran berhasil.');
        }
        else{
        	alert()->error('Error','Delete Jam Pelajaran Gagal.');
        }
        return redirect('jampelajaran');
    }
}
