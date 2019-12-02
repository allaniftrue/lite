import axios from 'axios';
import * as types from '../mutation-types';

// state
export const state = {
  subscribers: []
}

// getters
export const getters = {
  subscribers: state => state.subscribers
}

// mutations
export const mutations = {
  [types.FETCH_SUBSCRIBERS_SUCCESS] (state, { subscribers }) {
    state.subscribers = subscribers
  },

  [types.FETCH_SUBSCRIBERS_FAILURE] (state) {
    state.subscribers = []
  }
}

// actions
export const actions = {
  async fetchSubscribers ({ commit }) {
    try {
      const { data } = await axios.get('/api/subscribers')

      commit(types.FETCH_SUBSCRIBERS_SUCCESS, { subscribers: data })
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  }
}
