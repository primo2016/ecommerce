<script setup lang="ts">
import AppBar from '@/components/AppBar.vue';
import ProductsList from '@/components/ProductsList.vue';

</script>

<template>
  <v-layout class="rounded rounded-md">
    <AppBar></AppBar>
    <v-main>
			<v-container fluid>
				<ProductsList></ProductsList>
			</v-container>
    </v-main>
  </v-layout>
</template>

<style scoped>

</style>
