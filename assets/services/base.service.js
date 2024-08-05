import axios from 'axios';
import { API_URL } from '../config';
import authHeader from './auth.header';

class BaseService {
  constructor(endpoint) {
    this.apiURL = API_URL + endpoint;
  }

  get(url) {
    return axios.get(this.apiURL + url, { headers: authHeader() });
  }

  post(url, data) {
    return axios.post(this.apiURL + url, data, { headers: authHeader() });
  }

  patch(url, data) {
    return axios.patch(this.apiURL + url, data, { headers: authHeader() });
  }

  delete(url) {
    return axios.delete(this.apiURL + url, { headers: authHeader() });
  }
}

export default BaseService;
