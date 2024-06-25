@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Editar Recuerdo</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('recuerdos.update', $recuerdo->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $recuerdo->nombre }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ $recuerdo->descripcion }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="portada" class="form-label">Portada</label>
                            @if ($recuerdo->portada)
                                <div class="mb-2">
                                    <img src="{{asset('storage/'. $recuerdo->portada) }}" alt="Portada Actual" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="portada" name="portada">
                        </div>

                        <div class="mb-3">
                            <label for="audio" class="form-label">Audio</label>
                            @if ($recuerdo->audio)
                                <div class="mb-2">
                                    <audio controls>
                                        <source src="{{ asset('storage/' . $recuerdo->audio) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="audio" name="audio">
                        </div>

                        <div class="mb-4">
                            <label for="imagenes" class="form-label">Imágenes</label>
                            <div class="row">
                            @foreach ($imagenes as $imagen)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $imagen->url) }}" class="card-img-top" alt="Imagen">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="eliminar_imagenes[]" value="{{ $imagen->id }}" id="eliminar_imagen_{{ $imagen->id }}">
                                        <label class="form-check-label" for="eliminar_imagen_{{ $imagen->id }}">
                                            Eliminar imagen
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            
                    <div class="d-flex justify-content-center mt-4">
                        {{ $imagenes->links() }}
                    </div>
                            </div>
                            @if($img  <50)

                            @include('users.dragAndDrop')
                             @yield('drag')
                            @else
                            <p>La cantidad de imagenes esta al limite en tu cuenta! </p>
                             @endif
                        </div>
                        

                        <div class="form-group">
            <h3>Mensajes</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Mensaje</th>
                        <th>Imagen</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recuerdo->mensajes as $mensaje)
                    <tr>
                        <td>{{ $mensaje->nombre }}</td>
                        <td>{{ $mensaje->mensaje }}</td>
                        <td>
                            @if ($mensaje->imagen)
                            <img src="{{ asset('storage/' . $mensaje->imagen) }}" alt="Imagen del mensaje" style="max-width: 150px;">
                            @else
                            Sin imagen
                            @endif
                        </td>
                        <td>
                            <input type="checkbox" name="eliminar_mensaje[]" value="{{ $mensaje->id }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



                        <button type="submit" class="btn btn-success">Actualizar</button>
                        <a href="{{ route('recuerdos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
