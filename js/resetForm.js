document.addEventListener('DOMContentLoaded', function () {
    const formNoticia = document.getElementById('formNoticia');

    if (formNoticia) {
        formNoticia.addEventListener('submit', function (event) {
            // Prevenir o envio padrão do formulário
            event.preventDefault();

            // Enviar o formulário
            enviarFormulario()
                .then(() => {
                    // Limpar os campos do formulário após o envio bem-sucedido
                    formNoticia.reset();
                })
                .catch(error => {
                    console.error("Erro ao enviar o formulário:", error);
                });
        });
    }
});
