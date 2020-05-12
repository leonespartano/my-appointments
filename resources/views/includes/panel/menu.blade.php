   <!-- Navigation -->
   <h6 class="navbar-heading text-muted">
   	@if (auth()->user()->role == 'admin')
   		Gestionar Datos
   	@else
   		Menu
   	@endif

   </h6>
   <ul class="navbar-nav">

		@include('includes.panel.menu.'.auth()->user()->role)

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
   		<a class="nav-link" href="{{url('/charts/appointments/line')}}">
   			<i class="ni ni-collection text-yellow"></i> Frecuencia de Citas
   		</a>
   	</li>
   	<li class="nav-item">
   		<a class="nav-link" href="{{url('charts/doctors/column')}}">
   			<i class="ni ni-spaceship text-orange"></i> Médicos más activos
   		</a>
   </ul>
   @endif
