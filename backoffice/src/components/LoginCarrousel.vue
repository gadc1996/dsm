<script setup lang="ts">
const items = [
    {
        src: "https://via.placeholder.com/550",
    },
    {
        src: "https://via.placeholder.com/550",
    },
    {
        src: "https://via.placeholder.com/550",
    },
    {
        src: "https://via.placeholder.com/550",
    },
    {
        src: "https://via.placeholder.com/550",
    },
];
</script>

<template lang="pug">
v-carousel.d-none.d-xl-block(
    cycle='' 
    :interval='4000' 
    height='100%' 
    hide-delimiters 
    :show-arrows='false' 
    )
  v-carousel-item(
      v-for='(item, index) in items' 
      :key='index' 
      :src='item.src'
    )
</template>
