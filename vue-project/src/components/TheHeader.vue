/** * The main header component for the Vue.js application. * Renders the
application title and navigation links. */
<template>
  <Disclosure
    as="nav"
    class="bg-zinc-800 sticky top-0 left-0 right-0 z-1"
    v-slot="{ open }"
  >
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <!-- Logo -->
          <div class="flex items-center">
            <router-link to="/" class="flex items-center">
              <img class="h-8 mr-2" src="../assets/013.JPG" alt="LOGO NÈEE" />
              <!-- <span class="text-lg font-semibold text-white">HONG DUC</span> -->
            </router-link>
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <router-link
                v-for="item in navigation"
                :key="item.key"
                :to="item.href"
                :aria-current="item.current ? 'page' : undefined"
                :class="[
                  item.current
                    ? 'bg-gray-900 text-white no-underline'
                    : 'no-underline text-gray-300 hover:bg-gray-700 hover:text-white',
                  'rounded-md px-3 py-2 text-sm font-medium',
                ]"
              >
                <template v-if="item.key === 'giohang'">
                  <span @click="openGioHang = true">{{ item.name }}</span>
                </template>
                <template v-else-if="item.key === 'tatcasanpham'">
                  <div
                    class="relative"
                    @mouseover="showDropdown = true"
                    @mouseleave="handleMouseLeave"
                  >
                    <router-link
                      class="inline-flex no-underline text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"
                      href="#products"
                      to="#products"
                    >
                      TẤT CẢ SẢN PHẨM
                      <ChevronDownIcon
                        class="-mr-1 h-5 w-5 text-gray-400"
                        aria-hidden="true"
                      />
                    </router-link>

                    <transition
                      enter-active-class="transition duration-200 ease-out"
                      enter-from-class="transform scale-95 opacity-0"
                      enter-to-class="transform scale-100 opacity-100"
                      leave-active-class="transition duration-75 ease-in"
                      leave-from-class="transform scale-100 opacity-100"
                      leave-to-class="transform scale-95 opacity-0"
                    >
                      <div
                        v-show="showDropdown"
                        class="absolute z-10 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 mt-2"
                        @mouseover="showDropdown = true"
                      >
                        <div class="py-1">
                          <router-link
                            v-for="category in categories"
                            class="no-underline block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            :key="category.key"
                            :to="category.href"
                          >
                            {{ category.name }}
                          </router-link>
                        </div>
                      </div>
                    </transition>
                  </div>
                </template>
                <template v-else>{{ item.name }}</template>
              </router-link>
            </div>
          </div>
        </div>
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <button
              type="button"
              @click="openDialogSearch()"
              class="relative rounded-full bg-zinc-700 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
            >
              <span class="absolute -inset-1.5" />
              <span class="sr-only">View search</span>
              <MagnifyingGlassIcon class="h-6 w-6" aria-hidden="true" />
            </button>

            <!-- Search input and overlay -->
            <TransitionRoot as="template" :show="openSearch">
              <Dialog
                as="div"
                class="relative z-10"
                @close="openSearch = false"
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
                  <div
                    class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block"
                  />
                </TransitionChild>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                  <div
                    class="flex pt-16 items-stretch justify-end text-center mr-20 md:items-center md:px-2 lg:px-4"
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
                        class="bg-white p-1 rounded-full shadow-md w-96 border-3 border-lime-100 flex items-center"
                      >
                        <MagnifyingGlassIcon
                          class="h-6 w-6"
                          aria-hidden="true"
                        />
                        <input
                          v-model="searchTerm"
                          type="text"
                          placeholder="Search..."
                          class="w-full px-2 py-1 border-none outline-none"
                          @keyup.enter="searchProducts"
                        />
                      </DialogPanel>
                    </TransitionChild>
                  </div>
                </div>
              </Dialog>
            </TransitionRoot>
            <!-- 
            <button
              type="button"
              class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
            >
              <span class="absolute -inset-1.5" />
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button> -->
            <!-- Profile dropdown -->
            <Menu as="div" class="relative ml-3">
              <div>
                <MenuButton
                  class="relative flex max-w-xs items-center rounded-full bg-zinc-700 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                >
                  <span class="absolute -inset-1.5" />
                  <span class="sr-only">Open user menu</span>
                  <template v-if="isLoggedIn">
                    <img
                      class="h-8 w-8 rounded-full object-cover"
                      :src="user.imageUrl"
                      alt=""
                    />
                  </template>
                  <template v-else>
                    <UserCircleIcon class="h-8 w-8 text-gray-400" />
                  </template>
                </MenuButton>
              </div>
              <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems
                  v-if="isLoggedIn"
                  class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <MenuItem v-for="item in userNavigation" v-slot="{ active }">
                    <a
                      v-if="item.key === 'logout'"
                      href="#"
                      :class="[
                        active ? 'bg-gray-100 no-underline' : '',
                        'no-underline block px-4 py-2 text-sm text-gray-700',
                      ]"
                      @click.prevent="handleLogout"
                    >
                      {{ item.name }}
                    </a>
                    <router-link
                      v-else-if="item.key === 'profile'"
                      :to="item.href"
                      :class="[
                        active ? 'bg-gray-100 no-underline' : '',
                        'no-underline block px-4 py-2 text-sm text-gray-700',
                      ]"
                    >
                      {{ item.name }}
                    </router-link>
                    <a
                      v-else
                      :href="item.href"
                      :class="[
                        active ? 'bg-gray-100 no-underline' : '',
                        'no-underline block px-4 py-2 text-sm text-gray-700',
                      ]"
                      >{{ item.name }}</a
                    >
                  </MenuItem>
                </MenuItems>
                <MenuItems
                  v-else
                  class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <MenuItem>
                    <a
                      href="/signin"
                      class="no-underline block px-4 py-2 text-sm text-gray-700"
                    >
                      <!-- @click.prevent="showLoginModal = true" -->
                      Đăng nhập
                    </a>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
        <div class="-mr-2 flex md:hidden">
          <!-- Mobile menu button -->
          <DisclosureButton
            class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
          >
            <span class="absolute -inset-0.5" />
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
      </div>
    </div>

    <DisclosurePanel class="md:hidden">
      <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
        <DisclosureButton
          v-for="item in navigation"
          :key="item.name"
          as="a"
          :href="item.href"
          :class="[
            item.current
              ? 'bg-gray-900 text-white'
              : 'text-gray-300 hover:bg-gray-700 hover:text-white',
            'block rounded-md px-3 py-2 text-base font-medium',
          ]"
          :aria-current="item.current ? 'page' : undefined"
          >{{ item.name }}</DisclosureButton
        >
      </div>
      <div class="border-t border-gray-700 pb-3 pt-4">
        <!-- <div class="flex items-center px-5">
          <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt="" />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium leading-none text-white">
              {{ user.name }}
            </div>
            <div class="text-sm font-medium leading-none text-gray-400">
              {{ user.email }}
            </div>
          </div>
          <button
            type="button"
            class="relative ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
          >
            <span class="absolute -inset-1.5" />
            <span class="sr-only">View notifications</span>
            <BellIcon class="h-6 w-6" aria-hidden="true" />
          </button>
          <button
            type="button"
            class="relative ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
          >
            <span class="absolute -inset-1.5" />
            <span class="sr-only">View notifications</span>
            <SearchOutlined class="h-6 w-6" aria-hidden="true" />
          </button>
        </div> -->
        <div class="mt-3 space-y-1 px-2">
          <DisclosureButton
            v-for="item in userNavigation"
            :key="item.name"
            as="a"
            :href="item.href"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
          >
            {{ item.name }}
          </DisclosureButton>
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>

  <!-- Cart -->
  <TransitionRoot as="template" :show="openGioHang">
    <Dialog as="div" class="relative z-10" @close="openGioHang = false">
      <TransitionChild
        as="template"
        enter="ease-in-out duration-500"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in-out duration-500"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        />
      </TransitionChild>

      <!-- Cart -->
      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div
            class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10"
          >
            <TransitionChild
              as="template"
              enter="transform transition ease-in-out duration-500 sm:duration-700"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transform transition ease-in-out duration-500 sm:duration-700"
              leave-from="translate-x-0"
              leave-to="translate-x-full"
            >
              <DialogPanel class="pointer-events-auto w-screen max-w-md">
                <div
                  class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl"
                >
                  <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                    <div class="flex items-start justify-between">
                      <DialogTitle class="text-lg font-medium text-gray-900"
                        >Giỏ hàng</DialogTitle
                      >
                      <div class="ml-3 flex h-7 items-center">
                        <button
                          type="button"
                          class="relative -m-2 p-2 text-gray-400 hover:text-gray-500"
                          @click="open = false"
                        >
                          <span class="absolute -inset-0.5" />
                          <span class="sr-only">Close panel</span>
                          <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>

                    <!-- Cart -->
                    <div class="mt-8">
                      <div class="flow-root">
                        <div v-if="cart.length === 0">
                          <p>Giỏ hàng trống</p>
                        </div>
                        <div v-else>
                          <ul
                            role="list"
                            class="-my-6 divide-y divide-gray-200"
                          >
                            <li
                              v-for="item in cart"
                              :key="item.id"
                              class="flex py-6"
                            >
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
                                    <p class="ml-4">
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
                                    Qty {{ item.quantity }}
                                  </p>

                                  <div class="flex">
                                    <button
                                      type="button"
                                      @click="removeFromCart(item)"
                                      class="font-medium text-indigo-600 hover:text-indigo-500"
                                    >
                                      Xóa
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                    <div
                      class="flex justify-between text-base font-medium text-gray-900"
                    >
                      <p>Tổng tiền</p>
                      <!-- <p>{{ formatPrice(total) }}</p> -->
                      <p>{{ formatPrice(getTotalPrice()) }}</p>
                    </div>
                    <p class="mt-0.5 text-sm text-gray-500">
                      Tiền ship và thuế được tính khi thanh toán
                    </p>
                    <div class="mt-6">
                      <router-link
                        to="/checkout"
                        @click="openGioHang = false"
                        class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700"
                        >Thanh toán
                      </router-link>
                    </div>
                    <div
                      class="mt-6 flex justify-center text-center text-sm text-gray-500"
                    >
                      <p>
                        hoặc{{ " " }}
                        <button
                          type="button"
                          class="font-medium text-indigo-600 hover:text-indigo-500"
                          @click="openGioHang = false"
                        >
                          Tiếp tục mua sắm
                          <span aria-hidden="true"> &rarr;</span>
                        </button>
                      </p>
                    </div>
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import {
  Bars3Icon,
  BellIcon,
  XMarkIcon,
  MagnifyingGlassIcon,
} from "@heroicons/vue/24/outline";
import { onMounted, ref, inject, computed } from "vue";
import { useStore } from "vuex";
import {
  Dialog,
  DialogTitle,
  DialogPanel,
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { StarIcon } from "@heroicons/vue/20/solid";
import { useRouter } from "vue-router";
import { MDBFooter } from "mdb-vue-ui-kit";
import { MDBIcon } from "mdb-vue-ui-kit";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { UserCircleIcon } from "@heroicons/vue/24/outline";
import { SearchOutlined } from "@ant-design/icons-vue";

const router = useRouter();
// const cart = inject("cart");

// const categories = ref([]);
const apiUrl = inject("apiUrl");
const getCategories = () => {
  axios
    .get(`${apiUrl}/categories`)
    .then(function (response) {
      categories.value = response.data.categories;
    })
    .catch(function (error) {
      console.log(error);
    });
};

const categories = [
  {
    name: "Đồng hồ nam",
    key: "donghonam",
    href: "donghonam",
  },
  {
    name: "Đồng hồ nữ",
    key: "donghonu",
    href: "donghonu",
  },
  {
    name: "Đồng hồ thông minh",
    key: "donghothongminh",
    href: "donghothongminh",
  },
];

const formatPrice = (value) => {
  return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

// Nhận cart từ provide
const cart = inject("cart");
const addToCart = inject("addToCart");
const removeFromCart = inject("removeFromCart");
const clearCart = inject("clearCart");
const getTotalPrice = inject("getTotalPrice");

// const removeFromCart = (item) => {
//   cart.value = cart.value.filter(cartItem => cartItem !== item)
// }

const total = computed(() => {
  console.log("cart:", cart.value);
  return cart.value.reduce((total, item) => {
    return total + item.price * item.stock;
  }, 0);
});

const showDropdown = ref(false);
const handleMouseLeave = () => {
  showDropdown.value = false;
};

const searchTerm = ref("");

const searchProducts = () => {
  const query = searchTerm.value.trim();
  if (query) {
    router.push({ name: "SearchView", query: { q: query } });
  }
};

// const user = JSON.parse(localStorage.getItem('user'))

// const baseURL = "http://192.168.23.1:8000/storage/";
// const imageUrl = `${baseURL}${user.avatar}`;
// user.imageUrl = imageUrl;

// Fetch user data from localStorage
let user = localStorage.getItem("user");
if (user) {
  user = JSON.parse(user);
  const baseURL = "http://192.168.23.1:8000/storage/";
  user.imageUrl = `${baseURL}${user.avatar}`;
} else {
  user = null;
}

const navigation = [
  {
    name: "HOME/TRANG CHỦ",
    key: "home",
    href: "/",
    current: false,
  },
  {
    name: "TẤT CẢ SẢN PHẨM",
    key: "tatcasanpham",
    href: "#products",
    current: false,
  },
  // {
  //   name: "KHUYẾN MÃI",
  //   key: "khuyenmai",
  //   href: "#",
  //   current: false,
  // },
  {
    name: "LIÊN HỆ",
    key: "lienhe",
    href: "/lienhe",
    current: false,
  },
  {
    name: "GIỎ HÀNG",
    key: "giohang",
    href: "#",
    current: false,
  },
];
const userNavigation = [
  {
    name: "Tài khoản của bạn",
    key: "profile",
    href: "/customer",
  },
  // {
  //   name: "Cài đặt",
  //   key: "settings",
  //   href: "/setting",
  // },
  {
    name: "Đăng xuất",
    key: "logout",
    href: "#",
  },
];

import { isLoggedIn, setIsLoggedIn } from "../views/useAuth"; // Import biến isLoggedIn từ file useAuth.js

const loggedInFromStorage = localStorage.getItem("isLoggedIn") === "true";
setIsLoggedIn(loggedInFromStorage);
// Hàm xử lý đăng xuất
const handleLogout = () => {
  // Xóa thông tin đăng nhập từ localStorage, sessionStorage hoặc Vuex store
  localStorage.removeItem("token");
  // Xử lý logic đăng xuất, ví dụ gọi API đăng xuất
  setIsLoggedIn(false);
  // Lưu trạng thái đăng xuất và giỏ hàng rỗng vào localStorage
  clearCart();

  // // Đặt lại trạng thái đăng nhập
  // isLoggedIn.value = false;

  // // Điều hướng về trang đăng nhập hoặc trang chủ
  // router.push("/");
};

const openSearch = ref(false);

function openDialogSearch() {
  openSearch.value = true;
}

//openGioHang
const openGioHang = ref(false);

// const App = defineComponent({
// setup() {
const users = ref([]);
const admins = ref([]);

const getUser = () => {
  axios
    .get("http://127.0.0.1:8000/api/users")

    .then(function (response) {
      // handle success
      users.value = response.data.data;
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    });
};

const getAdmin = async () => {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/admins");
    admins.value = response.data;
  } catch (error) {
    console.error(error);
  }
};
onMounted(() => {
  getUser();
  getAdmin();
  getCategories();
});
</script>
