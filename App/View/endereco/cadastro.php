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
      <form method="POST" action="http://<?=APP_HOST?>/endereco/cadastrar">
        <div class="row mb-3">
          <div class="col-auto">
            <h1>Cadastro de endereço</h1>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-auto">
            <a href="http://<?=APP_HOST?>/endereco" class="btn btn-secondary">
              <i class="bi bi-arrow-left">&ensp;</i>Voltar
            </a>
          </div>
        </div>
        <input type="hidden" name="cliente" value="<?= $sessao::getCodigoConta() ?>">
        <div class="row mb-3">
          <div class="col-12 col-md-7 col-lg-4">
            <label for="rua" class="form-label">Rua</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['rua_validada'] ? 'is-invalid' : '') ?>"
            id="rua" name="rua" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['rua'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['rua_validada']) { ?>
              <div class="alert alert-danger mt-1">
                O nome da rua deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-5 col-md-3 col-lg-2">
            <label for="numero" class="form-label">Número</label>
            <input type="number" class="form-control border border-primary"
            id="numero" name="numero" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['numero'] : '' ?>" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12 col-md-7 col-lg-4">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['bairro_validado'] ? 'is-invalid' : '') ?>"
            id="bairro" name="bairro" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['bairro'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['bairro_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O nome do bairro deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-8 col-md-6 col-lg-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['cidade_validada'] ? 'is-invalid' : '') ?>"
            id="cidade" name="cidade" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['cidade'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['cidade_validada']) { ?>
              <div class="alert alert-danger mt-1">
                O nome da cidade deve conter apenas letras, espaços ou apóstrofos.
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-auto">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select border border-primary" id="estado" name="estado" required>
              <option value="<?= (isset($dados['formulario'])) ? $dados['formulario']['estado'] : '' ?>" selected>
                <?= (isset($dados['formulario']) ? $dados['formulario']['estado'] : 'Selecione o estado') ?>
              </option>
              <option>AC</option>
              <option>AL</option>
              <option>AP</option>
              <option>AM</option>
              <option>BA</option>
              <option>CE</option>
              <option>DF</option>
              <option>ES</option>
              <option>GO</option>
              <option>MA</option>
              <option>MT</option>
              <option>MS</option>
              <option>MG</option>
              <option>PA</option>
              <option>PB</option>
              <option>PR</option>
              <option>PE</option>
              <option>PI</option>
              <option>RJ</option>
              <option>RN</option>
              <option>RS</option>
              <option>RO</option>
              <option>RR</option>
              <option>SC</option>
              <option>SP</option>
              <option>SE</option>
              <option>TO</option>
            </select>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-5 col-md-3 col-lg-2">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control border border-primary
            <?= (isset($dados['validacao']) && !$dados['validacao']['cep_validado'] ? 'is-invalid' : '') ?>"
            id="cep" name="cep" value="<?= (isset($dados['formulario'])) ? $dados['formulario']['cep'] : '' ?>" required>
            <?php if (isset($dados['validacao']) && !$dados['validacao']['cep_validado']) { ?>
              <div class="alert alert-danger mt-1">
                O CEP deve ter 8 dígitos juntos ou separados por hífen (-).
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