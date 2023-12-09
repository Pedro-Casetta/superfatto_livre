<table class="table table-bordered">
  <thead class="table-dark">
    <tr>
      <th scope="col">Código</th>
      <th scope="col">CNPJ</th>
      <th scope="col">Nome</th>
      <th scope="col">Categoria</th>
    </tr>
  </thead>
  <tbody class="table-group-divider table-warning border-success">
    <?php foreach ($dados['fornecedores'] as $fornecedor) { ?>
        <tr>
          <th scope="row"><?= $fornecedor->getCodigo(); ?></th>
          <td><?= $fornecedor->getCnpj(); ?></td>
          <td><?= $fornecedor->getNome(); ?></td>
          <td><?= $fornecedor->getCategoria(); ?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>