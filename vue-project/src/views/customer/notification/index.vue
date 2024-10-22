<template>
    <h1 class="text-xl font-bold mt-4">Thông báo của tôi</h1>
    <div class="flex flex-col bg-white w-11/12 rounded-lg shadow-lg relative mt-4">
      <header class="px-4 py-2 flex items-center border-b-2">
        <div class="flex space-x-7">
          <router-link to="/" class="text-gray-500 hover:text-gray-700">
            <HomeIcon class="w-6 h-6" />
          </router-link>
          <router-link to="/calendar" class="text-gray-500 hover:text-gray-700">
            <CalendarIcon class="w-6 h-6" />
          </router-link>
          <router-link to="/documents" class="text-gray-500 hover:text-gray-700">
            <DocumentTextIcon class="w-6 h-6" />
          </router-link>
          <router-link to="/settings" class="text-gray-500 hover:text-gray-700">
            <CogIcon class="w-6 h-6" />
          </router-link>
        </div>
        <div class="flex-grow"></div>
        <a
          href="#"
          @click.prevent="showOptions = !showOptions"
          class="text-blue-500 hover:text-blue-700 relative"
        >
          <EllipsisVerticalIcon class="h-6 w-6 text-gray-500" />
          <div
            v-if="showOptions"
            @click.away="showOptions = false"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10"
          >
            <p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              Đánh dấu đọc tất cả
            </p>
            <p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              Xóa tất cả thông báo
            </p>
          </div>
        </a>
      </header>
  
      <main class="flex flex-col items-center justify-center flex-grow px-4 py-28">
        <div class="flex items-center" >
          <BellIcon class="w-32 h-32"/>
        </div>
        <h1 class="text-2xl font-bold mt-4 mb-2">
          Bạn chưa có thông báo
        </h1>
        <button
          class="bg-yellow-400 hover:bg-yellow-600  font-bold py-2 px-4 rounded mt-4"
        >
        <router-link to="/" class="text-white no-underline">
            Tiếp tục mua sắm
        </router-link>
        </button>
      </main>
    </div>
  </template>
  
  <script setup>
  import { ref } from "vue";
  import {
    EllipsisVerticalIcon,
    HomeIcon,
    CalendarIcon,
    DocumentTextIcon,
    CogIcon,
    BellIcon,
  } from "@heroicons/vue/24/solid";
  
  const showOptions = ref(false);
  </script>
  