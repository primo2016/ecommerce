import { ProductResponse } from "@/interfaces/ecommerce-interface";
import { defineStore } from "pinia";
import { ref } from "vue";

export const definedProductStore = defineStore('products', () => {
	const uriService = '/core/v1/products';
	const productsCart = ref<ProductResponse[]>([]);
	const isLoading = ref<boolean>(false);
	const errorMessage = ref('');

    const storeToCart = (product: ProductResponse) => {
      productsCart.value?.push(product);
    };

    const existInCart = (product: ProductResponse) => {
      return (productsCart.value.findIndex((p) => p.id === product.id) >= 0);
    };

    const removeFromCart = (product: ProductResponse) => {
      const index = productsCart.value.findIndex((p) => p.id === product.id);
      productsCart.value.splice(index, 1);
    };

    const clearAllFromCart = () => {
      productsCart.value = [];
    };

	return {
      // state
      isLoading,
      uriService,
      productsCart,
      errorMessage,
      //getters
      //actions
      storeToCart,
      existInCart,
      removeFromCart,
      clearAllFromCart
	}
});
