import Swal from "sweetalert2";
import regFormCheck from "./regFormCheck";
import ciudadService from "@/services/ciudad.service";
import horarioService from "@/services/horario.service";
import vehiculosService from "@/services/vehiculos.service";
import encodeImageToBase64 from "@/assets/utils/imageEncoder";

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
        showSwalConfirmationDelete(extraTxt = "") {
            const swalDelete = new Swal({
                title: "¿Estas Seguro?",
                text: extraTxt + "Este cambio es irreversible",
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
            } else {
                return null;
            }
        },
        async showEditAdmin(admin) {
            const { value: formValues } = await Swal.fire({
                title: "Editar un administrador",
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
        async showEditUser(user) {
            //recoger ciudades
            const response = await ciudadService.getCiudades();
            let cius = [];
            let ciudadActual;
            if (response.success) {
                response.ciudades.forEach((ciudad) => {
                    cius.push({ id: ciudad.id, nombre: ciudad.nombre });
                });
                ciudadActual = cius.find((ciudad) => ciudad.nombre === user.ciudad);
            }
            const { value: formValues } = await Swal.fire({
                title: `Editar un ${user.rol}`,
                html: `
                <label for="swal-input-email" style="width: 4.5rem;">Email</label>
                <input id="swal-input-email" class="swal2-input" placeholder="Email" value="${user.email}">

                <label for="swal-input-nombre" style="width: 4.5rem;">Nombre</label>
                <input id="swal-input-nombre" class="swal2-input" placeholder="Nombre" value="${user.nombre}">

                <label for="swal-input-apellidos" style="width: 4.5rem;">Apellidos</label>
                <input id="swal-input-apellidos" class="swal2-input" placeholder="Apellidos" value="${user.apellidos}">

                <label for="swal-input-telefono" style="width: 4.5rem;">Teléfono</label>
                <input id="swal-input-telefono" class="swal2-input" placeholder="Teléfono" value="${user.telefono}">

                <label for="swal-select-ciudad"style="width: 4.5rem;"> Ciudad</label>
                <select
                  id="swal-select-ciudad"
                  class="swal2-select"
                  autocomplete="usuario.ciudad"
                  placeholder="Ciudad"
                  required
                >
                  <option value="${ciudadActual.id}" selected style="color: black;">${ciudadActual.nombre}</option>

                ${cius.map(ciudad => {
                    if (ciudad.id === ciudadActual.id) return '';
                    return `
                    <option
                    value="${ciudad.id}"
                    style="color: black;"
                    >
                    ${ciudad.nombre}
                    </option>
                `
                }).join('')}
                </select>

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
                    const ciudadElegida = document.getElementById("swal-select-ciudad").value;
                    if (!email || !nombre || !apellidos || !telefono || !ciudadElegida) {
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


                    return { id: user.id, email, nombre, apellidos, telefono, ciudad: ciudadElegida, contrasena };
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
        async showAddciudad() {
            const { value: formValues } = await Swal.fire({
                title: "Añadir una ciudad",
                html: `
                <label for="swal-input-ciudad" style="width: 4.9rem;">ciudad</label>
                <input id="swal-input-ciudad" class="swal2-input" placeholder="ciudad">
              `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                preConfirm: () => {
                    const ciudad = document.getElementById("swal-input-ciudad").value;


                    if (!ciudad) {
                        Swal.showValidationMessage("Todos los campos son obligatorios");
                        return false;
                    }
                    // validar valores
                    if (!regFormCheck.checkNombre(ciudad)) {
                        Swal.showValidationMessage('La ciudad no es válida.');
                        return false;
                    }
                    return {
                        ciudad
                    };
                },
            });

            if (formValues) {
                return formValues;
            } else {
                return null;
            }
        },
        async showEditConductor(conductor) {
            // recoger coches 
            const response = await vehiculosService.getVehiculosLibres();
            let coches = [];
            let cocheActual = { id: '', matricula: '' };
            if (conductor.coche) {
                cocheActual = await vehiculosService.getVehiculosMatricula(conductor.coche);
                cocheActual = { id: cocheActual.vehiculo.id, matricula: cocheActual.vehiculo.matricula }
            }

            if (response.success) {
                response.vehiculos.forEach((coche) => {
                    coches.push({ id: coche.id, matricula: coche.matricula });
                });
            }

            //recoger horarios
            const response2 = await horarioService.getHorarios();
            let horarios = [];
            let horarioActual;
            if (response2.success) {
                response2.horarios.forEach((horario) => {
                    horarios.push({ id: horario.id, nombre: horario.nombre });
                });
                horarioActual = horarios.find((horario) => horario.nombre === conductor.horario);
            }

            const { value: formValues } = await Swal.fire({
                title: "Editar un Conductor",
                html: `
                 <label for="swal-select-coche"style="width: 4.5rem;"> Coches Libres </label>
                <select
                  id="swal-select-coche"
                  class="swal2-select"
                  autocomplete="usuario.coche"
                  placeholder="coche"
                  required
                >
                  <option value="${cocheActual.matricula}" selected style="color: black;">${cocheActual.matricula}</option>

                ${coches.map(coche => {
                    if (coche.id === cocheActual.id) return '';
                    return `
                    <option
                    value="${coche.matricula}"
                    style="color: black;"
                    >
                    ${coche.matricula}
                    </option>
                `
                }).join('')}
                </select>

                 <label for="swal-select-horario"style="width: 4.5rem;"> Horario </label>
                <select
                  id="swal-select-horario"
                  class="swal2-select"
                  autocomplete="usuario.horario"
                  placeholder="horario"
                  required
                >
                  <option value="${horarioActual.id}" selected style="color: black;">${horarioActual.nombre}</option>

                ${horarios.map(horario => {
                    if (horario.id === horarioActual.id) return '';
                    return `
                    <option
                    value="${horario.id}"
                    style="color: black;"
                    >
                    ${horario.nombre}
                    </option>
                `
                }).join('')}
                </select>
              `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                preConfirm: () => {
                    const coche = document.getElementById("swal-select-coche").value;
                    const horario = document.getElementById("swal-select-horario").value;


                    if (!coche || !horario) {
                        Swal.showValidationMessage("Todos los campos son obligatorios");
                        return false;
                    }

                    return { id: conductor.id, matricula: coche, horario };
                },
            });

            if (formValues) {
                return formValues;
            } else {
                return null;
            }
        },
        async showAddVehiculo() {
            const tipos = ["comun", "van"];
            const { value: formValues } = await Swal.fire({
                title: "Crear un Vehiculo",
                html: `
             <div>
                <label for="swal-input-matricula" style="width: 4.5rem;">matricula</label>
                <input id="swal-input-matricula" class="swal2-input" placeholder="matricula">
                
                <label for="swal-input-capacidad" style="width: 4.5rem;">capacidad</label>
                <input id="swal-input-capacidad" class="swal2-input" type="number" placeholder="capacidad">
                
                <label for="swal-input-fabricante" style="width: 4.5rem;">fabricante</label>
                <input id="swal-input-fabricante" class="swal2-input" placeholder="fabricante">
                
                <label for="swal-input-modelo" style="width: 4.5rem;">modelo</label>
                <input id="swal-input-modelo" class="swal2-input" placeholder="modelo">

                  <label for="swal-select-tipo"style="width: 4.5rem;"> tipo</label>
                <select
                  id="swal-select-tipo"
                  class="swal2-select"
                  autocomplete="usuario.tipo"
                  placeholder="tipo"
                  required
                >
                  <option value="" selected disabled style="color: black;"> tipo</option>

                ${tipos.map(tipo =>
                    `<option
                    value="${tipo}"
                    style="color: black;">
                    ${tipo}
                    </option>
                `
                ).join('')}
                </select>

               <label for="swal-input-imagen" style="width: 4.5rem;">imagen</label>
                <input id="swal-input-imagen" type="file" class="swal2-input" placeholder="imagen" accept="image/*">
            </div>
              `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                preConfirm: async () => {
                    const matricula = document.getElementById("swal-input-matricula").value;
                    const capacidad = document.getElementById("swal-input-capacidad").value;
                    const fabricante = document.getElementById("swal-input-fabricante").value;
                    const modelo = document.getElementById("swal-input-modelo").value;
                    const tipo = document.getElementById("swal-select-tipo").value;
                    let imagen = document.getElementById("swal-input-imagen");
                    imagen = imagen && imagen.files.length > 0 ? imagen.files[0] : null;

                    if (!matricula || !capacidad || !fabricante || !modelo | !tipo) {
                        Swal.showValidationMessage("Todos los campos son obligatorios");
                        return false; // Evita cerrar el modal
                    }
                    // validar valores

                    if (!regFormCheck.checkMatricula(matricula)) {
                        Swal.showValidationMessage('La matricula no es válida.');
                        return false;
                    }
                    if (capacidad < 5 || capacidad > 10) {
                        Swal.showValidationMessage('La capacidad no es válida.');
                        return false;
                    }
                    if (!regFormCheck.checkNomCoche(fabricante)) {
                        Swal.showValidationMessage('El fabricante no es válida.');
                        return false;
                    }
                    if (!regFormCheck.checkNomCoche(modelo)) {
                        Swal.showValidationMessage('El modelo no es válida.');
                        return false;
                    }
                    if (tipo == "") {
                        Swal.showValidationMessage('el tipo no es válida.');
                        return false;
                    }


                    if (imagen && imagen.type.startsWith("image/")) {
                        const result = await regFormCheck.checkImagenCoche(imagen);

                        if (result) {
                            imagen = await encodeImageToBase64(imagen);
                        } else {
                            imagen = null;
                            Swal.showValidationMessage('Por favor, selecciona un archivo de imagen válido.');
                            return false;
                        }
                    } else {
                        Swal.showValidationMessage('Por favor, selecciona un archivo de imagen válido.');
                        return false;
                    }

                    return { matricula, capacidad, fabricante, modelo, tipo, imagen };
                },
            });

            if (formValues) {
                return formValues;
            } else {
                return null;
            }
        },
        async showEditVehiculo(vehiculo) {
            const { value: formValues } = await Swal.fire({
                title: "Actualizar imagen vehiculo",
                html: `
             <div>
                <label for="swal-input-matricula" style="width: 4.5rem;">matricula</label>
                <input id="swal-input-matricula" class="swal2-input" placeholder="matricula" value="${vehiculo.matricula}" disabled>
                
                <label for="swal-input-fabricante" style="width: 4.5rem;">fabricante</label>
                <input id="swal-input-fabricante" class="swal2-input" placeholder="fabricante" value="${vehiculo.fabricante}" disabled>
                
                <label for="swal-input-modelo" style="width: 4.5rem;">modelo</label>
                <input id="swal-input-modelo" class="swal2-input" placeholder="modelo" value="${vehiculo.modelo}" disabled>

               <label for="swal-input-imagen" style="width: 4.5rem;">imagen</label>
                <input id="swal-input-imagen" type="file" class="swal2-input" placeholder="imagen" accept="image/*">
            </div>
              `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                preConfirm: async () => {
                    const matricula = document.getElementById("swal-input-matricula").value;
                    let imagen = document.getElementById("swal-input-imagen");
                    imagen = imagen && imagen.files.length > 0 ? imagen.files[0] : null;


                    if (imagen && imagen.type.startsWith("image/")) {
                        const result = await regFormCheck.checkImagenCoche(imagen);

                        if (result) {
                            imagen = await encodeImageToBase64(imagen);
                        } else {
                            imagen = null;
                            Swal.showValidationMessage('Por favor, selecciona un archivo de imagen válido.');
                            return false;
                        }
                    } else {
                        Swal.showValidationMessage('Por favor, selecciona un archivo de imagen válido.');
                        return false;
                    }

                    return { id: vehiculo.id, matricula, imagen };
                },
            });

            if (formValues) {
                return formValues;
            } else {
                return null;
            }
        }
    }
}