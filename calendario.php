<?php
session_start();
include "conexaoBD.php";

if (!isset($_SESSION['idUsuario'])) {
    header("Location: formLogin.php");
    exit();
}
$idUsuario = $_SESSION['idUsuario'];

$mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
$ano = isset($_GET['ano']) ? $_GET['ano'] : date('Y');

$primeiroDia = mktime(0, 0, 0, $mes, 1, $ano);
$diasNoMes = date('t', $primeiroDia);
$diaDaSemana = date('w', $primeiroDia);

$dataSelecionada = isset($_GET['data'])
    ? $_GET['data']
    : null;
$eventosDoDia = [];

if ($dataSelecionada) {

    $buscarEventos = "
        SELECT *
        FROM eventos
        WHERE idUsuario = '$idUsuario'
        AND dataEvento = '$dataSelecionada'
        ORDER BY horaEvento ASC
    ";

    $resultadoEventos = mysqli_query(
        $conn,
        $buscarEventos
    );

    if ($resultadoEventos) {
        while ($evento = mysqli_fetch_assoc($resultadoEventos)) {
            $eventosDoDia[] = $evento;
        }
    }
}
?>

<?php include "header.php"?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Calendário - S.O.Study</title>

        <link rel="stylesheet" href="css/geral.css">
        <link rel="stylesheet" href="css/calendario.css">
    </head>

    <body>

        <main>

            <h2 class="titulo-calendario">
                📅 Calendário
            </h2>

            <section class="area-calendario">

                <div class="calendario">

                    <div class="navegacao">

                        <?php
                        $mesAnterior = $mes - 1;
                        $anoAnterior = $ano;

                        if ($mesAnterior < 1) {
                            $mesAnterior = 12;
                            $anoAnterior--;
                        }

                        $mesProximo = $mes + 1;
                        $anoProximo = $ano;

                        if ($mesProximo > 12) {
                            $mesProximo = 1;
                            $anoProximo++;
                        }
                        ?>

                        <a href="?mes=<?php echo $mesAnterior; ?>&ano=<?php echo $anoAnterior; ?>">
                            ←
                        </a>

                        <h3>
                            <?php
                            $meses = [
                                1 => 'Janeiro',
                                2 => 'Fevereiro',
                                3 => 'Março',
                                4 => 'Abril',
                                5 => 'Maio',
                                6 => 'Junho',
                                7 => 'Julho',
                                8 => 'Agosto',
                                9 => 'Setembro',
                                10 => 'Outubro',
                                11 => 'Novembro',
                                12 => 'Dezembro'
                            ];
                            echo $meses[(int)$mes] . ' ' . $ano;
                            ?>
                        </h3>

                        <a href="?mes=<?php echo $mesProximo; ?>&ano=<?php echo $anoProximo; ?>">
                            →
                        </a>

                    </div>

                    <div class="dias-semana">

                        <div>Dom</div>
                        <div>Seg</div>
                        <div>Ter</div>
                        <div>Qua</div>
                        <div>Qui</div>
                        <div>Sex</div>
                        <div>Sáb</div>

                    </div>

                    <div class="dias">

                        <?php

                        for ($i = 0; $i < $diaDaSemana; $i++) {
                            echo '<div class="dia vazio"></div>';
                        }

                        for ($dia = 1; $dia <= $diasNoMes; $dia++) {

                            $data = sprintf(
                                '%04d-%02d-%02d',
                                $ano,
                                $mes,
                                $dia
                            );

                            $temEvento = false;
                            $buscarEventoData = "
                                SELECT idEvento
                                FROM eventos
                                WHERE idUsuario = '$idUsuario'
                                AND dataEvento = '$data'
                                LIMIT 1
                            ";

                            $resultadoEventoData = mysqli_query(
                                $conn,
                                $buscarEventoData
                            );

                            if (mysqli_num_rows($resultadoEventoData) > 0) {

                                $temEvento = true;

                            }

                            $classe = '';
                            if ($dataSelecionada == $data) {
                                $classe = 'selecionado';
                            }

                            if ($temEvento) {
                                $classe .= ' possui-evento';
                            }

                            ?>

                            <a
                                class="dia <?php echo $classe; ?>"
                                href="?mes=<?php echo $mes; ?>&ano=<?php echo $ano; ?>&data=<?php echo $data; ?>"
                            >

                                <span>
                                    <?php echo $dia; ?>
                                </span>

                                <?php if ($temEvento): ?>

                                    <small>•</small>

                                <?php endif; ?>

                            </a>
                            <?php
                        }
                        ?>

                    </div>

                </div>

                <aside class="painel">

                    <?php if ($dataSelecionada): ?>

                        <h2>
                            <?php
                            echo date(
                                'd/m/Y',
                                strtotime($dataSelecionada)
                            );
                            ?>
                        </h2>


                        <?php if (count($eventosDoDia) > 0): ?>
                            <?php foreach ($eventosDoDia as $evento): ?>

                                <div class="evento <?php echo $evento['concluido'] ? 'concluido' : ''; ?>">
                                    <h3>
                                        <?php echo htmlspecialchars($evento['titulo']); ?>
                                    </h3>

                                    <p>
                                        <?php echo htmlspecialchars($evento['descricao']); ?>
                                    </p>

                                    <span>
                                        🕐 <?php echo $evento['horaEvento']; ?>
                                    </span>

                                    <div class="acoes-evento">
                                        <?php if ($evento['concluido']): ?>
                                            <a
                                                href="acao_evento.php?acao=desfazer&id=<?php echo $evento['idEvento']; ?>&data=<?php echo $dataSelecionada; ?>"
                                                class="botao-desfazer"
                                            >
                                                ↩ Desfazer
                                            </a>
                                        <?php else: ?>

                                            <a
                                                href="acao_evento.php?acao=concluir&id=<?php echo $evento['idEvento']; ?>&data=<?php echo $dataSelecionada; ?>"
                                                class="botao-concluir"
                                            >
                                                ✓ Concluir
                                            </a>

                                        <?php endif; ?>
                                        <a
                                            href="acao_evento.php?acao=remover&id=<?php echo $evento['idEvento']; ?>&data=<?php echo $dataSelecionada; ?>"
                                            class="botao-remover"
                                            onclick="return confirm('Tem certeza que deseja remover este evento?');"
                                        >
                                            🗑 Remover
                                        </a>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <a
                                class="botao"
                                href="adicionar_evento.php?data=<?php echo $dataSelecionada; ?>"
                            >
                                + Adicionar evento
                            </a>
                        <?php else: ?>

                            <p class="sem-eventos">
                                Nenhum evento neste dia.
                            </p>

                            <a
                                class="botao"
                                href="adicionar_evento.php?data=<?php echo $dataSelecionada; ?>"
                            >
                                + Adicionar evento
                            </a>

                        <?php endif; ?>

                    <?php else: ?>

                        <h2>
                            Selecione uma data
                        </h2>

                        <p>
                            Clique em um dia do calendário para visualizar seus eventos.
                        </p>

                    <?php endif; ?>

                </aside>

            </section>

        </main>

    </body>
</html>