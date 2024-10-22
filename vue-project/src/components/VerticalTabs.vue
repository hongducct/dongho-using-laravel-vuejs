<template>
    <div class="custom-tabs-container p-16">
      <div class="">
        <a-tabs 
          v-model:activeKey="activeKey"
          tabPosition="left"
          class="border mr-12"
        >
          <a-tab-pane key="1" tab="Xem tài khoản"></a-tab-pane>
          <a-tab-pane key="2" tab="Địa chỉ"></a-tab-pane>
          <a-tab-pane key="3" tab="Cài đặt"></a-tab-pane>
        </a-tabs>
      </div>
      <div class="custom-content">
        <div v-if="activeKey === '1'">Nội dung của Tab 1</div>
        <div v-if="activeKey === '2'">Nội dung của Tab 2</div>
        <div v-if="activeKey === '3'">Nội dung của Tab 3</div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const activeKey = ref('1');
  </script>
  
  <style scoped>
  .custom-tabs-container {
    display: flex;
    align-items: flex-start;
  }
  
  .custom-content {
    border: 1px solid #d9d9d9; /* Border for content */
    padding: 10px; /* Optional padding for content */
    width: 100%;
  }
  </style>
  