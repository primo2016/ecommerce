import { ref } from "vue";
import { defineStore } from "pinia";

export const definedOrderStore = defineStore('orders', () => {
	const uriService = '/core/v1/order';
	const isLoading = ref<boolean>(false);
	const errorMessage = ref('');
	return {
      // state
      isLoading,
      uriService,
      errorMessage,
      //getters
      //actions
	}
});
