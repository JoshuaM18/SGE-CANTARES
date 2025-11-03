document.addEventListener('DOMContentLoaded', () => {
    const listaChats = document.getElementById('listaChats');
    const chatContenido = document.getElementById('chatContenido');
    const mensajeTexto = document.getElementById('mensajeTexto');
    const btnEnviar = document.getElementById('btnEnviar');

    let idUsuario = window.idUsuario; // Variable inyectada desde PHP
    let idConversacion = null;

    // Delegación de eventos: escucha clicks en UL y captura LI
    listaChats.addEventListener('click', (e) => {
        const item = e.target.closest('.chat-item');
        if (!item) return;

        // Marcar como seleccionado
        listaChats.querySelectorAll('.chat-item').forEach(i => i.classList.remove('selected'));
        item.classList.add('selected');

        idConversacion = item.dataset.id;
        cargarMensajes();
    });

    // Función para cargar mensajes de la conversación
    function cargarMensajes() {
        if (!idConversacion) return;

        fetch(`/SGE/Vista/mensajes/ajax_mensajes.php?id_usuario=${idUsuario}&id_conversacion=${idConversacion}`)
            .then(res => res.text())
            .then(html => {
                chatContenido.innerHTML = html;
                chatContenido.scrollTop = chatContenido.scrollHeight;
            })
            .catch(err => {
                console.error('Error al cargar mensajes:', err);
            });
    }

    // Refrescar conversación automáticamente cada 3 segundos
    setInterval(() => {
        if (idConversacion) cargarMensajes();
    }, 3000);

    // Enviar mensaje
    btnEnviar.addEventListener('click', () => {
        if (!idConversacion) return alert('Selecciona un chat primero.');

        const contenido = mensajeTexto.value.trim();
        if (!contenido) return;

        const formData = new FormData();
        formData.append('id_remitente', idUsuario);
        formData.append('id_destinatario', idConversacion);
        formData.append('contenido', contenido);

        // Enviar mensaje al servidor (usando ruta relativa desde entrada.php)
        fetch('/SGE/Vista/mensajes/ajax_enviar_mensaje.php', { method: 'POST', body: formData })
            .then(res => res.text())
            .then(data => {
                if (data === 'ok') {
                    mensajeTexto.value = '';
                    cargarMensajes(); // recargar conversación
                } else {
                    alert('Error al enviar mensaje: ' + data);
                }
            })
            .catch(err => {
                console.error('Error al enviar mensaje:', err);
            });
    });
});
