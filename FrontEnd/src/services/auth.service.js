import axios from 'axios';
import authHeader from './auth-header';

// const API_URL = import.meta.env.VITE_API_BASE_URL;
const API_URL = "http://localhost:8080/";

const BASE_URL = import.meta.env.VITE_BASE_URL;

export default {

  async login(user) {
    try {
      const response = await fetch(
        API_URL + "login",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(user),
        }
      )
      if (!response.ok) {
        const data = await response.json(); // Espera el resultado de la conversión a JSON
        return data;
        // throw new Error(`HTTP error! error:${data.error} status: ${response.status} `);
      }
      const data = await response.json(); // Espera el resultado de la conversión a JSON
      if (data.access_token) {
        localStorage.setItem('authToken', JSON.stringify(data.access_token));
      }
      return data;
    } catch (err) {
      console.log(err);
    }
  },

  async logout() {
    await axios.post(API_URL + "/logout", {}, { headers: authHeader() })
    localStorage.removeItem('authToken');
    this.$router.push({ name: 'login' });
  },

  async register(user) {
    var response = await axios.post(API_URL + '/register', {
      name: user.name,
      email: user.email,
      password: user.password,
      password_confirmation: user.confirmPassword
    });
    if (response.data.access_token) {
      localStorage.setItem('authToken', JSON.stringify(response.data.access_token));
    }
    return response.data;
  },

  async passwordForgot(userEmail) {

    var response = await axios.post(API_URL + '/password-forgot', {
      redirect_url: BASE_URL + "/password-reset",
      email: userEmail
    })
    return response.status;
  },

  async passwordReset(passwordDTO) {

    var response = await axios.post(API_URL + '/password-reset', {
      password: passwordDTO.newPassword,
      password_confirmation: passwordDTO.confirmPassword,
      email: passwordDTO.email,
      token: passwordDTO.token
    })
    return response.status;
  }
}