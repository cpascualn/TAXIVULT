import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

  async getVehiculos() {
    try {
      return await simpleAuthQuery('/api/vehiculos');
    } catch (err) {
      console.error(err);
    }
  },
  async getVehiculosLibres() {
    try {
      return await simpleAuthQuery('/api/vehiculos/libres');
    } catch (err) {
      console.error(err);
    }
  },
  async getVehiculosMatricula(matricula) {
    try {
      return await AuthQuery('/api/vehiculos/matricula', { matricula });
    } catch (err) {
      console.error(err);
    }
  },
  async addVehiculo(vehiculo) {
    try {
      return await AuthQuery(`/api/vehiculos/insertar`, vehiculo);
    } catch (err) {
      console.error(err);
    }
  },
  async eliminarVehiculo(id) {
    try {
      return await simpleAuthQuery(`/api/vehiculos/eliminar/${id}`, 'DELETE');
    } catch (err) {
      console.error(err);
    }
  },
  async actualizarVehiculo(vehiculo) {
    try {
      return await AuthQuery(`/api/vehiculos/actualizar/${vehiculo.id}`, vehiculo, 'PATCH');
    } catch (err) {
      console.error(err);
    }
  },
  async getVehiculosTotales() {
    try {
      const response = await simpleAuthQuery(`/api/vehiculos/totales`);
      if (!response || !response.success)
        return 0;
      return response.totales;
    } catch (err) {
      console.error(err);
    }
  },
  async getVehiculoUsuario(user) {
    try {
      const response = await simpleAuthQuery(`/api/vehiculos/usuario/${user.id}`);
      if (!response || !response.success)
        return 0;
      return response;
    } catch (err) {
      console.error(err);
    }
  },




}