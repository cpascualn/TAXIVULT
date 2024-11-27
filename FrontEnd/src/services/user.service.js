import { simpleQuery, simpleAuthQuery, AuthQuery } from "@/assets/utils/fetchHelper";

export default {

    async getUsuarios() {
        try {
            return await simpleAuthQuery('/api/usuarios');
        } catch (err) {
            console.error(err);
        }
    },
    async eliminarUsuario(id) {
        try {
            return await simpleAuthQuery(`/api/usuarios/${id}`, 'DELETE');
        } catch (err) {
            console.error(err);
        }
    },
    async actualizarUsuario(user) {
        try {
            return await AuthQuery(`/api/usuarios/${user.id}`, user, 'PATCH');
        } catch (err) {
            console.error(err);
        }
    },
    async getUsuariosTotales() {
        try {
            const response = await simpleAuthQuery(`/api/usuarios/totales`);
            if (!response || !response.success)
                return 0;
            return response.totales;
        } catch (err) {
            console.error(err);
        }
    },
    async comprobarContrasena(user) {
        try {
            const response = await AuthQuery(`/api/usuarios/comprobarContrasena`, user);
            if (!response || response.success == null) return false;
            return response.success;
        } catch (err) {
            console.error(err);
            return false;
        }
    },
}
