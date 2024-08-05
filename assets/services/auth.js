import axios from 'axios';
import { API_URL } from '../config';

const LOGIN_CHECK = 'login_check';

class AuthService {
  login(user) {
    return axios
      .post(`${API_URL}${LOGIN_CHECK}`, {
        email: user.email,
        password: user.password
      })
      .then(response => {
        if (response.data.token) {
          localStorage.setItem('user', JSON.stringify(response.data));
        }

        return response.data;
      });
  }
  logout() {
    localStorage.removeItem('user');
  }
}

export default new AuthService();
