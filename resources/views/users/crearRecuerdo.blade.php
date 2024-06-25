@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Crear Recuerdo</h2>
        </div>
        <div class="card-body">
        <form action="{{ route('recuerdos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
<input type="hidden" name="user_id" id="" value="{{$user}}">
    <!-- Previsualización de Imagen de Portada -->
    <div class="form-group">
        <label for="portada">Imagen de Portada:</label>
        <input type="file" class="form-control-file" id="portada" name="portada" accept="image/*" required>
        <div id="portada-preview" class="mt-2"></div>
    </div>

    <!-- Previsualización de Audio -->
    <div class="form-group">
        <label for="audio">Audio:</label>
        <input type="file" class="form-control-file" id="audio" name="audio" accept="audio/*">
        <div id="audio-preview" class="mt-2"></div>
    </div>

    <!-- Campo de nombre -->
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>

    <!-- Campo de descripción -->
    <div class="form-group">
        <label for="descripcion">Mensaje o dedicatoria:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
    </div>

    <!-- Espacio para arrastrar imágenes -->
   
        @include('users.dragAndDrop')
        @yield('drag')
    <!-- Botón de envío -->
    <button type="submit" class="btn btn-primary">Crear Recuerdo</button>
</form>

        </div>
    </div>
</div>









@endsection



