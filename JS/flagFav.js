$(document).ready(function(){
    $('.flagFav').click(function(e){
        e.preventDefault(); // Prevenir o comportamento padrão do link

        var catalogoID = $(this).prop('id');
        var title = $(this).prop('title');

        if (title == 'Favorito') {
           $(this).html('<i class="bi bi-star"></i>').prop("title", "Não Favorito"); //altera a classe mudando a estrela e altera o título para verificar se é favorito ou não
            
           //.ajax encaminha para o arquivo que faz o UPDATE os valores das variáveis declaradas
            $.ajax({
                url: './atualizaFavoritos.php',
                type: 'POST',
                data: {id: catalogoID, flagFav: 0},
                success: function(data) {
                    console.log(data);
                }
            });
            //$.getJSON('../atualizaFavoritos.php?id='+imID+'&flagFav=0');
            // Redirecione para a URL corretamente construída
            //window.location.href = './atualizaFavoritos.php?imID=' + imID + '&flagFav=0';
        } else {
           $(this).html('<i class="bi bi-star-fill"></i>').prop("title", "Favorito");
           
            $.ajax({
                url: './atualizaFavoritos.php',
                type: 'POST',
                data: {id: catalogoID, flagFav: 1},
                success: function(data) {
                    console.log(data);
                }
            });
            $.ajax({
                url: './listaFav.php',
                type: 'POST',
                data: {flagFav: 1},
                success: function(data) {
                    console.log(data);
                }
            });
            //$.getJSON('../atualizaFavoritos.php?id='+imID+'&flagFav=1');
            //Redirecione para a URL corretamente construída
            //window.location.href = './atualizaFavoritos.php?imID=' + imID + '&flagFav=1';
        }
    });
});
