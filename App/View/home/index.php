


<?php if ($sessao::getMensagem()) { ?>
    <h1><?=$sessao::getMensagem()?></h1>
<?php } ?>



<?php if ($sessao::getNomeUsuario()) { ?>
    <h1><?=$sessao::getNomeUsuario()?></h1>
<?php } ?>