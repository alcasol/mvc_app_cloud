// -----------------------------------------------------------
// public/js/apiFunctions.js:
// -----------------------------------------------------------
// Define funciones específicas para cada operación de la API
// -----------------------------------------------------------
//
import { realizarSolicitudHTTP } from './httpRequest.js';
import { getEnvVariables } from './env.js';

async function borrarUsuario(username, password, cb) {
    try {
        // obtengo variable de entorno
        const envData = await getEnvVariables();
        const { BASE_URL, IP_PUERTO } = envData;

        realizarSolicitudHTTP("DELETE", IP_PUERTO + BASE_URL + "/user/deleteUser", { username, password }, cb);
    } catch (error) {
        console.error("Error al borrar usuario:", error);
        cb(error, null); 
    }
}

async function registrarUsuario(formData, cb) {
    try {
        const envData = await getEnvVariables();
        const { BASE_URL, IP_PUERTO } = envData;

        realizarSolicitudHTTP("POST", IP_PUERTO + BASE_URL + "/user/create", formData, cb);
    } catch (error) {
        console.error("Error al registrar usuario:", error);
        cb(error, null); 
    }
}

async function calcular(formData, cb) {
    try {
        const envData = await getEnvVariables();
        const { BASE_URL, IP_PUERTO } = envData;

        realizarSolicitudHTTP(
            "POST", 
            IP_PUERTO + BASE_URL + "/math/calculate", 
            formData, 
            cb
        );
    } catch (error) {
        console.error("Error al calcular:", error);
        cb(error, null); 
    }
}

export { borrarUsuario, registrarUsuario, calcular };



/*function cerrarSesion(cb) {
    realizarSolicitudHTTP("GET", IP_PUERTO + "/logout", null, cb);
}

function insertarPersona(datos, cb) {
    realizarSolicitudHTTP("POST", IP_PUERTO + "/alta", datos, cb);
}

function obtenerPersona(dni, cb) {
    realizarSolicitudHTTP("GET", IP_PUERTO + `/persona/${dni}`, null, cb);
}

function actualizarPersona(dni, datos, cb) {
    realizarSolicitudHTTP("PUT", IP_PUERTO + `/persona/${dni}`, datos, cb);
}

function buscarPersona(cb){
    realizarSolicitudHTTP("GET", IP_PUERTO + "/persona/6655", null, cb);
}
function buscarPersonaConDNI(dni, cb){
    console.log(dni);
    realizarSolicitudHTTP("GET", IP_PUERTO + `/persona/${dni}`, null, cb);
}
*/
