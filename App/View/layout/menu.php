<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="http://<?= APP_HOST; ?>/home">
      <img src="http://<?=APP_HOST?>/public/favicon_io/favicon-32x32.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Superfatto Livre
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php if ($sessao::getNomeUsuario() && $sessao::getTipoConta() == "administrador") { ?>
        <ul class="navbar-nav mx-auto">
          <li class="nav-item bg-success me-lg-1">
            <a class="nav-link text-warning" href="http://<?=APP_HOST?>/venda">
              <i class="bi bi-tag fs-3">&nbsp;</i>Vendas
            </a>
          </li>
          <li class="nav-item bg-success me-lg-1">
            <a class="nav-link text-warning" href="http://<?=APP_HOST?>/funcionario">
              <i class="bi bi-people fs-3">&nbsp;</i>Funcionários
            </a>
          </li>
          <li class="nav-item bg-success me-lg-1">
            <a class="nav-link text-warning" href="http://<?=APP_HOST?>/fornecedor">
              <i class="bi bi-truck fs-3">&nbsp;</i>Fornecedores
            </a>
          </li>
          <li class="nav-item bg-success me-lg-1">
            <a class="nav-link text-warning" href="http://<?=APP_HOST?>/lote">
              <i class="bi bi-box-seam fs-3">&nbsp;</i>Lote
            </a>
          </li>
          <li class="nav-item bg-success">
            <a class="nav-link text-warning" href="http://<?=APP_HOST?>/produto">
              <i class="bi bi-shop fs-3">&nbsp;</i>Produtos
            </a>
          </li>
        </ul>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <?= $sessao::getNomeUsuario() ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="http://<?=APP_HOST?>/conta/encaminharPerfil">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="http://<?=APP_HOST?>/conta/logout">Logout</a></li>
          </ul>
        </div>
      <?php } else if ($sessao::getNomeUsuario() && $sessao::getTipoConta() == "cliente") { ?>
        <div class="col-auto dropdown mx-auto me-0 pe-2">
          <a class="btn btn-secondary dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Departamento
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="http://<?=APP_HOST?>/">
              Todos
            </a></li>
            <?php if (isset($dados['departamentos']) && !empty($dados['departamentos'])) { ?>
              <?php foreach($dados['departamentos'] as $departamento) { ?>
                <li><a class="dropdown-item" href="http://<?=APP_HOST?>/?departamento=<?=$departamento->getNome()?>">
                  <?= $departamento->getNome() ?>
                </a></li>
            <?php } } ?>
          </ul>
        </div>
        <div class="col-auto mx-auto ms-0">
          <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/">
            <input type="hidden" id="departamento" name="departamento" value="<?=(isset($_GET['departamento'])) ? $_GET['departamento'] : ''?>">
            <input class="form-control me-2" type="search" size="30" id="busca" name="busca" placeholder="Nome do produto">
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </form>
        </div>
        <div class="col-auto mx-auto me-1">
          <a href="http://<?=APP_HOST?>/carrinho/" class="btn btn-dark">
            <i class="bi bi-cart"></i>
          </a>
        </div>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <?= $sessao::getNomeUsuario() ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="http://<?=APP_HOST?>/conta/encaminharPerfil">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="http://<?=APP_HOST?>/conta/logout">Logout</a></li>
          </ul>
        </div>
      <?php } else { ?>
        <div class="col-auto dropdown mx-auto me-0 pe-2">
          <a class="btn btn-secondary dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Departamento
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="http://<?=APP_HOST?>/">
              Todos
            </a></li>
            <?php if (isset($dados['departamentos']) && !empty($dados['departamentos'])) { ?>
              <?php foreach($dados['departamentos'] as $departamento) { ?>
                <li><a class="dropdown-item" href="http://<?=APP_HOST?>/?departamento=<?=$departamento->getNome()?>">
                  <?= $departamento->getNome() ?>
                </a></li>
            <?php } } ?>
          </ul>
        </div>
        <div class="col-auto mx-auto ms-0">
          <form class="d-flex" method="GET" action="http://<?=APP_HOST?>/">
            <input type="hidden" id="departamento" name="departamento" value="<?=(isset($_GET['departamento'])) ? $_GET['departamento'] : ''?>">
            <input class="form-control me-2" type="search" size="30" id="busca" name="busca" placeholder="Nome do produto">
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </form>
        </div>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="http://<?=APP_HOST?>/conta/encaminharCadastro">Cadastrar-se</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://<?=APP_HOST?>/conta/encaminharAcesso">Acessar</a>
          </li>
        </ul>
      <?php } ?>
    </div>
  </div>
</nav>