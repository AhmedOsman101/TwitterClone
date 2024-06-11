import { defineStore } from "pinia";
import axios from "axios";
import { router } from "@inertiajs/vue3";

export const useAuthStore = defineStore("auth", {
  state: () => {
    return {
      isAuthenticated: false,
      user: {
        id: null,
        full_name: null,
        username: null,
        email: null,
        bio: null,
        cover_photo: null,
        profile_picture: null,
      },
    };
  },
  actions: {
    async getAuthenticatedUser() {
      try {
        const response = await axios.post("http://localhost:8000/auth/user");
        this.user = await response.data.user;
      } catch (e) {
        console.log(e);
      }
    },
    async logout() {
      try {
        router.post("/user/logout");
        this.$reset();
      } catch (e) {
        console.log(e);
      }
    },
  },
});
