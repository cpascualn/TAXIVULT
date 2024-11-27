import { simpleQuery, simpleAuthQuery, Query, AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

  async getCiudades() {
    try {
      return await simpleQuery('/api/ciudades');
    } catch (err) {
      console.error(err);
    }
  },

  async getCiudad(id) {
    try {
      return await simpleQuery(`/api/ciudades/${id}`);
    } catch (err) {
      console.error(err);
    }
  },
  async getCiudadNombre() {
    try {
      return await simpleQuery(`/api/ciudades/${nombre}`);
    } catch (err) {
      console.error(err);
    }
  },
  async getCiudadUsuario() {
    try {
      let data = await profileService.getProfile();
      if (!data)
        return null;
      if (data.rol == 1) //los administradores no tienen ciudad
        return null;
      let ciuData = await this.getCiudad(data.ciudad);
      if (!ciuData.success)
        return null;
      return ciuData.ciudad;
    } catch (err) {
      console.error(err);
    }
  },
  async addCiudad(ciudad) {
    try {
      return await AuthQuery(`/api/ciudades/insertar`, ciudad);
    } catch (err) {
      console.error(err);
    }
  },
  async deleteCiudad(id) {
    try {
      return await simpleAuthQuery(`/api/ciudades/eliminar/${id}`, 'DELETE');
    } catch (err) {
      console.error(err);
    }
  },

  async getUsuariosPorCiudad() {
    try {
      const response = await simpleAuthQuery('/api/ciudades/obtener/UsuariosCiudad');
      if (!response || !response.success)
        return null;
      return response.data;
    } catch (err) {
      console.error(err);
    }
  },


}