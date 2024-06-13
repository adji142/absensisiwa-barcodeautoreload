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

use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\JamPelajaran;
use App\Models\Kelas;
use App\Models\Guru;

class JadwalPelajaranController extends Controller
{
    public function View(Request $request){


    	$KelasID = $request->input('KelasID');
    	$GuruID = $request->input('GuruID');
        $Hari = $request->input('Hari');

        $sql = "jadwalpelajaran.*, CONCAT(DATE_FORMAT(jampelajaran.JamMulai, '%H:%i'),' - ', DATE_FORMAT(jampelajaran.JamSelesai, '%H:%i')) Jam, kelas.NamaKelas, guru.NamaGuru, matapelajaran.NamaMataPelajaran";
    	$jadwalpelajaran = JadwalPelajaran::selectRaw($sql)
    				->leftJoin('matapelajaran','jadwalpelajaran.mapel_id','matapelajaran.id')
                    ->leftJoin('jampelajaran', 'jadwalpelajaran.jam_id', 'jampelajaran.id')
                    ->leftJoin('kelas', 'jadwalpelajaran.kelas_id','kelas.id')
                    ->leftJoin('guru', 'jadwalpelajaran.guru_id', 'guru.id');
    	$mapel = MataPelajaran::all();
    	$kelas = Kelas::all();
    	$guru = Guru::all();

        if ($Hari != "") {
            $jadwalpelajaran->where('jadwalpelajaran.Hari',$Hari);
        }
        if ($KelasID != "") {
            $jadwalpelajaran->where('jadwalpelajaran.kelas_id',$KelasID);
        }
        if ($GuruID != "") {
            $jadwalpelajaran->where('jadwalpelajaran.guru_id',$GuruID);
        }

    	$title = 'Delete Jadwal Pembelajaran !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Jadwal.Jadwal",[
            'jadwalpelajaran' => $jadwalpelajaran->get(), 
            'kelas' => $kelas,
            'guru' => $guru,
            'mapel' => $mapel,
            'oldHari' =>$Hari,
            'oldGuru' => $GuruID,
            'oldKelas' => $KelasID
        ]);
    }

    public function getJadwalJson(Request $request)
    {
        $data = array('success'=>false, 'message'=>'', 'data'=>array());

        $Hari = $request->input('Hari');
        $guru_id = $request->input('guru_id');
        $mapel_id = $request->input('mapel_id');
        $kelas_id = $request->input('kelas_id');
        $jam_id = $request->input('jam_id');

        $sql = "jadwalpelajaran.*, CONCAT(DATE_FORMAT(jampelajaran.JamMulai, '%H:%i'),' - ', DATE_FORMAT(jampelajaran.JamSelesai, '%H:%i')) Jam, kelas.NamaKelas, guru.NamaGuru, matapelajaran.NamaMataPelajaran";
        $jadwalpelajaran = JadwalPelajaran::selectRaw($sql)
                    ->leftJoin('matapelajaran','jadwalpelajaran.mapel_id','matapelajaran.id')
                    ->leftJoin('jampelajaran', 'jadwalpelajaran.jam_id', 'jampelajaran.id')
                    ->leftJoin('kelas', 'jadwalpelajaran.kelas_id','kelas.id')
                    ->leftJoin('guru', 'jadwalpelajaran.guru_id', 'guru.id')
                    ->where('jadwalpelajaran.Hari', $Hari)
                    ->where('jadwalpelajaran.guru_id', $guru_id)
                    ->where('jadwalpelajaran.mapel_id', $mapel_id)
                    ->where('jadwalpelajaran.kelas_id', $kelas_id)
                    ->where('jadwalpelajaran.jam_id', $jam_id)->get();

        $data['data'] = $jadwalpelajaran;
        return response()->json($data);
    }

    public function Form($id=0)
    {
    	$jadwalpelajaran = JadwalPelajaran::find($id);
    	$mapel = MataPelajaran::all();
        $kelas = Kelas::all();
        $guru = Guru::all();
        $jampelajaran = JamPelajaran::selectRaw("id, CONCAT(DATE_FORMAT(jampelajaran.JamMulai, '%H:%i'),' - ', DATE_FORMAT(jampelajaran.JamSelesai, '%H:%i')) Jam, Deskripsi")->get();
        
        return view("Jadwal.Jadwal-Input",[
            'jadwalpelajaran' => $jadwalpelajaran, 
            'kelas' => $kelas,
            'guru' => $guru,
            'mapel' => $mapel,
            'jampelajaran' => $jampelajaran
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'Hari'=>'required',
                'jam_id' => 'required',
                'kelas_id' => 'required',
                'guru_id' => 'required',
                'mapel_id' => 'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');
            $model = new JadwalPelajaran;
            $model->Hari = $request->input('Hari');
            $model->jam_id = $request->input('jam_id');
            $model->kelas_id = $request->input('kelas_id');
            $model->guru_id = $request->input('guru_id');
            $model->mapel_id = $request->input('mapel_id');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Jadwal Berhasil disimpan.');
                return redirect('jadwalpelajaran');
                
            }else{
                throw new \Exception('Penambahan Data Jadwal Pelajaran Gagal');
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
                'Hari'=>'required',
                'jam_id' => 'required',
                'kelas_id' => 'required',
                'guru_id' => 'required',
                'mapel_id' => 'required'
            ]);

            $model = JadwalPelajaran::find($request->input('id'));

            if ($model) {
                $model->Hari = $request->input('Hari');
	            $model->jam_id = $request->input('jam_id');
	            $model->kelas_id = $request->input('kelas_id');
	            $model->guru_id = $request->input('guru_id');
	            $model->mapel_id = $request->input('mapel_id');
                $update = $model->update();

                if ($update) {
                    alert()->success('Success','Data Jadwal Pelajaran berhasil disimpan.');
                    return redirect('jadwalpelajaran');
                }else{
                    throw new \Exception('Edit Jadwal Pelajaran Gagal');
                }
            } else{
                throw new \Exception('Jadwal Pelajaran not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = DB::table('jadwalpelajaran')
                    ->where('id','=', $request->id)
                    ->delete();

        if ($user) {
        	alert()->success('Success','Delete JadwalPelajaran berhasil.');
        }
        else{
        	alert()->error('Error','Delete JadwalPelajaran Gagal.');
        }
        return redirect('jadwalpelajaran');
    }
}
