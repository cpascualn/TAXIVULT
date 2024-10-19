import { simpleQuery } from "@/assets/utils/fetchHelper";
import { Query } from "@/assets/utils/fetchHelper";

export default {

  async login(user) {
    try {
      const data = await Query('/login', user);
      if (data.access_token) {
        localStorage.setItem('authToken', JSON.stringify(data.access_token));
      }
      return data;
    } catch (err) {
      console.log(err);
    }
  },

  async logout() {
    localStorage.removeItem('authToken');
  },

  async register(user) {
    try {
      return await Query('/register', user);
    } catch (error) {
      console.log(error);
      return { "error": error, "success": false };
    }
  },
}