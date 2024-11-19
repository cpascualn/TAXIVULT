import { simpleQuery, simpleAuthQuery, Query,AuthQuery } from "@/assets/utils/fetchHelper";
import profileService from "./profile.service";

export default {

  async getCiudades() {
    try {
      return await simpleQuery('/api/ciudades');
    } catch (err) {
      console.log(err);
    }
  },

  async getCiudad(id) {
    try {
      return await simpleQuery(`/api/ciudades/${id}`);
    } catch (err) {
      console.log(err);
    }
  },
  async getCiudadNombre() {
    try {
      return await simpleQuery(`/api/ciudades/${nombre}`);
    } catch (err) {
      console.log(err);
    }
  },
  async getCiudadUsuario() {
    try {
      let data = await profileService.getProfile();
      if (!data)
        return null;

      let ciuData = await this.getCiudad(data.usuario.ciudad);
      if(!ciuData.success)
        return null;
      return ciuData.ciudad;
    } catch (err) {
      console.log(err);
    }
  },
  async addCiudad(ciudad) {
    try {
      return await AuthQuery(`/api/ciudades/insertar`,ciudad);
    } catch (err) {
      console.log(err);
    }
  },
  async deleteCiudad(id) {
    try {
      console.log(id);
      
      return await simpleAuthQuery(`/api/ciudades/eliminar/${id}`,'DELETE');
    } catch (err) {
      console.log(err);
    }
  },


}