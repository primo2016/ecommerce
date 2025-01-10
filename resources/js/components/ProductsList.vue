<script setup lang="ts">
import { useProductStore } from '@/composables/useProducts';
import { ProductResponse } from '@/interfaces/ecommerce-interface';
import { onMounted, ref } from 'vue';


const productStore = useProductStore();

const { isLoading, getProducts, storeToCart, existInCart } = productStore;

const products = ref<ProductResponse[]>();
const alertMessage = ref<string>();
const alertVisible = ref<boolean>(false);

onMounted(async() => {
  products.value = await getProducts();
});

const addToCart = (product: ProductResponse) => {
  if(existInCart(product)) {
    showAlert('El producto ya fue agregado al carrito.');
  } else {
    storeToCart(product);
  }
  console.log('addToCart');

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
   <v-row dense>
    <v-col
      v-for="(product, i) in products"
      :key="i"
      cols="3"
    >
      <v-card
          :loading="false"
          class="mx-auto my-5"
          max-width="374"
      >
        <template v-slot:loader="{ isActive }">
            <v-progress-linear
                :active="isActive"
                color="deep-purple"
                height="4"
                indeterminate
            ></v-progress-linear>
        </template>

        <v-card-item>
            <v-card-title> {{ product.name }}</v-card-title>

            <v-card-subtitle>
                <v-chip density="compact" v-for="category in product.categories">
                  {{ category.name }}
                </v-chip>
            </v-card-subtitle>
        </v-card-item>

        <v-card-text>
            <div class="my-4 text-subtitle-1">
                $ {{ product.amount }}
            </div>

            <div>{{ product.description }}</div>
        </v-card-text>

        <v-divider class="mx-4 mb-1"></v-divider>

        <v-card-actions>
            <v-btn
                color="primary"
                text="Agregar al Carrito"
                block
                border
                @click="addToCart(product)"
            ></v-btn>
        </v-card-actions>
      </v-card>
  </v-col>
</v-row>
<v-bottom-sheet v-model:model-value="alertVisible" inset>
  <v-card color="red-lighten-2" title="Advertencia" :text="alertMessage" />
</v-bottom-sheet>
</template>

<style scoped>

</style>
