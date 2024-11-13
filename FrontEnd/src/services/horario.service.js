import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

  async getHorarios() {
    try {
      return await simpleQuery('/api/horarios');
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



}