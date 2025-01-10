<script setup lang="ts">
import { ref, toRefs } from 'vue';
import DialogCart from './DialogCart.vue';
import { useProductStore } from '@/composables/useProducts';

const productStore = useProductStore();
const { productsCart } = productStore;

const dialogActive = ref<boolean>(false);
const alertMessage = ref<string>('');
const alertVisible = ref<boolean>(false);

const openCartModal = () => {
    dialogActive.value = true;
};

const closeCartModal = () => {
    dialogActive.value = false;
};

const confirmCart = () => {
    showAlert('Productos confirmados con éxito');
    closeCartModal();
};

const showAlert = (message: string) => {
  alertMessage.value = message;
  alertVisible.value = true;
  setTimeout(() => {
    alertVisible.value = false;
  }, 3000);
};
</script>

<template>
    <v-app-bar
        color="primary"
        density="compact">
        <template v-slot:prepend>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
        </template>

        <v-app-bar-title>Productos</v-app-bar-title>

        <template v-slot:append>
            <v-btn stacked @click="openCartModal">
                <v-badge color="error" :content="productsCart?.length">
                    <v-icon icon="mdi-cart-outline"></v-icon>
                </v-badge>
            </v-btn>
        </template>
    </v-app-bar>

    <DialogCart
        v-if="dialogActive"
        :is-open="dialogActive"
        @on-close="closeCartModal"
        @on-confirm-cart="confirmCart"></DialogCart>

    <v-bottom-sheet v-model:model-value="alertVisible" inset>
        <v-card color="green" title="Confimación" :text="alertMessage" />
    </v-bottom-sheet>
</template>

<style scoped>

</style>
