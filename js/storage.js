// Inicializa o Firebase
const firebaseConfig = {
    apiKey: "AIzaSyD2mchCmwh-1Bv0Lu1vNB_xIrx6hAb0HGo",
    authDomain: "aero--news.firebaseapp.com",
    projectId: "aero--news",
    storageBucket: "aero--news.appspot.com",
    messagingSenderId: "154723192565",
    appId: "1:154723192565:web:43a0db4efbc682efe83fbc"
  };
  
  const firebaseApp = firebase.initializeApp(firebaseConfig);
  const storage = firebase.storage();
  
  function enviarImagem() {
    const imagem = document.querySelector("#imagem");
  
    if (imagem.files.length === 0) {
      alert("Selecione uma imagem para enviar.");
      return;
    }
  
    const ref = storage.ref("imagens/" + imagem.files[0].name);
    const uploadTask = ref.put(imagem.files[0]);
  
    return uploadTask.then((snapshot) => {
      return snapshot.ref.getDownloadURL();
    });
  }
  
  function enviarFormulario(event) {
    event.preventDefault();
  
    enviarImagem()
      .then((imgUrl) => {
        const titulo = document.getElementById('titulo').value;
        const subtitulo = document.getElementById('subtitulo').value;
        const noticia = document.getElementById('noticia').value;
  
        // Envia os dados (incluindo a URL da imagem) para o servidor PHP
        const formData = new FormData();
        formData.append('titulo', titulo);
        formData.append('subtitulo', subtitulo);
        formData.append('imagem', imgUrl);
        formData.append('noticia', noticia);
  
  
        return fetch('salvar_noticia.php', {
          method: 'POST',
          body: formData
        });
      })
      .then((response) => {
        if (response.ok) {
          return response.text();
        } else {
          throw new Error('Erro ao salvar notícia.');
        }
      })
      .then((message) => {
        document.querySelector("#resultado").innerHTML = message;
      })
      .catch((error) => {
        console.error("Erro:", error);
      });
  }