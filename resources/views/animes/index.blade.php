<x-layout title="Animes">
    <a href="{{ route('animes.create') }}" class="btn btn-dark mb-2">Adicionar</a>
    
    @isset($mensagemSucesso)
    <div class="alert alert-success">
        {{ $mensagemSucesso }}
    </div>
    @endisset

    <ul class="list-group">
        @foreach ($animes as $anime)
        <li class="list-group-item d-flex justify-content-between align-items-center" >
            <a href="{{route('seasons.index', $anime->id)}}">
                {{ $anime->nome }}
            </a>

            <span class="d-flex">
                <a href="{{route('animes.edit', $anime->id)}}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>

                <form action="{{route('animes.destroy', $anime->id)}}" class="ms-2" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </span>
        </li>
        @endforeach
    </ul>

</x-layout>