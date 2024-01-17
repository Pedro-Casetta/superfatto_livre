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
  </div>

  <?php if (isset($dados['produtos']) && !empty($dados['produtos'])) { ?>
    <div class="row">
      <div class="col table-responsive-md">
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
                <td><?= $produto->getPreco() ?></td>
                <td><?= $produto->getEstoque() ?></td>
                <td><?= $produto->getDepartamento()->getNome() ?></td>
                <td>
                  <img src="http://<?=APP_HOST?>/public/imagem/produto/<?= $produto->getImagem() ?>" width="60%">
                </td>
                <td>
                  <a href="http://<?=APP_HOST?>/produto/encaminharEdicao/<?= $produto->getCodigo() ?>" class="btn btn-info">
                    <i class="bi bi-pencil">&ensp;</i>Editar
                  </a>
                  <a href="http://<?=APP_HOST?>/produto/encaminharExclusao/<?= $produto->getCodigo() ?>"
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

  <?php } else if (isset($dados['produtos']) && empty($dados['produtos'])) { ?>
    <div class="row">
      <div class="col alert alert-dark">
        <h2>Não há cadastros.</h2>
      </div>
    </div>
  <?php } ?>

</div>