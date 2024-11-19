import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

  async getHorarios() {
    try {
      return await simpleAuthQuery('/api/horarios');
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