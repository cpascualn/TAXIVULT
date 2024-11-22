import { AuthQuery, simpleAuthQuery } from "@/assets/utils/fetchHelper";

export default {
    async InsertarViaje(data) {
        try {
            return await AuthQuery('/api/viajes/insertar', data);

        } catch (err) {
            console.log(err);
        }
    },
    async getViajes() {
        try {
            return await simpleAuthQuery('/api/viajes');
        } catch (err) {
            console.log(err);
        }
    },
    async getTotales() {
        try {
            const response = await simpleAuthQuery(`/api/viajes/totales`);
            if (!response || !response.success)
                return 0;
            return response.totales;
        } catch (err) {
            console.log(err);
        }
    },
}