import { simpleQuery, simpleAuthQuery, Query } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

    async getConductoresLibresCiudad(ciudad) {
        try {
            return await simpleAuthQuery(`/api/conductores/libres/${ciudad.id}`);
        } catch (err) {
            console.log(err);
        }
    },
}
