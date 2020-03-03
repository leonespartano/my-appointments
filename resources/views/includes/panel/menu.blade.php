   <!-- Navigation -->
   <h6 class="navbar-heading text-muted">
   	@if (auth()->user()->role == 'admin')
   		Gestionar Datos
   	@else
   		Menu
   	@endif

   </h6>
   <ul class="navbar-nav">
   	@if (auth()->user()->role == 'admin')
			<li class="nav-item">
				<a class="nav-link" href="/home">
					<i class="ni ni-tv-2 text-primary"></i> Dashboard
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/specialties">
					<i class="ni ni-planet text-yellow"></i> Especialidades
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/doctors">
					<i class="ni ni-single-02 text-orange"></i> Medicos
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/patients">
					<i class="ni ni-sastified text-info"></i> Pacientes
				</a>
			</li>
   	@elseif (auth()->user()->role == 'doctor')
			<li class="nav-item">
				<a class="nav-link" href="/schedule">
					<i class="ni ni-calendar-grid-58 text-danger"></i> Gestionar horario
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/specialties">
					<i class="ni ni-time-alarm text-primary"></i> Mis Citas
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/specialties">
					<i class="ni ni-planet text-info"></i> Mis Pacientes
				</a>
			</li>
		@else {{-- patient --}}
			<li class="nav-item">
				<a class="nav-link" href="/home">
					<i class="ni ni-send text-danger"></i> Reservar Cita
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/specialties">
					<i class="ni ni-time-alarm text-primary"></i> Mis Citas
				</a>
			</li>
   	@endif
   	<li class="nav-item">
   		<a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault();
			 document.getElementById('formLogOut').submit();">
   			<i class="ni ni-key-25"></i> Cerrar Sesión
   		</a>

   		<form action="{{route('logout')}}" method="POST" style="display: none;" id="formLogOut">
   			{{ csrf_field() }}
   		</form>
   </ul>

   @if (auth()->user()->role == 'admin')
   {{-- Divider --}}
   <hr class="my-3">
   <!-- Heading -->
   <h6 class="navbar-heading text-muted">Reportes</h6>
   <!-- Navigation -->
   <ul class="navbar-nav mb-md-3">
   	<li class="nav-item">
   		<a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
   			<i class="ni ni-collection text-yellow"></i> Frecuencia de Citas
   		</a>
   	</li>
   	<li class="nav-item">
   		<a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
   			<i class="ni ni-spaceship text-orange"></i> Médicos más activos
   		</a>
   </ul>
   @endif
