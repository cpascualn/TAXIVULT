import { AuthQuery, simpleAuthQuery } from "@/assets/utils/fetchHelper";

export default {
    async InsertarViaje(data) {
        console.log(data);
        
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
    async getTotalesCiudad() {
        try {
            const response = await simpleAuthQuery(`/api/viajes/totalesCiudad`);
            if (!response || !response.success)
                return 0;
            return response.totales;
        } catch (err) {
            console.log(err);
        }
    },
    async getTotalesCiudadMes() {
        try {
            const response = await simpleAuthQuery(`/api/viajes/totalesCiudadMes`);
            if (!response || !response.success)
                return 0;
            return response.totales;
        } catch (err) {
            console.log(err);
        }
    },
    async getViajesUsuario(user) {
        try {
            const response = await AuthQuery(`/api/viajes/usuario`, { id: user.id });
            if (!response || !response.success)
                return 0;
            return response.viajes;
        } catch (err) {
            console.log(err);
        }
    }
}