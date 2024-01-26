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
      <h1>Lotes</h1>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto dropdown mx-auto me-0 pe-0">
      <a class="btn btn-warning dropdown-toggle" href="#" data-bs-toggle="dropdown">
        Departamento
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="http://<?=APP_HOST?>/lote">
          Todos
        </a></li>
        <?php if (isset($dados['departamentos']) && !empty($dados['departamentos'])) { ?>
          <?php foreach($dados['departamentos'] as $departamento) { ?>
            <li><a class="dropdown-item" href="http://<?=APP_HOST?>/lote?departamento=<?=$departamento->getNome()?>">
              <?= $departamento->getNome() ?>
            </a></li>
        <?php } } ?>
      </ul>
    </div>
    <div class="col-auto mx-auto me-0 ms-0">
      <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/lote">
        <input type="hidden" id="departamento" name="departamento" value="<?=(isset($_GET['departamento'])) ? $_GET['departamento'] : ''?>">
        <input class="form-control me-2" type="date" size="25" id="busca" name="busca">
        <button class="btn btn-primary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>
  </div>
  
  <form action="http://<?=APP_HOST?>/lote/cadastrar" method="POST" class="row mb-3 form-inline">
    <div class="col-4">
      <input type="date" class="form-control border border-primary" id="data" name="data" required>
    </div>
    <div class="col-5">
        <select class="form-select border border-primary" id="fornecedor" name="fornecedor" required>
          <option value="" selected>Selecione o fornecedor</option>
            <?php if (isset($dados['fornecedores']) && !empty($dados['fornecedores'])) { ?>
              <?php foreach($dados['fornecedores'] as $fornecedor) { ?>
                <option value="<?= $fornecedor->getCodigo() ?>"><?= $fornecedor->getNome() ?></option>
            <?php } } ?>
        </select>
    </div>
    <div class="col-2">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-floppy">&ensp;</i>Cadastrar
      </button>
    </div>
  </form>

  <?php if (isset($dados['lotes']) && !empty($dados['lotes'])) { ?>
    <div class="row">
      <div class="col table-responsive-md px-0">
        <table class="table table-bordered align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th scope="col" style="width:5%;">Código</th>
              <th scope="col" style="width:15%;">Data</th>
              <th scope="col" style="width:20%;">Fornecedor</th>
              <th scope="col" style="width:10%;">Total (R$)</th>
              <th scope="col" style="width:10%;">Opções</th>
            </tr>
          </thead>
          <tbody class="table-group-divider table-warning border-success text-center">
            <?php foreach ($dados['lotes'] as $lote) { ?>
              <tr>
                <th scope="row"><?= $lote->getCodigo() ?></th>
                <td><?= $lote->getData() ?></td>
                <td><?= $lote->getFornecedor()->getNome() ?></td>
                <td><?= $lote->getTotal() ?></td>
                <td>
                  <a href="http://<?=APP_HOST?>/produtoLote/index/<?= $lote->getCodigo() ?>" class="btn btn-warning d-block mb-1">
                    <i class="bi bi-eye">&ensp;</i>Visualizar Produtos
                  </a>
                  <a href="http://<?=APP_HOST?>/lote/encaminharEdicao/<?= $lote->getCodigo() ?>" class="btn btn-info d-block mb-1">
                    <i class="bi bi-pencil">&ensp;</i>Editar
                  </a>
                  <a href="http://<?=APP_HOST?>/lote/encaminharExclusao/<?= $lote->getCodigo() ?>"
                  class="btn btn-danger d-block">
                    <i class="bi bi-x-lg">&ensp;</i>Excluir
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <?= $dados['paginacao'] ?>

  <?php } else if (isset($dados['lotes']) && empty($dados['lotes'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há cadastros.</h2>
      </div>
    </div>
  <?php } ?>

</div>