<template>
  <!-- Footer -->
  <footer class="bg-gray-900 text-white">
    <!-- Footer Top -->
    <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- About -->
        <div>
          <h3 class="text-lg font-semibold mb-4">About</h3>
          <p class="text-gray-400">
            This website is developed by hongducct using Vue.js and Laravel. It's
            designed to provide the best user experience with modern web
            technologies.
          </p>
        </div>
        <!-- Links -->
        <div class="pl-10">
          <h3 class="text-lg font-semibold mb-4">Useful Links</h3>
          <ul class="space-y-2 p-0">
            <li>
              <a href="#" class="text-gray-400 hover:text-white">Home</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white">About Us</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white">Services</a>
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-white">Contact</a>
            </li>
          </ul>
        </div>
        <!-- Contact -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Contact</h3>
          <ul class="space-y-2 text-gray-400 p-0">
            <li>
              <i class="fas fa-map-marker-alt mr-2"></i>Hanoi, Vietnam
            </li>
            <li>
              <i class="fas fa-envelope mr-2"></i>hongducct23@gmail.com
            </li>
            <li><i class="fas fa-phone mr-2"></i>+84 799 076 901</li>
            <li><i class="fas fa-print mr-2"></i>+84 388 424 835</li>
          </ul>
        </div>
        <!-- Newsletter -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
          <p class="text-gray-400 mb-4">
            Subscribe to our newsletter to receive the latest updates and offers.
          </p>
          <form>
            <div class="flex">
              <input
                type="email"
                class="form-input mr-2 block w-full rounded-md bg-gray-800 border-gray-700 text-white"
                placeholder="Enter your email"
              />
              <button
                type="submit"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-md"
              >
                Subscribe
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Footer Bottom -->
    <div class="bg-gray-800 py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <!-- Social Media -->
        <div class="flex space-x-4">
          <a
            href="https://www.facebook.com/hongducct23"
            target="_blank"
            class="text-gray-400 hover:text-white"
          >
            <i class="fab fa-facebook-f"></i>
          </a>
          <a
            href="https://www.instagram.com/hongducct"
            target="_blank"
            class="text-gray-400 hover:text-white"
          >
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-white">
            <i class="fab fa-linkedin"></i>
          </a>
          <a
            href="https://github.com/hongducct"
            target="_blank"
            class="text-gray-400 hover:text-white"
          >
            <i class="fab fa-github"></i>
          </a>
        </div>
        <!-- Copyright -->
        <p class="text-gray-400">
          &copy; 2024 Copyright:
          <a href="#" class="text-white hover:text-red-600">hongducct</a>
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from "vue";
</script>

<style scoped>
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css");
</style>