// public/js/upload.js
import { getEnvVariables } from './env.js';

document.getElementById("uploadForm").addEventListener("submit", async function(event) {
    event.preventDefault(); // Evitar el envío del formulario tradicional

    const formData = new FormData();
    const fileInput = document.getElementById("file");
    formData.append("file", fileInput.files[0]);

    try {
        const envData = await getEnvVariables();
        const baseUrl = envData.BASE_URL || '';

        console.log(baseUrl)
        const response = await fetch(baseUrl + "/file/uploadFile", {
            method: "POST",
            body: formData
        });

        const text = await response.text();
        let result;
        let errorMessage;

        try {
            result = JSON.parse(text);
            errorMessage = {
                status: result.status || 'error',
                message: result.message || 'Unknown error'
            };
        } catch (error) {
            console.log('Invalid JSON: ' + text);
            errorMessage = {
                status: 'error',
                message: 'Invalid JSON'
            };
        }

        if (response.ok && result.status === 'success') {
            alert("File uploaded successfully");
        } else {
            alert("Failed to upload file: " + errorMessage.message);
        }

        document.getElementById("salida").innerHTML = "Result: " + JSON.stringify(result);
    } catch (error) {
        alert("Error: " + error.message);
    }
});
