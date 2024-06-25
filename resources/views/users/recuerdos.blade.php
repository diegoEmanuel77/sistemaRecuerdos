@extends('layouts.app')

@section('content')
<!-- Incluye CSS de Bootstrap y otras librerías -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body{
    background-color: rgb(235, 235, 235);
}
    /* Estilos generales */
    .container {
        margin-top: 50px;
    }

    .portada-container {
        background-color: #fff7f3; /* Fondo suave */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin-bottom: 20px;
    }

    .portada-container img {
        max-height: 300px;
        width: auto;
        border-radius: 10px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .nombre-recuerdo {
        font-size: 2.5rem;
        font-weight: bold;
        margin-top: 20px;
    }

    .descripcion-recuerdo {
        font-style: italic;
        margin-top: 10px;
    }

    /* Estilos generales */
    .container {
        margin-top: 50px;
    }

    .animated-background {
        position: absolute;
        background-size: cover;
        animation: animateBackground 10s infinite ease-in-out;
    }

    
     /* Estilos específicos para el modal de imágenes */
     .modal-imagenes .modal-content {
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        background: rgba(0, 0, 0, 0.7); /* Fondo negro con opacidad */
    }

    .modal-imagenes .modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }

    .modal-imagenes .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
    }

    .modal-imagenes .modal-body {
        padding-top: 0;
        background: rgba(0, 0, 0, 0.7); /* Fondo negro con opacidad */
    }

    .carousel-inner img {
        max-height: 80vh;
        object-fit: contain;
    }

    .carousel-controls {
        text-align: center;
        margin-top: 20px;
    }

    .carousel-controls button {
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        outline: none;
        cursor: pointer;
    }

    .carousel-controls button:hover {
        color: #007bff;
    }

    .icon-button {
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
    }

    .icon-share {
        font-size: 24px;
        color: white;
    }

    .modal-imagenes .modal-footer {
        display: flex;
        justify-content: space-between;
        border-top: none;
        padding: 10px 0;
    }

   



    .carousel-controls .carousel-control-prev,
    .carousel-controls .carousel-control-next {
        position: static;
    }

    /* Estilos para pantallas de 400px o menos */
    @media (max-width: 400px) {
        .gallery {
            grid-template-columns: repeat(2, 1fr); /* Dos columnas */
        }
    }

</style>
<style>
        .audio-container {
            display: flex;
            align-items: center;
        }
        .audio-container audio {
            display: none;
        }
        .btn-primary {
            border: none;
            background: none;
        }
        .btn-primary .fa {
            font-size: 24px;
            color: #007bff;
        }
</style>
<div class="container">
  
   
    <div class="mb-5">
    @role('administrador')
    <a href="{{route('genera',encrypt($recuerdos->id))}}" class="btn btn-success">generar QR</a>
@endrole
    
        <!-- Imagen de portada -->
        <div class="portada-container">
            <img src="{{ asset('storage/' . $recuerdos->portada) }}" alt="Portada" class="img-fluid">
            <h2 class="nombre-recuerdo">{{ $recuerdos->nombre }}</h2>
            <p class="descripcion-recuerdo">{{ $recuerdos->descripcion }}</p>
        </div>
        
        
        
        <!-- Audio -->
        <div class="audio-container">
            <audio id="audio{{ $recuerdos->id }}" src="{{ asset('storage/' . $recuerdos->audio) }}"></audio>
            <button class="btn btn-primary" onclick="togglePlayPause('audio{{ $recuerdos->id }}')">
                    <i id="playPauseIcon" class="fa fa-play"></i>
                     </button>
             </div>






        <!-- Imágenes de muestra -->
     
        <div class="container mt-4">
    <div class="collage-container">
        @foreach($recuerdos->imagenes->shuffle() as $index => $imagen)
        <div class="image-wrapper">
            <img src="{{ asset('storage/' . $imagen->url) }}" class="img-fluid" alt="Imagen" data-index="{{ $index }}">
            <div class="overlay">
                <div class="overlay-text">Ver Imagen</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Modal para visualizador de imágenes -->
<div class="modal fade modal-imagenes" id="imageViewerModal" tabindex="-1" role="dialog" aria-labelledby="imageViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl fullscreen">
        <div class="modal-content fullscreen">
            <div class="modal-header">
                <h5 class="modal-title">{{ $recuerdos->nombre }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    @foreach($recuerdos->imagenes as $index => $imagen)
                        <div class="carousel-item @if($index === 0) active @endif">
                            <img src="{{ asset('storage/' . $imagen->url) }}" class="d-block w-100" alt="Imagen">
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-download"></i> Descargar
                </button>
                <button type="button" class="btn btn-danger">
                    <i class="fas fa-volume-mute"></i> Quitar Música
                </button>
            </div>
        </div>
    </div>
</div>
<style>


.collage-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
    max-width: 800px; /* Tamaño máximo del collage */
    margin: 0 auto; /* Centrar el collage en la página */
}

.image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Transiciones suaves */
}

.image-wrapper:hover {
    transform: scale(1.05); /* Escala el contenedor al hacer hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Aumenta ligeramente la sombra */
}

.image-inner {
    width: 100%;
    height: 0;
    padding-bottom: 100%; /* Hace que el contenedor sea cuadrado (aspect ratio 1:1) */
    position: relative;
}

.img-fluid {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ajusta la imagen para llenar el contenedor */
    display: block;
    border-radius: 10px; /* Bordes redondeados */
    transition: transform 0.3s ease; /* Transición suave para transformaciones */
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Cambia el color del overlay si es necesario */
    opacity: 0;
    transition: opacity 0.3s ease, background-color 0.3s ease; /* Transiciones para overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px; /* Bordes redondeados para el overlay */
}

.overlay-text {
    color: white;
    font-size: 18px;
    font-weight: bold;
}

.image-wrapper:hover .overlay {
    opacity: 1;
    cursor: pointer;
}

@media (max-width: 600px) {
    .collage-container {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); /* Cambia el tamaño de las columnas para dispositivos móviles */
    }
}

.modal-imagenes .modal-dialog.fullscreen {
        width: 100%;
        height: 100%;
        margin: 0;
    }

    .modal-imagenes .modal-content.fullscreen {
        height: 100%;
        border: 0;
        border-radius: 0;
    }

    .modal-imagenes .modal-body {
        height: calc(100vh - 120px); /* Ajusta la altura del modal-body según tus necesidades */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-item img {
        max-height: calc(100vh - 120px); /* Ajusta la altura máxima de las imágenes */
        width: auto;
        margin: auto;
    }
</style>
<script>
   
  
   document.addEventListener('DOMContentLoaded', function() {
        var imageWrappers = document.querySelectorAll('.image-wrapper');

        imageWrappers.forEach(function(wrapper) {
            wrapper.addEventListener('click', function() {
                var index = Array.from(imageWrappers).indexOf(wrapper);
                var modal = document.getElementById('imageViewerModal');
                var carousel = document.getElementById('imageCarousel');

                // Establecer la imagen activa en el carrusel
                var carouselInstance = new bootstrap.Carousel(carousel);
                carouselInstance.to(index);

                // Mostrar el modal
                var modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            });
        });
    });

</script>

    </div>
    <div class="container">
        <h3 class="text-center">Mensajes y recuerdos publicados por familiares, amigos y conocidos.</h3>
        <div class="row">
        <div class="card-deck">
            <!-- Ejemplo de card de mensaje -->
            @foreach ($recuerdos->mensajes as $mensaje)
               <div class="col-md-4">
            <div class="card card-mensaje" onclick="showMensajeModal('{{ $mensaje->nombre }}', '{{ $mensaje->mensaje }}', '{{ $mensaje->imagen ? asset('storage/' . $mensaje->imagen) : '' }}', '{{ $mensaje->created_at->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY')  }}')">
                <div class="card-body">
                    <div class="mensaje-info">
                        <h5><i class="fas fa-envelope-open-text"></i>{{ $mensaje->nombre }}</h5>
                    </div>
                </div>
            </div>
            </div>
            @endforeach
           
          
        </div>
        </div>
    </div>

  <!-- Modal para visualizador de mensajes -->
<div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black fst-italic" id="mensajeModalLabel">Te llevamos en nuestros corazones {{ $recuerdos->nombre }}</h5>
                
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex align-items-start">
                <img src="" class="img-thumbnail mr-3" style="max-width: 150px; display: none;" alt="Imagen adjunta">
                <div>
                    <h5 class="modal-nombre mb-1 text-black"></h5>
                    <p class="modal-mensaje mb-1 text-black fst-italic"></p>
                    <small class="modal-fecha text-muted"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
   
</div>


@include('users.mensaje')
@yield('mensaje')

<script>

function showMensajeModal(nombre, mensaje, imagen, created_ad) {
        var mensajeModal = document.getElementById('mensajeModal');
        console.log(nombre);
        console.log(mensaje);
        console.log(imagen);
        console.log(created_ad);
        // Actualizar el contenido del modal
        
        var modalBodyNombre = mensajeModal.querySelector('.modal-body .modal-nombre');
        var modalBodyMensaje = mensajeModal.querySelector('.modal-body .modal-mensaje');
        var modalBodyFecha = mensajeModal.querySelector('.modal-body .modal-fecha');
        var modalBodyImagen = mensajeModal.querySelector('.modal-body img');

     
        modalBodyNombre.textContent = 'De '+ nombre;
        modalBodyMensaje.textContent = ' " '+mensaje+' " ';

    

        modalBodyFecha.textContent = created_ad;

        if (imagen) {
            modalBodyImagen.src = imagen;
            modalBodyImagen.style.display = 'block';
        } else {
            modalBodyImagen.style.display = 'none';
        }

        // Mostrar el modal
        $('#mensajeModal').modal('show');
    }

</script>


<!-- Modal con el carrusel de imágenes -->

<script>
        function togglePlayPause(audioId) {
            var audio = document.getElementById(audioId);
            var icon = document.getElementById('playPauseIcon');
            if (audio.paused) {
                audio.play();
                icon.classList.remove('fa-play');
                icon.classList.add('fa-pause');
            } else {
                audio.pause();
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');
            }
        }
    </script>
<!-- Scripts al final del documento -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar tooltips de Bootstrap
        $('[data-toggle="tooltip"]').tooltip();

        // Reproducción automática de audio
        $('audio')[0].play();
        $('audio')[0].volume = 0.5;

        // Abrir modal al hacer clic en una imagen
        $('.gallery-item').click(function() {
            var index = $(this).data('index');
            var recuerdoId = $(this).data('recuerdo-id');
            $('#carouselExampleControls').carousel(index);
            $('#imageModal').modal('show'); // Abrir el modal
            $('#imageModal').attr('data-recuerdo-id', recuerdoId); // Guardar el ID del recuerdo
        });

    });

    function adjustVolume(value) {
        $('audio')[0].volume = value;
    }
</script>

@endsection
