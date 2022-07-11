import { API } from "@/constants/api";
import axios from "axios";
import { STATUS_CODE } from "@/constants/status-code";
import { Module } from "vuex";
import { IAuth, IAuthorizationData } from "@/interfaces/store/Auth";

export const AuthModule: Module<IAuth, any> = {
  namespaced: true,

  state: {
    token: "",
    refreshToken: "",
    role: "",
    isAuth: false,
  },

  getters: {},

  mutations: {
    getToken(state, payload) {
      state.token = payload;
    },

    getRefreshToken(state, payload) {
      state.refreshToken = payload;
    },

    userRole(state, payload) {
      state.role = payload.role;
    },

    authorizationSuccess(state, payload) {
      state.isAuth = payload;
    },
  },

  actions: {
    async authorization(store, data: IAuthorizationData) {
      try {
        const URL = API.signInPath;
        const response = await axios.post(URL, data);
        if (response.status === STATUS_CODE.SUCCESS) {
          store.commit("getToken", response.data.token);
          store.commit("getRefreshToken", response.data.refresh_token);
          store.commit("authorizationSuccess", true);
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
};
