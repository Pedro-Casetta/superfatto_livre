<div class="container-sm my-5">
  
  <?php if($sessao::getMensagem()) { ?>
    <div class="row">
      <div class="col alert alert-<?= (stripos($sessao::getMensagem(), 'Erro') !== false) ? 'danger' : 'info' ?>" id="mensagem">
        <button onclick="fecharMensagem('mensagem')" type="button" class="btn-close" aria-label="Close"></button>
        <h2><?= $sessao::getMensagem() ?></h2>
      </div>
    </div>
  <?php } ?>
  
  <div class="row">
    <div class="col">
      <form method="POST" action="http://<?=APP_HOST?>/conta/cadastrar">
        <div class="row mb-3">
          <div class="col-auto">
            <h1>Cadastro de usuário</h1>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <a href="http://<?=APP_HOST?>/" class="btn btn-secondary">
              <i class="bi bi-arrow-left">&ensp;</i>Voltar
            </a>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12 col-md-4">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control border border-black
            <?= (isset($dados['validacao']) && !$dados['validacao']['nome_validado'] ? 'is-invalid' : '') ?>"
            id="nome" name="nome" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['nome'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['nome_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O nome deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
          <div class="col-12 col-md-4 mx-auto">
            <label for="email" class="form-label">E-mail</label>
            <input type="text" class="form-control border border-black
            <?= (isset($dados['validacao']) && !$dados['validacao']['email_validado'] ? 'is-invalid' : '') ?>"
            id="email" name="email" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['email'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['email_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O formato de e-mail está incorreto.
              </div>
            <?php } else if (isset($dados['validacao']) && !$dados['validacao']['email_novo']) { ?>
              <div class="alert alert-danger mt-1">
                Esse e-mail já está sendo utilizado.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12 col-md-4">
            <label for="nome_usuario" class="form-label">Nome de usuário</label>
            <input type="text" class="form-control border border-black
            <?= (isset($dados['validacao']) && !$dados['validacao']['usuario_validado'] ? 'is-invalid' : '') ?>"
            id="nome_usuario" name="nome_usuario"
            value="<?= (isset($dados['formulario'])) ? $dados['formulario']['nome_usuario'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['usuario_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O nome de usuário deve conter pelo menos 6 dígitos alfanuméricos (A a Z, 0 a 9).
              </div>
            <?php } else if (isset($dados['validacao']) && !$dados['validacao']['usuario_novo']) { ?>
              <div class="alert alert-danger mt-1">
                Esse nome de usuário já está sendo utilizado.
              </div>
            <?php } ?>
          </div>
          <div class="col-12 col-md-4 mx-auto">
            <label for="tipo" class="form-label">Tipo de conta</label>
            <select class="form-select border border-black" id="tipo" name="tipo"
            onchange="exibirCampoCadastroConta(this.value)" required>
              <option value="" <?= (!isset($dados['formulario'])) ? 'selected' : '' ?>>Selecione o tipo</option>
              <option value="administrador"<?= 
              (isset($dados['formulario']) && $dados['formulario']['tipo'] == 'administrador') ? 'selected' : '' ?>>
              Administrador</option>
              <option value="cliente"<?= 
              (isset($dados['formulario']) && $dados['formulario']['tipo'] == 'cliente') ? 'selected' : '' ?>>
              Cliente</option>
            </select>
            <div class="row mb-4"
            style="display: <?= (isset($dados['formulario']) && $dados['formulario']['tipo'] == 'cliente') ? 'inline;' : 'none;'?>"
            id="campoTelefone">
              <div class="col p-0">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control border border-black
                <?= (isset($dados['validacao']) && !$dados['validacao']['telefone_validado'] ? 'is-invalid' : '') ?>"
                id="telefone" name="telefone" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['telefone'] : '' ?>">
                <?php if (isset($dados['validacao']) && !$dados['validacao']['telefone_validado']) { ?>
                  <div class="alert alert-danger mt-1">
                    O telefone deve conter pelo menos 8 dígitos, todos numéricos (0 a 9).
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="row mb-4"
            style="display: <?= (isset($dados['formulario']) && $dados['formulario']['tipo'] == 'administrador') ? 'inline;' : 'none;'?>"
            id="campoCredencial">
              <div class="col p-0">
                <label for="credencial" class="form-label">Credencial</label>
                <input type="text" class="form-control border border-black" id="credencial" name="credencial"
                value="<?= (isset($dados['formulario'])) ? $dados['formulario']['credencial'] : '' ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12 col-md-4">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control border border-black
            <?= (isset($dados['validacao']) && !$dados['validacao']['senha_validada'] ? 'is-invalid' : '') ?>"
            id="senha" name="senha" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['senha'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['senha_validada']) { ?>
              <div class="alert alert-danger mt-1">
                A senha deve conter pelo menos 6 dígitos.
              </div>
            <?php } ?>
          </div>
          <div class="col-12 col-md-4 mx-auto">
            <label for="confirma_senha" class="form-label">Confirme a senha</label>
            <input type="password" class="form-control border border-black
            <?= (isset($dados['validacao']) && !$dados['validacao']['confirmacao_senha'] ? 'is-invalid' : '') ?>"
            id="confirma_senha" name="confirma_senha"
            value="<?= (isset($dados['formulario'])) ? $dados['formulario']['confirma_senha'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['confirmacao_senha']) { ?>
              <div class="alert alert-danger mt-1">
                As senhas digitadas não conferem.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-auto">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-floppy">&ensp;</i>Cadastrar
            </button>
          </div>
          <div class="col-auto">
            <button type="reset" class="btn btn-warning">
              <i class="bi bi-eraser">&ensp;</i>Limpar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>