@extends('layout')
@section('content')

<style>
body{
    background:#f8f9fa;
    background-repeat: no-repeat;
    background-size: cover;
    /* background: linear-gradient(-135deg, #82d5e8, #2069f1) !important; */
    font-family: "Poppins", sans-serif;
    font-weight: 300;

}

.hvr:hover{
    background-color: #e4e4e4;
    transition: 0.4s;
    border-radius: 5px;
}
</style>
    <div class="wrapper bg-white shadow p-3" style="border-radius: 5px; margin-bottom:30px;">
        <div class="d-flex align-items-start justify-content-between">
            <div class="d-flex flex-column">
    @csrf
    @if (Session::get('notAllowed'))
        <div class="alert alert-danger">
            {{ Session::get('notAllowed')}}
        </div>  
    @endif

    @if (Session::get('successAdd'))
            <div class="alert alert-success">
                {{ Session::get('successAdd') }}
            </div>
    @endif

    @if (Session::get('successUpdate'))
        <div class="alert alert-success">
            {{ Session::get('successUpdate') }}
        </div>
    @endif

    @if (Session::get('done'))
    <div class="alert alert-success">
        {{ Session::get('done') }}
    </div>
    @endif
                <div class="h5">Hello, {{ auth()->user()->name }}</div>
                <br>
                <span>
                    <a href="{{route('todo.create')}}" class="text-success">Create</a>  
                    <a href="">Complated</a>
                </span>
            </div>
        </div>
        <div class="work border-bottom pt-3">
            <div class="d-flex align-items-center py-2 mt-1 mx-5">
                <div>
                    <span class="text-muted fas fa-comment btn"></span>
                </div>
                <div class="text-muted">{{$todos->count()}} todos</div>
            </div>
        </div>
        @foreach ($todos  as $todo)
        <a class="text-justify" href="/todo/edit/{{$todo['id']}}" class="text-justify" style="text-decoration: none;">
            <div id="comments" class="mt-1">
                <div class="comment d-flex align-items-start justify-content-between hvr">
                    <div class="mr-2">
                        @if ($todo['status'] == 1)
                        <span class="fa-solid fa-bookmark text-secondary btn"></span>
                        @else
                        <form action="/todo/complated/{{$todo['id']}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="fas fa-circle-check text-primary btn">
                            </button>
                        </form>
                    @endif
                    </div>
                    <div class="d-flex flex-column w-75">
                            {{$todo['title']}}
                            <br>
                            <br>
                        <p>{{$todo['description']}}</p>
                        <p class="text-muted">
                            {{$todo['status'] == 1 ? 'Complated' : 'On-Process'}}
                            <span class="date font-weight-bold">
                                @if ($todo['status'] == 1)
                                Selesai pada : {{\Carbon\Carbon::parse($todo['date_time'])->format('j F, Y') }} 
                                @else
                                Target selesai : {{\Carbon\Carbon::parse($todo['date'])->format('j F, Y') }}
                                @endif
                            </span>
                        </p>
                        <form id="delete" action="{{ route('todo.destroy', $todo['id']) }}"
                                method="POST" style="display: none; ">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                    <div class="ml-auto">
                        <span class='fa fa-trash' style='color: red' type="submit" onclick="event.preventDefault();document.getElementById('delete').submit();"></span>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@endsection