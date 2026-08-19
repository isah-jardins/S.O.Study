<?php

include "conexaoBD.php";

$sql = "SELECT * FROM vestibulares ORDER BY idVestibular ASC";
$resultado = mysqli_query($conn, $sql);

?>
<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Início - S.O.Study</title>

        <link rel="stylesheet" href="css/geral.css">
        <link rel="stylesheet" href="css/styles.css">
    </head>

    <body>

        <br>

        <div class="container">

            <!-- ==========================================
                CABEÇALHO DA PÁGINA
                ========================================== -->

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h1>
                    Vestibulares
                </h1>

                <a
                    href="cadastrarVestibular.php"
                    class="btn btn-success"
                >
                    + Cadastrar vestibular
                </a>

            </div>


            <div class="row">

                <div class="col-lg-8">

                    <?php

                    if (mysqli_num_rows($resultado) > 0) {

                        while ($vestibular = mysqli_fetch_assoc($resultado)) {

                            $idVestibular = $vestibular['idVestibular'];
                            $nome = $vestibular['nomeVestibular'];
                            $descricao = $vestibular['descricaoVestibular'];
                            $data = $vestibular['dataVestibular'];
                            $imagem = $vestibular['imagemVestibular'];

                    ?>

                            <div class="card mb-4">

                                <img
                                    class="card-img-top"
                                    src="<?= htmlspecialchars($imagem) ?>"
                                    alt="<?= htmlspecialchars($nome) ?>"
                                >

                                <div class="card-body">

                                    <div class="small text-muted">
                                        <?= htmlspecialchars($data) ?>
                                    </div>

                                    <h2 class="card-title">
                                        <?= htmlspecialchars($nome) ?>
                                    </h2>

                                    <p class="card-text">
                                        <?= htmlspecialchars($descricao) ?>
                                    </p>

                                    <a
                                        class="btn btn-primary"
                                        href="vestibular.php?idVestibular=<?= $idVestibular ?>"
                                    >
                                        Detalhes →
                                    </a>

                                </div>

                            </div>

                    <?php

                        }

                    } else {

                    ?>

                        <p>
                            Nenhum vestibular cadastrado.
                        </p>

                    <?php

                    }

                    ?>

                </div>

            </div>

        </div>
    </body>
</html>
<?php include "footer.php"; ?>