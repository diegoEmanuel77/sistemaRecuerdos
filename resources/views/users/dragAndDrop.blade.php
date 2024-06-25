@section('drag')

<div id="drop-area" class="form-group border rounded p-4">
    <h5 class="mb-3">Arrastra imágenes aquí o haz clic para seleccionar</h5>
    <div class="custom-file">
        <input type="file" id="images" name="imagenes[]" class="custom-file-input" accept="image/*" multiple>
        <label class="custom-file-label" for="images">Selecciona imágenes</label>
    </div>
    <div id="preview" class="d-flex flex-wrap mt-3"></div>
</div>

<script>
    var dropArea = document.getElementById('drop-area');
    var input = document.getElementById('images');
    var preview = document.getElementById('preview');
    var portadaPreview = document.getElementById('portada-preview');
    var audioPreview = document.getElementById('audio-preview');

    // Eventos de arrastre y soltar
    dropArea.addEventListener('dragenter', function(e) {
        e.preventDefault();
        dropArea.classList.add('highlight');
    });

    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
    });

    dropArea.addEventListener('dragleave', function() {
        dropArea.classList.remove('highlight');
    });

    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        dropArea.classList.remove('highlight');

        var files = e.dataTransfer.files;
        handleFiles(files);
    });

    // Evento de cambio de archivo seleccionado manualmente
    input.addEventListener('change', function() {
        // Limpiar el contenedor de vista previa antes de agregar nuevas imágenes
        preview.innerHTML = '';
        
        var files = this.files;
        handleFiles(files);
    });

    // Evento de cambio de imagen de portada seleccionada
    portada.addEventListener('change', function() {
        var file = this.files[0];
        showImagePreview(file, portadaPreview);
    });

    // Evento de cambio de archivo de audio seleccionado
    audio.addEventListener('change', function() {
        var file = this.files[0];
        showAudioPreview(file, audioPreview);
    });

    function handleFiles(files) {
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!file.type.startsWith('image/')) {
                continue;
            }
            
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    var maxWidth = 200; // Ajusta este valor según tus necesidades

                    var ratio = Math.min(maxWidth / img.width, 1);
                    canvas.width = img.width * ratio;
                    canvas.height = img.height * ratio;

                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    var thumbnail = document.createElement('div');
                    thumbnail.className = 'thumbnail m-2 position-relative';
                    thumbnail.style.width = canvas.width + 'px';
                    thumbnail.style.height = canvas.height + 'px';

                    var imgElement = document.createElement('img');
                    imgElement.src = canvas.toDataURL('image/jpeg');
                    imgElement.className = 'img-thumbnail w-100 h-100';
                    thumbnail.appendChild(imgElement);

                    var deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.className = 'btn btn-sm btn-danger delete-btn';
                    deleteButton.innerHTML = '&times;';
                    deleteButton.style.position = 'absolute';
                    deleteButton.style.top = '0';
                    deleteButton.style.right = '0';
                    deleteButton.addEventListener('click', function() {
                        thumbnail.parentNode.removeChild(thumbnail);
                    });
                    thumbnail.appendChild(deleteButton);

                    preview.appendChild(thumbnail);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

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
    }

    function showAudioPreview(file, previewElement) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var audio = document.createElement('audio');
            audio.controls = true;
            var source = document.createElement('source');
            source.src = e.target.result;
            source.type = file.type;
            audio.appendChild(source);
            previewElement.innerHTML = '';
            previewElement.appendChild(audio);
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection
