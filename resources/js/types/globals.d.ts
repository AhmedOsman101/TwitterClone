import type { route as routeFn } from "ziggy-js";

declare global {
  interface Window {
    axios: AxiosInstance;
  }

  const route: typeof routeFn;
}
