<div class="container-sm my-5">

  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>

  <div class="row mb-3">
      <div class="col-auto">
        <a href="http://<?=APP_HOST?>/<?=
          (isset($dados['carrinho']) ? 'carrinho/index' : 'produto/detalhesProduto/' . $dados['produtos'][0]->getCodigo()) ?>"
          class="btn btn-secondary">
          <i class="bi bi-arrow-left">&ensp;</i>Voltar
        </a>
      </div>
      <div class="col-auto">
        <h1>Finalizar compra</h1>
      </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto border border-2 border-primary mb-3">
      <div class="row mb-3">
        <div class="col-auto">
          <h2>Itens</h2>
        </div>
        <div class="col-auto mx-auto me-0">
            <h2>Total: R$ <?= (isset($dados['carrinho'])) ?
              $dados['carrinho']->getTotalView() : $dados['produtos'][0]->getSubtotalView() ?></h2>
        </div>
      </div>
      <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) {
        foreach ($dados['produtos'] as $produto) { ?>
        <div class="row mb-3 bg-success-subtle rounded mx-auto p-2">
          <div class="col-auto">
            <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>"
            class="border border-black border-2" width="150px" height="150px">
            <h4 class="mt-1 text-center"><?= $produto->getNome() ?></h4>
          </div>
          <div class="col-auto my-auto ms-3">
            <h4 class="text-center">Preço</h4>
            <h5 class="text-center">R$ <?= $produto->getPrecoView() ?></h5>
          </div>
          <div class="col-auto my-auto ms-3">
            <h4 class="text-center">Quantidade</h4>
            <h5 class="text-center"><?= $produto->getQuantidade() ?></h5> 
          </div>
          <div class="col-auto my-auto ms-3">
            <h4 class="text-center">Subtotal</h4>
            <h5 class="text-center">R$ <?= $produto->getSubtotalView() ?></h5>
          </div>
        </div>
      <?php } }?>
    </div>
    <div class="col-auto mx-auto">
      <form method="POST" action="http://<?=APP_HOST?>/venda/salvarEndereco" enctype="multipart/form-data">
        <?php if(count($dados['produtos']) == 1) { ?>
          <input type="hidden" id="produto" name="produto"
          value="<?= $dados['produtos'][0]->getCodigo() ?>">
          <input type="hidden" id="quantidade" name="quantidade"
          value="<?= $dados['produtos'][0]->getQuantidade() ?>">
          <input type="hidden" id="estoque" name="estoque"
          value="<?= $dados['produtos'][0]->getEstoque() ?>">
        <?php } ?>
        <div class="row mb-3">
          <div class="col-12">
            <label for="endereco" class="form-label">Endereco</label>
            <select class="form-select border border-primary" id="endereco" name="endereco">
              <option value="" selected>Selecione o endereço</option>
              <?php if (isset($dados['enderecos']) && !empty($dados['enderecos'])) { ?>
                <?php foreach($dados['enderecos'] as $endereco) { ?>
                  <option value="<?= $endereco->getCodigo() ?>"><?= $endereco->getRua() . ", " . $endereco->getNumero() ?></option>
              <?php } } ?>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <h5>Cadastre o endereço</h5>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12">
            <label for="rua" class="form-label">Rua</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['rua_validada'] ? 'is-invalid' : '') ?>"
            id="rua" name="rua" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['rua'] : '' ?>">
            <?php if (isset($dados['validacao']) && !$dados['validacao']['rua_validada']) { ?>
              <div class="alert alert-danger mt-1">
                O nome da rua deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-5">
            <label for="numero" class="form-label">Número</label>
            <input type="number" class="form-control border border-primary"
            id="numero" name="numero" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['numero'] : '' ?>">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['bairro_validado'] ? 'is-invalid' : '') ?>"
            id="bairro" name="bairro" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['bairro'] : '' ?>">
            <?php if (isset($dados['validacao']) && !$dados['validacao']['bairro_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O nome do bairro deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['cidade_validada'] ? 'is-invalid' : '') ?>"
            id="cidade" name="cidade" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['cidade'] : '' ?>">
            <?php if (isset($dados['validacao']) && !$dados['validacao']['cidade_validada']) { ?>
              <div class="alert alert-danger mt-1">
                O nome da cidade deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-auto">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select border border-primary" id="estado" name="estado">
              <option value="<?= (isset($dados['formulario'])) ? $dados['formulario']['estado'] : '' ?>" selected>
                <?= (isset($dados['formulario']) ? $dados['formulario']['estado'] : 'Selecione o estado') ?>
              </option>
              <option>AC</option>
              <option>AL</option>
              <option>AP</option>
              <option>AM</option>
              <option>BA</option>
              <option>CE</option>
              <option>DF</option>
              <option>ES</option>
              <option>GO</option>
              <option>MA</option>
              <option>MT</option>
              <option>MS</option>
              <option>MG</option>
              <option>PA</option>
              <option>PB</option>
              <option>PR</option>
              <option>PE</option>
              <option>PI</option>
              <option>RJ</option>
              <option>RN</option>
              <option>RS</option>
              <option>RO</option>
              <option>RR</option>
              <option>SC</option>
              <option>SP</option>
              <option>SE</option>
              <option>TO</option>
            </select>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-6">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['cep_validado'] ? 'is-invalid' : '') ?>"
            id="cep" name="cep" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['cep'] : '' ?>">
            <?php if (isset($dados['validacao']) && !$dados['validacao']['cep_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O CEP deve ter 8 dígitos juntos ou separados por hífen (-).
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-auto">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-floppy">&ensp;</i>Salvar endereço
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