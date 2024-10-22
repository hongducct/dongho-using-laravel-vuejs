<template>
  <!-- Header -->
  <Disclosure
    as="nav"
    class="bg-zinc-700 sticky top-0 left-0 right-0 z-10"
    v-slot="{ open }"
  >
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <img class="h-8" src="../assets/013.JPG" alt="LOGO NÈEE" />
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <div
                class="relative"
                @mouseover="showDropdown = true"
                @mouseleave="handleMouseLeave"
              >
                <router-link
                  to="/"
                  href="#products"
                  class="inline-flex no-underline text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"
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
              <router-link
                v-for="item in navigation.filter(
                  (item) => item.key !== 'tatcasanpham'
                )"
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
                {{ item.name }}
              </router-link>
            </div>
          </div>
        </div>
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <Menu as="div" class="relative ml-3">
              <div>
                <MenuButton
                  class="relative flex max-w-xs items-center rounded-full bg-zinc-700 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                >
                  <span class="absolute -inset-1.5" />
                  <span class="sr-only">Open user menu</span>
                  <template v-if="adminIsLoggedIn">
                    <img
                      class="h-8 w-8 rounded-full object-cover"
                      :src="admin.imageUrl"
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
                  v-if="adminIsLoggedIn"
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
                      href="/admin/login"
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
  <div class="container-fluid mt-3 mx-4" style="padding-bottom: 81px">
    <div class="row">
      <div v-if="!(isLoginPage || isAccountPage)" class="col-sm-2">
        <a-list bordered style="width: 100%" class="bg-white h-full border-2 border-blue-300">
          <template #header>
            <div class="text-lg font-bold text-gray-500 px-2 py-2 bg-gray-100 text-center rounded">
              Bảng Điều Khiển
            </div>
          </template>
          <TheMenu />
        </a-list>
      </div>
      <div :class="(isLoginPage || isAccountPage) ? 'col-sm-12' : 'col-sm-10 router-view-container'">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script setup>
import TheHeader from "@/components/TheHeader.vue";
import TheFooter from "@/components/TheFooter.vue";
import TheMenu from "@/components/TheMenu.vue";
// import TheSidebar from '@/components/TheSidebar.vue'
import { useRoute } from 'vue-router'
const route = useRoute()
const isLoginPage = computed(() => route.path === '/admin/login')
const isAccountPage = computed(() => route.path === '/admin/account')
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

// const user = {
//   name: "Tom Cook",
//   email: "tom@example.com",
//   imageUrl: "src/assets/013.JPG",
// };
const navigation = [
  {
    name: "TẤT CẢ SẢN PHẨM",
    key: "tatcasanpham",
    href: "#products",
    current: false,
  },
  {
    name: "HOME/TRANG CHỦ",
    key: "home",
    href: "/",
    current: false,
  },
  // {
  //   name: "LIÊN HỆ",
  //   key: "lienhe",
  //   href: "/lienhe",
  //   current: false,
  // },
  {
    name: "ADMIN",
    key: "admin",
    href: "/admin/",
    current: true,
  },
];
const userNavigation = [
  {
    name: "Tài khoản của bạn",
    key: "profile",
    href: "/admin/account",
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
console.log(localStorage);

const adminIsLoggedIn = ref(
  localStorage.getItem("adminIsAuthenticated") === "true"
);

console.log(adminIsLoggedIn);
// Hàm xử lý đăng xuất
const handleLogout = () => {
  // Xóa thông tin đăng nhập từ localStorage, sessionStorage hoặc Vuex store
  localStorage.removeItem("token");
  // Xử lý logic đăng xuất, ví dụ gọi API đăng xuất
  console.log(localStorage);
  // Lưu trạng thái đăng xuất và giỏ hàng rỗng vào localStorage
  // // Đặt lại trạng thái đăng nhập
  adminIsLoggedIn.value = false;
  localStorage.setItem("adminIsAuthenticated", false);

  //load lại trang
  router.push('/admin/login');
};

let admin = localStorage.getItem("admin");
if (admin) {
  admin = JSON.parse(admin);
  const baseURL = "http://192.168.23.1:8000/storage/";
  admin.imageUrl = `${baseURL}${admin.avatar}`;
} else {
  admin = null;
}

const openSearch = ref(false);

function openDialogSearch() {
  openSearch.value = true;
}


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

<style scoped>
.router-view-container {
  height: 85  vh; /* 85% chiều cao của màn hình */
  overflow-y: auto; /* Đảm bảo nội dung có thể cuộn nếu vượt quá chiều cao */
}

</style>
