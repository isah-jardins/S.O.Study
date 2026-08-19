<?php

include "header.php";

?>

<div class="container">

    <br>

    <h1>Cadastrar novo vestibular</h1>

    <br>

    <form
        action="salvarVestibular.php"
        method="POST"
        enctype="multipart/form-data"
    >

        <!-- NOME -->

        <div class="mb-3">

            <label for="nomeVestibular" class="form-label">
                Nome do vestibular
            </label>

            <input
                type="text"
                class="form-control"
                id="nomeVestibular"
                name="nomeVestibular"
                required
            >

        </div>


        <!-- DESCRIÇÃO -->

        <div class="mb-3">

            <label for="descricaoVestibular" class="form-label">
                Descrição
            </label>

            <textarea
                class="form-control"
                id="descricaoVestibular"
                name="descricaoVestibular"
                rows="4"
                required
            ></textarea>

        </div>


        <!-- IMAGEM -->

        <div class="mb-3">

            <label for="imagemVestibular" class="form-label">
                Imagem do vestibular
            </label>

            <input
                type="file"
                class="form-control"
                id="imagemVestibular"
                name="imagemVestibular"
                accept=".jpg,.jpeg,.png"
                required
            >

            <small class="form-text text-muted">
                Formatos permitidos: JPG, JPEG e PNG.
            </small>

        </div>


        <!-- DATA -->

        <div class="mb-3">

            <label for="dataVestibular" class="form-label">
                Data do vestibular
            </label>

            <input
                type="date"
                class="form-control"
                id="dataVestibular"
                name="dataVestibular"
                required
            >

        </div>


        <!-- BOTÃO -->

        <button
            type="submit"
            class="btn btn-success"
        >
            Cadastrar vestibular
        </button>


        <a
            href="index.php"
            class="btn btn-secondary"
        >
            Cancelar
        </a>

    </form>

</div>

<?php include "footer.php"; ?>