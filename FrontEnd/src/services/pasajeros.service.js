import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {
    async getPasajeros() {
        try {
            return await simpleAuthQuery(`/api/pasajeros`);
        } catch (err) {
            console.error(err);
        }
    },
    async obtenerPasajero(pasajero) {
        try {
            const response = await simpleAuthQuery(`/api/pasajeros/obtener/${pasajero.id}`);
            if (!response || !response.success || !response.pasajero) return null;
            return response.pasajero;
        } catch (err) {
            console.error(err);
            return null
        }
    }, async actualizarPasajero(pasajero) {
        try {
            return await AuthQuery(`/api/pasajeros/actualizar/${pasajero.id}`, pasajero, 'PATCH');
        } catch (err) {
            console.error(err);
        }
    },
}