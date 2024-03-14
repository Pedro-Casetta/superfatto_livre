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
      <h1>Endereços</h1>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/conta/encaminharPerfil" class="btn btn-secondary">
        <i class="bi bi-arrow-left">&ensp;</i>Voltar
      </a>
    </div>
    <div class="col-auto">
      <a href="http://<?=APP_HOST?>/endereco/encaminharCadastro" class="btn btn-success">
        <i class="bi bi-plus-lg">&ensp;</i>Adicionar
      </a>
    </div>
    <div class="col-auto mx-auto me-0">
      <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/endereco">
        <input class="form-control me-2" type="search" size="30" id="busca" name="busca" placeholder="Rua, bairro...">
        <button class="btn btn-primary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>
  </div>

  <?php if (isset($dados['enderecos']) && !empty($dados['enderecos'])) { ?>
    <div class="row">
      <div class="col table-responsive-md px-0">
        <table class="table table-bordered align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th scope="col" style="width:15%;">Rua</th>
              <th scope="col" style="width:5%;">Número</th>
              <th scope="col" style="width:20%;">Bairro</th>
              <th scope="col" style="width:15%;">Cidade</th>
              <th scope="col" style="width:15%;">Estado</th>
              <th scope="col" style="width:10%;">CEP</th>
              <th scope="col" style="width:15%;">Opções</th>
            </tr>
          </thead>
          <tbody class="table-group-divider table-warning border-success text-center">
            <?php foreach ($dados['enderecos'] as $endereco) { ?>
              <tr>
                <th scope="row"><?= $endereco->getRua() ?></th>
                <td><?= $endereco->getNumero() ?></td>
                <td><?= $endereco->getBairro() ?></td>
                <td><?= $endereco->getCidade() ?></td>
                <td><?= $endereco->getEstado() ?></td>
                <td><?= $endereco->getCep() ?></td>
                <td>
                  <a href="http://<?=APP_HOST?>/endereco/encaminharEdicao/<?= $endereco->getCodigo() ?>"
                  class="btn btn-info editar">
                    <i class="bi bi-pencil">&ensp;</i>Editar
                  </a>
                  <a href="http://<?=APP_HOST?>/endereco/encaminharExclusao/<?= $endereco->getCodigo() ?>"
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

  <?php } else if (isset($dados['enderecos']) && empty($dados['enderecos'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há cadastros.</h2>
      </div>
    </div>
  <?php } ?>

</div>