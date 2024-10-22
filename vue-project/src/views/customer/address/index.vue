<template>
  <div class="bg-white p-6 rounded-lg shadow-md w-10/12">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-semibold">Sổ địa chỉ</h2>
      <button @click="addAddress" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
        + Thêm địa chỉ mới
      </button>
    </div>

    <ul>
      <li v-for="address in addresses" :key="address.id">
        <div class="flex justify-between py-4 px-10 mb-4 border border-gray-300 rounded-md">
          <div>
            <div class="flex items-center mb-2">
              <div class="bg-gray-200 rounded-full h-8 w-8 flex items-center justify-center mr-2">
                <i class="fas fa-map-marker-alt text-gray-500"></i>
              </div>
              <span class="font-semibold">{{ address.name }}</span>
            </div>
            <p class="text-sm mb-2">
              <span class="text-gray-400">Địa chỉ: </span>{{ address.address }},
              {{ address.ward }}, {{ address.district }},
              {{ address.province }}
            </p>
            <p class="text-sm">
              <span class="text-gray-400">Điện thoại: </span>
              {{ address.phone_number }}
            </p>
          </div>
          <div class="flex flex-col justify-center">
            <!-- Sửa address -->
            <a-button type="link" @click="showEditModal(address)" class="border m-1">Sửa</a-button>
            <!-- Xóa address -->
            <a-button type="link" danger @click="deleteAddress(address.id)" class="border m-1">Xóa</a-button>
          </div>
        </div>
      </li>
    </ul>
    <div v-if="showAddressModal">
      <AddressModal v-model:showAddressModal="showAddressModal" @createAddress="handleCreateAddress" />
    </div>
    <div v-if="showEditAddressModal">
      <EditAddressModal v-model:showEditModal="showEditAddressModal" :editingAddress="editingAddress"
        @updateAddress="handleUpdateAddress" />
    </div>
  </div>
</template>

<script setup>
import { inject, ref } from "vue";
import AddressModal from "./AddressModal.vue";
import EditAddressModal from "./EditAddressModal.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const user = JSON.parse(localStorage.getItem("user"));

const apiUrl = inject("apiUrl");
const addresses = ref([]);
const showAddressModal = ref(false);
const showEditAddressModal = ref(false);
const editingAddress = ref(null);

const addAddress = () => {
  showAddressModal.value = true;
};

const fetchAddresses = async () => {
  try {
    const response = await axios.get(`${apiUrl}/address/${user.id}`);
    addresses.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

const handleCreateAddress = async (newAddress) => {
  try {
    const response = await axios.post(`${apiUrl}/address`, newAddress, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    await fetchAddresses();
    showAddressModal.value = false; // Close modal after adding the address
    toast(`Đã thêm địa chỉ thành công!`, {
      // Giữa màn hình
      position: "top-center",
      transition: "zoom",
      autoClose: 3000,
      theme: "auto",
      type: "success",
      dangerouslyHTMLString: true,
    });
  } catch (error) {
    console.error(error);
  }
};

const showEditModal = (address) => {
  editingAddress.value = { ...address };
  showEditAddressModal.value = true;
};

const handleUpdateAddress = async (updatedAddress) => {
  console.log("Request Payload:", updatedAddress);
  try {
    const response = await axios.put(
      `${apiUrl}/address/${updatedAddress.id}`,
      updatedAddress,
      {
        headers: {
          "Content-Type": "application/json", // Changed to application/json
        },
      }
    );
    await fetchAddresses();
    showEditAddressModal.value = false; // Close modal after updating the address
    console.log(response);
    toast(`Đã cập nhật địa chỉ thành công!`, {
      // Giữa màn hình
      position: "top-center",
      transition: "zoom",
      autoClose: 3000,
      theme: "auto",
      type: "success",
      dangerouslyHTMLString: true,
    });
  } catch (error) {
    console.error(error);
  }
};

const deleteAddress = (id) => {
  if (window.confirm("Bạn có chắc chắn muốn xóa địa chỉ này?")) {
    axios
      .delete(`${apiUrl}/address/${id}`)
      .then(function (response) {
        fetchAddresses();
        console.log(response);
        toast(`Đã xóa địa chỉ thành công!`, {
          // Giữa màn hình
          position: "top-center",
          transition: "zoom",
          autoClose: 3000,
          theme: "auto",
          type: "success",
          dangerouslyHTMLString: true,
        });
      })
      .catch(function (error) {
        console.log(error);
      });
  }
};

fetchAddresses();
</script>
