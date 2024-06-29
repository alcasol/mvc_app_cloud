// public/js/env.js
// Esta función está diseñada para obtener las variables de entorno desde el 
// servidor y almacenarlas en el almacenamiento local (localStorage --> caché)
// para su uso posterior.
//
export async function getEnvVariables() {
    try {
        let envData = JSON.parse(localStorage.getItem('envData'));

        if (!envData) {
            const response = await fetch("/mvc_app_raiola/public/env");
            envData = await response.json();
            
            // Almacena las variables de entorno en localStorage
            localStorage.setItem('envData', JSON.stringify(envData));
        }

        return envData;
    } catch (error) {
        console.error("Error fetching environment variables:", error);
        return {};
    }
}
