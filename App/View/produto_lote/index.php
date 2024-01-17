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
      <h1>Produtos do lote</h1>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-auto">
      <h4>Lote <?=$dados['lote']->getCodigo() ?></h4>
    </div>
    <div class="col-auto">
      <h4>Data <?=$dados['lote']->getData() ?></h4>
    </div>
    <div class="col-auto">
      <h4>Fornecedor <?=$dados['lote']->getFornecedor() ?></h4>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <h4>Departamento <?=$dados['lote']->getFornecedor()->getDepartamento()->getNome() ?></h4>
    </div>
    <div class="col-auto">
      <h4>Total <?=$dados['lote']->getTotal() ?></h4>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/lote" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
  </div>
  
  <form action="http://<?=APP_HOST?>/produtoLote/cadastrar" method="POST" class="row mb-3 form-inline">
    <input type="hidden" name="lote" value="<?= $dados['lote']->getCodigo() ?>">
    <div class="col-5">
      <select class="form-select border border-primary" id="produto" name="produto" required>
        <option value="" selected>Selecione o produto</option>
          <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) { ?>
            <?php foreach($dados['produtos'] as $produto) {
              if ($produto->getDepartamento()->getCodigo() == $dados['lote']->getFornecedor()->getDepartamento()->getCodigo()) ?>
                <option value="<?= $produto->getCodigo() ?>"><?= $produto->getNome() ?></option>
          <?php } } ?>
      </select>
    </div>
    <div class="col-4">
      <input type="number" min="1" class="form-control border border-primary" id="quantidade" name="quantidade" required>
    </div>
    <div class="col-2">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-floppy">&ensp;</i>Cadastrar
      </button>
    </div>
  </form>

  <?php if (isset($dados['produtos_lote']) && !empty($dados['produtos_lote'])) { ?>
    <div class="row">
      <div class="col table-responsive-md">
        <table class="table table-bordered align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th scope="col" style="width:15%;">Imagem</th>
              <th scope="col" style="width:20%;">Nome</th>
              <th scope="col" style="width:10%;">Preço (R$)</th>
              <th scope="col" style="width:5%;">Quantidade</th>
              <th scope="col" style="width:10%;">Subtotal (R$)</th>
              <th scope="col" style="width:15%;">Opções</th>
            </tr>
          </thead>
          <tbody class="table-group-divider table-warning border-success text-center">
            <?php foreach ($dados['produtos_lote'] as $produtoLote) { ?>
              <tr>
                <td scope="row">
                  <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produtoLote->getImagem() ?>" width="60%">
                </td>
                <td><?= $produtoLote->getNome() ?></td>
                <td><?= $produtoLote->getPreco() ?></td>
                <td><?= $produtoLote->getQuantidade() ?></td>
                <td><?= $produtoLote->getSubtotal() ?></td>
                <td>
                  <a href="http://<?=APP_HOST?>/produto_lote/encaminharEdicao/<?= $produtoLote->getLote()->getCodigo() ?>
                  /<?= $produtosLote->getCodigo() ?>" class="btn btn-info">
                    <i class="bi bi-pencil">&ensp;</i>Editar
                  </a>
                  <a href="http://<?=APP_HOST?>/produto_lote/encaminharExclusao/<?= $produtoLote->getLote()->getCodigo() ?>
                  /<?= $produtosLote->getCodigo() ?>" class="btn btn-danger margem_celular">
                    <i class="bi bi-x-lg">&ensp;</i>Excluir
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

  <?php } else if (isset($dados['produtos_lote']) && empty($dados['produtos_lote'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há cadastros.</h2>
      </div>
    </div>
  <?php } ?>

</div>