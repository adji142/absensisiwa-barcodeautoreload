@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('guru')}}">Guru</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Guru</li>
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
										@if ($guru )
                                    		Edit Guru
	                                	@else
	                                    	Tambah Guru
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
								@if ($guru )
                            		<form action="{{route('guru-edit')}}" method="post">
                            	@else
                                	<form action="{{route('guru-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-6">
	                            			<label  class="text-body">NIK</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" name="id" id="id" value="{{ request()->id }}">
	                            				<input type="text" class="form-control" id="NIK" name="NIK" placeholder="Masukan NIK" value="{{ ($guru) ? $guru->NIK : '' }}" required="" {{ ($guru) ? "readonly" : "" }}>
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Nama Guru</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaGuru" name="NamaGuru" placeholder="Masukan Nama Guru" value="{{ ($guru) ? $guru->NamaGuru : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Email</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="email" class="form-control" id="Email" name="Email" placeholder="Masukan Email" value="{{ ($guru) ? $guru->Email : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Phone</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="number" class="form-control" id="Phone" name="Phone" placeholder="Masukan Email" value="{{ ($guru) ? $guru->Phone : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Tempat Lahir</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="TempatLahir" name="TempatLahir" placeholder="Masukan Tempat Lahir" value="{{ ($guru) ? $guru->TempatLahir : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-6">
	                            			<label  class="text-body">Tanggal Lahir</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="date" class="form-control" id="TanggalLahir" name="TanggalLahir" placeholder="Masukan Email" value="{{ ($guru) ? $guru->TanggalLahir : '' }}" required="" >
	                            			</fieldset>
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Mata Pelajaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<select class="form-control Select2Combo" id="mapel_id" name="mapel_id">
	                            					<option value="-1">Pilih Mata Pelajaran</option>
	                            					@foreach($mapel as $v)
	                            						<option value="{{ $v['id'] }}" {{ ($guru) ? $guru->mapel_id == $v['id'] ? 'selected' : '' :'' }}>{{ $v['NamaMataPelajaran'] }}</option>
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