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
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();

        $guru = Guru::where('email', Auth::user()->email)->get();

    	$title = 'Delete Guru !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Absensi.Absensi",[
            'absensi' => $absensi,
            'kelas' => $kelas,
            'mapel' => $mapel,
            'guru' => $guru
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

    public function CheckBarcodeAbsensi(Request $request){
        $data = array('success'=>false, 'message'=>'', 'data'=>array());

        try {
            $model = GenerateBarcodeAbsensi::where('uuid','=',$request->input('uuid'))
                        ->where(DB::raw("DATE(Tanggal)"),"=", $request->input('Tanggal'))
                        ->first();

            if ($model) {
                if ($model->valid == 0) {
                    $data["message"] = "Barcode tidak Valid";
                }
                else{
                    $data['success'] = true;
                    $data['data'] = $model;
                }
            }
            else{
                $data["message"] = "Barcode Tidak Ada";
            }
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);

    }

    public function ShowDataAbsensi(Request $request)
    {
        $data = array('success'=>false, 'message'=>'', 'data'=>array());

        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $kelas_id = $request->input('kelas_id');
        $mapel_id = $request->input('mapel_id');
        $siswa_id = $request->input('siswa_id');

        try {
            $sql = "absensi.*,DATE_FORMAT(absensi.TanggalAbsen, '%d-%m-%Y %T') FormatedAbsensiDate, CONCAT(DATE_FORMAT(jampelajaran.JamMulai, '%H:%i'),' - ', DATE_FORMAT(jampelajaran.JamSelesai, '%H:%i')) Jam, kelas.NamaKelas, guru.NamaGuru, matapelajaran.NamaMataPelajaran, siswa.NamaSiswa, siswa.NIS ";
            $oAbsen = Absensi::selectRaw($sql)
                        ->leftJoin('jadwalpelajaran', 'absensi.jadwal_id', 'jadwalpelajaran.id')
                        ->leftJoin('matapelajaran','jadwalpelajaran.mapel_id','matapelajaran.id')
                        ->leftJoin('jampelajaran', 'jadwalpelajaran.jam_id', 'jampelajaran.id')
                        ->leftJoin('kelas', 'jadwalpelajaran.kelas_id','kelas.id')
                        ->leftJoin('guru', 'jadwalpelajaran.guru_id', 'guru.id')
                        ->leftJoin('siswa', 'absensi.siswa_id','siswa.id')
                        ->whereBetween(DB::raw("DATE(absensi.TanggalAbsen)"), [$TglAwal, $TglAkhir]);
            if ($kelas_id != "") {
                $oAbsen->where('jadwalpelajaran.kelas_id', $kelas_id);
            }
            if ($mapel_id != "") {
                $oAbsen->where('jadwalpelajaran.mapel_id', $mapel_id);
            }
            if ($siswa_id != "") {
                $oAbsen->where('absensi.siswa_id', $siswa_id);
            }

            $data['success'] = true;
            $data['data'] = $oAbsen->get();
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function ShowReviewAbsensi(Request $request)
    {
        $data = array('success'=>false, 'message'=>'', 'data'=>array());

        $Tanggal = $request->input('Tanggal');
        $Hari = $request->input('Hari');
        $Siswa_ID = $request->input('Siswa_ID');

        try {
            $oAbsen = DB::select('CALL fsp_getReviewAbsen(?, ?, ?)', [$Tanggal, $Hari, $Siswa_ID]);

            $data['success'] = true;
            $data['data'] = $oAbsen;
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function insertAbsensi(Request $request)
    {
        $data = array('success'=>false, 'message'=>'', 'data'=>array());

        try {

            $find = Absensi::where('jadwal_id',$request->input('jadwal_id'))
                    ->where('siswa_id', $request->input('siswa_id'))->get();
            if (count($find) > 0) {
                $data['message'] = "Anda Sudah Absen pada jadwal pelajaran ini !";
                goto jump;
            }

            $model = new Absensi;
            $model->jadwal_id = $request->input('jadwal_id');
            $model->TanggalAbsen = $request->input('TanggalAbsen');
            $model->siswa_id = $request->input('siswa_id');
            $model->barcode_id = $request->input('barcode_id');
            $model->CreatedBy = $request->input('CreatedBy');

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                $data['message'] = "Berhasil Absen";
                
            }else{
                $data['success'] = false;
                $data['message'] = "Absen Gagal";
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }
        jump:

        return response()->json($data);
    }


}
