
//Usuário e senha
const usuario = "marcela";
const senha = "marcela123";

        //Pegando os ID
        const form = document.getElementById("login-form");
        const usernameInput = document.getElementById("username");
        const passwordInput = document.getElementById("password");
        const loginButton = document.getElementById("login-button");
        const loginMessage = document.getElementById("login-message");

       
        loginButton.addEventListener("click", function () {
            
            const usuarioInserido = usernameInput.value;
            const senhaInserida = passwordInput.value;

            
            if (usuarioInserido === usuario && senhaInserida === senha) {
                loginMessage.textContent = "Login bem-sucedido!";
                
                window.location.href = "menu.html"; 
            } else {
                loginMessage.textContent = "Usuário ou senha incorretos. Tente novamente.";
            }

            // Limpando os campos
            usernameInput.value = "";
            passwordInput.value = "";
        });
