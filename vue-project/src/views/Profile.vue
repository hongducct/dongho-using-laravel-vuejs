<template>
  <TheHeader />
  <!-- breadcrumb -->
  <div class="breadcrumb-section rounded-full" style="background-color: #f5f5fa; padding: 20px 15px">
      <div class="container">
        <div class="row items-center">
          <div class="col-sm-6 content-center">
            <a-breadcrumb separator=">">
              <a-breadcrumb-item @click="navigateTo('/')"  class="flex items-center">
                <div class="flex items-center">
                  <HomeOutlined />
                  <span style="padding-left: 3px;">TRANG CHỦ</span>
                </div>
              </a-breadcrumb-item>
              <a-breadcrumb-item>x</a-breadcrumb-item>
            </a-breadcrumb>
          </div>
        </div>
      </div>
    </div>
</template>
<script setup>
import TheHeader from "@/components/TheHeader.vue";
import TheFooter from "@/components/TheFooter.vue";
import Breadcrumb from "@/components/Breadcrumb.vue";
import VerticalTabs from "@/components/VerticalTabs.vue";
import { ref, reactive } from "vue";
import { HomeOutlined, UserOutlined } from "@ant-design/icons-vue";
</script>
