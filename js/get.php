<?php
// Conecte-se ao banco de dados (substitua com suas credenciais)
$servername = "localhost";
$username = "root";
$password = "";
$database = "academiaSenac";

$conn = new mysqli($servername, $username, $password, $database);

// Verifique a conexão com o banco de dados
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL para obter os dados dos alunos com suas metas, dias da semana e horários
$sql = "SELECT ALUNOS.CPF, ALUNOS.NOME, ALUNOS.IDADE, ALUNOS.GENERO, ALUNOS.NASCIMENTO, ALUNOS.TELEFONE, ALUNOS.EMAIL, OBJETIVOS.META, HORARIOS.DIAS_DA_SEMANA, HORARIOS.HORA 
        FROM ALUNOS
        LEFT JOIN OBJETIVOS ON ALUNOS.CPF = OBJETIVOS.ALUNOS_CPF
        LEFT JOIN HORARIOS ON ALUNOS.CPF = HORARIOS.ALUNOS_CPF";

$result = $conn->query($sql);

// Array para armazenar os dados dos alunos
$alunos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $aluno = array(
            "CPF" => $row["CPF"],
            "NOME" => $row["NOME"],
            "IDADE" => $row["IDADE"],
            "GENERO" => $row["GENERO"],
            "NASCIMENTO" => date("d-m-Y", strtotime($row["NASCIMENTO"])),
            "TELEFONE" => $row["TELEFONE"],
            "EMAIL" => $row["EMAIL"],
            "META" => $row["META"],
            "DIAS_DA_SEMANA" => $row["DIAS_DA_SEMANA"],
            "HORA" => $row["HORA"]
        );
        $alunos[] = $aluno;
    }
}

// Feche a conexão com o banco de dados
$conn->close();

// Retorne os dados dos alunos em formato JSON
header("Content-Type: application/json");
echo json_encode($alunos);
?>
