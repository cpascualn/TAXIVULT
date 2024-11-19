import Swal from "sweetalert2";
import regFormCheck from "./regFormCheck";
export default {
    methods: {
        showSwal(options) {
            new Swal({
                toast: true,
                position: "top-right",
                iconColor: "white",
                width: options.width ? options.width : 300,
                text: options.message,
                customClass: {
                    popup: options.type === "success" ? "bg-success" : "bg-danger",
                    htmlContainer: 'text-white',
                },
                showConfirmButton: false,
                showCloseButton: true,
                timer: 5000,
                timerProgressBar: true,

            });
        },
        showSwalConfirmationDelete() {
            const swalDelete = new Swal({
                title: "¿Estas Seguro?",
                text: "Este cambio es irreversible",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true,
                customClass: {
                    confirmButton: "btn bg-gradient-success",
                    cancelButton: "btn bg-gradient-danger",
                },
                buttonsStyling: false,
            });

            return swalDelete;
        },
        async showAddUser() {
            const { value: formValues } = await Swal.fire({
                title: "Crear un Administrador",
                html: `
             <div>
                <label for="swal-input-email" style="width: 4.5rem;">Email</label>
                <input id="swal-input-email" class="swal2-input" placeholder="Email">
                
                <label for="swal-input-nombre" style="width: 4.5rem;">Nombre</label>
                <input id="swal-input-nombre" class="swal2-input" placeholder="Nombre">
                
                <label for="swal-input-apellidos" style="width: 4.5rem;">Apellidos</label>
                <input id="swal-input-apellidos" class="swal2-input" placeholder="Apellidos">
                
                <label for="swal-input-telefono" style="width: 4.5rem;">Teléfono</label>
                <input id="swal-input-telefono" class="swal2-input" placeholder="Teléfono">

                 <label for="swal-input-contrasena" style="width: 4.5rem;">Contraseña</label>
                <input id="swal-input-contrasena" type="password" class="swal2-input" placeholder="Contraseña" >
            </div>
              `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                preConfirm: () => {
                    const email = document.getElementById("swal-input-email").value;
                    const nombre = document.getElementById("swal-input-nombre").value;
                    const apellidos = document.getElementById("swal-input-apellidos").value;
                    const telefono = document.getElementById("swal-input-telefono").value;
                    const contrasena = document.getElementById("swal-input-contrasena").value;

                    if (!email || !nombre || !apellidos || !telefono) {
                        Swal.showValidationMessage("Todos los campos son obligatorios");
                        return false; // Evita cerrar el modal
                    }
                    // validar valores
                    if (!regFormCheck.checkMail(email)) {
                        Swal.showValidationMessage('El correo no es válido.');
                        return false;
                    }
                    if (!regFormCheck.checkNombre(nombre)) {
                        Swal.showValidationMessage('El nombre no es válido.');
                        return false;
                    }
                    if (!regFormCheck.checkTelefono(telefono)) {
                        Swal.showValidationMessage('El teléfono no es válido.');
                        return false;
                    }
                    if (!regFormCheck.checkNombre(apellidos)) {
                        Swal.showValidationMessage('Los apellidos no son válidos.');
                        return false;
                    }
                    if (!regFormCheck.checkContrasena(contrasena)) {
                        Swal.showValidationMessage('La contraseña no es válida.');
                        return false;
                    }


                    return { email, nombre, apellidos, telefono, contrasena, rol: 1 };
                },
            });

            if (formValues) {
                return formValues;
                // Puedes manejar los valores aquí
            } else {
                return null;
            }
        },
        async showEditUser(admin) {
            const { value: formValues } = await Swal.fire({
                title: "Editar un Administrador",
                html: `
                <label for="swal-input-email" style="width: 4.5rem;">Email</label>
                <input id="swal-input-email" class="swal2-input" placeholder="Email" value="${admin.email}">

                <label for="swal-input-nombre" style="width: 4.5rem;">Nombre</label>
                <input id="swal-input-nombre" class="swal2-input" placeholder="Nombre" value="${admin.nombre}">

                <label for="swal-input-apellidos" style="width: 4.5rem;">Apellidos</label>
                <input id="swal-input-apellidos" class="swal2-input" placeholder="Apellidos" value="${admin.apellidos}">

                <label for="swal-input-telefono" style="width: 4.5rem;">Teléfono</label>
                <input id="swal-input-telefono" class="swal2-input" placeholder="Teléfono" value="${admin.telefono}">

                 <label for="swal-input-contrasena"style="width: 4.5rem;"> Contraseña</label>
                <input id="swal-input-contrasena" type="password" class="swal2-input" placeholder="Nueva Contraseña" >
              `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                preConfirm: () => {
                    const email = document.getElementById("swal-input-email").value;
                    const nombre = document.getElementById("swal-input-nombre").value;
                    const apellidos = document.getElementById("swal-input-apellidos").value;
                    const telefono = document.getElementById("swal-input-telefono").value;
                    const contrasena = document.getElementById("swal-input-contrasena").value;

                    if (!email || !nombre || !apellidos || !telefono) {
                        Swal.showValidationMessage("Todos los campos son obligatorios");
                        return false;
                    }
                    // validar valores
                    if (!regFormCheck.checkMail(email)) {
                        Swal.showValidationMessage('El correo no es válido.');
                        return false;
                    }
                    if (!regFormCheck.checkNombre(nombre)) {
                        Swal.showValidationMessage('El nombre no es válido.');
                        return false;
                    }
                    if (!regFormCheck.checkTelefono(telefono)) {
                        Swal.showValidationMessage('El teléfono no es válido.');
                        return false;
                    }
                    if (!regFormCheck.checkNombre(apellidos)) {
                        Swal.showValidationMessage('Los apellidos no son válidos.');
                        return false;
                    }
                    if (contrasena != null && contrasena != '' && !regFormCheck.checkContrasena(contrasena)) {
                        Swal.showValidationMessage('La contraseña no es válida.');
                        return false;
                    }


                    return { id: admin.id, email, nombre, apellidos, telefono, contrasena };
                },
            });

            if (formValues) {
                return formValues;
            } else {
                return null;
            }
        },
        async showEditHorario(horario) {
            const { value: formValues } = await Swal.fire({
                title: "Editar un Horario",
                html: `
                <label for="swal-input-tarifaDia" style="width: 4.9rem;">tarifaDia</label>
                <input id="swal-input-tarifaDia" class="swal2-input" placeholder="tarifaDia" value="${horario.tarifa_dia}">

                <label for="swal-input-tarifaMinuto" style="width: 4.9rem;">tarifaMinuto</label>
                <input id="swal-input-tarifaMinuto" class="swal2-input" placeholder="tarifaMinuto" value="${horario.tarifa_minuto}">
              `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                preConfirm: () => {
                    const tarifa_dia = document.getElementById("swal-input-tarifaDia").value;
                    const tarifa_minuto = document.getElementById("swal-input-tarifaMinuto").value;


                    if (!tarifa_dia || !tarifa_minuto) {
                        Swal.showValidationMessage("Todos los campos son obligatorios");
                        return false;
                    }
                    // validar valores
                    const regex = /^(?:\d{1,2}|\d{1,2}\.\d{1,2})$/;
                    if (!regex.test(tarifa_dia)) {
                        Swal.showValidationMessage('La tarifa no es válida.');
                        return false;
                    }
                    if (!regex.test(tarifa_minuto)) {
                        Swal.showValidationMessage('La tarifa no es válida.');
                        return false;
                    }
                    return {
                        id: horario.id,
                        nombre: horario.nombre,
                        tarifa_dia,
                        tarifa_minuto,
                    };
                },
            });

            if (formValues) {
                return formValues;
            } else {
                return null;
            }
        },
    }
}
