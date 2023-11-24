
function enviarFormulario(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    // Desativa o botão de envio para evitar múltiplos envios
    document.querySelector('.botao-enviar').disabled = true;

    // Obtenha os dados do formulário (você pode enviar esses dados para o servidor usando AJAX ou outra abordagem)
    const formData = new FormData(document.getElementById('formNoticia'));

    // Aqui você pode adicionar lógica para enviar os dados para o servidor, por exemplo, usando AJAX
    // ...

    // Limpe os campos do formulário após o envio bem-sucedido
    document.getElementById('formNoticia').reset();
}