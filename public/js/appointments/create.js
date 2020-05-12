let $doctor, $date, $specialty, $hours;
let iRadio;
const noHoursAlert = `<div class="alert alert-danger" role="alert">
									No se encontraron horas disponibles para el medico seleccionado.
								</div>`;
$(function () {
	$specialty = $('#specialty');
	$date = $('#date')
	$doctor = $('#doctor');
	$hours = $('#hours');

	$specialty.change(() => {
		const specialtyId = $specialty.val();
		const url = `/api/specialties/${specialtyId}/doctors`;
		$.getJSON(url, onDoctorsLoaded);
	});
	$doctor.change(loadHours);
	$date.change(loadHours);
});

function onDoctorsLoaded(doctors) {
	let htmlOptions = '';
	doctors.forEach(doctor => {
		htmlOptions += `<option value ="${doctor.id}"> ${doctor.name}</option>`;
	});
	$doctor.html(htmlOptions);
	loadHours(); //Efecto colateral
}

function loadHours() {
	const selectedDate = $date.val();
	const doctorId = $doctor.val();
	const url = `/api/schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
	$.getJSON(url, displayHours);

}
function displayHours(data){
		if(!data.morning && !data.afternoon ||
			data.morning.lenght == 0 && data.morning.lenght == 0){

				$hours.html(noHoursAlert);
				return;
		}
		let htmlOurs ='';
		iRadio = 0;
		if (data.morning){
			const morning_intervals = data.morning;
			morning_intervals.forEach(interval => {
				htmlOurs += getRadioInterval(interval);
			})
		}
		if (data.afternoon){
			const afternoon_intervals = data.afternoon;
			afternoon_intervals.forEach(interval => {
				htmlOurs += getRadioInterval(interval);
			})
		}
		$hours.html(htmlOurs);
	}

	//Función para regresar Radio Button
	function getRadioInterval(interval){
		const text = `${interval.start} - ${interval.end}`;
		return `
		<div class="custom-control custom-radio mb-3">
  		<input name="scheduled_time" value="${interval.start}" class="custom-control-input" id="interval${iRadio}"
				type="radio" required>
  		<label class="custom-control-label" for="interval${iRadio++}">${text}</label>
	</div>
		`;
	}
