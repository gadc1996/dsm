import type { AxiosResponse } from "axios";
import type CrudState from "@/interfaces/crud-state";
import type { ModalType } from "@/types/modal-type"
import { useAlertStore } from "../stores/alert";
import { useAuthStore } from "../stores/auth";

const alert = useAlertStore();
const auth = useAuthStore();

export default class {
    state: CrudState;
    actions: object;

    constructor(module: string) {
        this.state = {
            resources: [],
            isModalVisible: false,
            defaultSelectedResource: {},
            selectedResource: {},
            modalType: undefined,
            selectedResourceIndex: -1,
            isLoading: false,
            lastPage: 1,
        };

        this.actions = {
            setHeaders() {
                this.$axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${localStorage.token}`;
            },
            async loadResources(page = 1): Promise<void> {
                this.setHeaders();
                await this.$axios
                    .get(`${module}?page=${page}`)
                    .then((response: AxiosResponse) => {
                        this.$state.resources = response.data.data;
                        this.$state.pagination = response.data.current_page;
                        this.$state.lastPage = response.data.last_page;
                    })
                    .catch(() => {
                        alert.setAlert("error", "Error, intenta de nuevo");
                    });
            },
            async addResource(): Promise<void> {
                await this.$axios
                    .post(`${module}`, this.$state.selectedResource)
                    .then((response: AxiosResponse) => {
                        this.$state.resources.unshift(response.data);
                        this.closeModal();
                        alert.setAlert("success", "Creado correctamente");
                    })
                    .catch(() => {
                        alert.setAlert("error", "Error, intenta de nuevo");
                    });
            },
            async updateResource(): Promise<void> {
                await this.$axios
                    .put(
                        `${module}/${this.$state.selectedResource.id}`,
                        this.$state.selectedResource
                    )
                    .then((response: AxiosResponse) => {
                        this.$state.resources[
                            this.$state.selectedResourceIndex
                        ] = response.data;
                        this.closeModal();
                        alert.setAlert("success", "Creado correctamente");
                    })
                    .catch(() => {
                        alert.setAlert("error", "Error, intenta de nuevo");
                    });
            },
            async deleteResource(): Promise<void> {
                await this.$axios
                    .delete(`${module}/${this.$state.selectedResource.id}`)
                    .then(() => {
                        this.$state.resources.splice(
                            this.$state.selectedResourceIndex,
                            1
                        );
                        this.closeModal();
                        alert.setAlert("success", "Eliminado correctamente");
                    })
                    .catch(() => {
                        alert.setAlert("error", "Error, intenta de nuevo");
                    });
            },
            closeModal(): void {
                this.$state = {
                    isModalVisible: false,
                    modalType: undefined,
                    selectedResource: {
                        ...this.$state.defaultSelectedResource,
                    },
                    selectedResourceIndex: -1,
                };
            },
            openModal(index: number, type: ModalType): void {
                this.$state = {
                    modalType: type,
                    isModalVisible: true,
                    selectedResource:
                        type === "add"
                            ? this.$state.defaultSelectedResource
                            : this.$state.resources[index],
                    selectedResourceIndex: index,
                };
            },
            async submit(): Promise<void> {
                const functionMapper = {
                    add: this.addResource,
                    update: this.updateResource,
                    delete: this.deleteResource,
                };
                functionMapper[this.$state.modalType]();
            },
        };
    }
}
