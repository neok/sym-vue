import TicketsService from '../services/tickets';
import EventService from '../services/events';

const initialState = {
  tickets: []
};

export const tickets = {
  namespaced: true,
  state: initialState,
  actions: {
    getTicket({ commit }, ticketId) {
      return TicketsService.getById(ticketId).then(
        ticket => {
          return Promise.resolve(ticket);
        },
        error => {
          return Promise.reject(error);
        }
      );
    },
    fetchTickets({ commit }, eventId) {
      return EventService.getByEvent(eventId).then(
        tickets => {
          commit('setTickets', tickets);
          return Promise.resolve(tickets);
        },
        error => {
          if (error.response && error.response.status === 401) {
            // Handle unauthorized access
            commit('logout', null, { root: true });
          }
          return Promise.reject(error);
        }
      );
    },
    createTicket({ commit }, ticket) {
      return TicketsService.create(ticket).then(
        newTicket => {
          commit('updateTicket', newTicket);
          return Promise.resolve(newTicket);
        },
        error => {
          return Promise.reject(error);
        }
      );
    },
    updateTicket({ commit }, ticket) {
      return TicketsService.update(ticket).then(
        updatedTicket => {
          commit('updateTicket', updatedTicket);
          return Promise.resolve(updatedTicket);
        },
        error => {
          return Promise.reject(error);
        }
      );
    },

  },
  mutations: {
    setTickets(state, tickets) {
      state.tickets = tickets;
    },
    updateTicket(state, updatedTicket) {
      const index = state.tickets.findIndex(ticket => ticket.id === updatedTicket.id);
      if (index !== -1) {
        state.tickets[index] = updatedTicket;
      }
    }
  },
  getters: {
    tickets: state => state.tickets
  }
};
