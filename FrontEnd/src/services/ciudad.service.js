const API_URL = import.meta.env.VITE_API_BASE_URL;

export default {

  async getCiudades() {
    try {
      const response = await fetch(
        API_URL + "/api/ciudades",
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          }
        }
      )

      const data = await response.json();
      if (!data.success) {
        throw new Error('fallo al acceder a las ciudades')
      }
      return data;
    } catch (err) {
      console.log("fallo del fetch");
      console.log(err);
    }
  }
}