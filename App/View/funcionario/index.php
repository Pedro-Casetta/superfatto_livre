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
      <h1>Funcionários</h1>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/funcionario/encaminharCadastro" class="btn btn-success">
        <i class="bi bi-plus-lg">&ensp;</i>Adicionar
      </a>
    </div>
    <div class="col-auto mx-auto me-0">
      <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/funcionario">
        <input class="form-control me-2" type="search" size="30" id="busca" name="busca" placeholder="Nome ou setor do funcionário">
        <button class="btn btn-primary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>
  </div>

  <?php if (isset($dados['funcionarios']) && !empty($dados['funcionarios'])) { ?>
    <div class="row">
      <div class="col table-responsive-md px-0">
        <table class="table table-bordered align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th scope="col" style="width:5%;">Código</th>
              <th scope="col" style="width:15%;">CPF</th>
              <th scope="col" style="width:25%;">Nome</th>
              <th scope="col" style="width:15%;">Setor</th>
              <th scope="col" style="width:10%;">Salário (R$)</th>
              <th scope="col" style="width:15%;">Opções</th>
            </tr>
          </thead>
          <tbody class="table-group-divider table-warning border-success text-center">
            <?php foreach ($dados['funcionarios'] as $funcionario) { ?>
              <tr>
                <th scope="row"><?= $funcionario->getCodigo() ?></th>
                <td><?= $funcionario->getCpf() ?></td>
                <td><?= $funcionario->getNome() ?></td>
                <td><?= $funcionario->getSetor() ?></td>
                <td><?= $funcionario->getSalarioView() ?></td>
                <td>
                  <a href="http://<?=APP_HOST?>/funcionario/encaminharEdicao/<?= $funcionario->getCodigo() ?>"
                  class="btn btn-info editar">
                    <i class="bi bi-pencil">&ensp;</i>Editar
                  </a>
                  <a href="http://<?=APP_HOST?>/funcionario/encaminharExclusao/<?= $funcionario->getCodigo() ?>"
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

  <?php } else if (isset($dados['funcionarios']) && empty($dados['funcionarios'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há cadastros.</h2>
      </div>
    </div>
  <?php } ?>

</div>