import axios from 'axios';

axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest',
};
axios.defaults.xsrfHeaderName = 'X-CSRF-TOKEN';

export default {
  user: null,

  authenticate(user) {
    this.user = user;
  },

  logout() {
    this.user = null;
  },

  fetchUser() {
    return axios.get('http://story.dev/api/user')
      .then(({ data }) => this.authenticate(data))
      .catch(() => this.logout());
  },

  getUser() {
    return this.user;
  },

  isAuthenticated() {
    return !!this.user;
  },
};
