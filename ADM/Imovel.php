<?php
    //Apresenta as informações do imovel e a possibilidade de editar ou excluir
    
    $IDdoImovelSelecionado = $_POST['Id_do_imovelSelecionado']; 

    echo "<p>Aqui deve aparecer as informações do imovel igual no página do imovel para usuário comuns</p>";

    echo "<a href='EditarImovel.php?IDdoImovel={$IDdoImovelSelecionado}'>Editar</a>";
    echo "<a href='ExcluirImovel.php?IDdoImovel={$IDdoImovelSelecionado}'>Excluir</a>";
?>
