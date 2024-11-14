import { AuthQuery, simpleAuthQuery } from "@/assets/utils/fetchHelper";

export default {
    async InsertarViaje(data) {
        try {
            return await AuthQuery('/api/viajes/insertar', data);

        } catch (err) {
            console.log(err);
        }
    },
}