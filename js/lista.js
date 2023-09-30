let botaoClicado = false;

document.addEventListener("DOMContentLoaded", function () {
    const listarAlunosBtn = document.getElementById("listarAlunosBtn");
    const infoAlunos = document.getElementById("infoAlunos");

    listarAlunosBtn.addEventListener("click", function () {
        // Requisição AJAX para buscar os dados dos alunos
        botaoClicado = true;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/js/get.php", true); // Substitua por seu arquivo PHP
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);

                // Limpe a tabela antes de adicionar os novos dados
                infoAlunos.innerHTML = "";

                // Preencha a tabela com os dados obtidos
                data.forEach(function (aluno) {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${aluno.CPF}</td>
                        <td>${aluno.NOME}</td>
                        <td>${aluno.IDADE}</td>
                        <td>${aluno.GENERO}</td>
                        <td>${aluno.NASCIMENTO}</td>
                        <td>${aluno.TELEFONE}</td>
                        <td>${aluno.EMAIL}</td>
                        <td>${aluno.META}</td>
                        <td>${aluno.DIAS_DA_SEMANA}</td>
                        <td>${aluno.HORA}</td>
                        <td><a href="editarAluno.php?cpf=${aluno.CPF}">Editar</a></td>
                    `;
                    infoAlunos.appendChild(row);
                });
            }
        };
        xhr.send();
    });
});
