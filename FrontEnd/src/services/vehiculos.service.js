import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

  async getVehiculos() {
    try {
      return await simpleAuthQuery('/api/vehiculos');
    } catch (err) {
      console.log(err);
    }
  },
  async getVehiculosLibres() {
    try {
      return await simpleAuthQuery('/api/vehiculos/libres');
    } catch (err) {
      console.log(err);
    }
  },
  async getVehiculosMatricula(matricula) {
    try {
      return await AuthQuery('/api/vehiculos/matricula', { matricula });
    } catch (err) {
      console.log(err);
    }
  },
  async addVehiculo(vehiculo) {
    try {
      return await AuthQuery(`/api/vehiculos/insertar`, vehiculo);
    } catch (err) {
      console.log(err);
    }
  },
  async eliminarVehiculo(id) {
    try {
      return await simpleAuthQuery(`/api/vehiculos/eliminar/${id}`, 'DELETE');
    } catch (err) {
      console.log(err);
    }
  },
  async actualizarVehiculo(vehiculo) {
    try {
      return await AuthQuery(`/api/vehiculos/actualizar/${vehiculo.id}`,vehiculo, 'PATCH');
    } catch (err) {
      console.log(err);
    }
  }



}