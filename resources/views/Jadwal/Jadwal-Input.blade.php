@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('jadwalpelajaran')}}">JadwalPelajaran</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Jadwal Pelajaran</li>
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
										@if ($jadwalpelajaran )
                                    		Edit Jadwal Pelajaran
	                                	@else
	                                    	Tambah Jadwal Pelajaran
	                                	@endif
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
								@if ($jadwalpelajaran )
                            		<form action="{{route('jadwalpelajaran-edit')}}" method="post">
                            	@else
                                	<form action="{{route('jadwalpelajaran-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-6">
	                            			<label  class="text-body">Hari</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" name="id" id="id" value="{{ request()->id }}">
	                            				<select id="Hari" name="Hari" class="form-group Select2Combo">
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

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Jam Pelajaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select id="jam_id" name="jam_id" class="form-group Select2Combo">
	                            					<option value="-1">Pilih Jam Pelajaran</option>
	                            					@foreach($jampelajaran as $v)
	                            						<option value="{{ $v['id'] }}" {{ ($jadwalpelajaran) ? $jadwalpelajaran->jam_id == $v['id'] ? 'selected' : '' :'' }}>{{ $v['Jam'] }}</option>
	                            					@endforeach
	                            				</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Kelas</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select id="kelas_id" name="kelas_id" class="form-group Select2Combo">
	                            					<option value="-1">Pilih Kelas</option>
	                            					@foreach($kelas as $v)
	                            						<option value="{{ $v['id'] }}" {{ ($jadwalpelajaran) ? $jadwalpelajaran->kelas_id == $v['id'] ? 'selected' : '' :'' }}>{{ $v['NamaKelas'] }}</option>
	                            					@endforeach
	                            				</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Guru</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select id="guru_id" name="guru_id" class="form-group Select2Combo">
	                            					<option value="-1">Pilih Guru</option>
	                            					@foreach($guru as $v)
	                            						<option value="{{ $v['id'] }}" {{ ($jadwalpelajaran) ? $jadwalpelajaran->guru_id == $v['id'] ? 'selected' : '' :'' }} omapelid = '{{ $v['mapel_id'] }}'>{{ $v['NamaGuru'] }}</option>
	                            					@endforeach
	                            				</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Mata Pelajaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select id="mapel_id" name="mapel_id" class="form-group Select2Combo">
	                            					<option value="-1">Pilih Mata pelajaran</option>
	                            					@foreach($mapel as $v)
	                            						<option value="{{ $v['id'] }}" {{ ($jadwalpelajaran) ? $jadwalpelajaran->mapel_id == $v['id'] ? 'selected' : '' :'' }}>{{ $v['NamaMataPelajaran'] }}</option>
	                            					@endforeach
	                            				</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12">
	                            			<button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
	                            		</div>
	                            	</div>

                            	</form>
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
		jQuery(document).ready(function () {
			jQuery('.Select2Combo').select2();
		});


		jQuery('#guru_id').change(function() {
            var selectedOption = jQuery(this).find('option:selected');
            var oGuru = selectedOption.attr('omapelid');
            // console.log(oGuru)
            jQuery('#mapel_id').val(oGuru).trigger('change');
            // jQuery('#description').text(description);
        });
	})
</script>
@endpush