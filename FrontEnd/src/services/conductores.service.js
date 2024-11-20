import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {
    async getConductores() {
        try {
            return await simpleAuthQuery(`/api/conductores`);
        } catch (err) {
            console.log(err);
        }
    },
    async getConductoresLibresCiudad(ciudad) {
        try {
            return await simpleAuthQuery(`/api/conductores/libres/${ciudad.id}`);
        } catch (err) {
            console.log(err);
        }
    },
    async getConductoresDisponiblesCiudad(hora_ini, hora_fin, ciudad) {
        try {
            const datos = { hora_ini, hora_fin, ciudad };
            return await AuthQuery(`/api/conductores/disponibles`, datos);
        } catch (err) {
            console.log(err);
        }
    },
    async actualizarConductor(conductor) {
        try {
            return await AuthQuery(`/api/conductores/actualizar/${conductor.id}`, conductor, 'PATCH');
        } catch (err) {
            console.log(err);
        }
    }
}
