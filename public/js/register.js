import { registrarUsuario } from './apiFunctions.js';

// Event listener para el formulario con submit
document.getElementById('registerForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    // Convertir FormData a un objeto
    const formDataObject = {};
    formData.forEach((value, key) => formDataObject[key] = value);

    registrarUsuario(formDataObject, function(err, res) {
        const messageDiv = document.getElementById('responseMessage');
        if (err) {
            messageDiv.innerHTML = `<p>Error: ${err.message || 'Registration failed!'}</p>`;
            console.error('Error:', err);
            return;
        }

        if (res && res.status === 'success') {
            messageDiv.innerHTML = `<p>${res.message}</p>`;
        } else {
            messageDiv.innerHTML = `<p>Error: ${res ? res.message : 'Registration failed!'}</p>`;
        }
    });
});
