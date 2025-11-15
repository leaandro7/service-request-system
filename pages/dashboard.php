<?php

require "connection.php";

try {
    $stmt = $pdo->query("SELECT * FROM chamados");
    $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $err) {
    echo ("Erro no Fetch de chamados:" . $err->getMessage());
}


// Definindo algumas variáveis derivadas de $chamaados.

$total_abertos = 0;
$total_andamento = 0;
$total_concluido = 0;
$total_suspenso = 0;


foreach ($chamados as $chamado) {

    $total_abertos++;

    switch ($chamado["status"]) {

        case "1":
            $total_andamento++;
            break;
        case "2":
            $total_concluido++;
            break;
        case "3":
            $total_suspenso++;
            break;
    }
}

?>

<div class="dashboard">
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <div class="dashboard-content">
            <p class="text-dashboard-content">Ordens de Serviço</p>
            <div class="dashboard-cards">
                <div class="ticket-card">

                    <p class="card-title">Chamados Abertos</p>
                    <p class="card-value"><?= $total_abertos ?></p>
                    <span style="opacity: 0;">
                        <p>Relação</p>
                        <p>50%</p>
                    </span>

                </div>

                <div class="ticket-card" style="background-color: #ffe6099d; color: black;">
                    <p class="card-title">Em andamento</p>
                    <p class="card-value"><?= $total_andamento ?></p>
                    <span>
                        <p>Relação</p>
                        <p><?=
                            $total_abertos > 0
                                ? number_format($total_andamento * 100 / $total_abertos, 1)  . "%" : '0%';
                            ?>
                        </p>
                    </span>
                </div>

                <div class="ticket-card" style="background-color: #1ac734; color: black;">
                    <p class="card-title">Concluídos</p>
                    <p class="card-value"><?= $total_concluido ?></p>
                    <span>
                        <p>Relação</p>
                        <p><?=
                            $total_abertos > 0
                                ? number_format($total_concluido * 100 / $total_abertos, 1)  . "%" : '0%';
                            ?>
                        </p>
                    </span>
                </div>

                <div class="ticket-card" style="background-color: #ff4133c7; color: black;">
                    <p class="card-title">Suspensos</p>
                    <p class="card-value"><?= $total_suspenso ?></p>
                    <span>
                        <p>Relação</p>
                        <p><?=
                            $total_abertos > 0
                                ? number_format($total_suspenso * 100 / $total_abertos, 1)  . "%" : '0%';
                            ?>
                        </p>
                    </span>
                </div>

            </div>
        </div>
    </div>

    <section class="table-section">
        <h2 class="table-title">Ordens de Serviço</h2>

        <table class="service-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Resolução</th>
                    <th>Turno</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <?php if (count($chamados) > 0): ?>

                    <?php
                    // Classes CSS para cada status
                    $status_classes = [
                        '0' => 'status-open',
                        '1' => 'status-progress',
                        '2' => 'status-done',
                        '3' => 'status-suspended'
                    ];

                    // Textos legíveis para cada status
                    $status_labels = [
                        '0' => 'Aberto',
                        '1' => 'Em Andamento',
                        '2' => 'Concluído',
                        '3' => 'Suspenso',
                    ];
                    ?>

                    <?php foreach ($chamados as $chamado): ?>
                        <tr id=<?= $chamado['id'] ?> class="row-click">
                            <td><?= htmlspecialchars($chamado['id']) ?></td>
                            <td><?= htmlspecialchars($chamado['categoria']) ?></td>

                            <!-- Resolução -->
                            <td><?= $chamado['duracao'] !== null ? htmlspecialchars($chamado['duracao']) . " segundos" : '00:00' ?></td>

                            <!-- Turno -->
                            <td><?= htmlspecialchars($chamado['turno']) ?></td>

                            <!-- Status com classe dinâmica -->
                            <td>
                                <span class="status <?= $status_classes[$chamado['status']] ?>">
                                    <?= $status_labels[$chamado['status']] ?>
                                </span>
                            </td>


                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>


            </tbody>
        </table>
    </section>
</div>


<!-- MODAL -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <h2>Detalhes do Chamado</h2>
        <p><strong>Categoria:</strong> <span id="m_categoria"></span></p>
        <p><strong>Descrição:</strong> <span id="m_descricao"></span></p>
        <p><strong>Status:</strong> <span id="m_status"></span></p>

        <!-- Duraçção -->
        <p id="duracao_wrap" style="display:none;">
            <strong>Duração:</strong>
            <span id="m_duracao"></span> minutos
        </p>

        <div id="buttonsArea"></div>
    </div>
</div>

<script>
    // Função para mudar valores do MODAL
    const $ = id => document.getElementById(id);

    const statusClass = {
        0: "status-open",
        1: "status-progress",
        2: "status-done",
        3: "status-suspended"
    };

    const statusText = {
        0: "Em Aberto",
        1: "Em Andamento",
        2: "Concluído",
        3: "Suspenso"
    };

    // Função para mudar valores do MODAL - FIM
    document.querySelectorAll('.row-click').forEach(row => {
        row.addEventListener('click', function() {
            const chamados = <?= json_encode($chamados) ?>;

            const item = chamados.find(c => c.id == row.id)

            // Substituindo valores no modal
            $('m_categoria').textContent = item.categoria;
            $('m_descricao').textContent = item.descricao;

            // Duração (Só aparecer se for maior que 0 (se tiver sido concluída))
            if (item.duracao > 0) {
                $('duracao_wrap').style.display = "block";
                $('m_duracao').textContent = item.duracao;
            } else {
                $('duracao_wrap').style.display = "none";
            }
            // Status
            const statusEl = $('m_status');
            statusEl.textContent = statusText[item.status] ?? "Desconhecido";
            statusEl.className = ""; // limpa classes
            statusEl.classList.add(statusClass[item.status]);
            // Substituindo valores no modal - FIM //

            // botões dinâmicos baseado só no vetor
            const area = document.getElementById('buttonsArea');
            area.innerHTML = '';
            if (item.status == 0) {
                area.innerHTML = `<button onclick="iniciar(${item.id})">Iniciar</button>`;
            } else if (item.status == 1) {
                area.innerHTML = `
                <button onclick="finalizar(${item.id})">Finalizar</button>
                <button onclick="suspender(${item.id})">Suspender</button>
            `;
            } else if (item.status == 3) {
                area.innerHTML = `<button onclick="iniciar(${item.id})">Reiniciar</button>`;
            }
            // Abrir modal
            document.getElementById("modal").style.display = "flex";

        });
    });

    // Exit, do modal
    document.getElementById('closeModal').onclick = () => {
        document.getElementById("modal").style.display = "none";
    };


    // Funções dos botões
    const iniciar = (id) => {
        fetch("update.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${id}&action=iniciar`
            })
            .then(r => r.text())
            .then(res => {
                console.log(res);
            });
        location.reload()
    }

    const finalizar = (id) => {
        fetch("update.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${id}&action=finalizar`
            })
            .then(r => r.text())
            .then(res => {
                console.log(res);
            });
        location.reload()
    }


    const suspender = (id) => {
        fetch("update.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${id}&action=suspender`
            })
            .then(r => r.text())
            .then(res => {
                console.log(res);
            });
        location.reload()
    }
</script>