@extends('layouts.panel')

@section('content')
<form action="{{'/schedule'}}" method="POST">
	{{csrf_field()}}
	<div class="card shadow">
		<div class="card-header border-0">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="mb-0">Gestionar horarios</h3>
				</div>
				<div class="col text-right">
					<button type="submit" class="btn btn-sm btn-success">
						Guardar Cambios
					</button>
				</div>
			</div>
		</div>
		<div class="card-body">
			@if(session('notification'))
			<div class="alert alert-success" role="alert">
				{{session('notification')}}
			</div>
			@endif
		</div>

		<div class="table-responsive">
			<!-- Projects table -->
			<table class="table align-items-center table-flush">
				<thead class="thead-light">
					<tr>
						<th scope="col">Dia</th>
						<th scope="col">Activo</th>
						<th scope="col">Turno mañana</th>
						<th scope="col">Turno tarde</th>
					</tr>
				</thead>
				<tbody>

					@foreach ($days as $key => $day)
					<tr>
						<th>{{$day}}</th>
						<td>

							<label class="custom-toggle">
								<input type="checkbox" name="active[]" value="{{$key}}">
								<span class="custom-toggle-slider round-circle"></span>
							</label>
						</td>
						<td>
							<div class="row">
								<div class="col">
									<select class="form-control" name="morning_start[]>
										@for ($i=5; $i<12; $i++)
											<option value="{{$i}}:00">{{$i}}:00am</option>
											<option value="{{$i}}:30">{{$i}}:30am</option>
										@endfor
									</select> </div>
								<div class="col">
									<select class="form-control" name="morning_end[]>
										@for ($i=5; $i<12; $i++)
											<option value="{{$i}}:00">{{$i}}:00am</option>
											<option value="{{$i}}:30">{{$i}}:30am</option>
										@endfor
									</select>
								</div>
							</div>

						</td>
						<td>
							<div class="row">
								<div class="col">
									<select class="form-control" name="afternoon_start[]>
										@for ($i=1; $i < 12; $i++)
											<option value="{{$i + 12}}:00">{{$i}}:00pm</option>
											<option value="{{$i + 12}}:30">{{$i}}:30pm</option>
										@endfor
									</select> </div>
								<div class="col">
									<select class="form-control" name="afternoon_end[]>
										@for ($i=1; $i < 12; $i++)
											<option value="{{$i + 12}}:00">{{$i}}:00pm</option>
											<option value="{{$i + 12}}:00">{{$i}}:30pm</option>
										@endfor
									</select>
								</div>
							</div>

						</td>
					</tr>
					@endforeach

				</tbody>
			</table>
		</div>
	</div>
</form>

@endsection
