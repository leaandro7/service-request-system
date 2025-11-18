<?php
require "connection.php";

try {
    $stmt = $pdo->query("SELECT * FROM chamados");
    $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $err) {
    echo "Erro no Fetch de chamados: " . $err->getMessage();
}
?>

<table class="adm-service-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Categoria</th>
            <th>Descrição</th>
            <th>Turno</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($chamados as $chamado): ?>
        <tr>
            <td><?= "#" . str_pad($chamado['id'], 4, "0", STR_PAD_LEFT) ?></td>
            <td><?= htmlspecialchars($chamado['categoria']) ?></td>

            <td class="descricao-col"><?= htmlspecialchars($chamado['descricao']) ?></td>

            <td><?= htmlspecialchars($chamado['turno']) ?></td>
            <td>

                <button class="btn-edit" onclick="abrirModalEditar(<?= $chamado['id'] ?>)">
                <i class="fa-solid fa-pen-to-square"></i>
                </button>

                <button class="btn-delete" onclick="abrirModal(<?= $chamado['id'] ?>)">
                <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div id="admModal" class="adm-modal">
    <div class="adm-modal-content">
        <span id="admClose" class="adm-close">&times;</span>

        <h2>Detalhes do Chamado</h2>

        <div class="modal-content-details">
        <p><strong>Categoria:</strong> <span id="m_categoria"></span></p>
        <p><strong>Descrição:</strong> <span id="m_descricao" class="descricao-modal-delete"></span></p>
        </div>
        
        <div id="buttonsDelete"></div>
    </div>
</div>

<div id="editModal" class="adm-modal">
    <div class="adm-modal-content edit-style">
        <span id="editClose" class="adm-close">&times;</span>

        <h2 class="edit-title">Editar Chamado</h2>

        <form id="formEditar">
            <input type="hidden" id="edit_id">

            <label>Categoria:</label>
            <select id="edit_categoria" required>
                <option value="Suporte Técnico">Suporte Técnico</option>
                <option value="Configuração de Software">Configuração de Software</option>
                <option value="Problema com periféricos">Problema com periféricos</option>
                <option value="Falha na Autenticação">Falha na Autenticação</option>
            </select>

            <label>Descrição:</label>
            <div class="descricao-container">
                <textarea id="edit_descricao" maxlength="50" required></textarea>
                <p id="contadorDesc" class="contador">0 / 50</p>
            </div>

            <label>Turno:</label>
            <select id="edit_turno">
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
            </select>

            <button type="submit" class="btn-edit save-btn">Salvar</button>
        </form>
    </div>
</div>


<script>

    

const chamados = <?= json_encode($chamados) ?>;

    const modalDelete = document.getElementById("admModal");
    const modalEdit   = document.getElementById("editModal");

    const closeDelete = document.getElementById("admClose");
    const closeEdit   = document.getElementById("editClose");

    const $ = id => document.getElementById(id);

    /**
     * ABRIR MODAL DELETE
     */
    function abrirModal(id) {
        const item = chamados.find(c => c.id == id);

        $("m_categoria").textContent = item.categoria;
        $("m_descricao").textContent = item.descricao;

        $("buttonsDelete").innerHTML = `
            <button class="delete-btn-modal" onclick="deletar(${item.id})">
                Deletar
            </button>
        `;

        modalDelete.style.display = "flex";
    }

    closeDelete.onclick = () => modalDelete.style.display = "none";

    /**
     * ABRIR MODAL EDITAR
     */
    function abrirModalEditar(id) {
        const item = chamados.find(c => c.id == id);

        $("edit_id").value = item.id;
        $("edit_categoria").value = item.categoria;
        $("edit_descricao").value = item.descricao;
        $("edit_turno").value = item.turno;

        modalEdit.style.display = "flex";
    }

    closeEdit.onclick = () => modalEdit.style.display = "none";

    /**
     * ENVIAR EDIÇÃO
     */
    $("formEditar").addEventListener("submit", async (e) => {
        e.preventDefault();

        const dados = new URLSearchParams();
        dados.append("id", $("edit_id").value);
        dados.append("categoria", $("edit_categoria").value);
        dados.append("descricao", $("edit_descricao").value);
        dados.append("turno", $("edit_turno").value);
        dados.append("action", "editar");

        const resposta = await fetch("update.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: dados
        });

        marcarRowEditada($("edit_id").value);

        location.reload();
    });

    function marcarRowEditada(id) {
    localStorage.setItem("row_editada", id);
    }

    /**
     * DELETAR
     */
    function deletar(id) {
        if (!confirm("Tem certeza que deseja deletar este chamado?")) return;

        fetch("delete.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}`
        })
        .then(r => r.text())
        .then(() => location.reload());
    }

    // VALIDAÇÃO DE EDITAR DESCRIÇÃO
    $("edit_descricao").addEventListener("input", () => {
        const txt = $("edit_descricao").value;
        const len = txt.length;
        const max = 50;

        $("contadorDesc").textContent = `${len} / ${max}`;

        if (len >= max) {
            $("contadorDesc").style.color = "red";
            $("edit_descricao").style.borderColor = "red";
        } else {
            $("contadorDesc").style.color = "";
            $("edit_descricao").style.borderColor = "";
        }
    });
</script>