import { simpleQuery, simpleAuthQuery, Query } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

    async getConductoresLibresCiudad(ciudad) {
        try {
            console.log('entra');

            return new Promise((resolve, reject) => {
                resolve([{
                    id: 1,
                    latitud: 40.422732700,
                    longitud: -3.697641700,
                }, {
                    id: 2,
                    latitud: 40.417827200,
                    longitud: -3.702222089,
                }])
            });
            //   return await simpleQuery('/api/conductores/...',ciudad);
        } catch (err) {
            console.log(err);
        }
    },
}
