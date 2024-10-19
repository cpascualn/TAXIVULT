import { simpleQuery } from "@/assets/utils/fetchHelper";
import { Query } from "@/assets/utils/fetchHelper";

export default {

  async getCiudades() {
    try {
      return await simpleQuery('/api/ciudades');
    } catch (err) {
      console.log(err);
    }
  }
}