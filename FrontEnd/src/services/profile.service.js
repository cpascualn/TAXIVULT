import { simpleQuery, Query, simpleAuthQuery } from "@/assets/utils/fetchHelper";
import { jwtDecode } from "jwt-decode";

export default {
  async getProfile() {
    try {
      const usrToken = localStorage.getItem("authToken");
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

  async editProfile() {

  },

  async uploadPic() {

  }

}