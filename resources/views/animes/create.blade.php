<x-layout title="Novo Anime">
    <form action="{{route('animes.store')}}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-8">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text"
                    autofocus 
                    id="nome" 
                    name="nome" 
                    class="form-control" 
                    value="{{old('nome')}}">
            </div>

            <div class="col-2">
                <label for="seasonsQty" class="form-label">Nº Temporadas:</label>
                <input type="text" 
                    id="seasonsQty" 
                    name="seasonsQty" 
                    class="form-control" 
                    value="{{old('seasonsQty')}}">
            </div>

            <div class="col-2">
                <label for="episodePerSeasons" class="form-label">Eps / Temporadas:</label>
                <input type="text" 
                    id="episodePerSeasons" 
                    name="episodePerSeasons" 
                    class="form-control" 
                    value="{{old('episodePerSeasons')}}">
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Adicionar</button>

    </form>

</x-layout>