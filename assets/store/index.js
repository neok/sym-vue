import { createStore } from "vuex";
import { auth } from "./auth.module";
import {organizers} from "./organizers.module";
import {events} from "./events.module";
import {tickets} from "./tickets.module";

const store = createStore({
  modules: {
    auth,
    organizers,
    events,
    tickets
  },
});

export default store;
