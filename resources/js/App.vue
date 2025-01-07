<template>
    <v-app>
        <v-main>
            <v-container>
                <v-btn color="primary">{{ title }}</v-btn>
            </v-container>  
        </v-main>
    </v-app>
</template>

<script setup lang="ts">
import { ref } from 'vue';


const title = ref<string>('Hello, Vuetify in Laravel with vue3');

</script>
