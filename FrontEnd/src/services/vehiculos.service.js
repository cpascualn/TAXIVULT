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
      return await AuthQuery('/api/vehiculos/matricula',{matricula});
    } catch (err) {
      console.log(err);
    }
  },

  async getHorario(horario) {
    try {
      return await AuthQuery(`/api/horarios/buscarHora`,horario);
    } catch (err) {
      console.log(err);
    }
  },
  async actualizarHorario(horario) {
    try {
        return await AuthQuery(`/api/horarios/${horario.id}`,horario,'PATCH');
    } catch (err) {
        console.log(err);
    }
},



}