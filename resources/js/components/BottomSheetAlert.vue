<script setup lang="ts">
import { toRefs } from 'vue';


interface Props {
    alertVisible: boolean,
    alertMessage: string,
    color: string,
    title: string
}
const props = defineProps<Props>();
const { alertVisible, alertMessage } = toRefs(props);

</script>

<template>
    <v-bottom-sheet v-model:model-value="alertVisible" inset>
        <v-card :color="color" :title="title" :text="alertMessage" />
    </v-bottom-sheet>
</template>

<style scoped>

</style>
