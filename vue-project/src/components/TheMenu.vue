<template>
  <a-menu
    v-model:openKeys="state.openKeys"
    v-model:selectedKeys="state.selectedKeys"
    mode="inline"
    :inline-collapsed="state.collapsed"
    class="bg-white border-r border-gray-200 mt-4"
  >
    <a-menu-item
      v-for="item in items"
      :key="item.key"
      class="px-4 py-2 hover:bg-blue-100 transition duration-300 ease-in-out"
    >
      <router-link
        :to="{ name: item.routeName }"
        @click="handleMenuItemClick(item.key)"
        class="no-underline text-gray-700 hover:text-gray-900 flex items-center"
      >
        <component :is="item.icon" class="mr-2" />
        {{ item.label }}
      </router-link>
    </a-menu-item>
  </a-menu>
</template>

<script setup>
import { reactive, watch } from 'vue';
import {
  PieChartOutlined,
  MailOutlined,
  DesktopOutlined,
  InboxOutlined,
  AppstoreOutlined,
} from '@ant-design/icons-vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const state = reactive({
  collapsed: false,
  selectedKeys: ['admin-products'],
  openKeys: [],
});

const items = reactive([
  {
    key: 'admin-users',
    routeName: 'admin-users',
    icon: PieChartOutlined,
    label: 'Tài khoản',
  },
  {
    key: 'admin-products',
    routeName: 'admin-products',
    icon: DesktopOutlined,
    label: 'Sản phẩm',
  },
  {
    key: 'admin-admins',
    routeName: 'admin-admins',
    icon: InboxOutlined,
    label: 'Admins',
  },
  {
    key: 'upload-product',
    routeName: 'upload-product',
    icon: MailOutlined,
    label: 'Upload Product',
  },
  // {
  //   key: 'admin-test',
  //   routeName: 'admin-test',
  //   icon: AppstoreOutlined,
  //   label: 'test',
  // },
]);

const handleMenuItemClick = (key) => {
  state.selectedKeys = [key];
};

watch(
  () => state.openKeys,
  (_val, oldVal) => {
    state.preOpenKeys = oldVal;
  }
);

router.afterEach((to, _from) => {
  const item = items.find((item) => item.routeName === to.name);
  if (item) {
    state.selectedKeys = [item.key];
  }
});
</script>

<style scoped>
.no-underline {
  text-decoration: none;
}
</style>
