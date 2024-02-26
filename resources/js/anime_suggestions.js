$(document).ready(function() {
    // Manipulador de evento para clicar em um item da lista de sugestões
    $(document).on('click', '#suggestions li', function() {
        var selectedValue = $(this).text();
        $('#nome').val(selectedValue);
        $('#suggestions').empty(); // Limpa a lista de sugestões após selecionar
    });

    $('#nome').on('input', function() {
        var query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: 'https://kitsu.io/api/edge/anime',
                method: 'GET',
                data: { filter: { text: query } },
                success: function(response) {
                    $('#suggestions').empty();
                    response.data.forEach(function(anime) {
                        if (anime.attributes && anime.attributes.titles && anime.attributes.titles.en_jp) {
                            $('#suggestions').append('<li class="list-group-item">' + anime.attributes.titles.en_jp + '</li>');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#suggestions').empty();
        }
    });
});