<template>
  <h2>Thông tin tài khoản</h2>
  <div class="mr-12">
    <div class="flex bg-white rounded-lg">
      <div class="p-4 w-6/12">
        <span class="text-base">Thông tin cá nhân</span>
        <div class="mt-4">
          <form @submit.prevent="updateUser">
            <div class="flex">
              <div class="mr-4">
                <div
                  class="border-4 flex items-center rounded-full w-28 h-28 bg-sky-100 relative justify-center"
                >
                  <div class="">
                    <div class="flex items-center cursor-pointer">
                      <img
                        :src="userImageUrl"
                        alt="avatar"
                        class="w-28 h-28 rounded-full object-cover"
                        @click="changeAvatar"
                      />
                      <div
                        class="absolute flex w-4 h-4 rounded-full justify-center items-center"
                        style="
                          background-color: rgb(100, 100, 109);
                          right: 3px;
                          bottom: 5px;
                        "
                      >
                        <img
                          src="https://frontend.tikicdn.com/_desktop-next/static/img/account/edit.png"
                          class="w-3 h-3"
                          alt="edit icon"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="w-full flex justify-between flex-col">
                <div class="mb-4 flex items-center">
                  <label class="mr-4 w-24">Họ &amp; Tên</label>
                  <div class="flex">
                    <div class="">
                      <input
                        class="input rounded border-2 p-2"
                        type="search"
                        name="fullName"
                        maxlength="128"
                        placeholder="Thêm họ tên"
                        v-model="admin.name"
                      />
                    </div>
                  </div>
                </div>
                <div class="mb-4 flex items-center">
                  <label class="mr-4 w-24">Nickname</label>
                  <div>
                    <div class="">
                      <input
                        class="input rounded border-2 p-2"
                        name="userName"
                        maxlength="128"
                        placeholder="Thêm nickname"
                        type="search"
                        v-model="admin.username"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-4 flex items-center">
              <label class="mr-4 w-28">&nbsp;</label>
              <button
                type="submit"
                class="w-44 h-10 rounded border-2 bg-blue-500 text-white"
              >
                Lưu thay đổi
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="border-x my-4"></div>
      <div class="flex flex-col p-4 space-y-4 w-full">
        <span class="font-bold text-lg">Email</span>
        <div class="space-y-4">
          <div class="py-3 flex items-center justify-between border-y">
            <div class="flex items-center space-x-4">
              <img
                src="https://frontend.tikicdn.com/_desktop-next/static/img/account/email.png"
                class="w-6 h-6"
                alt="Email icon"
              />
              <div class="flex flex-col">
                <span class="font-medium">Địa chỉ email</span>
                <span>{{ admin.email }}</span>
              </div>
            </div>
            <button
              class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
              @click="changeEmail"
            >
              Cập nhật
            </button>
          </div>
        </div>

        <span class="font-bold text-lg">Bảo mật</span>
        <div class="space-y-4">
          <div class="py-3 flex items-center justify-between border-y">
            <div class="flex items-center space-x-4">
              <img
                src="https://frontend.tikicdn.com/_desktop-next/static/img/account/lock.png"
                class="w-6 h-6"
                alt="Lock icon"
              />
              <span class="font-medium">Đổi mật khẩu</span>
            </div>
            <button
              class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
              @click="changePassword"
            >
              Cập nhật
            </button>
          </div>
        </div>
        <EmailModal
          v-model:showEmailModal="showEmailModal"
          @updateEmail="handleUpdateEmail"
        />
        <PasswordModal
          v-model:showPasswordModal="showPasswordModal"
          @updatePassword="handleUpdatePassword"
        />
        <span class="font-bold text-lg">Liên kết mạng xã hội</span>
        <div class="space-y-4">
          <div class="py-3 flex items-center justify-between border-y">
            <div class="flex items-center space-x-4">
              <img
                src="https://frontend.tikicdn.com/_desktop-next/static/img/account/facebook.png"
                class="w-6 h-6"
                alt="Facebook icon"
              />
              <span class="font-medium">Facebook</span>
            </div>
            <button
              class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
            >
              Liên kết
            </button>
          </div>
          <div class="py-3 flex items-center justify-between border-y">
            <div class="flex items-center space-x-4">
              <img
                src="https://frontend.tikicdn.com/_desktop-next/static/img/account/google.png"
                class="w-6 h-6"
                alt="Google icon"
              />
              <span class="font-medium">Google</span>
            </div>
            <button
              class="bg-green-500 text-white px-4 py-2 rounded-md cursor-not-allowed"
            >
              Đã liên kết
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, inject, watch, computed } from "vue";

import EmailModal from "./EmailModal.vue";
import PasswordModal from './PasswordModal.vue';

const showEmailModal = ref(false);
const showPasswordModal = ref(false);

const changeEmail = () => {
  showEmailModal.value = true;
};

const handleUpdateEmail = async (newEmail) => {
  try {
    // Gọi API để cập nhật email ở đây
    const response = await axios.put(`${apiUrl}/admin/${admin.value.id}`, {
      email: newEmail,
    });

    // Cập nhật email của admin
    admin.value.email = newEmail;
  } catch (error) {
    console.error(error);
  }
};

const changePassword = () => {
  showPasswordModal.value = true;
};

const handleUpdatePassword = async ({ oldPassword, newPassword }) => {
  try {
    // Gọi API để cập nhật mật khẩu ở đây
    const response = await axios.put(`${apiUrl}/admin/${admin.value.id}`, {
      oldPassword,
      newPassword,
    });

    // Xử lý phản hồi từ API
    console.log(response.data);
  } catch (error) {
    console.error(error);
  }
};

const apiUrl = inject("apiUrl");
const baseURL = "http://192.168.23.1:8000/storage/";

// Khai báo user là một reactive object
// const user = ref(JSON.parse(localStorage.getItem("user")));

// Khai báo admin là một reactive object
const admin = ref(JSON.parse(localStorage.getItem("admin")));

// Computed property để lấy đường dẫn ảnh đại diện
const userImageUrl = computed(() => {
  return admin.value.avatar ? `${baseURL}${admin.value.avatar}` : "";
});

// Watch sự thay đổi của admin để lưu vào localStorage
watch(
  admin,
  (newValue) => {
    localStorage.setItem("admin", JSON.stringify(newValue));
  },
  { deep: true }
);

const changeAvatar = async () => {
  try {
    const file = await openImageFileDialog();

    if (file) {
      const formData = new FormData();
      formData.append("avatar", file);

      const responseUpload = await axios.post(
        `${apiUrl}/upload-avatar`,
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );

      const updatedUserResponse = await axios.put(
        `${apiUrl}/admin/${admin.value.id}`,
        {
          ...admin.value,
          avatar: responseUpload.data.imageUrl,
        }
      );

      // Cập nhật thuộc tính avatar của admin.value
      admin.value.avatar = updatedUserResponse.data.data.avatar;
    }
  } catch (error) {
    console.error("Lỗi khi thay đổi ảnh đại diện:", error);
  }
};

const openImageFileDialog = async () => {
  return new Promise((resolve, reject) => {
    const input = document.createElement("input");
    input.type = "file";
    input.accept = "image/*";
    input.addEventListener("change", () => {
      const file = input.files[0];
      resolve(file);
    });
    input.click();
  });
};

const updateUser = async () => {
  try {
    console.log('admin:', admin);
    const response = await axios.put(`${apiUrl}/admin/${admin.value.id}`, {
      name: admin.value.name,
      username: admin.value.username,
    });

    console.log(response.data.data);

    // Cập nhật các thuộc tính tương ứng của admin.value
    admin.value.name = response.data.data.name;
    admin.value.username = response.data.data.username;
    localStorage.setItem("admin", JSON.stringify(admin.value));
  } catch (error) {
    console.error(error);
  }
};
</script>