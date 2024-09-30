function DNIcorrecto(dni)
{
    var numeroDNI=dni.substring(0,8);
    numeroDNI=parseInt(numeroDNI)%23;
    let dic={
        0:"T", 1:"R",2:"w",
        3:"A",4:"G",5:"M",
        6:"Y",7:"F",8:"p",
        9:"D",10:"X",11:"B",
        12:"N",13:"J",14:"Z",
        15:"S",16:"Q",17:"V",
        18:"H",19:"L",20:"C",
        21:"K",22:"E"
     
    };
    return dni[9]==dic[numeroDNI];
}
function validar() {

var respuesta=""
var valorIntroducido=document.getElementById("nombre").value;
var respuestasCorrectas=true;

//Comprobar si nombre y apellido solamente contienen texto
if (!/^[a-zA-Z\s]+$/.test(valorIntroducido))
{
    respuesta+="Solo se pueden introducir letras en el nombre!!!, Por favor ponga su nombre\n";
    respuestasCorrectas=false;
    
}

valorIntroducido=document.getElementById("dni").value;

//Comprobar letra DNI correcta y que el formato es correcto, mediante una expresión regular
if( !(valorIntroducido.length==10 && /^[0-9]{8}-[A-Z]$/.test(valorIntroducido) && DNIcorrecto(valorIntroducido)))
{
    respuesta+="El DNI no es correcto \n";
    respuestasCorrectas=false;
    
}

//Comprobar digito de telefono solo 9 digitos.
valorIntroducido=document.getElementById("telefono").value;
if(!(valorIntroducido.length==9 && /^[0-9]{9}$/.test(valorIntroducido)))
{
    respuesta+="El teléfono debe de tener 9 dígitos\n";
    respuestasCorrectas=false;
    
}

//Fecha de Nacimiento en formato de 1999-08-26
valorIntroducido=document.getElementById("fecha").value;
if(!( /^\d{4}-\d{2}-\d{2}$/.test(valorIntroducido) && !isNaN(Date.parse(valorIntroducido))))
{
    // isNaN(Date.parse(valorIntroducido)) si es una fecha valida devuelve false
    respuesta+="La fecha introducida debe de tener este formato YYYY-MM-dd \n"; //https://es.stackoverflow.com/questions/302153/validar-fecha-que-introduce-el-usuario-en-javascript
    respuestasCorrectas=false;
    
}

//Solo formatos de email validos ejemplo@servidor.extension
if ((/^[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*@gmail\.com$/.test(valorIntroducido)))
{
    respuesta+="El gmail no es correcto \n";
    respuestasCorrectas=false;
}

if (document.getElementById("password1").value != document.getElementById("password2").value) {
    respuesta += "Las contraseñas no coinciden\n";
    respuestasCorrectas = false;
}

if (document.getElementById("password1").value.length == 0) {
    respuesta += "La contraseña no puede estar vacía\n";
    respuestasCorrectas = false;
}

if (document.getElementById("username").value.length == 0) {
    respuesta += "El nombre de usuario no puede estar vacío\n";
    respuestasCorrectas = false;
}

if (respuestasCorrectas){
    document.register_form.submit();
}
else{
    window.alert("Ha ocurrido algun error en alguna de sus repuestas:\n"+respuesta);
}

}