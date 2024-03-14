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
      <form method="POST" action="http://<?=APP_HOST?>/produto/cadastrar" enctype="multipart/form-data">
        <div class="row mb-3">
          <div class="col-auto">
            <h1>Cadastro de produto</h1>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <a href="http://<?=APP_HOST?>/produto" class="btn btn-secondary">
              <i class="bi bi-arrow-left">&ensp;</i>Voltar
            </a>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-10 col-md-6 col-lg-4">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['nome_validado'] ? 'is-invalid' : '') ?>"
            id="nome" name="nome" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['nome'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['nome_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O nome deve conter apenas letras, números, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <label for="preco" class="form-label">Preço</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['preco_validado'] ? 'is-invalid' : '') ?>"
            id="preco" name="preco" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['preco'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['preco_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O preço deve conter apenas dígitos ou ponto separando o valor dos centavos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <label for="estoque" class="form-label">Estoque</label>
            <input type="number" min="0" class="form-control border border-primary"
             id="estoque" name="estoque" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['estoque'] : '' ?>" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <label for="imagem" class="form-label">Imagem</label>
            <input type="file" class="form-control border border-primary"
            id="imagem" name="imagem" accept="image/*" required>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-auto">
            <label for="departamento" class="form-label">Departamento</label>
            <select class="form-select border border-primary" id="departamento" name="departamento" required>
              <option value="">Selecione o departamento</option>
              <?php if (isset($dados['departamentos']) && !empty($dados['departamentos'])) { ?>
                <?php foreach($dados['departamentos'] as $departamento) { ?>
                  <option value="<?= $departamento->getCodigo() ?>"
                  <?= (isset($dados['formulario']) && $dados['formulario']['departamento'] == $departamento->getCodigo() ?
                  'selected' : '') ?>>
                    <?= $departamento->getNome() ?>
                  </option>
              <?php } } ?>
            </select>
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