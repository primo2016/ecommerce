import axiosInstance from "@/api/axiosInstance"
import { definedProductStore } from "@/store/productStore";
import { storeToRefs } from "pinia";

export const useProductStore = () => {

    const productStore = definedProductStore();

    const { isLoading, productsCart } = storeToRefs(productStore);

    const getProducts = async() => {
        isLoading.value = true
        try
        {
            const { data: response } = await axiosInstance.get(`${productStore.uriService}`);

            if(response) {
                return response.data || [];
            }
        } catch (error) {
            throw new Error(`Error al obtener la lista de productos - Exception: ${error}`);
        } finally {
            isLoading.value = false;
        }
    };

    return {
        isLoading,
        getProducts,
        productsCart,
        storeToCart: productStore.storeToCart,
        removeFromCart: productStore.removeFromCart,
        existInCart: productStore.existInCart,
        clearAllFromCart: productStore.clearAllFromCart,
    }
}

