@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('matapelajaran')}}">Mata Pelajaran</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Mata Pelajaran</li>
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
										@if ($matapelajaran )
                                    		Edit Mata Pelajaran
	                                	@else
	                                    	Tambah Mata Pelajaran
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
								@if ($matapelajaran )
                            		<form action="{{route('matapelajaran-edit')}}" method="post">
                            	@else
                                	<form action="{{route('matapelajaran-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama MataPelajaran</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="hidden" name="id" id="id" value="{{ request()->id }}">
	                            				<input type="text" class="form-control" id="NamaMataPelajaran" name="NamaMataPelajaran" placeholder="Masukan Nama MataPelajaran" value="{{ ($matapelajaran) ? $matapelajaran->NamaMataPelajaran : '' }}" required="" >
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-12">
	                            			<label  class="text-body">Keterangan</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="Keterangan" name="Keterangan" placeholder="Masukan Keterangan" value="{{ ($matapelajaran) ? $matapelajaran->Keterangan : '' }}" >
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
	
</script>
@endpush