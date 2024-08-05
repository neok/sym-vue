import BaseService from './base.service';

class OrganizersService extends BaseService {
  constructor() {
    super('organizers');
  }

  getAll() {
    return this.get('')
      .then(response => response.data)
      .catch(error => {
        if (error.response && error.response.status === 401) {
          //redirect to login or something
        }
        return Promise.reject(error);
      });
  }

  getEventsByOrganizer(organizerId) {
    return this.get(`/${organizerId}/events`)
      .then(response => response.data)
      .catch(error => {
        if (error.response && error.response.status === 401) {
          // Handle unauthorized access
          console.error('Unauthorized access - 401');
        }
        return Promise.reject(error);
      });
  }
}

export default new OrganizersService();
