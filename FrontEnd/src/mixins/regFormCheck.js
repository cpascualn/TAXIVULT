import imageService from "@/services/image.service";

export default {

    checkMail(mail) {
        const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regexCorreo.test(mail);
    },

    checkNombre(nombre) {
        const regexNombre = /^[a-zA-ZÀ-ÿ\s]{2,}$/;
        return regexNombre.test(nombre);
    },

    checkNomCoche(nombre) {
        const regexNombre = /^[a-zA-ZÀ-ÿ0-9\s\-.]{2,}$/;
        return regexNombre.test(nombre);
    },

    checkTelefono(telefono) {
        const regexTelefono = /^\+?[0-9\s()-]{9,15}$/;
        return regexTelefono.test(telefono);
    },

    // Validación de contraseña (mínimo 8 caracteres, al menos una letra y un número)
    checkContrasena(password) {
        const regexPassword = /^(?=.*[a-zA-Z])(?=.*\d).{8,}$/;
        return regexPassword.test(password);
    },

    // Validación de tarjeta de crédito (Visa, MasterCard, American Express, etc.)
    checkTarjeta(tarjeta) {
        const regexTarjeta = /^\d{4}(?:\s?\d{4}){3}$/;
        return regexTarjeta.test(tarjeta);
    },

    // Validación de fecha de expiración de tarjeta (MM/YY o MM/YYYY)
    checkExpTarjeta(expiracion) {
        const regexExpiracion = /^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/;
        return regexExpiracion.test(expiracion);
    },

    // Validación de CVC (3 o 4 dígitos)
    checkCvcTarjeta(cvc) {
        const regexCVC = /^[0-9]{3,4}$/;
        return regexCVC.test(cvc);
    },
    checkIban(iban) {
        const regexIban = /^[A-Z]{2}\d{2}(?:\s?\d{4}){5}$/;
        return regexIban.test(iban);
    },

    // Validación de DNI (España, formato 8 dígitos + letra)
    checkDNI(dni) {
        const regexDNI = /^\d{8}[A-HJ-NP-TV-Z]$/i;
        return regexDNI.test(dni);
    },

    // Validación de VTC (8 caracteres alfanuméricos)
    checkVTC(vtc) {
        const regexVTC = /^[A-Za-z]{3}-?\d{6}$/;
        return regexVTC.test(vtc);
    },

    // Validación de matrícula (España, formato XXXX BBB, con letras y números)
    checkMatricula(matricula) {
        const regexMatricula = /^\d{4}\s?[A-Z]{3}$/;
        return regexMatricula.test(matricula);
    },
    async checkImagenCoche(img) {
        // si la ia devuelve alguna de estas palabras clave, es true
        const keywords = ['car', 'taxi', 'vehicle', 'cab', 'hack', 'taxi', 'taxicab', 'van', 'minvan', 'minivan', 'minibus', 'moving van', 'sports car', 'sport car'];

        try {
            const result = await imageService.checkImage(img);
            // Procesa el resultado para verificar si hay un vehículo
            if (!result) return false;
            if (result.error) return false;
            const isVehicle = result.some(item =>
                keywords.some(keyword => item.label.toLowerCase().includes(keyword))
            );
            return isVehicle;
        } catch (error) {
            console.error('Error al verificar la imagen:', error);
            return false;
        }
    }
}