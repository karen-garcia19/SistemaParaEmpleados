document.addEventListener("DOMContentLoaded", () =>{
	let form = document.getElementById('form_subir');

	form.addEventListener("submit" , function(event){
		event.preventDefault();
		subir__archivos(this);
	});
});

function subir__archivos(form){
	let barra_estado = form.children[1].children[0],
	span = barra_estado.children[0],
	boton_cancelar = form.children[2].children[1];

	barra_estado.classList.remove('barra_verde','barra_roja');

	let peticion = new XMLHttpRequest();

	peticion.upload.addEventListener("progress",(event) => {
		let porcentaje = Math.round((event.loaded / event.total) * 100);

		console.log(porcentaje);

		barra_estado.style.width = porcentaje +'%';
		span.innerHTML = porcentaje+ '%';
	});

	peticion.addEventListener("load",() =>{
		barra_estado.classList.add('barra_verde');
		span.innerHTML = "Proceso Completado";
	});


	peticion.open('post','subir.php');
	peticion.send(new FormData(form));


	boton_cancelar.addEventListener("click",() =>{
		peticion.abort();
		barra_estado.classList.remove('barra_verde');
		barra_estado.classList.add('barra_roja');
		span.innerHTML = "Proceso cancelado";
	});
}