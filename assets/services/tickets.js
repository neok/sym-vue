import BaseService from './base.service';

class TicketsService extends BaseService {
  constructor() {
    super('tickets');
  }
  create(ticket) {
    return this.post('', ticket)
      .then(response => response.data)
      .catch(error => {
        return Promise.reject(error);
      });
  }

  update(ticket) {
    //can be put or patch, depending on if we want to update all fields or just a few
    return this.patch(`/${ticket.id}`, ticket)
      .then(response => response.data)
      .catch(error => {
        return Promise.reject(error);
      });
  }
  getById(ticketId) {
    return this.get(`/${ticketId}`)
      .then(response => response.data)
      .catch(error => {
        return Promise.reject(error);
      });
  }
}

export default new TicketsService();
