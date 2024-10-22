<template>
  <TransitionRoot as="template" :show="showAddressModal">
    <Dialog
      as="div"
      class="fixed z-10 inset-0 overflow-y-auto"
      @close="emit('update:showAddressModal', false)"
    >
      <div
        class="flex items-end ml-4 justify-center pt-4 px-4 pb-20 text-center sm:block sm:p-0"
      >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in duration-200"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <DialogOverlay
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
          />
        </TransitionChild>

        <span
          class="hidden sm:inline-block sm:align-middle sm:h-screen"
          aria-hidden="true"
          >&#8203;</span
        >

        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to="opacity-100 translate-y-0 sm:scale-100"
          leave="ease-in duration-200"
          leave-from="opacity-100 translate-y-0 sm:scale-100"
          leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <DialogPanel
            class="inline-block align-bottom mt-0 mb-12 bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
          >
            <div>
              <h2 class="text-2xl font-semibold mb-4">Tạo sổ địa chỉ</h2>
              <div class="mb-4">
                <label class="block mb-1">Họ và tên:</label>
                <input
                  v-model="form.fullName"
                  type="text"
                  required
                  class="w-full px-3 py-2 border rounded"
                />
              </div>
              <div class="mb-4">
                <label class="block mb-1">Số điện thoại:</label>
                <input
                  v-model="form.phone"
                  type="tel"
                  required
                  class="w-full px-3 py-2 border rounded"
                />
              </div>
              <div class="mb-4">
                <label class="block mb-1">Tỉnh/Thành phố:</label>
                <select
                  v-model="form.province"
                  @change="handleProvinceChange(form.province)"
                  class="w-full px-3 py-2 border rounded"
                >
                  <option value="">Chọn tỉnh/thành phố</option>
                  <option
                    v-for="province in provinces"
                    :key="province.ProvinceID"
                    :value="province"
                  >
                    {{ province.ProvinceName }}
                  </option>
                </select>
              </div>
              <div class="mb-4">
                <label class="block mb-1">Quận/Huyện:</label>
                <select
                  v-model="form.district"
                  @change="handleDistrictChange(form.district)"
                  class="w-full px-3 py-2 border rounded"
                >
                  <option value="">Chọn quận/huyện</option>
                  <option
                    v-for="district in districts"
                    :key="district.DistrictID"
                    :value="district"
                  >
                    {{ district.DistrictName }}
                  </option>
                </select>
              </div>
              <div class="mb-4">
                <label class="block mb-1">Phường/Xã:</label>
                <select
                  v-model="form.ward"
                  class="w-full px-3 py-2 border rounded"
                >
                  <option value="">Chọn phường/xã</option>
                  <option
                    v-for="ward in wards"
                    :key="ward.WardCode"
                    :value="ward"
                  >
                    {{ ward.WardName }}
                  </option>
                </select>
              </div>
              <div class="mb-4">
                <label class="block mb-1">Địa chỉ:</label>
                <input
                  v-model="form.address"
                  type="text"
                  required
                  class="w-full px-3 py-2 border rounded"
                />
              </div>
              <div class="flex justify-end">
                <button
                  type="submit"
                  class="bg-blue-500 text-white px-3 py-2 rounded"
                  @click="createAddress"
                >
                  Cập nhật
                </button>
                <button
                  type="button"
                  class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md ml-2"
                  @click="emit('update:showAddressModal', false)"
                >
                  Đóng
                </button>
              </div>
            </div>
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, onMounted, inject } from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import axios from "axios";

const props = defineProps({
  showAddressModal: Boolean,
});
const emit = defineEmits(["update:showAddressModal", "createAddress"]);
const apiUrl = inject("apiUrl");

const userId = JSON.parse(localStorage.getItem("user")).id;

const form = ref({
  fullName: "",
  phone: "",
  province: "",
  district: "",
  ward: "",
  address: "",
  userId: userId,
});

const provinces = ref([]);
const districts = ref([]);
const wards = ref([]);

const getProvinces = async () => {
  try {
    const response = await axios.get(
      "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province",
      {
        headers: {
          Token: "8681be77-1858-11ef-8bfa-8a2dda8ec551",
        },
      }
    );
    provinces.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
};

const getDistricts = async (provinceId) => {
  try {
    const response = await axios.get(
      "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district",
      {
        headers: {
          Token: "8681be77-1858-11ef-8bfa-8a2dda8ec551",
        },
        params: {
          province_id: provinceId,
        },
      }
    );
    districts.value = response.data.data;
    form.value.district = "";
    form.value.ward = "";
    wards.value = [];
  } catch (error) {
    console.error(error);
  }
};

const getWards = async (districtId) => {
  try {
    const response = await axios.get(
      "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward",
      {
        headers: {
          Token: "8681be77-1858-11ef-8bfa-8a2dda8ec551",
        },
        params: {
          district_id: districtId,
        },
      }
    );
    wards.value = response.data.data;
    form.value.ward = "";
  } catch (error) {
    console.error(error);
  }
};

const handleProvinceChange = () => {
  if (form.value.province) {
    getDistricts(form.value.province.ProvinceID);
  }
};

const handleDistrictChange = () => {
  if (form.value.district) {
    getWards(form.value.district.DistrictID);
  }
};

const createAddress = () => {
  const newAddress = {
    name: form.value.fullName,
    phone_number: form.value.phone,
    province: form.value.province.ProvinceName,
    district: form.value.district.DistrictName,
    ward: form.value.ward.WardName,
    address: form.value.address,
    user_id: form.value.userId,
  };
  emit("createAddress", newAddress);
  emit("update:showAddressModal", false);
};

onMounted(() => {
  getProvinces();
});
</script>

<style scoped>
/* Add any necessary custom styles here */
</style>
