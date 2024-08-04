@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('absensi')}}">Absensi</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Buat barcode Absensi</li>
			</ol>
		</nav>
	</div>
</div>
<!--end::Subheader-->
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 px-4">
				<div class="row">
					<div class="col-lg-12 col-xl-12 px-4">
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0" >
							<div class="card-header align-items-center  border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">
										Buat barcode Absensi
									</h3>
								</div>
							</div>
						
						</div>


					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="form-group row">
                            		<div class="col-md-4">
                            			<label  class="text-body">Hari</label>
                            			<fieldset class="form-group mb-3">
                            				<select id="Hari" name="Hari" class="form-group Select2Combo" disabled="">
                            					<option value="Senin">Senin</option>
                            					<option value="Selasa">Selasa</option>
                            					<option value="Rabu">Rabu</option>
                            					<option value="Kamis">Kamis</option>
                            					<option value="Jumat">Jumat</option>
                            					<option value="Sabtu">Sabtu</option>
                            					<option value="Minggu">Minggu</option>
                            				</select>
                            			</fieldset>
                            		</div>
                            		<div class="col-md-4">
                            			<label  class="text-body">Guru</label>
                            			<fieldset class="form-group mb-3">
                            				<select id="guru_id" name="guru_id" class="form-group Select2Combo"  disabled="">
                            					<option value="">Pilih Guru</option>
                            					@foreach($guru as $v)
                            						<option value="{{ $v['id'] }}">{{ $v['NamaGuru'] }}</option>
                            					@endforeach
                            				</select>
                            			</fieldset>
                            		</div>
                            		<div class="col-md-4">
                            			<label  class="text-body">Mata Pelajaran</label>
                            			<fieldset class="form-group mb-3">
                            				<select id="mapel_id" name="mapel_id" class="form-group Select2Combo"  disabled="">
                            					<option value="">Pilih Mata pelajaran</option>
                            					@foreach($mapel as $v)
                            						<option value="{{ $v['id'] }}">{{ $v['NamaMataPelajaran'] }}</option>
                            					@endforeach
                            				</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Kelas</label>
                            			<fieldset class="form-group mb-3">
                            				<select id="kelas_id" name="kelas_id" class="form-group Select2Combo">
                            					<option value="">Pilih Kelas</option>
                            					@foreach($kelas as $v)
                            						<option value="{{ $v['id'] }}">{{ $v['NamaKelas'] }}</option>
                            					@endforeach
                            				</select>
                            			</fieldset>
                            		</div>

                            		<div class="col-md-6">
                            			<label  class="text-body">Jam Pelajaran</label>
                            			<fieldset class="form-group mb-3">
                            				<select id="jam_id" name="jam_id" class="form-group Select2Combo">
                            					<option value="">Pilih Jam Pelajaran</option>
                            					@foreach($jampelajaran as $v)
                            						<option value="{{ $v['id'] }}">{{ $v['Jam'] }}</option>
                            					@endforeach
                            				</select>
                                            <input type="hidden" name="JadwalID" id="JadwalID">
                            			</fieldset>
                            		</div>

                            		<div class="col-md-12">
                            			<button type="button" id="btGenerateQRCode" class="btn btn-success text-white font-weight-bold me-1 mb-1">Buat Barcode</button>

                                        <button type="button" id="btScanQRCode" class="btn btn-warning text-white font-weight-bold me-1 mb-1">Scan Barcode</button>
                            		</div>
                            	</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>


<div class="modal fade" id="QRCodeAbsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalScrollableTitle">Absen Siswa</h5>
              <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
                <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                </svg>
              </button>
            </div>
            <div class="modal-body">
                <h2><center><b>SCAN BARCODE DISINI</b></center></h2>
                <!-- <div id="QRCode"></div> -->
                <center><img id="QRCode"></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btSelesaiAbsen"> 
                    <span class="">Selesai</span>
                </button>
            </div>      
        </div>
    </div>
</div>

<div class="modal fade" id="QRCodeScanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalScrollableTitle">Absen Siswa</h5>
              <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-bs-dismiss="modal" aria-label="Close">
                <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                </svg>
              </button>
            </div>
            <div class="modal-body">
                <div id="QRreader" style="width:100%;"></div>
                <p id="QRresult"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="btSelesaiAbsen"> 
                    <span class="">Selesai</span>
                </button>
            </div>      
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('node_modules/html5-qrcode/html5-qrcode.min.js') }}"></script>
<script type="text/javascript">
	jQuery(function () {
        var LastUUID = "";
        var count = 0;
        let html5QrcodeScanner = new Html5QrcodeScanner("QRreader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
        function onScanSuccess(decodedText, decodedResult) {
            let now = new Date();

            let year = now.getFullYear();
            let month = ("0" + (now.getMonth() + 1)).slice(-2); // Months are zero-based
            let day = ("0" + now.getDate()).slice(-2);
            let hours = ("0" + now.getHours()).slice(-2);
            let minutes = ("0" + now.getMinutes()).slice(-2);
            let seconds = ("0" + now.getSeconds()).slice(-2);
            var CreatedBy = "<?php echo Auth::user()->name; ?>";
            // Handle the scanned code as you like
            // document.getElementById('QRresult').innerText = `Scanned result: ${decodedText}`;
            $.ajax({
                async:false,
                type: 'post',
                url: "{{route('insertabsen')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                },
                data: {
                    'jadwal_id' : jQuery('#JadwalID').val(),
                    'TanggalAbsen' : year+"-"+month+"-"+day+" "+hours+":"+minutes+":"+seconds,
                    'siswa_id' : decodedText,
                    'barcode_id' : generateRandomString(25),
                    'CreatedBy' : CreatedBy,
                    'source' : 'Web'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            text: "Berhasil Absen",
                            icon: "success",
                            title: "Horray...",
                            // text: "Data berhasil disimpan! <br> " + response.Kembalian,
                        });
                    }
                    else{
                        Swal.fire({
                            text: response.message,
                            icon: "error",
                            title: "Ups...",
                            // text: "Data berhasil disimpan! <br> " + response.Kembalian,
                        });
                    }
                }
            });

        }

		jQuery(document).ready(function () {
			jQuery('.Select2Combo').select2();
			// console.log('<?php echo $uuid ?>')
			var Jadwal = <?php echo $jadwalpelajaran ?>;

            // console.log(Jadwal);

			$.each(Jadwal,function (k,v) {
				jQuery('#guru_id').val(v.guru_id).trigger('change')
				jQuery('#mapel_id').val(v.mapel_id).trigger('change')
                jQuery('#Hari').val(v.Hari).trigger('change')
			});

            SetEnableCommand();
            // loopFunction();
		});

        jQuery('#btGenerateQRCode').click(function () {
            jQuery('#QRCodeAbsen').modal({backdrop: 'static', keyboard: false})
            jQuery('#QRCodeAbsen').modal('show');

            loopFunction()
            
        });

        jQuery('#btScanQRCode').click(function () {
            jQuery('#QRCodeScanner').modal({backdrop: 'static', keyboard: false})
            jQuery('#QRCodeScanner').modal('show');

            loopFunction()
            
        });


		jQuery('#guru_id').change(function() {
            var selectedOption = jQuery(this).find('option:selected');
            var oGuru = selectedOption.attr('omapelid');
            // console.log(oGuru)
            jQuery('#mapel_id').val(oGuru).trigger('change');
            SetEnableCommand();
            // jQuery('#description').text(description);
        });
        jQuery('#Hari').change(function () {
            SetEnableCommand();
        });
        jQuery('#mapel_id').change(function () {
            SetEnableCommand();
        });
        jQuery('#kelas_id').change(function () {
            GetJadwal();
            SetEnableCommand();
        });
        jQuery('#jam_id').change(function () {
            GetJadwal();
            SetEnableCommand();
        });

        function loopFunction() {
            console.log('Loop iteration: ' + count);

            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');

            var firstDay = now.getFullYear()+"-"+month+"-01";
            var NowDay = now.getFullYear()+"-"+month+"-"+day;

            var _Tanggal = NowDay;
            var _Jam = hours+":"+minutes+":"+seconds;

            DeActiveBarcode(LastUUID);
            
            $.ajax({
                async:false,
                type: 'post',
                url: "{{route('absensi-generatecode')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                },
                data: {
                    'Tanggal' : _Tanggal + " "+_Jam,
                    'jadwal_id' : jQuery('#JadwalID').val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {
                        LastUUID = response.uuid;
                        GenerateQRCode(LastUUID);
                    }
                    else{
                        console.log(response.message)
                    }
                }
            });

            count++;

            // Set a condition to break out of the loop
            if (count < 1000) {
                setTimeout(loopFunction, 60000); // Delay of 1 second (1000 milliseconds)
            }
        }

        function GetJadwal() {
            $.ajax({
                async:false,
                type: 'post',
                url: "{{route('jadwalpelajaran-getjson')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                },
                data: {
                    'Hari' : jQuery('#Hari').val(),
                    'guru_id' : jQuery('#guru_id').val(),
                    'mapel_id' : jQuery('#mapel_id').val(),
                    'kelas_id' : jQuery('#kelas_id').val(),
                    'jam_id' : jQuery('#jam_id').val(),
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    if (response.data.length >0) {
                        jQuery('#JadwalID').val(response.data[0]['id']);
                    }
                    else{
                        jQuery('#JadwalID').val('');   
                    }
                }
            });
        }

        function DeActiveBarcode(text) {
            $.ajax({
                async:false,
                type: 'post',
                url: "{{route('absensi-deactivebarcode')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                },
                data: {
                    'uuid' : text
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    if (response.success == true) {
                        console.log('Good')
                    }
                    else{
                        console.log("Faiiled " + response.message)
                        
                    }
                }
            });
        }
        function GenerateQRCode(text) {
            // console.log(uuid)
            var xUrl = "{{ url('/') }}";
            console.log(xUrl)

            jQuery('#QRCode').attr('src', xUrl+"/generate-qr-code?text="+text);
        }

        function SetEnableCommand() {
            var errorCount = 0;

            if (jQuery('#Hari').val() == "") {
                errorCount +=1;
            }
            if (jQuery('#guru_id').val() == "") {
                errorCount +=1;
            }
            if (jQuery('#mapel_id').val() == "") {
                errorCount +=1;
            }
            if (jQuery('#kelas_id').val() == "") {
                errorCount +=1;
            }
            if (jQuery('#jam_id').val() == "") {
                errorCount +=1;
            }
            if (jQuery('#JadwalID').val() == "") {
                errorCount +=1;
            }


            console.log(errorCount)

            if (errorCount > 0) {
                jQuery('#btGenerateQRCode').attr('disabled',true);
                jQuery('#btScanQRCode').attr('disabled',true);
            }
            else{
                jQuery('#btGenerateQRCode').attr('disabled',false);
                jQuery('#btScanQRCode').attr('disabled',false);
            }
        }

        function generateRandomString(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const charactersLength = characters.length;
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
	});
</script>
@endpush