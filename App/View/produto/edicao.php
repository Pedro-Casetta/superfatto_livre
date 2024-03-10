<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <?php if (isset($dados['produto']) && !empty($dados['produto'])) { ?>
    <div class="row">
      <div class="col">
        <form method="POST" action="http://<?=APP_HOST?>/produto/atualizar" enctype="multipart/form-data">
          <div class="row mb-3">
            <div class="col-auto">
              <h1>Edição de produto</h1>
            </div>
          </div>
          <input type="hidden" name="codigo" value="<?= $dados['produto']->getCodigo() ?>">
          <input type="hidden" name="imagem_atual" value="<?= $dados['produto']->getImagem() ?>">
          <div class="row mb-3">
            <div class="col-11 col-md-9 col-lg-6">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control border border-primary
              <?= (isset($dados['validacao']) && !$dados['validacao']['nome_validado'] ? 'is-invalid' : '') ?>"
              id="nome" name="nome"
              value="<?= (isset($dados['formulario'])) ? $dados['formulario']['nome'] : $dados['produto']->getNome() ?>" required>
              <?php if (isset($dados['validacao']) && !$dados['validacao']['nome_validado']) { ?>
                <div class="alert alert-danger mt-1">
                  O nome deve conter apenas letras, números, espaços ou apóstrofos.
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="preco" class="form-label">Preço</label>
              <input type="text" class="form-control border border-primary
              <?= (isset($dados['validacao']) && !$dados['validacao']['preco_validado'] ? 'is-invalid' : '') ?>"
              id="preco" name="preco"
              value="<?= (isset($dados['formulario'])) ? $dados['formulario']['preco'] : $dados['produto']->getPreco() ?>" required>
              <?php if (isset($dados['validacao']) && !$dados['validacao']['preco_validado']) { ?>
                <div class="alert alert-danger mt-1">
                  O preço deve conter apenas dígitos ou ponto separando o valor dos centavos.
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="estoque" class="form-label">Estoque</label>
              <input type="number" min="0" class="form-control border border-primary" id="estoque" name="estoque"
              value="<?= (isset($dados['formulario'])) ? $dados['formulario']['estoque'] : $dados['produto']->getEstoque() ?>" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <label for="imagem" class="form-label">Imagem</label>
              <input type="file" class="form-control border border-primary" id="imagem" name="imagem" accept="image/*">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-6 col-md-4 col-lg-3">
              <h4>Imagem atual:</h4>
              <img src="http://<?=APP_HOST?>/public/imagem/produto/<?=$dados['produto']->getImagem()?>" width="60%">
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-auto">
              <label for="departamento" class="form-label">Departamento</label>
              <select class="form-select border border-primary" id="departamento" name="departamento" required>
                <?php if (isset($dados['departamentos']) && !empty($dados['departamentos'])) { ?>
                  <?php foreach($dados['departamentos'] as $departamento) { ?>
                    <option value="<?= $departamento->getCodigo() ?>" 
                    <?=(isset($dados['formulario']) && $dados['formulario']['departamento'] == $departamento->getCodigo() ? 'selected' :
                      ($departamento->getCodigo() == $dados['produto']->getDepartamento()->getCodigo() ? 'selected' : '')) ?>>
                      <?= $departamento->getNome() ?>
                    </option>
                <?php } } ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg">&ensp;</i>Atualizar
              </button>
            </div>
            <div class="col-auto">
              <a href="http://<?=APP_HOST?>/produto" class="btn btn-secondary">
                <i class="bi bi-x-lg">&ensp;</i>Cancelar
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>

</div>