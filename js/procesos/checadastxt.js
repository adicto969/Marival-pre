function checadastxt() {
  var input = document.getElementById('archivotxt'), formdata = false;
  var i = 0, len = input.files.length, img, reader, file;
  var Archivo = document.getElementById('archivotxt').value;

  formdata = new FormData();
  extension = (Archivo.substring(Archivo.lastIndexOf("."))).toLowerCase();
  console.log(extension);
  if(extension == ".xls" || extension == ".txt"){
    document.getElementById('estado_consulta_ajax').innerHTML = 'Subiendo...';

    file = input.files[0];
    //console.log(file.type);
    //Una pequeña validación para subir imágenes
    //Si el navegador soporta el objeto FileReader
    reader = new FileReader();
    //Llamamos a este evento cuando la lectura del archivo es completa
    //Después agregamos la imagen en una lista
    reader.onloadend = function(e){

    };
    //Comienza a leer el archivo
    //Cuando termina el evento onloadend es llamado
    reader.readAsDataURL(file);

    //Usamos el método append, cuyos parámetros son:
    //name : El nombre del campo
    //value: El valor del campo (puede ser de tipo Blob, File e incluso string)
    formdata.append('Archivo[]', file);


    $.ajax({
       url : 'ajax.php?modo=checadastxt',
       type : 'POST',
       data : formdata,
       processData : false,
       contentType : false,
       beforeSend: function()
       {
         resultado = '<div class="progress">';
         resultado += '<div class="indeterminate"></div>';
         resultado += '</div>';
         $("#estado_consulta_ajax").html(resultado);
       }
       }).done(function(datos){
         $("#estado_consulta_ajax").html(datos);
         var Dimensiones = AHD();
         if(Dimensiones[3] > Dimensiones[1]){
           $('#pie').css("position", "inherit");
         }else {
           $('#pie').css("position", "absolute");
         }
       }).fail(function(){
         $("#estado_consulta_ajax").html("ERROR");
       });

  }else {
    Materialize.toast('El Archivo tiene que ser .xls o .txt', 3000);
  }

}
