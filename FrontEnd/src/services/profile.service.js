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
      return await simpleAuthQuery(url);

    } catch (err) {
      console.log(err);
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