import axios from "axios";

const baseURL = import.meta.env.DEV
  ? "http://insuraprime_crm.test/"
  : "https://crm.pbibinc.com/";

const axiosClient = axios.create({
  baseURL,
});

export default axiosClient;
