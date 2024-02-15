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
          <div class="col-6 col-md-4 col-lg-3">
            <label for="rua" class="form-label">Rua</label>
            <input type="text" class="form-control border border-primary" id="rua" name="rua" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-11 col-md-9 col-lg-6">
            <label for="numero" class="form-label">Número</label>
            <input type="number" class="form-control border border-primary" id="numero" name="numero" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-11 col-md-9 col-lg-6">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control border border-primary" id="bairro" name="bairro" required>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-11 col-md-9 col-lg-6">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control border border-primary" id="cidade" name="cidade" required>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-11 col-md-9 col-lg-6">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select border border-primary" id="estado" name="estado" required>
              <option value="" selected>Selecione o estado</option>
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
          <div class="col-11 col-md-9 col-lg-6">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control border border-primary" id="cep" name="cep" required>
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