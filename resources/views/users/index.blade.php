@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <a href="{{route('visita',base64_encode(5))}}">genera</a>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Usuarios</h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Crear Usuario</a>
        </div>

        @if ($users->isEmpty())
            <div class="alert alert-info">No hay usuarios disponibles.</div>
        @else
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="d-flex align-items-center">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm mr-2">Editar</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="mr-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                            @if ($user->memories()->count() < $user->recuerdos)
                            <a href="{{ route('users.memories.create', $user) }}" class="btn btn-success btn-sm mr-2">Añadir Recuerdos</a>
                            @endif
                            @if ($user->memories()->count() >= 1)
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ver Recuerdos
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                                        @foreach ($user->memories as $memory)
                                            <li><a class="dropdown-item" href="{{route('users.memories',['idu'=> encrypt($user->id),'idr'=> encrypt($memory->id)])}}">{{ $memory->nombre }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
