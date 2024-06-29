// -----------------------------------------------------------
// httpRequest.js: 
// -----------------------------------------------------------
// Esta funcion maneja todas las solicitudes HTTP de la API
// -----------------------------------------------------------
//
export function realizarSolicitudHTTP(verbo, url, parametrosLlamada, cb) {
    console.log('Realizando solicitud HTTP:', verbo, url, parametrosLlamada);
    const options = {
        method: verbo,
        headers: {
            'Content-Type': 'application/json;charset=UTF-8'
        },
        body: parametrosLlamada ? JSON.stringify(parametrosLlamada) : null
    };

    fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.status);
            }
            return response.text(); // Leer el cuerpo de la respuesta como texto
        })
        .then(text => {
            // Verificar si el texto de la respuesta está vacío
            if (!text.trim()) {
                // Si la respuesta está vacía, llamar a la función de callback sin datos
                cb(null, null);
            } else {
                // Intentar parsear el texto como JSON
                try {
                    const data = JSON.parse(text);
                    cb(null, data);
                } catch (error) {
                    // Si hay un error al parsear el JSON, llamar a la función de callback con el error
                    cb(error, null);
                }
            }
        })
        .catch(error => {
            cb(error, null);
        });
}
