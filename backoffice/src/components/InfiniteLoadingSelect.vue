<script setup lang="ts">
import { computed, ref } from "vue";
const props = defineProps([
    "items",
    "itemsText",
    "itemsValue",
    "modelValue",
    "pagination",
]);

const emit = defineEmits(["update:modelValue", "infinite"]);

const value = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

const callback = (e) => {
    if (e[0].isIntersecting) emit("infinite");
};

const observer = new IntersectionObserver(callback);

let open = ref(false);

function toggleOptions() {
    open.value = !open.value;
    if (open.value) {
        document
            .querySelectorAll(".infinite-loader")
            .forEach((el) => observer.observe(el));
    }
}
const selectedText = computed(() => {
    const selected = props.items.find(
        (el) => props.modelValue == el[props.itemsValue]
    );
    return selected ? selected[props.itemsText] : "Select an option...";
});

const allElementsAreLoaded = computed(() => {
    return props.pagination.current_page >= props.pagination.last_page;
});
</script>

<template lang="pug">
.infinite-loading-select(
    @click="toggleOptions"
    :class="{open: open}"
)
    .arrow &#9660;
    .selected {{ selectedText }}
    .options 
        .option(
            v-for="item in items"
            @click="value = item[itemsValue]"
        ) {{ item[itemsText] }}
        .infinite-loader
            svg.spinner(
                viewbox='0 0 50 50'
                v-if="!allElementsAreLoaded"
            )
                circle.path(cx='25' cy='25' r='20' fill='none' stroke-width='5')
</template>

<style lang="scss">
@keyframes rotate {
    100% {
        transform: rotate(360deg);
    }
}

@keyframes dash {
    0% {
        stroke-dasharray: 1, 150;
        stroke-dashoffset: 0;
    }
    50% {
        stroke-dasharray: 90, 150;
        stroke-dashoffset: -35;
    }
    100% {
        stroke-dasharray: 90, 150;
        stroke-dashoffset: -124;
    }
}

.infinite-loading-select {
    position: relative;
    display: block;
    margin: 0.5rem auto;
    width: 100%;
    background: #f5f5f5;
    height: 3rem;
    border-radius: 3px;
    font-size: 12px;
    box-shadow: 0px 1em 1em -1.5em rgba(0, 0, 0, 0.5);
    border-bottom: 1px solid rgba(0, 0, 0, 0.3);
    &::after {
        position: absolute;
        left: 50%;
        content: "";
        height: 2px;
        background: black;
        transition: all 0.3s linear;
        width: 0;
        bottom: -1px;
        border-radius: 20%;
    }
    &:hover {
        cursor: pointer;
    }
    .arrow {
        transition: all 0.3s linear;
        position: absolute;
        display: flex;
        align-items: center;
        top: 0;
        bottom: 0;
        right: 1rem;
        margin: 0 auto;
        width: auto;
    }
    .selected {
        position: absolute;
        bottom: 0;
        top: 0;
        left: 3%;
        display: flex;
        align-items: center;
        font-size: 1rem;
    }
    .options {
        background: #e2e2e2;
        position: absolute;
        top: 100%;
        width: 100%;
        height: 0;
        overflow: scroll;
        border-radius: 0 0 2% 2%;
        transition: all 0.2s linear;
        z-index: 1;
        .option {
            margin-top: 0.5rem;
            font-size: 1rem;
            padding: 0.5rem;
            text-transform: capitalize;
            font-weight: 500;
            &:hover {
                cursor: pointer;
                background: #f5f5f5;
            }
        }

        .infinite-loader {
            display: flex;
            justify-content: center;
            .spinner {
                animation: rotate 2s linear infinite;
                width: 50px;
                height: 50px;
                margin: 1rem auto;
                & .path {
                    stroke: gray;
                    stroke-linecap: round;
                    animation: dash 1.5s ease-in-out infinite;
                }
            }
        }
    }
}

.open {
    background: #e2e2e2;
    .arrow {
        transform: rotate(-180deg);
    }
    &::after {
        width: 100%;
        margin-left: -50%;
    }
    .options {
        height: 250px;
    }
}
</style>
