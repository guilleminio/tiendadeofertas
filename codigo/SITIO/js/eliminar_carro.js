var myModal = document.getElementById('exampleModal')/*
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})
*/

$('#btnVaciarCarro').click(function(){
	
	$.post('backend/procesar_eliminar_carro.php',function(resultado){
		//alert(resultado);
		
		if ( resultado.error != null ){
			alert(resultado.error);
		}else{
			alert('Se ha eliminado el carro.');
			location.href = 'index.php';
		}
	},'json');

})