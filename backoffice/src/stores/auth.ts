import { defineStore } from "pinia";
import { useAlertStore } from "./alert";
import type { AxiosResponse } from "axios";

const alert = useAlertStore();

interface AuthState {
    user: object;
    loginForm: object;
}

export const useAuthStore = defineStore<string, AuthState>({
    id: "auth",
    state: () => ({
        user: {},
        loginForm: {
            email: "",
            password: "",
        },
    }),
    getters: {},
    actions: {
        async loadUser(): Promise<void> {
            await this.$axios
                .get("auth/user", {
                    headers: { Authorization: `Bearer ${localStorage.token}` },
                })
                .then((response: AxiosResponse) => {
                    this.$state.user = response.data
                })
                .catch(() => {
                    this.logout();
                });
        },
        async login(): Promise<void> {
            await this.$axios
                .post("auth/login", this.$state.loginForm)
                .then((response) => {
                    this.setAuthToken(response.data);
                    this.$router.push("/");
                })
                .catch(() => {
                    alert.setAlert(
                        "error",
                        "Error, por favor intente nuevamente"
                    );
                })
                .finally(() => {
                    alert.unsetAlert();
                });
        },
        async logout(): Promise<void> {
            this.$axios
                .get("auth/logout")
                .then(() => {
                    localStorage.removeItem("token");
                    this.$router.push("/login");
                })
                .catch(() => {
                    alert.setAlert(
                        "error",
                        "Error, por favor intente nuevamente"
                    );
                })
                .finally(() => {
                    alert.unsetAlert();
                });
        },
        setAuthToken(token: string): void {
            localStorage.token = token;
        },
        verifyUser() {
            !localStorage.token ? this.$router.push("/login") : this.loadUser();
        },
    },
});
