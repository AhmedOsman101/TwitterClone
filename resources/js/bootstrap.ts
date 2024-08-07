import { Axios, AxiosInstance } from "axios";

window.axios = new Axios({
	baseURL: import.meta.env.APP_URL,
	headers: {
		"Content-Type": "application/json",
		// Authorization: "Bearer your-token-here",
		// Referrer: import.meta.env.APP_URL,
		"X-Requested-With": "XMLHttpRequest",
		Accept: "application/json",
	},
	withCredentials: true,
	withXSRFToken: true,
}) as AxiosInstance;
