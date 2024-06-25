@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inicio') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @role('administrador')
                   <div>
                    <a href="{{route('users.index')}}" class="btn btn-success">Administrar Clientes</a>
                   </div>
                   @endrole

                   <div class="container">
                     <h5>Mis recuerdos</h5>
                     @foreach ($data as $recuerdo )
                         <a href="{{route('users.memories',['idu'=> encrypt($recuerdo->user_id),'idr'=> encrypt($recuerdo->id)])}}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                    <p class="text"> {{$recuerdo->nombre}}</p> 
                                    <a href="{{route('recuerdos.edit',$recuerdo->id)}}" class="btn btn-warning">Editar</a>
                                    </div>
                                    <div class="col">
                                        <p class="text-end"> {{$recuerdo->created_at}}</p> 
                                        
                                    </div>
                                </div>
                       
                         </div>
                         </div>
                        </a>
                     @endforeach
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
