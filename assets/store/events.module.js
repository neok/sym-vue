import EventsService from '../services/events';
import OrganizerService from '../services/organizers';

const initialState = {
  events: []
};

export const events = {
  namespaced: true,
  state: initialState,
  actions: {
    fetchEvents({ commit }, organizerId) {
      return OrganizerService.getEventsByOrganizer(organizerId).then(
        events => {
          commit('setEvents', events);
          return Promise.resolve(events);
        },
        error => {
          if (error.response && error.response.status === 401) {
            commit('logout', null, { root: true });
          }
          return Promise.reject(error);
        }
      );
    }
  },
  mutations: {
    setEvents(state, events) {
      state.events = events;
    }
  },
  getters: {
    events: state => state.events
  }
};
