<x-layout title="Temporadas de '{!! $anime->nome !!}'">
    <div class="mb-4">
        <a href="{{ route('animes.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar
        </a>
        
        <div class="card">
            <div class="row g-0">
                <div class="col-md-3">
                    @if($anime->imagem_url)
                        <img src="{{ $anime->imagem_url }}" class="img-fluid rounded-start anime-cover" alt="{{ $anime->nome }}">
                    @else
                        <div class="placeholder-image d-flex align-items-center justify-content-center h-100 bg-light rounded-start">
                            <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <h1 class="h3 card-title mb-2">{{ $anime->nome }}</h1>
                        <p class="card-text text-muted">
                            <i class="bi bi-collection-play me-2"></i>{{ $seasons->count() }} temporada(s)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($seasons->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>Nenhuma temporada cadastrada para este anime.
        </div>
    @else
        <div class="accordion" id="seasonsAccordion">
            @foreach ($seasons as $season)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#season{{ $season->id }}" aria-expanded="false" 
                                aria-controls="season{{ $season->id }}">
                            <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                <span>Temporada {{ $season->number }}</span>
                                <button class="btn btn-success btn-sm mark-season-watched" 
                                        data-season-id="{{ $season->id }}"
                                        title="Marcar temporada como assistida"
                                        onclick="event.stopPropagation()">
                                    <i class="bi bi-check-all me-2"></i>Marcar como assistida
                                </button>
                            </div>
                        </button>
                    </h2>
                    <div id="season{{ $season->id }}" class="accordion-collapse collapse" 
                         data-bs-parent="#seasonsAccordion">
                        <div class="accordion-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($season->episodes as $episode)
                                    <div class="list-group-item episode-item d-flex justify-content-between align-items-center p-3 episode-status-{{ $episode->getProgressForUser(Auth::id())?->status ?? 'not_watched' }}">
                                        <div class="d-flex align-items-center">
                                            <span class="episode-number me-3">Episódio {{ $episode->number }}</span>
                                            <span class="status-badge">
                                                @if($episode->isWatchedByUser(Auth::id()))
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Assistido
                                                    </span>
                                                @elseif($episode->isInProgressByUser(Auth::id()))
                                                    <span class="badge bg-primary">
                                                        <i class="bi bi-play-circle me-1"></i>Em andamento
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-circle me-1"></i>Não assistido
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="episode-controls btn-group">
                                            <button class="btn btn-sm {{ $episode->isWatchedByUser(Auth::id()) ? 'btn-success' : 'btn-outline-success' }} mark-watched" 
                                                    data-episode-id="{{ $episode->id }}"
                                                    title="Marcar como assistido">
                                                <i class="bi bi-check"></i>
                                            </button>
                                            <button class="btn btn-sm {{ $episode->isInProgressByUser(Auth::id()) ? 'btn-primary' : 'btn-outline-primary' }} mark-in-progress" 
                                                    data-episode-id="{{ $episode->id }}"
                                                    title="Marcar como em andamento">
                                                <i class="bi bi-play"></i>
                                            </button>
                                            <button class="btn btn-sm {{ !$episode->isWatchedByUser(Auth::id()) && !$episode->isInProgressByUser(Auth::id()) ? 'btn-secondary' : 'btn-outline-secondary' }} mark-not-watched" 
                                                    data-episode-id="{{ $episode->id }}"
                                                    title="Marcar como não assistido">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @push('styles')
    <style>
        .episode-item {
            transition: all 0.3s ease;
        }
        .episode-status-watched {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }
        .episode-status-in_progress {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }
        .episode-status-not_watched {
            background-color: transparent !important;
        }
        .status-badge {
            min-width: 120px;
            text-align: center;
        }
        .episode-number {
            min-width: 100px;
            font-weight: 500;
        }
        .accordion-button:not(.collapsed) {
            background-color: var(--bs-primary-bg-subtle);
            color: var(--bs-primary);
        }
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }
        .anime-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            max-height: 200px;
        }
        .placeholder-image {
            min-height: 200px;
            background-color: var(--bs-gray-100);
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Função para atualizar o progresso
            function updateProgress(episodeId, status) {
                console.log('Iniciando atualização de progresso:', { episodeId, status });
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                
                fetch(`/episodes/${episodeId}/progress`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error('Falha ao atualizar progresso');
                    }
                    
                    // Encontrar o elemento do episódio
                    const episodeItem = document.querySelector(`.episode-controls button[data-episode-id="${episodeId}"]`).closest('.episode-item');
                    
                    if (!episodeItem) {
                        throw new Error('Elemento do episódio não encontrado');
                    }
                    
                    // Atualizar classe do item
                    episodeItem.classList.remove('episode-status-watched', 'episode-status-in_progress', 'episode-status-not_watched');
                    episodeItem.classList.add(`episode-status-${status}`);
                    
                    // Atualizar badge de status
                    const statusBadge = episodeItem.querySelector('.status-badge');
                    let statusText = '';
                    let badgeClass = '';
                    let statusIcon = '';
                    
                    switch(status) {
                        case 'watched':
                            statusText = 'Assistido';
                            badgeClass = 'bg-success';
                            statusIcon = 'bi-check-circle';
                            break;
                        case 'in_progress':
                            statusText = 'Em andamento';
                            badgeClass = 'bg-primary';
                            statusIcon = 'bi-play-circle';
                            break;
                        default:
                            statusText = 'Não assistido';
                            badgeClass = 'bg-secondary';
                            statusIcon = 'bi-circle';
                    }
                    
                    statusBadge.innerHTML = `<span class="badge ${badgeClass}"><i class="bi ${statusIcon} me-1"></i>${statusText}</span>`;
                    
                    // Atualizar botões
                    const buttons = episodeItem.querySelectorAll('.episode-controls button');
                    
                    // Primeiro, remover todas as classes de estilo dos botões
                    buttons.forEach(button => {
                        button.classList.remove(
                            'btn-success', 'btn-primary', 'btn-secondary',
                            'btn-outline-success', 'btn-outline-primary', 'btn-outline-secondary'
                        );
                    });
                    
                    // Depois, adicionar as classes corretas para cada botão
                    const watchedButton = episodeItem.querySelector('.mark-watched');
                    const inProgressButton = episodeItem.querySelector('.mark-in-progress');
                    const notWatchedButton = episodeItem.querySelector('.mark-not-watched');
                    
                    // Configurar o botão de assistido
                    if (status === 'watched') {
                        watchedButton.classList.add('btn-success');
                        inProgressButton.classList.add('btn-outline-primary');
                        notWatchedButton.classList.add('btn-outline-secondary');
                    }
                    // Configurar o botão de em andamento
                    else if (status === 'in_progress') {
                        watchedButton.classList.add('btn-outline-success');
                        inProgressButton.classList.add('btn-primary');
                        notWatchedButton.classList.add('btn-outline-secondary');
                    }
                    // Configurar o botão de não assistido
                    else {
                        watchedButton.classList.add('btn-outline-success');
                        inProgressButton.classList.add('btn-outline-primary');
                        notWatchedButton.classList.add('btn-secondary');
                    }
                    
                    // Mostrar notificação
                    showToast(`Episódio marcado como ${statusText.toLowerCase()}`, 'success');
                })
                .catch(error => {
                    console.error('Erro ao atualizar progresso:', error);
                    showToast('Erro ao atualizar o progresso. Por favor, tente novamente.', 'danger');
                });
            }

            // Event listeners para os botões
            document.querySelectorAll('.mark-watched').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const episodeId = this.dataset.episodeId;
                    updateProgress(episodeId, 'watched');
                });
            });

            document.querySelectorAll('.mark-in-progress').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const episodeId = this.dataset.episodeId;
                    updateProgress(episodeId, 'in_progress');
                });
            });

            document.querySelectorAll('.mark-not-watched').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const episodeId = this.dataset.episodeId;
                    updateProgress(episodeId, 'not_watched');
                });
            });

            // Marcar temporada inteira como assistida
            document.querySelectorAll('.mark-season-watched').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const seasonId = this.dataset.seasonId;
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    
                    fetch(`/seasons/${seasonId}/mark-watched`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            throw new Error('Falha ao marcar temporada como assistida');
                        }
                        
                        // Atualizar todos os episódios da temporada
                        const seasonItem = this.closest('.accordion-item');
                        const episodeItems = seasonItem.querySelectorAll('.episode-item');
                        
                        episodeItems.forEach(item => {
                            const episodeId = item.querySelector('.episode-controls button').dataset.episodeId;
                            updateProgress(episodeId, 'watched');
                        });
                        
                        showToast('Temporada marcada como assistida', 'success');
                    })
                    .catch(error => {
                        console.error('Erro ao marcar temporada:', error);
                        showToast('Erro ao marcar temporada como assistida. Por favor, tente novamente.', 'danger');
                    });
                });
            });
        });
    </script>
    @endpush
</x-layout>