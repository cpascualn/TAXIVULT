import { simpleQuery, Query, simpleAuthQuery, AuthQuery } from "@/assets/utils/fetchHelper";
import { jwtDecode } from "jwt-decode";
const usrToken = localStorage.getItem("authToken");
export default {
  async getProfile() {
    try {
      let id = '';
      if (!usrToken)
        return null;

      const decoded = jwtDecode(usrToken);
      id = decoded.data.userId;

      let url = `/api/usuarios/${id}`;
      const response = await simpleAuthQuery(url);
      if (!response || !response.success)
        return null;
      return response.usuario;
    } catch (err) {
      console.log(err);
      return null;

    }
  },

  async verViajes() {
    try {
      let id = '';
      if (!usrToken)
        return null;

      const decoded = jwtDecode(usrToken);
      id = decoded.data.userId;

      return await AuthQuery('/api/viajes/activoUsuario', { id });

    } catch (err) {
      console.log(err);
    }
  },
  getRol() {
    if (!usrToken)
      return 0;
    const decoded = jwtDecode(usrToken);
    let rol = decoded.data.rol;
    return rol;
  }

}