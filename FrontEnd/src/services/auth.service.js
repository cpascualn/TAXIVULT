import authHeader from './auth-header';

const API_URL = import.meta.env.VITE_API_BASE_URL;

export default {

  async login(user) {

    try {
      const response = await fetch(
        API_URL + "/login",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(user),
        }
      )

      const data = await response.json();
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


      const response = await fetch(
        API_URL + "/register",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(user),
        }
      )
      console.log(response);
      if (!response.ok) {
        const errorText = await response.text(); // Obtén la respuesta como texto
        console.log("Error en la respuesta:", errorText);
        throw new Error(errorText);
      }

      return {response,"success": true};
    } catch (error) {
      return { "error": error, "success": false };
    }
  },

  async passwordForgot(userEmail) {


  },

  async passwordReset(passwordDTO) {


  }
}