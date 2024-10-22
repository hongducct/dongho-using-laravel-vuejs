<template>
  <TheHeader />
  <div class="max-w-md mx-auto mt-8 mb-10">
    <a-form
      :model="formState"
      name="basic"
      autocomplete="off"
      @finish="onFinish"
      @finishFailed="onFinishFailed"
      class="bg-white shadow rounded px-8 pt-6 pb-8 mb-4"
    >
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="username">
          Username
        </label>
        <a-input
          v-model:value="formState.username"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        />
        <p v-if="errors.username" class="text-red-500 text-xs italic">
          {{ errors.username }}
        </p>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="name"
          >Name</label
        >
        <input
          v-model="formState.name"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="name"
          type="text"
        />
        <p v-if="errors.name" class="text-red-500 text-xs italic">
          {{ errors.name }}
        </p>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="email"
          >Email</label
        >
        <input
          v-model="formState.email"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="email"
          type="email"
        />
        <p v-if="errors.email" class="text-red-500 text-xs italic">
          {{ errors.email }}
        </p>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="password"
          >Password</label
        >
        <a-input-password
          v-model:value="formState.password"
          required=""
          id="password"
          placeholder="Nhập mật khẩu"
          class="border flex block w-full rounded-md py-1.5 p-2 text-gray-900 shadow ring-1 ring-inset ring-gray-300 placeholder:text-white focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
        />
        <p v-if="errors.password" class="text-red-500 text-xs italic">
          {{ errors.password }}
        </p>
      </div>
      <!-- Upload Image -->
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="avatar">
          Avatar
        </label>
        <div class="border-2 bg-yellow-50 p-2 border-dashed rounded shadow">
          <a-upload-dragger
            name="file"
            :progress="progress"
            :multiple="false"
            :action="`${apiUrl}/upload-images`"
            @change="handleChange"
            list-type="picture"
          >
            <p class="ant-upload-drag-icon">
              <InboxOutlined />
            </p>
            <p class="ant-upload-text">
              Click or drag file to this area to upload
            </p>
            <p class="ant-upload-hint">
              Support for a single or bulk upload. Strictly prohibit from
              uploading company data or other band files
            </p>
          </a-upload-dragger>
        </div>
      </div>
      <!-- Add this new form item -->
      <a-form-item name="image">
        <input type="hidden" v-model="formState.image" />
      </a-form-item>
      <div class="flex items-center justify-between">
        <a-checkbox
          v-model:checked="formState.remember"
          class="text-gray-700 font-bold"
        >
          Remember me
        </a-checkbox>
        <a-button
          type="primary"
          html-type="submit"
          class="bg-blue-500 flex items-center hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        >
          Submit
        </a-button>
      </div>
    </a-form>
  </div>
</template>

<script setup>
import { reactive, inject, ref } from "vue";
import { InboxOutlined } from "@ant-design/icons-vue";
import TheHeader from "@/components/TheHeader.vue";
import { message } from "ant-design-vue";
import axios from "axios"; // Import axios

const apiUrl = inject("apiUrl");
const formState = reactive({
  username: "",
  name: "",
  email: "",
  password: "",
  image: "", // Add this line
  remember: true,
});

const handleChange = (info) => {
  const status = info.file.status;
  if (status === "done") {
    message.success(`${info.file.name} file added successfully.`);
    if (errors.value.images) {
      delete errors.value.images;
    }
    formState.image = info.file.originFileObj; // Assign the file object
  } else if (status === "error") {
    message.error(`${info.file.name} file failed to add.`);
  }
};

const progress = {
  strokeColor: {
    "0%": "#108ee9",
    "100%": "#87d068",
  },
  strokeWidth: 3,
  format: (percent) => `${parseFloat(percent.toFixed(2))}%`,
  class: "test",
};

const errors = ref([]);
const registerUser = async () => {
  try {
    const formData = new FormData();
    formData.append("username", formState.username);
    formData.append("name", formState.name);
    formData.append("email", formState.email);
    formData.append("password", formState.password);
    formData.append("avatar", formState.image);

    console.log("formData:", formData.value);
    axios
      .post(`${apiUrl}/register`, formData)
      .then((response) => {
        console.log("Registration successful:", response.data);

        message.success(response.data.message);
        window.location.href = "/signin"; // Điều hướng về trang đăng nhập
      })
      .catch((error) => {
        console.log("error: ", error);
        errors.value = error.response.data.error;
        if (error.response) {
          console.log(error.response.data.errors); // Hiển thị lỗi từ server
        } else if (error.request) {
          console.error("Request error:", error.request);
        } else {
          console.error("Request setup error:", error.message);
        }
      });

    // Xử lý phản hồi từ máy chủ tại đây
  } catch (error) {
    error.value = error.response.data.errors;
    console.error("Registration failed:", error.response.data);
    // Xử lý lỗi tại đây
  }
};

const onFinish = async (values) => {
  console.log("Success:", values);
  console.log("image:", formState.image);

  await registerUser();
};

const onFinishFailed = (errorInfo) => {
  console.log("Failed:", errorInfo);
};
</script>
