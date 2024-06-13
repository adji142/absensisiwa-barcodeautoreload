<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerateBarcodeAbsensiController extends Controller
{
    public function GenerateAbsensi(Request $request){
    	$mapel = MataPelajaran::all();
    	$kelas = Kelas::all();
    	$guru = Guru::all();
    	$jadwalpelajaran = JadwalPelajaran::all();
    }
}
