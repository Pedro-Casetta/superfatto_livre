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
      <h1>Departamentos</h1>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/lote" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto mx-auto me-0">
      <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/departamento">
        <input class="form-control me-2" type="search" size="25" id="busca" name="busca" placeholder="Nome do departamento">
        <button class="btn btn-primary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>
  </div>
  
  <form action="http://<?=APP_HOST?>/departamento/cadastrar" method="POST" class="row mb-3 form-inline">
    <div class="col-4">
      <input type="text" class="form-control border border-primary" id="nome" name="nome" required>
    </div>
    <div class="col-2">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-floppy">&ensp;</i>Cadastrar
      </button>
    </div>
  </form>

  <?php if (isset($dados['departamentos']) && !empty($dados['departamentos'])) { ?>
    <div class="row">
      <div class="col table-responsive-md px-0">
        <table class="table table-bordered align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th scope="col" style="width:10%;">Codigo</th>
              <th scope="col" style="width:20%;">Nome</th>
              <th scope="col" style="width:20%;">Opções</th>
            </tr>
          </thead>
          <tbody class="table-group-divider table-warning border-success text-center">
            <?php foreach ($dados['departamentos'] as $departamento) { ?>
              <tr>
                <td><?= $departamento->getCodigo() ?></td>
                <td><?= $departamento->getNome() ?></td>
                <td>
                  <a href="http://<?=APP_HOST?>/departamento/encaminharEdicao/<?= $departamento->getCodigo()?>"
                  class="btn btn-info">
                    <i class="bi bi-pencil">&ensp;</i>Editar
                  </a>
                  <a href="http://<?=APP_HOST?>/departamento/encaminharExclusao/<?= $departamento->getCodigo()?>"
                  class="btn btn-danger margem_celular">
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

  <?php } else if (isset($dados['departamentos']) && empty($dados['departamentos'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há cadastros.</h2>
      </div>
    </div>
  <?php } ?>

</div>