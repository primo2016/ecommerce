import axiosInstance from "@/api/axiosInstance"
import { definedOrderStore } from "@/store/orderStore";
import { storeToRefs } from "pinia";

export const useOrderStore = () => {

    const orderStore = definedOrderStore();

    const { isLoading } = storeToRefs(orderStore);

    const calculateFinalPrice = async(selectedProducts: number[], discountCode?: string) => {
        isLoading.value = true
        try
        {
            const { data: response } = await axiosInstance.post(`${orderStore.uriService}`, { selectedProducts, discountCode });

            if(response) {
                return response.data || [];
            }
        } catch (error) {
            throw new Error(`Error al obtener precio final de la orden - Exception: ${error}`);
        } finally {
            isLoading.value = false;
        }
    };

    return {
        isLoading,
        calculateFinalPrice,
    }
}

