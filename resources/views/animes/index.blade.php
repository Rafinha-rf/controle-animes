<x-layout title="Lista de Animes">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Lista de Animes</h1>
        <a href="{{ route('animes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Novo Anime
        </a>
    </div>

    @if($animes->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>Nenhum anime cadastrado ainda.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($animes as $anime)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if($anime->imagem_url)
                            <img src="{{ $anime->imagem_url }}" class="card-img-top anime-cover" alt="{{ $anime->nome }}">
                        @else
                            <div class="placeholder-image d-flex align-items-center justify-content-center bg-light">
                                <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $anime->nome }}</h5>
                            <p class="card-text text-muted">
                                <i class="bi bi-collection-play me-2"></i>{{ $anime->seasons_count }} temporada(s)
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('seasons.index', $anime) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-list-ul me-2"></i>Ver Episódios
                                </a>
                                <div class="btn-group">
                                    <a href="{{ route('animes.edit', $anime) }}" class="btn btn-outline-secondary btn-sm" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('animes.destroy', $anime) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir" 
                                                onclick="return confirm('Tem certeza que deseja excluir este anime?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @push('styles')
    <style>
        .anime-cover {
            height: 200px;
            object-fit: cover;
        }
        .placeholder-image {
            height: 200px;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Mostrar notificação ao excluir anime
        document.querySelectorAll('form[action*="destroy"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (confirm('Tem certeza que deseja excluir este anime?')) {
                    showToast('Anime excluído com sucesso!', 'success');
                } else {
                    e.preventDefault();
                }
            });
        });
    </script>
    @endpush
</x-layout>