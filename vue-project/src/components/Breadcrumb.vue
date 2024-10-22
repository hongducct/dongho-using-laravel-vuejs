<template>
  <div
    class="breadcrumb-section"
    style="background-color: #f8f8f8; padding: 30px 0"
  >
    <div class="container">
      <div class="row items-center">
        <div class="col-sm-6">
          <div class="page-title"><h2>PROFILE</h2></div>
        </div>
        <div class="col-sm-6 content-center">
          <a-breadcrumb class="flex justify-end">
            <a-breadcrumb-item @click="navigateTo('/')">
              <HomeOutlined />
              <span>TRANG CHỦ</span>
            </a-breadcrumb-item>
            <!-- <a-breadcrumb-item @click="navigateTo('/')">
      <UserOutlined />
      <span>Application List</span>
    </a-breadcrumb-item> -->
            <a-breadcrumb-item>PROFILE</a-breadcrumb-item>
          </a-breadcrumb>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { HomeOutlined, UserOutlined } from "@ant-design/icons-vue";

const router = useRouter();

const navigateTo = (path) => {
  router.push(path);
};
</script>
