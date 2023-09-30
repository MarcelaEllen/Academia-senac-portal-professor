<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <title>Lista de alunos</title>
</head>
<body>
    <nav id="navbar">
        <img src="/assets/img/logo.png">
        <ul>
            <li><a href="/menu.html">Menu</a></li>
            <li><a href="/addAluno.php">Adicionar novo aluno</a></li>
            <li><a href="#">A academia</a></li>
        </ul>
    </nav>

    <section id="listaAlunos">
        <h1 id="tituloLista">Alunos da Academia Senac</h1>
        <button id="listarAlunosBtn">Listar Alunos</button>
        <table id="tabelaAlunos">
            <thead>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Gênero</th>
                    <th>Data de Nascimento</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Meta</th>
                    <th>Dias da Semana</th>
                    <th>Horário Preferido</th>
                    <th>Ações</th> <!-- Adicione a coluna de ações -->
                </tr>
            </thead>
            <tbody id="infoAlunos">
            <?php
            session_start(); // Inicie a sessão PHP
            if (isset($_SESSION['botaoClicado']) && $_SESSION['botaoClicado'] && isset($result) && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["CPF"] . "</td>";
                    echo "<td>" . $row["NOME"] . "</td>";
                    echo "<td>" . $row["IDADE"] . "</td>";
                    echo "<td>" . $row["GENERO"] . "</td>";
                    echo "<td>" . $row["NASCIMENTO"] . "</td>";
                    echo "<td>" . $row["TELEFONE"] . "</td>";
                    echo "<td>" . $row["EMAIL"] . "</td>";
                    echo "<td>" . $row["META"] . "</td>";
                    echo "<td>" . $row["DIAS_DA_SEMANA"] . "</td>";
                    echo "<td>" . $row["HORA"] . "</td>";

                    // Adicione um botão "Editar" que inclui o CPF do aluno na URL
                    echo '<td><a href="editarAluno.php?cpf=' . $row['CPF'] . '">Editar</a></td>';

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>Clique no botão 'Listar Alunos' para exibir a lista.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </section>

    <script src="/js/lista.js"></script>
</body>
</html>
