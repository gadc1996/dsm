import Crud from "@/composables/crud";
import { defineStore } from "pinia";
import type { AxiosResponse } from "axios";

const crud = new Crud("users");

export const useUserStore = defineStore({
    id: "user",
    state: () => ({
        ...crud.state,
        roles: {
            data: [],
            pagination: {
                current_page: 0,
                last_page: 1,
            },
        },
    }),
    getters: {},
    actions: {
        ...crud.actions,
        async loadRoles(): Promise<void> {
            await this.$axios
                .get(
                    `roles?page=${
                        this.$state.roles.pagination.current_page + 1
                    }`
                )
                .then((response: AxiosResponse) => {
                    this.$state.roles = {
                        data: this.$state.roles.data.concat(response.data.data),
                        pagination: {
                            current_page: response.data.current_page,
                            last_page: response.data.last_page,
                        },
                    };
                })
                .catch(() => {
                    alert.setAlert("error", "Error, intenta de nuevo");
                });
        },
        async initialize() {
            await this.loadResources();
            // await this.loadRoles();
        },
    },
});
