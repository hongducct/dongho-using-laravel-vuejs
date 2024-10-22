<template>
  <div id="app" class="bg-zinc-200">
    <!-- <TheHeader /> -->
    <main class="min-h-svh">
      <!-- Nội dung chính của trang -->
      <routerView />
    </main>
    <TheFooter />
  </div>
</template>

<script setup>

import { provide, ref, onMounted, onUnmounted } from 'vue'

import { useCart } from './views/useCart';

const { cart, addToCart, removeFromCart, clearCart, getTotalPrice } = useCart();

// Cung cấp cart cho các component con
provide('cart', cart);
provide('addToCart', addToCart);
provide('removeFromCart', removeFromCart);
provide('clearCart', clearCart);
provide('getTotalPrice', getTotalPrice);

// Table height state
const tableHeight = ref(0);

const calculateTableHeight = () => {
  tableHeight.value = window.innerHeight * 0.4;
};

onMounted(() => {
  calculateTableHeight();
  window.addEventListener('resize', calculateTableHeight);
});

onUnmounted(() => {
  window.removeEventListener('resize', calculateTableHeight);
});

// Provide table height to child components
provide('tableHeight', tableHeight);

import TheHeader from './components/TheHeader.vue';
import TheFooter from './components/TheFooter.vue';
</script>

<style scoped>
#app {
  font-family: Roboto, Helvetica, Arial, sans-serif;
}
</style>
