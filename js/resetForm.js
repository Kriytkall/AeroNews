document.addEventListener('DOMContentLoaded', function () {
    const formNoticia = document.getElementById('formNoticia');

    if (formNoticia) {
        formNoticia.addEventListener('submit', function (event) {
            event.preventDefault();

            enviarFormulario()
                .then(() => {
                    formNoticia.reset();
                })
                .catch(error => {
                    console.error("Erro ao enviar o formulário:", error);
                });
        });
    }
});
