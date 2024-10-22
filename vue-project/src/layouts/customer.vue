<template>
  <TheHeader />
  <div class="container-fuild mt-3" style="padding-bottom: 81px">
    <div class="row mx-4">
      <div class="col-sm-2 ml-6 border-r border-gray-300">
        <a-menu v-model:openKeys="state.openKeys" v-model:selectedKeys="state.selectedKeys" mode="inline"
          :inline-collapsed="state.collapsed" class="bg-white py-2 px-1 rounded-lg h-full left-0 top-0 overflow-y-auto">
          <a-menu-item-group>
            <template #title>
              <div class="text-lg font-bold text-gray-500 px-4 py-2 bg-gray-100 text-center rounded mb-4">
                Tài Khoản
              </div>
            </template>
            <a-menu-item :key="item.key" v-for="item in items" class="py-4 hover:bg-gray-300 transition-colors duration-300">
              <router-link :to="{ name: item.routeName }" @click="handleMenuItemClick(item.key)"
                class="flex items-center no-underline text-gray-700 hover:text-gray-900">
                <component :is="item.icon" class="mr-2" />
                {{ item.label }}
              </router-link>
            </a-menu-item>
          </a-menu-item-group>
        </a-menu>
      </div>
      <div class="col-sm-9">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch, h } from "vue";
import {
  PieChartOutlined,
  MailOutlined,
  DesktopOutlined,
  InboxOutlined,
  AppstoreOutlined,
} from "@ant-design/icons-vue";
import { useRouter } from "vue-router";
import { icons } from "ant-design-vue/es/image/PreviewGroup";

import TheHeader from "@/components/TheHeader.vue";

const router = useRouter();

const state = reactive({
  collapsed: false,
  selectedKeys: ["admin-products"],
});

const items = reactive([
  {
    key: "customer-account",
    routeName: "customer-account",
    icon: () => h(PieChartOutlined),
    label: "Thông tin tài khoản",
  },
  {
    key: "customer-notification",
    routeName: "customer-notification",
    icon: () => h(DesktopOutlined),
    label: "Thông báo của tôi",
  },
  {
    key: "customer-address",
    routeName: "customer-address",
    icon: () => h(InboxOutlined),
    label: "Sổ địa chỉ",
  },
  // {
  //   key: "customer-test",
  //   routeName: "customer-test",
  //   icon: () => h(MailOutlined),
  //   label: "Test",
  // },
]);

const isSelected = (key) => {
  return state.selectedKeys.includes(key);
};

const handleMenuItemClick = (key) => {
  state.selectedKeys = [key];
};

watch(
  () => state.openKeys,
  (_val, oldVal) => {
    state.preOpenKeys = oldVal;
  }
);

// Watch for route changes and update selectedKeys accordingly
router.afterEach((to, _from) => {
  const items = items.find((item) => item.routeName === to.name);
  if (items) {
    state.selectedKeys = [items.key];
  }
});
</script>

<style scoped></style>
