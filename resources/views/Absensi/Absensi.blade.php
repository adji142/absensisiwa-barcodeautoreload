@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Absensi</li>
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
									<h3 class="card-label mb-0 font-weight-bold text-body">Absensi 
									</h3>
								</div>
							    <div class="icons d-flex">
									<a href="{{ url('absensi-generate') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Buat barcode Absensi</a>
								
								</div>
							</div>
						
						</div>


					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-header" >
								Filter Data
							</div>

							<div class="card-body" >
								<div class="row">
									<div class="col-md-2">
										<label  class="text-body">Tanggal Awal</label>
										<input type="date" class="form-control" id="TglAwal" name="TglAwal">
									</div>
									<div class="col-md-2">
										<label  class="text-body">Tanggal Akhir</label>
										<input type="date" class="form-control" id="TglAkhir" name="TglAkhir">
									</div>
									<div class="col-md-3">
										<label  class="text-body">Kelas</label>
										<select id="kelas_id" name="kelas_id" class="js-example-basic-single js-states form-control bg-transparent">
                        					<option value="">Pilih Kelas</option>
                        					@foreach($kelas as $v)
                        						<option value="{{ $v['id'] }}">{{ $v['NamaKelas'] }}</option>
                        					@endforeach
                        				</select>
									</div>

									<div class="col-md-3">
										<label  class="text-body">Mata Pelajaran</label>
										<select id="mapel_id" name="mapel_id" class="js-example-basic-single js-states form-control bg-transparent">
                            					<option value="">Pilih Mata Pelajaran</option>
                            					@foreach($mapel as $v)
                            						<option value="{{ $v['id'] }}">{{ $v['NamaMataPelajaran'] }}</option>
                            					@endforeach
                            				</select>
									</div>

									<div class="col-md-2">
										<!-- <label  class="text-body">Status User</label> -->
										<br>
										<button type="button" class="btn btn-danger text-white font-weight-bold me-1 mb-1" id="btSearch">Cari Data</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								<div class="table-responsive" id="printableTable">
									<table id="orderTable" class="display" style="width:100%">
										<thead>
											<tr>
												<th>NIS</th>
												<th>Nama Siswa</th>
												<th>Mata Pelajaran</th>
												<th>Jam Pelajaran</th>
												<th>Kelas</th>
												<th>Tanggal Absen</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>

@endsection

@push('scripts')
<script type="text/javascript">
	jQuery(function () {
		var guru = [];
		jQuery(document).ready(function() {
			jQuery('#orderTable').DataTable({
				"pagingType": "simple_numbers",
		  
			"columnDefs": [ {
			  "targets"  : 'no-sort',
			  "orderable": false,
			}]
			});

			// 
			var now = new Date();
	    	var day = ("0" + now.getDate()).slice(-2);
	    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	    	var firstDay = now.getFullYear()+"-"+month+"-01";
	    	var NowDay = now.getFullYear()+"-"+month+"-"+day;
	    	GetDate = now.getFullYear()+"-"+month+"-"+day;

	    	jQuery('#TglAwal').val(NowDay);
	    	jQuery('#TglAkhir').val(NowDay);

	    	guru = <?php echo $guru ?>;
	    	console.log(guru);

	    	if (guru.length > 0) {
	    		jQuery('#mapel_id').val(guru[0]['mapel_id']).trigger('change');
	    		jQuery('#mapel_id').attr('disabled',true);
	    	}
	    	else{
	    		jQuery('#mapel_id').attr('disabled',false);
	    	}

	    	getData();
		});

		jQuery('#btSearch').click(function () {
			getData();
		})

		function getData() {
			$.ajax({
                async:false,
                type: 'post',
                url: "{{route('absensi-readreviewabsen')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                },
                data: {
                    'TglAwal' : jQuery('#TglAwal').val(),
                    'TglAkhir' : jQuery('#TglAkhir').val(),
                    'kelas_id' : jQuery('#kelas_id').val(),
                    'mapel_id' : jQuery('#mapel_id').val(),
                    'siswa_id' : ''
                },
                dataType: 'json',
                success: function(response) {
                    var table = jQuery('#orderTable').DataTable();
                    table.clear().draw();
                    for (var i = 0; i < response.data.length; i++) {
                    	// Things[i]
                    	// console.log(response.data[i])
      //               	<th>NIS</th>
						// <th>Nama Siswa</th>
						// <th>Mata Pelajaran</th>
						// <th>Jam Pelajaran</th>
						// <th>Kelas</th>
						// <th>Tanggal Absen</th>
						table.row.add([
		                    response.data[i]['NIS'],
		                    response.data[i]['NamaSiswa'],
		                    response.data[i]['NamaMataPelajaran'],
		                    response.data[i]['Jam'],
		                    response.data[i]['NamaKelas'],
		                    response.data[i]['FormatedAbsensiDate'],
		                ]).draw(false);
                    }
                }
            });
		}
	})
	
</script>
@endpush