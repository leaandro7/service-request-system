<div class="form-wrapper">
  <form method="POST" action="insert.php" class="form-box">
    <h2>Cadastro</h2>

    <label for="categoria">Categoria:</label>
    <select name="categoria" id="categoria" required>
      <option value="">Selecione...</option>
      <option value="Suporte Técnico">Suporte Técnico</option>
      <option value="Configuração de Software">Configuração de Software</option>
      <option value="Problema com periféricos">Problema com periféricos</option>
      <option value="Falha na Autenticação">Falha na Autenticação</option>
    </select>

    <label for="turno">Turno:</label>
    <select name="turno" id="turno" required>
      <option value="">Selecione...</option>
      <option value="Manhã">Manhã</option>
      <option value="Tarde">Tarde</option>
      <option value="Noite">Noite</option>
    </select>

    <label>Descrição:</label>
    <textarea name="descricao" id="descricao" rows="4" maxlength="50" placeholder="Digite aqui..." required></textarea>
    <p id="contadorDesc" style="margin-top: 4px; font-weight: bold;">0 / 50</p>

    <button type="submit">Enviar</button>
  </form>

  <script>
    const $ = id => document.getElementById(id);

    $("descricao").addEventListener("input", () => {
        const txt = $("descricao").value;
        const len = txt.length;
        const max = 50;

        $("contadorDesc").textContent = `${len} / ${max}`;

        if (len >= max) {
            $("contadorDesc").style.color = "red";
            $("descricao").style.borderColor = "red";
        } else {
            $("contadorDesc").style.color = "";
            $("descricao").style.borderColor = "";
        }
    });
  </script>
</div>
