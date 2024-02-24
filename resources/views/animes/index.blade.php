<x-layout title="Animes">
    <a href="{{ route('animes.create') }}" class="btn btn-dark mb-2">Adicionar</a>
    
    @isset($mensagemSucesso)
    <div class="alert alert-success">
        {{ $mensagemSucesso }}
    </div>
    @endisset

    <ul class="list-group">
        @foreach ($animes as $anime)
        <li class="list-group-item d-flex align-items-center">
            <img src="{{$anime->imagem_url}}" alt="" class="rounded img-fluid me-3" style="width: 100px; height: auto;">
            <div>
                <a href="{{route('seasons.index', $anime->id)}}" class="text-decoration-none">{{ $anime->nome }}</a>

                <div class="mt-2">
                    <a href="{{route('animes.edit', $anime->id)}}" class="btn btn-primary btn-sm mb-2">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <form action="{{route('animes.destroy', $anime->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</x-layout>