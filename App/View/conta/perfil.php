<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['conta']) && !empty($dados['conta'])) { ?>
    <div class="row mb-3">
      <div class="col-auto">
        <h1>Perfil</h1>
      </div>
    </div>
    <div class="row mb-3">
        <div class="col-auto">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control border border-primary" id="nome" name="nome"
          value="<?= $dados['conta']->getNome() ?>" readonly>
        </div>
        <div class="col-auto">
            <label for="email" class="form-label">E-mail</label>
            <input type="text" class="form-control border border-primary" id="email" name="email"
            value="<?= $dados['conta']->getEmail() ?>" readonly>
        </div>
    </div>
    <div class="row mb-3">
      <div class="col-auto">
        <label for="nome_usuario" class="form-label">Nome de usuário</label>
        <input class="form-control border border-primary" id="nome_usuario" name="nome_usuario"
        value="<?= $dados['conta']->getNomeUsuario(); ?>" readonly>
      </div>  
    <?php if ($dados['conta']->getTipo() == 'administrador') { ?>
        <div class="col-auto">
          <label for="credencial" class="form-label">Credencial</label>
          <input class="form-control border border-primary" id="credencial"
          name="credencial" value="<?= $dados['conta']->getCredencial()->getNome() ?>" readonly>
        </div>
    <?php } else if ($dados['conta']->getTipo() == 'cliente') { ?>
        <div class="col-auto">
          <label for="telefone" class="form-label">Telefone</label>
          <input class="form-control border border-primary" id="telefone" name="telefone"
          value="<?= $dados['conta']->getTelefone() ?>" readonly>
        </div>
    <?php } ?>
    </div>
    <div class="row">
      <div class="col-auto">
        <a href="http://<?=APP_HOST?>/conta/encaminharEdicao/<?= $dados['conta']->getCodigo() ?>" class="btn btn-primary">
            <i class="bi bi-pencil">&ensp;</i>Editar
        </a>
      </div>
      <?php if ($sessao::getTipoConta() == "cliente") { ?>
        <div class="col-auto">
          <a href="http://<?=APP_HOST?>/endereco" class="btn btn-dark">
              <i class="bi bi-geo-alt">&ensp;</i>Gerenciar endereços
          </a>
        </div>
      <?php } ?>
      <div class="col-auto">
        <a href="http://<?=APP_HOST?>/conta/encaminharTrocaSenha/<?= $dados['conta']->getCodigo() ?>" class="btn btn-warning">
            <i class="bi bi-lock">&ensp;</i>Trocar senha
        </a>
      </div>
      <div class="col-auto">
        <a href="http://<?=APP_HOST?>/conta/encaminharExclusao/<?= $dados['conta']->getCodigo() ?>" class="btn btn-danger">
          <i class="bi bi-trash">&ensp;</i>Excluir conta
        </a>
      </div>
    </div>
  <?php } ?>

</div>