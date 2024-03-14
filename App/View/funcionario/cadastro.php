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
      <form method="POST" action="http://<?=APP_HOST?>/funcionario/cadastrar">
        <div class="row mb-3">
          <div class="col-auto">
            <h1>Cadastro de funcionário</h1>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <a href="http://<?=APP_HOST?>/funcionario" class="btn btn-secondary">
              <i class="bi bi-arrow-left">&ensp;</i>Voltar
            </a>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-10 col-md-6 col-lg-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['cpf_validado'] ? 'is-invalid' : '') ?>"
            id="cpf" name="cpf" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['cpf'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['cpf_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O cpf deve ter 11 dígitos juntos ou separados por ponto (.) e hífen (-).
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-10 col-md-6 col-lg-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['nome_validado'] ? 'is-invalid' : '') ?>"
            id="nome" name="nome" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['nome'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['nome_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O nome deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-10 col-md-6 col-lg-3">
            <label for="setor" class="form-label">Setor</label>
            <input type="text" class="form-control border border-primary" id="setor" name="setor"
            value="<?= (isset($dados['formulario'])) ? $dados['formulario']['setor'] : '' ?>" required>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-10 col-md-6 col-lg-3">
            <label for="salario" class="form-label">Salário</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['salario_validado'] ? 'is-invalid' : '') ?>"
            id="salario" name="salario" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['salario'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['salario_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O salário deve conter apenas dígitos ou ponto separando o valor dos centavos.
              </div>
            <?php } ?>
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