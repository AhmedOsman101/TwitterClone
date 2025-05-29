import { useAxios } from "@vueuse/integrations/useAxios.mjs";
import { defineStore } from "pinia";
import { ref } from "vue";
import AxiosInstance from "@/lib/axios";
import type { User } from "@/types";

export const useAuthStore = defineStore("auth", () => {
  const user = ref<User>({} as User);

  /**
   * Fetches the authenticated user data from the API and updates the user state if not already authenticated.
   * @param {User} data The data to update the user
   */
  function updateAuthenticatedUser(data: User): void {
    user.value = { ...user.value, ...data };
  }

  /**
   * Sets the authenticated user in the store.
   * @param {User} data - The user data to set.
   */
  function setAuthenticatedUser(data: User): void {
    user.value = data;
  }

  /**
   * Fetches the authenticated user data from the server and updates the store.
   */
  async function fetchUser(): Promise<void> {
    // await axios
    // 	.post(route("auth.user"))
    // 	.then((res) => this.setAuthenticatedUser(res.data));

    const { isFinished, data } = await useAxios<User>(
      route("auth.user"),
      AxiosInstance
    );

    if (isFinished.value) setAuthenticatedUser(data.value);
  }

  return { user, updateAuthenticatedUser, setAuthenticatedUser, fetchUser };
});
