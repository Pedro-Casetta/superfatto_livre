<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <div class="row">
    <div class="col">
      <form method="POST" action="http://<?=APP_HOST?>/conta/cadastrar">
        <div class="row mb-3">
          <div class="col-auto">
            <h1>Cadastro de usuário</h1>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
              <i class="bi bi-arrow-left">&ensp;</i>Voltar
            </a>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col-10 col-md-7 col-lg-4">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control border border-black" id="nome" name="nome" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-10 col-md-7 col-lg-4">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" class="form-control border border-black" id="email" name="email" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="nome_usuario" class="form-label">Nome de usuário</label>
              <input type="text" class="form-control border border-black" id="nome_usuario" name="nome_usuario" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="senha" class="form-label">Senha</label>
              <input type="password" class="form-control border border-black" id="senha" name="senha" required>
            </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <label for="tipo" class="form-label">Tipo de conta</label>
            <select class="form-select border border-black" id="tipo" name="tipo" onchange="exibirCampoCadastroConta(this.value)" required>
                <option value="" selected>Selecione o tipo</option>
                <option value="administrador">Administrador</option>
                <option value="cliente">Cliente</option>
            </select>
          </div>
        </div>
        <div class="row mb-4" style="display: none;" id="campoTelefone">
            <div class="col-6 col-md-4 col-lg-3 p-0">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="text" class="form-control border border-black" id="telefone" name="telefone">
            </div>
        </div>
        <div class="row mb-4" style="display: none;" id="campoCredencial">
            <div class="col-6 col-md-4 col-lg-3 p-0">
              <label for="credencial" class="form-label">Credencial</label>
              <input type="text" class="form-control border border-black" id="credencial" name="credencial">
            </div>
        </div>
        <div class="row">
          <div class="col-auto">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-floppy">&ensp;</i>Cadastrar
            </button>
          </div>
          <div class="col-auto">
            <button type="reset" class="btn btn-warning">
              <i class="bi bi-eraser">&ensp;</i>Limpar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>