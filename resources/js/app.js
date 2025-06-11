// Se importa la libreria de dropzone y en app.blade.php se importa asi @vite('resources/js/app.js')
import Dropzone from "dropzone";


Dropzone.autoDiscover = false;
// configuracion del boton de subir imagen mediante DropZone
const dropzone = new Dropzone("#dropzone",{
    dictDefaultMessage: "Sube aqui tu imagen",
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true, // Con la posibilidad de que el usuario borre su imagen
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,// maximo
    uploadMultiple:false, // solo admite 1 imagen

    // Init se inicia la funcion y Se ejecuta cuando dropzone es inicializado y si tiene algo
    init: function(){
        // Si hay algo para seleccionar se oprime el boton de "crear publicacion", no desaparecera la imagen de dropzone
        if(document.querySelector('[name="imagen"]').value.trim()){
            const imagenPublicada = {}
            imagenPublicada.size = 1234; // Objeto que se le asignan valores 
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            // call es para las llamadas a la funcion
            this.options.addedfile.call(this, imagenPublicada);
            this.opcions.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            // Clases de dropzone cuando se muestra cuando ya se
            imagenPublicada.previewELement.classList.add('dz-success','dz-complete');

            
        }
    }
});

// un evento donde se ven las acciones de envio pasandole los parametroa a la funcion de lo que recibe en consola dropzone
// dropzone.on('sending', function(file, xhr, formData){
//     console.log(file);
// })

// Evento donde pasa lo que ya se realizo
dropzone.on('success', function(file, response){
    console.log(response.imagen);// el ".imagen es del return del controlador que tiene "imagenController en la consola solo mostrara el ID y no mas detalles"
    document.querySelector('[name="imagen"]').value = response.imagen; // el name es traido del input que tiene de name="imagen" de tipo hidden
    // cuando subes un documento, debe de generar un value para el id de la imagen
})
//Evento de vaciar el id del value del input del tipo "hidden", cuando quite la imagen de dropzone para poner otro
dropzone.on('removedfile', function(){
    document.querySelector('[name="imagen"]').value = "";
})

// // Evento donde pasa lo que ya se realizo, se le pasa el message del error
// dropzone.on('error', function(file, message){
//     console.log(message);
// })

// // Evento donde pasa lo que ya se realizo
// dropzone.on('removedfile', function(file, response){
//     console.log('Archivo eliminado');
// })