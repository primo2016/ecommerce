<script setup lang="ts">
import { useOrderStore } from '@/composables/useOrder';
import { useProductStore } from '@/composables/useProducts';
import { CalculatorResponse, ProductResponse } from '@/interfaces/ecommerce-interface';
import { onMounted, ref, toRefs } from 'vue';

interface Emits {
  (e: 'onClose'): void;
  (e: 'onConfirmCart'): void;
}

interface Props {
    isOpen: boolean;
}

const emits = defineEmits<Emits>();

const props = defineProps<Props>();
const { isOpen: dialogActive } = toRefs(props);

const productStore = useProductStore();
const { productsCart, removeFromCart, clearAllFromCart } = productStore;

const orderStore = useOrderStore();
const { calculateFinalPrice } = orderStore;

const displayDetalis = ref<boolean>(false);
const discountCode = ref<string>();
const resultCalculator = ref<CalculatorResponse | null>();

onMounted(() => {
  resultCalculator.value = null;
  displayDetalis.value = false;
});

const onCloseModal = () => {
    emits('onClose');
};

const confirmCart = () => {
  clearAllFromCart();
  resultCalculator.value = null;
  emits('onConfirmCart');
};

const deleteProduct = (product: ProductResponse) => {
  removeFromCart(product);
};

const priceCalculator = async() => {
  const selectedProducts: number[] = productsCart.value.map((m) => Number(m.id));
  resultCalculator.value = await calculateFinalPrice(selectedProducts, discountCode.value);

  displayDetalis.value = true;
};



const discountCalculator = (product: ProductResponse) => (product.amount - product.amount * product.discountToApply / 100).toFixed(2);

</script>

<template>
    <v-dialog
      transition="dialog-top-transition"
      v-model="dialogActive"
      width="600"
      persistent
    >
      <v-card
        width="600"
        class="mx-auto"
        prepend-icon="mdi-cart-outline"
        title="Mis productos"
      >
      <div v-if="!!productsCart.length">
        <v-list lines="three">
          <v-list-subheader inset>Productos agregados al carrito</v-list-subheader>

          <v-list-item
            v-for="(product, i) in productsCart"
            :key="i"
            :title="product.name"
            :subtitle="`$ ${product.amount}`"
          >
            <template v-slot:prepend>
              <v-avatar color="grey-lighten-1">
                <v-icon color="white">mdi-wallet-giftcard</v-icon>
              </v-avatar>
            </template>
            <v-chip density="compact" v-if="!!product.discountToApply">
              %{{product.discountToApply}} Off - $ {{ discountCalculator(product) }}
            </v-chip>
            <template v-slot:append>
              <v-btn @click="deleteProduct(product)"
                color="grey-lighten-1"
                icon="mdi-delete"
                variant="text"
              ></v-btn>
            </template>
          </v-list-item>
        </v-list>

        <v-divider inset></v-divider>

        <v-form @submit.prevent="priceCalculator">
          <v-container>
            <v-row>
              <v-col
                cols="12"
                md="6"
              >
                <v-text-field
                  density="compact"
                  v-model="discountCode"
                  label="Código de descuento"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                md="6"
              >
                <v-btn type="submit" block>Calcular Precio Final</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-form>

        <v-list lines="two" v-if="displayDetalis">
          <v-list-subheader inset>Detalles costo final</v-list-subheader>

          <v-list-item
            :title="resultCalculator?.subtotal.toFixed(2)"
            subtitle="SUBTOTAL"
          />
          <v-list-item
          :title="resultCalculator?.totalDiscountApplied.toFixed(2)"
          subtitle="DESCUENTOS APLICADOS"
          />
          <v-list-item v-if="resultCalculator?.totalAdditionalDiscountApplied"
          :title="resultCalculator?.totalAdditionalDiscountApplied.toFixed(2)"
          subtitle="DESCUENTO ADICIONAL"
          />
          <v-list-item
            :title="resultCalculator?.total.toFixed(2)"
            subtitle="TOTAL"
          />
        </v-list>
      </div>
      <v-list lines="two" v-else>
        <v-list-item
          title="No hay productos agregados al carrito."
          subtitle="Carrito sin productos."
        >
        </v-list-item>
      </v-list>

        <template v-slot:actions>
          <v-spacer></v-spacer>

          <v-btn @click="onCloseModal">
            Cancelar
          </v-btn>

          <v-btn :disabled="!productsCart.length || !displayDetalis" class="bg-primary" @click="confirmCart">
            Confirmar
          </v-btn>
        </template>
      </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
