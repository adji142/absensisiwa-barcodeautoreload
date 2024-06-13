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
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\JamPelajaran;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Absensi;
use App\Models\DayConverter;
use App\Models\GenerateBarcodeAbsensi;
use Ramsey\Uuid\Uuid;

class AbsensiController extends Controller
{
    public function View(Request $request){
    	$sql = "";
    	$absensi = Absensi::selectRaw("*")->get();

    	$title = 'Delete Guru !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Absensi.Absensi",[
            'absensi' => $absensi
        ]);
    }

    public function FormGenerate()
    {
    	$oDay= new DayConverter();
    	$enDay = Carbon::now()->format('l');
    	$dayName = $oDay->ConvertDay($enDay);

    	$guru = Guru::where('Email',Auth::user()->email)->get();
    	$jadwalpelajaran = JadwalPelajaran::where('Hari',$dayName)
    						->where('guru_id',$guru[0]['id'])
    						->where('mapel_id',$guru[0]['mapel_id'])
    						->get();
    	$jamPelajaranID = array();

    	foreach ($jadwalpelajaran as $key) {
    		array_push($jamPelajaranID, $key['jam_id']);
    	}

    	$mapel = MataPelajaran::all();
        $kelas = Kelas::all();
        $jampelajaran = JamPelajaran::selectRaw("id, CONCAT(DATE_FORMAT(jampelajaran.JamMulai, '%H:%i'),' - ', DATE_FORMAT(jampelajaran.JamSelesai, '%H:%i')) Jam, Deskripsi")
        				->whereIn('id', $jamPelajaranID)
        				->get();
        
        return view("Absensi.Absensi-Generate",[
            'jadwalpelajaran' => $jadwalpelajaran, 
            'kelas' => $kelas,
            'guru' => $guru,
            'mapel' => $mapel,
            'jampelajaran' => $jampelajaran,
            'Hari' => $dayName,
            'uuid' => (string) Uuid::uuid4()
        ]);
    }

    public function GenerateQR(Request $request)
    {
        $data = array('success'=>false, 'message'=>'', 'data'=>array());

        Log::debug($request->all());
        try {
            $this->validate($request, [
                'Tanggal'=>'required',
                'jadwal_id' => 'required'
            ]);

            // Carbon::parse($request->input('check_in'))->format('Y-m-d');

            $uuid = (string) Uuid::uuid4();

            $model = new GenerateBarcodeAbsensi;
            $model->Tanggal = $request->input('Tanggal');
            $model->jadwal_id = $request->input('jadwal_id');
            $model->uuid = $uuid;
            $model->valid = 1;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                $data['uuid'] = $uuid;
            }else{
                $data['message'] = 'Generate barcode Gagal';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $data['message'] = 'Generate barcode Gagal : ' .$e->getMessage();
        }

        return response()->json($data);
    }

    public function generateQrCode(Request $request)
    {
        $text = $request->input('text', 'default text');
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($text);

        return response($qrCode, 200)->header('Content-Type', 'image/svg+xml');
    }

    public function DeActivebarcode(Request $request)
    {
        
        $data = array('success'=>false, 'message'=>'', 'data'=>array());
        try {
            $model = GenerateBarcodeAbsensi::where('uuid','=',$request->input('uuid'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('generatebarcodeabsensi')
                            ->where('uuid','=', $request->input('uuid'))
                            ->update(
                                [
                                    'valid'=>0,
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = "Deactive Failed";
                }
            } else{
                $data['message'] = "Barcode NotFound";
            }
        } catch (Exception $e) {
            $data['message'] = "Deactive Failed ". $e->getMessage();
        }

        return response()->json($data);
    }


}
