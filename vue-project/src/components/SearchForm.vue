<template>
  <form class="py-3 px-4 flex items-center">
    <label class="sr-only">Search</label>
    <div class="bg-white p-1 rounded-6 shadow-md w-96 border-3 border-orange-200 flex items-center ">
        <MagnifyingGlassIcon class="h-6 w-6 text-gray-500" />
      <input
        type="text"
        @input="search"
        name="search"
        placeholder="Search"
        class="w-full px-2 py-1 border-none outline-none"
      />
    </div>
  </form>
</template>
<script setup>
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline";
 
const emit = defineEmits(["search"]);
const search = (e) => {
  // console.log(e.target.value)
  emit("search", e.target.value);
};
</script>
