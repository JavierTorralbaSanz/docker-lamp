// inactividad.js - Detecta inactividad en toda la sesión del usuario.
const TIEMPO_INACTIVIDAD = 1500000; // 25 minutos en milisegundos
//const TIEMPO_INACTIVIDAD = 6000;  se ha comprobado con 6 seg   en milisegundos
let temporizador;

function reiniciarTemporizador() {
    clearTimeout(temporizador);
    temporizador = setTimeout(verificarSesion, TIEMPO_INACTIVIDAD);
}

// Verifica si la sesión sigue activa después de inactividad.
function verificarSesion() {
  
                clearTimeout(temporizador);
                //window.removeEventListener('DOMContentLoaded', reiniciarTemporizador);
                //document.removeEventListener('mousemove', reiniciarTemporizador);
                //document.removeEventListener('keypress', reiniciarTemporizador);
                alert("Se ha cerrado la sesión por inactividad.");
                window.location.href = '/logout'; // Redirige al usuario para cerrar sesión.
}   

//window.onload = reiniciarTemporizador; 
//document.onmousemove = reiniciarTemporizador;
//document.onkeypress = reiniciarTemporizador;
// Eventos para detectar actividad del usuario.
window.addEventListener('DOMContentLoaded', reiniciarTemporizador);
document.addEventListener('mousemove', reiniciarTemporizador);
document.addEventListener('keypress', reiniciarTemporizador);