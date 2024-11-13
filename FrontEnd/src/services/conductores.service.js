import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

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
}
