import type { ModalType } from "@/types/modal-type"

export default interface CrudState {
    resources: Array<object>;
    isModalVisible: boolean;
    defaultSelectedResource: object;
    selectedResource: object;
    modalType: ModalType;
    selectedResourceIndex: number;
    isLoading: boolean;
    lastPage: number;
}
