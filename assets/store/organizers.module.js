import OrganizersService from '../services/organizers';

const initialState = {
  organizers: []
};

export const organizers = {
  namespaced: true,
  state: initialState,
  actions: {
    fetchOrganizers({ commit }) {
      return OrganizersService.getAll().then(
        organizers => {
          commit('setOrganizers', organizers);
          return Promise.resolve(organizers);
        },
        error => {
          if (error.response && error.response.status === 401) {
            // Handle unauthorized access
            commit('logout', null, { root: true });
          }
          return Promise.reject(error);
        }
      );
    }
  },
  mutations: {
    setOrganizers(state, organizers) {
      state.organizers = organizers;
    }
  },
  getters: {
    organizers: state => state.organizers
  }
};
