//Funcion para validar formulario de registro
function validarRegister() {
    let nombre = document.getElementById('nombre').value;
    let apellidos = document.getElementById('apellidos').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('pass').value;
    let verifypass = document.getElementById('pass2').value;
    if (nombre == "" || apellidos == "" || email == "" || password == "" || verifypass == "") {
        Swal.fire({
            icon: 'error',
            title: 'Datos no rellenados',
            text: 'Todos los campos son obligatorios',
            showConfirmButton: false,
            timer: 2200,
            timerProgressBar: true
        });
        return false;
    } else {
        if (password == verifypass) {
            /*Swal.fire({
                icon: 'success',
                title: 'Registro completado',
                text: 'Los datos se han guardado correctamente :D',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            }).then(function() {
                return true;
            });*/
            return true;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Contraseña incorrecta',
                text: 'Una de las dos contraseñas no coinciden',
                showConfirmButton: false,
                timer: 2200,
                timerProgressBar: true
            });
            return false;
        }
    }
}

//Validación login
function loginValidate() {
    let email = document.getElementById("email").value;
    let pass = document.getElementById("pass").value;
    if (email == '') {
        Swal.fire({
            icon: 'error',
            title: 'Email vacío',
            text: 'Por favor introduce el email',
            showConfirmButton: true,
            timer: 4000,
            timerProgressBar: false
        });
        return false;
    } else if (pass == '') {
        Swal.fire({
            icon: 'error',
            title: 'Password vacío',
            text: 'Por favor introduce el password para iniciar sesion',
            showConfirmButton: true,
            timer: 4000,
            timerProgressBar: false
        });
        return false;
    } else {
        /* Swal.fire({
            icon: 'success',
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true
        }); */
    }
}