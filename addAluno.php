<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "academiaSenac";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $genero = $_POST["genero"];
    $dataNascimento = $_POST["dataNascimento"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $meta = $_POST["meta"];
    $frequencia = $_POST["frequencia"];
    $horarioPreferido = $_POST["horarioPreferido"];

    $dataFormatada = date("Y-m-d", strtotime(str_replace("/", "-", $dataNascimento)));
    
    // Inserir na tabela ALUNOS
    $sqlAlunos = "INSERT INTO ALUNOS (CPF, NOME, IDADE, GENERO, NASCIMENTO, TELEFONE, EMAIL)
                  VALUES ('$cpf', '$nome', $idade, '$genero', '$dataFormatada', '$telefone', '$email')";
    
    if ($conn->query($sqlAlunos) === TRUE) {
        // Inserir na tabela OBJETIVOS
        $sqlObjetivos = "INSERT INTO OBJETIVOS (ALUNOS_CPF, META)
                        VALUES ('$cpf', '$meta')";
    
        if ($conn->query($sqlObjetivos) === TRUE) {
            // Inserir na tabela HORARIOS
            $sqlHorarios = "INSERT INTO HORARIOS (ALUNOS_CPF, DIAS_DA_SEMANA, HORA)
                            VALUES ('$cpf', '$frequencia', '$horarioPreferido')";
    
            if ($conn->query($sqlHorarios) === TRUE) {
                echo "Cadastro realizado com sucesso!";
            } else {
                echo "Erro ao inserir dados na tabela HORARIOS: " . $conn->error;
            }
        } else {
            echo "Erro ao inserir dados na tabela OBJETIVOS: " . $conn->error;
        }
    } else {
        echo "Erro ao inserir dados na tabela ALUNOS: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        /* Adicione o código CSS da caixa de diálogo pop-up aqui */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
    <title>Adicionar aluno</title>
</head>
<body>
    <nav id="navbar">
        <img src="/assets/img/logo.png">
        <ul>
            <li><a href="/menu.html">Menu</a></li>
            <li><a href="#">A academia</a></li>
        </ul>
    </nav>
    <div>
        <button id="button-voltar"> <a href="/listaAlunos.php">VOLTAR</a></button>
    </div>
    <section id="formularioAluno">
        <h1 id="tituloFormulario">Cadastro de Aluno</h1>
        <form id="cadastroAlunoForm" method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" required>

            <label for="genero">Gênero:</label>
            <select id="genero" name="genero">
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
            </select>

            <label for="dataNascimento">Data de Nascimento:</label>
            <input type="date" id="dataNascimento" name="dataNascimento" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="meta">Meta:</label>
            <select id="meta" name="meta">
                <option value="nenhum">Nenhuma das opções</option>
                <option value="PerderPeso">Perder peso</option>
                <option value="GanharMusculo">Ganhar massa muscular</option>
                <option value="Saude">Saúde</option>
            </select>

            <label for="frequencia">Frequência por semana:</label>
            <select id="frequencia" name="frequencia">
                <option value="todos">Todos os dias</option>
                <option value="PerderPeso">5 dias</option>
                <option value="GanharMusculo">3 dias</option>
            </select>

            <label for="horarioPreferido">Horário Preferido:</label>
            <input type="time" id="horarioPreferido" name="horarioPreferido">

            <input type="submit" value="Cadastrar">
        </form>
        <!-- Caixa de diálogo pop-up -->
        <div class="popup" id="popup">
            <div class="popup-content">
                <span id="popup-message"></span>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer-container">
            <div class="footer-logo">
                <img src="/assets/img/logo.png" alt="Logo da Academia">
            </div>
            <div class="footer-info">
                <p>Academia SENAC</p>
                <p>Endereço: Rua da Academia, 123</p>
                <p>Telefone: (11) 555-5555</p>
                <p>Email: info@academiaSENAC.com</p>
            </div>
            <div class="footer-social">
                <img src="/assets/img/facebook.png">
                <img src="/assets/img/instagram.png">
                <img src="/assets/img/twitter.png">
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 Academia Senac. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
