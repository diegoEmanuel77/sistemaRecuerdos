@section('mensaje')
<div class="container mt-4">
   
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Deja tu mensaje</h5>
            <p>Escribe un mensaje honrando a {{$recuerdos->nombre}}, el mensaje podran verlo todos los amigos(as), familiares y conocidos que accedan a esta pagina a recordar nuestro ser querido que ya no esta con nosotros.  </p>
            <form id="mensajeForm" action="{{ route('recuerdos.mensaje') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <label for="nombre">Tu Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo" required>
                </div>

                <input type="hidden" name="idr" value ="{{$recuerdos->id}}">
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí" required></textarea>
                </div>
                <div class="form-group">
                        <label for="imagen">Selecciona una imagen (opcional):</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                        <div id="imagen-preview" class="mt-2"></div>
                    </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-info">Enviar Mensaje</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
<script> 
   
    var imagenPreview = document.getElementById('imagen-preview');
 // Evento de cambio de imagen de imagen seleccionada
    imagen.addEventListener('change', function() {
        var file = this.files[0];
        console.log(file);
        showImagePreview(file, imagenPreview);
    });
    function showImagePreview(file, previewElement) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail mt-2';
            previewElement.innerHTML = '';
            previewElement.appendChild(img);
        };
        reader.readAsDataURL(file);
    }</script>
@endsection