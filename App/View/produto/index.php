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
      <h1>Produtos</h1>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/produto/encaminharCadastro" class="btn btn-success">
        <i class="bi bi-plus-lg">&ensp;</i>Adicionar
      </a>
    </div>
    <div class="col-auto dropdown mx-auto me-0 pe-0">
      <a class="btn btn-warning dropdown-toggle" href="#" data-bs-toggle="dropdown">
        Departamento
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="http://<?=APP_HOST?>/produto">
          Todos
        </a></li>
        <?php if (isset($dados['departamentos']) && !empty($dados['departamentos'])) { ?>
          <?php foreach($dados['departamentos'] as $departamento) { ?>
            <li><a class="dropdown-item" href="http://<?=APP_HOST?>/produto?departamento=<?=$departamento->getNome()?>">
              <?= $departamento->getNome() ?>
            </a></li>
        <?php } } ?>
      </ul>
    </div>
    <div class="col-auto mx-auto me-0 ms-0">
      <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/produto">
        <input type="hidden" id="departamento" name="departamento" value="<?=(isset($_GET['departamento'])) ? $_GET['departamento'] : ''?>">
        <input class="form-control me-2" type="search" size="25" id="busca" name="busca" placeholder="Nome do produto">
        <button class="btn btn-primary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>
  </div>

  <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) { ?>
    <div class="row">
      <div class="col table-responsive-md px-0">
        <table class="table table-bordered align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th scope="col" style="width:5%;">Código</th>
              <th scope="col" style="width:25%;">Nome</th>
              <th scope="col" style="width:10%;">Preço (R$)</th>
              <th scope="col" style="width:5%;">Estoque</th>
              <th scope="col" style="width:15%;">Departamento</th>
              <th scope="col" style="width:15%;">Imagem</th>
              <th scope="col" style="width:15%;">Opções</th>
            </tr>
          </thead>
          <tbody class="table-group-divider table-warning border-success text-center">
            <?php foreach ($dados['produtos'] as $produto) { ?>
              <tr>
                <th scope="row"><?= $produto->getCodigo() ?></th>
                <td><?= $produto->getNome() ?></td>
                <td><?= $produto->getPrecoView() ?></td>
                <td><?= $produto->getEstoque() ?></td>
                <td><?= $produto->getDepartamento()->getNome() ?></td>
                <td>
                  <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>" width="60%">
                </td>
                <td>
                  <a href="http://<?=APP_HOST?>/produto/encaminharEdicao/<?= $produto->getCodigo() ?>"
                  class="btn btn-info editar">
                    <i class="bi bi-pencil">&ensp;</i>Editar
                  </a>
                  <a href="http://<?=APP_HOST?>/produto/encaminharExclusao/<?= $produto->getCodigo() ?>"
                  class="btn btn-danger excluir">
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


  <?php } else if (isset($dados['produtos']) && empty($dados['produtos'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há cadastros.</h2>
      </div>
    </div>
  <?php } ?>

</div>