// -----------------------------------------------------------
// public/js/main.js
// -----------------------------------------------------------
// Define el comportamiento de los botones
// -----------------------------------------------------------
//
import { borrarUsuario } from './apiFunctions.js';

document.getElementById("btnDeleteUser").addEventListener("click", function(event) {
    event.preventDefault(); // Evitar el envío del formulario tradicional

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    if (!username || !password) {
        alert("Por favor, ingrese el nombre de usuario y la contraseña.");
        return;
    }

    borrarUsuario(username, password, function(err, res) {
        if (err) {
            alert("Hubo un error de transmisión HTTP: " + err);
            console.error('Error:', err);
            return;
        }

        if (res && res.status === 'success') {
            alert("Usuario eliminado exitosamente.");
            // Puedes realizar acciones adicionales después de la eliminación exitosa
        } else {
            alert("Error al eliminar el usuario: " + (res ? res.message : 'Desconocido'));
        }
    });
});


