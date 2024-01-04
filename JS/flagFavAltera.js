const maison2 = require('maison2');

const connection = maison2.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'maison2'
});

connection.connect(function(erro){
  if(erro) console.error('Erro ao realizar a conexão com o DB' + erro.stack); return;
});

var flagsImoveis = document.getElementsByClassName('flagFav');
var estrela = document.querySelector('i');
var statusFavorito = document.querySelector('[name="Favorito"]');
var statusNaoFavorito = document.querySelector('[name="Não Favorito"]');
var catalogoID = document.getElementById('id');

for (var i = 0; i < flagsImoveis.length; i++) {
  flagsImoveis[i].addEventListener('click', function(event){
    event.preventDefault(); // Prevenir o comportamento padrão do link

    if(statusFavorito){
      connection.query("UPDATE Catalogo SET flagFav = 0 WHERE CatalogoID =" + catalogoID);
      statusFavorito.setAttribute('name', 'Não Favorito');
      estrela.setAttribute('class', 'bi bi-star');
    }
    if(statusNaoFavorito){
      connection.query("UPDATE Catalogo SET flagFav = 1 WHERE CatalogoID =" + catalogoID);
      statusFavorito.setAttribute('name', 'Favorito');
      estrela.setAttribute('class', 'bi bi-star-fill');
    }
  });
}