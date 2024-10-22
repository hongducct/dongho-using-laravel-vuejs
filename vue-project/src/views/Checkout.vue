<template>
  <TheHeader />
  <div class="mb-36 mx-40 mt-12">
    <div>
      <h2 class="text-2xl font-bold m-6">Xác nhận thanh toán</h2>
    </div>
    <div class="flex">
      <!-- Left -->
      <div class="w-2/3 pr-4 mr-1 bg-white shadow-lg rounded-lg">
        <div class="flex h-full flex-col">
          <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
            <div class="flex items-start justify-between">
              <h2 class="text-lg font-medium text-gray-500">Giỏ hàng</h2>
            </div>
            <!-- Cart -->
            <div class="mt-8">
              <div class="flow-root">
                <div v-if="cart.length === 0">
                  <p>Giỏ hàng trống</p>
                </div>
                <div v-else>
                  <ul role="list" class="-my-6 divide-y divide-gray-200">
                    <li v-for="item in cart" :key="item.id" class="flex py-6">
                      <div
                        class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200"
                      >
                        <img
                          :src="item.images[0]"
                          :alt="item.imageAlt"
                          class="h-full w-full object-cover object-center"
                        />
                      </div>
                      <div class="ml-4 flex flex-1 flex-col">
                        <div>
                          <div
                            class="flex justify-between text-base font-medium text-gray-900"
                          >
                            <h5>
                              <a :href="item.href">{{ item.name }}</a>
                            </h5>
                            <p class="ml-4 text-gray-300">
                              {{ formatPrice(item.price) }}
                            </p>
                          </div>
                          <p class="mt-1 text-sm text-gray-500">
                            {{ item.color }}
                          </p>
                        </div>
                        <div
                          class="flex flex-1 items-end justify-between text-sm"
                        >
                          <p class="text-gray-500">
                            Số lượng {{ item.quantity }}
                          </p>
                          <div class="flex">
                            <p class="text-lg">
                              {{ formatPrice(item.quantity * item.price) }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Right -->
      <div class="w-1/3 pl-1 ml-1">
        <!-- Thông tin khách hàng -->
        <div class="mb-4 p-4 bg-white rounded-lg shadow-lg">
          <h2 class="text-xl font-semibold mb-4">Thông tin khách hàng</h2>
          <div class="space-y-2">
            <div class="flex items-center">
              <label class="block text-gray-700 w-1/3">Số điện thoại</label>
              <span class="block w-2/3 bg-gray-100 p-2 rounded-md">{{
                formatPhoneNumber(selectedAddress.phone_number)
              }}</span>
            </div>
            <div class="flex items-center">
              <label class="block text-gray-700 w-1/3">Họ & tên</label>
              <span class="block w-2/3 bg-gray-100 p-2 rounded-md">{{
                user.name
              }}</span>
            </div>
            <div class="flex items-center">
              <label class="block text-gray-700 w-1/3">Email</label>
              <span class="block w-2/3 bg-gray-100 p-2 rounded-md">{{
                user.email
              }}</span>
            </div>
          </div>
          <!-- Địa chỉ -->
          <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex justify-between mb-2 items-center">
              <span class="text-gray-700 font-medium">Giao tới</span>
              <button @click="changeAddress" class="text-indigo-600">
                Thay đổi
              </button>
            </div>
            <div>
              <div class="flex items-center mb-2">
                <span class="font-semibold">{{ selectedAddress.name }}</span>
                <div class="border-x mx-4 h-4 border-gray-300"></div>
                <span class="text-gray-700">{{
                  formatPhoneNumber(selectedAddress.phone_number)
                }}</span>
              </div>
              <div>
                <span class="text-gray-700 block bg-gray-100 p-2 rounded-md">
                  {{
                    selectedAddress.address +
                    " - " +
                    selectedAddress.ward +
                    " - " +
                    selectedAddress.district +
                    " - " +
                    selectedAddress.province
                  }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <!-- Phương thức thanh toán -->
        <div
          class="mb-4 p-4 w-96 bg-white rounded-lg shadow-md border-2 border-red-600 cursor-pointer"
        >
          <h2 class="text-xl font-semibold mb-4">Phương thức thanh toán</h2>
          <div class="space-y-2">
            <label class="flex items-center cursor-pointer">
              <input
                type="radio"
                value="1"
                checked
                class="form-radio text-indigo-600"
              />
              <span class="ml-2 text-black-85 font-semibold">VNPAY</span>
              <span class="ml-2 text-black-45 text-sm">
                <svg
                  width="14"
                  height="11"
                  viewBox="0 0 14 11"
                  fill="none"
                  class="inline-block mr-1"
                >
                  <rect width="14" height="11" fill="url(#pattern0)"></rect>
                  <defs>
                    <pattern
                      id="pattern0"
                      patternContentUnits="objectBoundingBox"
                      width="1"
                      height="1"
                    >
                      <use
                        xlink:href="#image0_6522_32684"
                        transform="matrix(0.000837648 0 0 0.0010661 -0.0025891 0)"
                      ></use>
                    </pattern>
                  </defs>
                </svg>
                Trả online nhiều ưu đãi
              </span>
            </label>
          </div>
        </div>
        <!-- Hình thức giao hàng -->
        <div
          class="mb-4 p-4 w-96 bg-white rounded-lg shadow-md border-2 border-red-600 cursor-pointer"
        >
          <label class="flex items-center cursor-pointer">
            <input
              type="radio"
              name="shipping"
              checked
              class="form-radio text-indigo-600"
            />
            <div class="flex items-center justify-between w-full">
              <span class="ml-2">Giao tiết kiệm</span>
              <span class="flex items-center space-x-2">
                <span class="line-through">25.000 đ</span>
                <span>MIỄN PHÍ</span>
              </span>
            </div>
          </label>
        </div>

        <!-- Thanh toán -->
        <div class="p-4 bg-white rounded-lg shadow-md">
          <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
            <div
              class="flex justify-between text-base font-medium text-gray-900"
            >
              <p>Tổng tiền</p>
              <p>{{ formatPrice(getTotalPrice()) }}</p>
            </div>
            <div class="mt-6">
              <div
                @click="openDialogPayment"
                class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700"
              >
                Thanh toán
              </div>
            </div>
            <div
              class="mt-6 flex justify-center text-center text-sm text-gray-500"
            >
              <p>
                hoặc
                <button
                  type="button"
                  class="font-medium text-indigo-600 hover:text-indigo-500"
                  @click="openGioHang = false"
                >
                  <router-link to="/"
                    >Tiếp tục mua sắm<span aria-hidden="true"
                      >&rarr;</span
                    ></router-link
                  >
                </button>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <TransitionRoot as="template" :show="open">
      <Dialog as="div" class="relative z-10" @close="open = false">
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in duration-200"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div
            class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block"
          />
        </TransitionChild>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div
            class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4"
          >
            <TransitionChild
              as="template"
              enter="ease-out duration-300"
              enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
              enter-to="opacity-100 translate-y-0 md:scale-100"
              leave="ease-in duration-200"
              leave-from="opacity-100 translate-y-0 md:scale-100"
              leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
            >
              <DialogPanel
                class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl"
              >
                <div
                  class="relative w-full items-center overflow-hidden bg-white px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8 rounded-4"
                >
                  <div class="flex border-b-2 mb-4">
                    <div class="qr-heading">
                      <h3 class="flex">
                        <img
                          src="https://frontend.tikicdn.com/_desktop-next/static/img/icons/checkout/icon-payment-method-vnpay.png"
                          alt="icon"
                          width="32"
                          height="32"
                        />
                        Thanh toán bằng VNPAY-QR
                      </h3>
                    </div>
                    <button
                      type="button"
                      class="absolute right-4 top-4 text-gray-400 hover:text-gray-500 sm:right-6 sm:top-8 md:right-6 md:top-6 lg:right-8 lg:top-8"
                      @click="open = false"
                    >
                      <span class="sr-only">Close</span>
                      <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                    </button>
                  </div>
                  <div
                    class="grid w-full grid-cols-1 items-start gap-x-6 gap-y-8 sm:grid-cols-12 lg:gap-x-8"
                  >
                    <div
                      class="relative aspect-h-3 aspect-w-2 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5 p-12"
                    >
                      <img
                        :src="qrCodeUrl"
                        class="p-1 object-cover object-center"
                      />
                      <span
                        class="absolute bottom-3 left-10 text-base text-gray-500"
                      >
                        Tổng tiền:
                      </span>
                      <span
                        class="absolute bottom-3 right-5 text-sm text-gray-500"
                      >
                        <span class="text-lg font-bold">{{
                          formatPrice(getTotalPrice())
                        }}</span>
                        VNĐ
                      </span>
                    </div>
                    <div class="sm:col-span-8 lg:col-span-7">
                      <div class="qr-content__right">
                        <div class="qr-content__desc">
                          <h2 class="text-2xl text-gray-900 sm:pr-12 mb-5">
                            Quét mã QR để thanh toán
                          </h2>
                          <div
                            class="flex mb-2 text-gray-500 leading-6 items-start"
                          >
                            <span
                              class="w-5 h-5 flex items-center justify-center bg-blue-400 mr-2 rounded-full text-white mt-1"
                              >1</span
                            >
                            <p>
                              Mở <b>ứng dụng ngân hàng hỗ trợ VNPAY-QR</b> trên
                              điện thoại
                            </p>
                          </div>
                          <div
                            class="flex mb-2 text-gray-500 leading-6 items-start"
                          >
                            <span
                              class="w-5 h-5 flex items-center justify-center bg-blue-400 mr-2 rounded-full text-white mt-1"
                              >2</span
                            >
                            <p>
                              Trên ứng dụng chọn tính năng
                              <img
                                src="https://salt.tikicdn.com/ts/upload/03/74/d4/01670f7f9e6a3c86583939eb2494e9cf.png"
                                alt="icon"
                                class="w-7 inline-block mx-1 align-middle"
                              />
                              <b>Quét mã QR</b>
                            </p>
                          </div>
                          <div
                            class="flex mb-2 text-gray-500 leading-6 items-start"
                          >
                            <span
                              class="w-5 h-5 flex items-center justify-center bg-blue-400 mr-2 rounded-full text-white mt-1"
                              >3</span
                            >
                            <p>Quét mã QR ở trang này và thanh toán</p>
                          </div>
                        </div>
                        <div
                          class="p-3 bg-orange-100 border-2 border-pink-300 rounded-md mt-6 sm:p-8 lg:p-6 xl:p-8 text-center"
                        >
                          <span>Giao dịch kết thúc sau</span>
                          <div class="mt-3">
                            <span
                              class="bg-orange-500 py-1 px-2 rounded-lg text-white text-xl"
                              >{{ minutes }}</span
                            >
                            :
                            <span
                              class="bg-orange-500 py-1 px-2 rounded-lg text-white text-xl"
                              >{{ seconds }}</span
                            >
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>

  <TransitionRoot as="template" :show="changeAddressModal">
    <Dialog as="div" class="relative z-10" @close="changeAddressModal = false">
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0"
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
              class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
            >
              <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold">Sổ địa chỉ</h2>
                <button
                  @click="addAddress"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded"
                >
                  + Thêm địa chỉ mới
                </button>
              </div>

              <ul>
                <li 
                  v-for="address in addresses" 
                  :key="address.id" 
                  @click="selectAddress(address)"
                  :class="{'bg-gray-100': selectedAddress && selectedAddress.id === address.id}"
                >
                  <div class="p-4 mb-4 border border-gray-300 rounded-md cursor-pointer">
                    <div class="flex items-center mb-2">
                      <div
                        class="bg-gray-200 rounded-full h-8 w-8 flex items-center justify-center mr-2"
                      >
                        <i class="fas fa-map-marker-alt text-gray-500"></i>
                      </div>
                      <span class="font-semibold">{{ address.name }}</span>
                    </div>
                    <p class="text-sm mb-2">
                      <span class="text-gray-400">Địa chỉ: </span
                      >{{ address.address }}, {{ address.ward }},
                      {{ address.district }},
                      {{ address.province }}
                    </p>
                    <p class="text-sm">
                      <span class="text-gray-400">Điện thoại: </span
                      >{{ formatPhoneNumber(address.phone_number) }}
                    </p>
                  </div>
                </li>
              </ul>
              <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button
                  type="button"
                  class="w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                  @click="confirmSelection"
                >
                  Xác nhận
                </button>
                <button
                  type="button"
                  class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm"
                  @click="changeAddressModal = false"
                >
                  Hủy
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
  <AddressModal
    v-model:showAddressModal="showAddressModal"
    @createAddress="handleCreateAddress"
  />
</template>

<script setup>
import { inject, ref, computed, onMounted, watch } from "vue";
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { useRouter } from "vue-router";
import TheHeader from "@/components/TheHeader.vue";

import AddressModal from "@/views/customer/address/AddressModal.vue";
const user = JSON.parse(localStorage.getItem("user"));
console.log("user", user.email);

const showAddressModal = ref(false);

const addAddress = () => {
  showAddressModal.value = true;
};

const apiUrl = inject("apiUrl");

const changeAddressModal = ref(false);

const changeAddress = () => {
  changeAddressModal.value = !changeAddressModal.value;
};

const addresses = ref([]);
const selectedAddress = ref({
  id: '',
  user_id: user.id,
  name: '',
  phone_number: '',
  province: '',
  district: '',
  ward: '',
  address: '',
});

const selectAddress = (address) => {
  selectedAddress.value = address;
};

const confirmSelection = () => {
  // Close the change address modal
  changeAddressModal.value = false;
  
  // Ensure selectedAddress is set (optional: you can log it or handle it as needed)
  if (selectedAddress.value) {
    console.log("Selected Address:", selectedAddress.value);
  } else {
    console.warn("No address selected.");
  }
};

const formatPhoneNumber = (phoneNumber) => {
  return phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
};

const handleCreateAddress = async (newAddress) => {
  try {
    console.log("xx", newAddress);
    const response = await axios.post(`${apiUrl}/address`, newAddress, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    addresses.value.push(response.data);
    showAddressModal.value = false; // Close modal after adding the address
  } catch (error) {
    console.error(error);
  }
};

const fetchAddresses = async () => {
  try {
    const response = await axios.get(`${apiUrl}/address/${user.id}`);
    addresses.value = response.data;
    // Đã cập nhật giá trị của addresses, có thể truy cập giá trị bên trong ngay sau khi cập nhật
    console.log(
      "Số điện thoại của đối tượng đầu tiên là:",
      // formatPhoneNumber(addresses.value[0].phone_number)
    );
    // nếu có địa chỉ thì lấy đầu tiên làm giá trị mặc định, còn không thì không gán
    if (addresses.value.length > 0) {
      selectedAddress.value = addresses.value[0];
    }
    // selectedAddress.value = addresses.value[0];
    console.log("Giá trị của selectedAddress là:", selectedAddress.value);
  } catch (error) {
    console.error(error);
  }
};

// lấy user từ localStorage

// Nhận cart từ provide
const cart = inject("cart");
const getTotalPrice = inject("getTotalPrice");

const formatPrice = (value) => {
  return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

const open = ref(false);

function openDialogPayment() {
  open.value = true;
}

// QR code URL computed property
const qrCodeUrl = computed(() => {
  const totalPrice = getTotalPrice();
  return `https://qr.sepay.vn/img?acc=0799076901&bank=SHB&amount=${totalPrice}&des=TEST`;
});

// Countdown timer
const minutes = ref(4);
const seconds = ref(59);

// Router for navigation
const router = useRouter();

const startCountdown = () => {
  const countdown = setInterval(() => {
    if (seconds.value === 0) {
      if (minutes.value === 0) {
        clearInterval(countdown);
        handleTimeout();
      } else {
        minutes.value--;
        seconds.value = 59;
      }
    } else {
      seconds.value--;
    }
  }, 1000);
};

// Handle timeout function
const handleTimeout = () => {
  open.value = false;
  router.push("/"); // Redirect to payment screen
};

// Start the countdown when the dialog is opened
watch(open, (newVal) => {
  if (newVal) {
    minutes.value = 4;
    seconds.value = 59;
    startCountdown();
  }
});

fetchAddresses();
</script>
