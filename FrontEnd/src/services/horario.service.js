import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

  async getHorarios() {
    try {
      return await simpleAuthQuery('/api/horarios');
    } catch (err) {
      console.error(err);
    }
  },

  async getHorario(horario) {
    try {
      return await AuthQuery(`/api/horarios/buscarHora`, horario);
    } catch (err) {
      console.error(err);
    }
  },
  async actualizarHorario(horario) {
    try {
      return await AuthQuery(`/api/horarios/${horario.id}`, horario, 'PATCH');
    } catch (err) {
      console.error(err);
    }
  },
  async getHorarioUsuario(user) {
    try {
      const response = await simpleAuthQuery(`/api/horarios/${user.id}`);
      if (!response || !response.success) return null;
      return response.horario;
    } catch (err) {
      console.error(err);
    }
  },



}