@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('siswa')}}">Siswa</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Siswa</li>
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
										@if ($siswa )
                                    		Edit Siswa
	                                	@else
	                                    	Tambah Siswa
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
								@if ($siswa )
                            		<form action="{{route('siswa-edit')}}" method="post">
                            	@else
                                	<form action="{{route('siswa-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-6">
	                            			<label  class="text-body">NIS</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" name="id" id="id" value="{{ request()->id }}">
	                            				<input type="text" class="form-control" id="NIS" name="NIS" placeholder="Masukan NIS" value="{{ ($siswa) ? $siswa->NIS : '' }}" required="" {{ ($siswa) ? "readonly" : "" }}>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Nama Siswa</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaSiswa" name="NamaSiswa" placeholder="Masukan Nama Siswa" value="{{ ($siswa) ? $siswa->NamaSiswa : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Email</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="email" class="form-control" id="Email" name="Email" placeholder="Masukan Email" value="{{ ($siswa) ? $siswa->Email : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Phone</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="Phone" name="Phone" placeholder="Masukan Email" value="{{ ($siswa) ? $siswa->Phone : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Tempat Lahir</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="TempatLahir" name="TempatLahir" placeholder="Masukan Tempat Lahir" value="{{ ($siswa) ? $siswa->TempatLahir : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Tanggal Lahir</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="date" class="form-control" id="TanggalLahir" name="TanggalLahir" placeholder="Masukan Email" value="{{ ($siswa) ? $siswa->TanggalLahir : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Kelas</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select class="form-control Select2Combo" id="Kelas_id" name="Kelas_id">
	                            					<option value="-1">Pilih Kelas</option>
	                            					@foreach($kelas as $v)
	                            						<option value="{{ $v['id'] }}" {{ ($siswa) ? $siswa->Kelas_id == $v['id'] ? 'selected' : '' :'' }}>{{ $v['NamaKelas'] }}</option>
	                            					@endforeach
	                            				</select>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Tahun Ajaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select class="form-control Select2Combo" id="TahunAjaran" name="TahunAjaran">
	                            					<option value="-1">Pilih Tahun Ajaran</option>
	                            					@foreach($tahunajaran as $v)
	                            						<option value="{{ $v['id'] }}" {{ ($siswa) ? $siswa->TahunAjaran == $v['id'] ? 'selected' : '' :'' }}>{{ $v['TahunAjaran'] }}</option>
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
		})
	})
</script>
@endpush