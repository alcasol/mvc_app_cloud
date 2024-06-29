// public/js/math.js

import { calcular } from './apiFunctions.js';

// Event listener para el formulario con submit
document.getElementById('mathForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    // Convertir FormData a un objeto
    const formDataObject = {};
    formData.forEach((value, key) => formDataObject[key] = value);

    calcular(formDataObject, function(err, res) {
        const messageDiv = document.getElementById('result');
        if (err) {
            messageDiv.innerHTML = `<p>Error: ${err.message || 'La conexión ha fallado!'}</p>`;
            console.error('Error:', err);
            return;
        }

        if (res && res.status === 'success') {
            messageDiv.innerHTML = `<p>${res.data.result}</p>`;
        } else {
            messageDiv.innerHTML = `<p>Error: ${res ? res.result : 'Error en el calculo!'}</p>`;
        }
    });
});


