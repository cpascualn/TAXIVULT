import { simpleQuery, simpleAuthQuery, Query } from "@/assets/utils/fetchHelper";

export default {

    async getUsuarios() {
        try {
            return await simpleAuthQuery('/api/usuarios');
        } catch (err) {
            console.log(err);
        }
    },
}
