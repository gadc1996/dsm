import { defineStore } from "pinia";

type AlertType = "error" | "success" | "warning" | "info" | undefined;

interface AlertState {
    type: AlertType;
    message: string | undefined;
    isVisible: boolean;
}

export const useAlertStore = defineStore<string, AlertState>({
    id: "alert",
    state: () => ({
        type: undefined,
        message: undefined,
        isVisible: false,
    }),
    getters: {},
    actions: {
        setAlert(type: AlertType, message: string) {
            this.$state = {
                type,
                message,
                isVisible: true,
            };
            this.unsetAlert();
        },
        unsetAlert() {
            setTimeout(() => {
                this.$state = {
                    type: "",
                    message: "",
                    isVisible: false,
                };
            }, 2000);
        },
    },
});
