import BaseService from './base.service';

class EventsService extends BaseService {
  constructor() {
    super('events');
  }

  getByEvent(eventId) {
    return this.get(`/${eventId}/tickets`)
      .then(response => response.data)
      .catch(error => {
        if (error.response && error.response.status === 401) {
          console.error('Unauthorized access - 401');
        }
        return Promise.reject(error);
      });
  }

}

export default new EventsService();
