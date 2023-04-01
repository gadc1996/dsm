import router from "@/router";
import { markRaw } from "vue";
import { createPinia } from "pinia";
import axios from "axios";

const pinia = createPinia();
const baseURL =
    process.env.NODE_ENV === "development"
        ? "http://127.0.0.1:8000/api"
        : "https://admin.pilatescourt.com.mx/api";

pinia.use(({ store }) => {
    store.$router = markRaw(router);
    store.$axios = markRaw(
        axios.create({
            baseURL,
        })
    );
});

export default pinia;
