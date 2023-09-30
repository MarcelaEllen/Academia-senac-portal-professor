document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("cadastroAlunoForm");
    const popup = document.getElementById("popup");
    const popupMessage = document.getElementById("popup-message");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        // Coleta os dados do formulário
        const formData = new FormData(form);

        // Cria uma requisição AJAX
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Exibe a mensagem de sucesso na caixa pop-up
                    popupMessage.textContent = "Cadastro realizado com sucesso!";
                    popupMessage.style.color = "green";
                    popup.style.display = "block";

                    // Fecha a caixa pop-up após 2 segundos
                    setTimeout(function () {
                        popup.style.display = "none";
                    }, 2000);

                    // Limpa os campos do formulário
                    form.reset();
                } else {
                    // Exibe a mensagem de erro, se houver
                    popupMessage.textContent = "Erro ao cadastrar: " + xhr.responseText;
                    popupMessage.style.color = "red";
                    popup.style.display = "block";
                }
            }
        };

        // Abre a requisição POST para o arquivo PHP de processamento
        xhr.open("POST", "addAluno.php", true);

        // Envia os dados do formulário
        xhr.send(formData);
    });
});
