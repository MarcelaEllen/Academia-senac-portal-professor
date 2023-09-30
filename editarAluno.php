<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        /* Estilos para a janela modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
        }

        /* Estilos para o modal de confirmação de exclusão */
        .confirm-modal {
            display: none;
            position: fixed;
            z-index: 2;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .confirm-content {
            background-color: #fff;
            margin: 25% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
        }
    </style>
    <title>Editar Aluno</title>
</head>
<body>
    <nav id="navbar">
        <img src="/assets/img/logo.png">
        <ul>
            <li><a href="/menu.html">Menu</a></li>
            <li><a href="/listaAlunos.php">Lista de Alunos</a></li>
            <li><a href="#">A academia</a></li>
        </ul>
    </nav>

    <section id="editarAluno">
        <h1>Editar Detalhes do Aluno</h1>

        <?php
        // Código PHP para processar a edição do aluno

    

        $edicaoBemSucedida = false; // Inicialmente, definido como falso

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "academiaSenac";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        $cpf = $_GET["cpf"];

        if (isset($_POST["confirmarExclusao"])) {
            $cpf = $_GET["cpf"];
        
         
            $sqlExcluirObjetivos = "DELETE FROM OBJETIVOS WHERE ALUNOS_CPF = '$cpf'";
            $sqlExcluirHorario = "DELETE FROM HORARIOS WHERE ALUNOS_CPF = '$cpf'";
            $sqlExcluirAluno = "DELETE FROM ALUNOS WHERE CPF = '$cpf'";
        
            if ($conn->query($sqlExcluirObjetivos) === TRUE &&
                $conn->query($sqlExcluirHorario) === TRUE &&
                $conn->query($sqlExcluirAluno) === TRUE ) {
                // Exclusão bem-sucedida
                echo '<script>alert("Aluno e objetivos excluídos com sucesso!");</script>';
                header("Location: listaAlunos.php"); // Redireciona para a lista de alunos
                exit();
            } else {
                // Erro na exclusão
                echo '<script>alert("Erro ao excluir aluno e objetivos. Tente novamente.");</script>';
            }
        }
        

        // Consulta SQL para buscar os dados do aluno, incluindo o horário, na tabela "ALUNOS" e "HORARIOS"
        $sql = "SELECT ALUNOS.CPF, ALUNOS.NOME, ALUNOS.IDADE, ALUNOS.GENERO, ALUNOS.NASCIMENTO, ALUNOS.TELEFONE, ALUNOS.EMAIL, HORARIOS.HORA 
                FROM ALUNOS
                LEFT JOIN HORARIOS ON ALUNOS.CPF = HORARIOS.ALUNOS_CPF
                WHERE ALUNOS.CPF = '$cpf'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Recupere os valores da consulta
            $nome = $row["NOME"];
            $idade = $row["IDADE"];
            $genero = $row["GENERO"];
            $dataNascimento = $row["NASCIMENTO"];
            $telefone = $row["TELEFONE"];
            $email = $row["EMAIL"];
            $horario = $row["HORA"];

            // Exiba o formulário de edição
            echo '<form id="formularioEdicao" action="editarAluno.php?cpf=' . $cpf . '" method="POST">';
            echo '<label for="nome">Nome:</label>';
            echo '<input type="text" id="nome" name="nome" value="' . $nome . '" required><br><br>';

            echo '<label for="idade">Idade:</label>';
            echo '<input type="number" id="idade" name="idade" value="' . $idade . '" required><br><br>';

            echo '<label for="horario">Horário Preferido:</label>';
            echo '<input type="time" id="horario" name="horario" value="' . $horario . '" required><br><br>';

            // Adicione mais campos conforme necessário

            echo '<input type="submit" value="Salvar">';
            echo '</form>';

            // Botão de Excluir Aluno
            echo '<button onclick="mostrarConfirmModal()">Excluir Aluno</button>';
        } else {
            echo "Aluno não encontrado.";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recupere os dados do formulário
            $nome = $_POST["nome"];
            $idade = $_POST["idade"];
            $horario = $_POST["horario"];

            // Execute uma consulta SQL de atualização para editar o aluno no banco de dados
            // Certifique-se de ajustar a consulta SQL com base na sua estrutura de banco de dados
            $sql = "UPDATE ALUNOS SET NOME = '$nome', IDADE = $idade WHERE CPF = '$cpf'";
            $sqlHorario = "UPDATE HORARIOS SET HORA = '$horario' WHERE ALUNOS_CPF = '$cpf'";

            if ($conn->query($sql) === TRUE && $conn->query($sqlHorario) === TRUE) {
                $edicaoBemSucedida = true;
            } else {
                $edicaoBemSucedida = false;
            }
        }
        ?>

        <!-- Janela modal para a mensagem de sucesso -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <?php
                if ($edicaoBemSucedida) {
                    echo "Aluno editado com sucesso!";
                } else {
                    echo "Erro ao editar aluno. Tente novamente.";
                }
                ?>
            </div>
        </div>

        <!-- Modal de confirmação de exclusão -->
        <div id="confirmModal" class="confirm-modal">
            <div class="confirm-content">
                <p>Tem certeza de que deseja excluir este aluno?</p>
                <form method="POST" action="">
                    <button type="button" onclick="fecharConfirmModal()">Cancelar</button>
                    <input type="hidden" name="excluir" value="true">
                    <input type="submit" name="confirmarExclusao" value="Confirmar">
                </form>
            </div>
        </div>

        <!-- JavaScript para mostrar/fechar o modal de confirmação de exclusão -->
        <script>
            function mostrarConfirmModal() {
                var confirmModal = document.getElementById("confirmModal");
                confirmModal.style.display = "block";
            }

            function fecharConfirmModal() {
                var confirmModal = document.getElementById("confirmModal");
                confirmModal.style.display = "none";
            }
        </script>

        <!-- Script para mostrar a janela modal após o envio do formulário -->
        <script>
            <?php
            if ($edicaoBemSucedida) {
                echo 'document.getElementById("modal").style.display = "block";';
            }
            ?>
             setTimeout(function () {
                var modal = document.getElementById("modal");
                modal.style.display = "none";
            }, 1500);
        </script>
    </section>

    <script src="/js/editarAluno.js"></script>
</body>
</html>
