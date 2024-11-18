import { simpleQuery, simpleAuthQuery, AuthQuery } from "@/assets/utils/fetchHelper";

export default {

    async getUsuarios() {
        try {
            return await simpleAuthQuery('/api/usuarios');
        } catch (err) {
            console.log(err);
        }
    },
    async eliminarUsuario(id) {
        try {
            return await simpleAuthQuery(`/api/usuarios/${id}`,'DELETE');
        } catch (err) {
            console.log(err);
        }
    },
    async actualizarUsuario(user) {
        try {
            return await AuthQuery(`/api/usuarios/${user.id}`,user,'PATCH');
        } catch (err) {
            console.log(err);
        }
    },
}
