import { Query } from "@/assets/utils/fetchHelper";
import { jwtDecode } from "jwt-decode";
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
  isTokenExpired(token) {
    if (!token || token == null)
      return true;
    const decodedToken = jwtDecode(token);
    const currentTime = new Date().getTime() / 1000;

    return decodedToken.exp < currentTime;
  }
}