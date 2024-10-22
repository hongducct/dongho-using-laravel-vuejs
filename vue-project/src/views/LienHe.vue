<template>
  <TheHeader />
  <!-- breadcrumb -->
  <div
    class="breadcrumb-section"
    style="background-color: #f8f8f8; padding: 20px 0"
  >
    <div class="container">
      <div class="row items-center">
        <div class="col-sm-6">
          <div class="page-title"><h2>Liên Hệ</h2></div>
        </div>
        <div class="col-sm-6 content-center">
          <a-breadcrumb class="flex justify-end">
            <a-breadcrumb-item @click="navigateTo('/')">
              <HomeOutlined />
              <span>TRANG CHỦ</span>
            </a-breadcrumb-item>
            <a-breadcrumb-item>LIÊN HỆ</a-breadcrumb-item>
          </a-breadcrumb>
        </div>
      </div>
    </div>
  </div>

  <div class="isolate px-6 py-24 sm:py-32 lg:px-8 flex justify-evenly bg-zinc-200">
    <div>
      <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          Liên hệ
        </h2>
      </div>
      <form @submit.prevent="handleSubmit" class="mx-auto mt-16 max-w-xl sm:mt-20">
        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
          <div class="sm:col-span-2 w-96">
            <label
              for="first-name"
              class="block text-sm font-semibold leading-6 text-gray-900"
              >Họ và tên</label
            >
            <div class="mt-2.5">
              <input
                v-model="form.firstName"
                type="text"
                name="first-name"
                id="first-name"
                autocomplete="given-name"
                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
          </div>

          <div class="sm:col-span-2">
            <label
              for="email"
              class="block text-sm font-semibold leading-6 text-gray-900"
              >Email</label
            >
            <div class="mt-2.5">
              <input
                v-model="form.email"
                type="email"
                name="email"
                id="email"
                autocomplete="email"
                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
          </div>
          <div class="sm:col-span-2">
            <label
              for="phone-number"
              class="block text-sm font-semibold leading-6 text-gray-900"
              >Số điện thoại</label
            >
            <div
              class="relative mt-2.5 absolute inset-y-0 left-0 flex items-center"
            >
              <input
                v-model="form.phoneNumber"
                type="tel"
                name="phone-number"
                id="phone-number"
                autocomplete="tel"
                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
          </div>
          <div class="sm:col-span-2">
            <label
              for="message"
              class="block text-sm font-semibold leading-6 text-gray-900"
              >Nội dung</label
            >
            <div class="mt-2.5">
              <textarea
                v-model="form.message"
                name="message"
                id="message"
                rows="4"
                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
          </div>
        </div>
        <div class="mt-10">
          <button
            type="submit"
            class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            Gửi thông tin
          </button>
        </div>
      </form>
    </div>

    <div>
      <div class="mt-10">
        <h3 class="text-2xl font-semibold leading-6 text-gray-900 mb-4">Liên hệ trực tiếp qua:</h3>
        <span>SDT - ZALO: <b>079.9076.901</b></span> <br>
        <span>Email: <b>hongducct23@gmail.com</b></span>
      </div>  
    </div>
  </div>

  <!-- <section class="py-20 section-b-space user-dashboard-section">
  
      </section> -->
</template>

<script setup>
import { useRouter } from "vue-router";
import { ref, reactive, inject } from "vue";
import { HomeOutlined } from "@ant-design/icons-vue";
import router from "@/router";
import TheHeader from "@/components/TheHeader.vue";
import { message } from "ant-design-vue";

const form = reactive({
  firstName: '',
  email: '',
  phoneNumber: '',
  message: ''
});

const navigateTo = (value) => {
  router.push(value);
};

const apiUrl = inject("apiUrl");

console.log(`${apiUrl}/contact`);

const handleSubmit = async () => {
  try {
    const response = await fetch(`${apiUrl}/contact`, {
    // const response = await fetch('http://your-laravel-api-url/api/contact', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        first_name: form.firstName,
        email: form.email,
        phone_number: form.phoneNumber,
        message: form.message
      }),
    });

    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const result = await response.json();
    console.log('Success:', result);
    message.success(result.message);
    form.firstName = '';
    form.email = '';
    form.phoneNumber = '';
    form.message = '';
    
    // alert('Thông tin của bạn đã được gửi thành công!');
    
  } catch (error) {
    console.error('There was a problem with your fetch operation:', error);
    alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
  }
};
</script>
