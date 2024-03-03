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
      <h1>Vendas</h1>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto mx-auto me-0">
      <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/venda">
        <input class="form-control me-2" type="date" size="30" id="data" name="data">
        <input class="form-control me-2" type="search" size="30" id="busca" name="busca" placeholder="Nome do cliente da venda">
        <button class="btn btn-primary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>
  </div>

  <?php if (isset($dados['vendas']) && !empty($dados['vendas'])) { ?>
    <div class="row">
      <div class="col table-responsive-md px-0">
        <table class="table table-bordered align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th scope="col" style="width:5%;">Código</th>
              <th scope="col" style="width:15%;">Data</th>
              <th scope="col" style="width:25%;">Cliente</th>
              <th scope="col" style="width:10%;">Total (R$)</th>
              <th scope="col" style="width:15%;">Situação</th>
            </tr>
          </thead>
          <tbody class="table-group-divider table-warning border-success text-center">
            <?php foreach ($dados['vendas'] as $venda) { ?>
              <tr>
                <th scope="row"><?= $venda->getCodigo() ?></th>
                <td><?= $venda->getDataView() ?></td>
                <td><?= $venda->getCliente()->getNome() ?></td>
                <td><?= $venda->getTotalView() ?></td>
                <td><?= $venda->getSituacao() ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <?= $dados['paginacao'] ?>

  <?php } else if (isset($dados['vendas']) && empty($dados['vendas'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há vendas.</h2>
      </div>
    </div>
  <?php } ?>

</div>