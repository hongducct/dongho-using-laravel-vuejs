<template>
  <div>
    <a-card title="Tài khoản" style="width: 100%">
      <div class="row">
        <div class="col-12">
          <a-table :dataSource="users" :columns="columns" :scroll="{ x: 1500, y: 600 }">
            <template #bodyCell="{ column, index, record }">
              <template v-if="column.key === 'index'">
                <span>{{ index + 1 }}</span>
              </template>
              <template v-if="column.key === 'avatar'">
                <a-image :width="100" :src="`${record.avatar}`" />
              </template>
              <template v-if="column.key === 'status'">
                <span v-if="record.status_id === 1" class="text-primary">
                  <a @click="showModal(record)">{{ record.status }}</a>
                </span>
                <span v-else class="text-danger">{{ record.status }}</span>
              </template>
            </template>
          </a-table>
        </div>
      </div>
    </a-card>
    <a-modal v-model:visible="isModalVisible" title="Thay đổi tình trạng" @ok="updateStatus">
      <a-select v-model:value="selectedStatus" style="width: 100%">
        <a-select-option v-for="status in statuses" :key="status.id" :value="status.id">{{ status.name }}</a-select-option>
      </a-select>
    </a-modal>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

const users = ref([]);
const isModalVisible = ref(false);
const selectedUser = ref(null);
const selectedStatus = ref(null);
const statuses = ref([]);

const columns = [
  { title: "STT", key: "index" },
  { title: "username", dataIndex: "username", key: "username" },
  { title: "Avatar", dataIndex: "avatar", key: "avatar" },
  { title: "Tên", dataIndex: "name", key: "name" },
  { title: "Email", dataIndex: "email", key: "email" },
  { title: "Tình trạng", dataIndex: "status", key: "status", slots: { default: "default" } },
];

import { inject } from "vue";
const apiUrl = inject("apiUrl");
console.log(`${apiUrl}/users`);

const showModal = (user) => {
  isModalVisible.value = true;
  selectedUser.value = user;
  selectedStatus.value = user.status_id;
};

const getUser = () => {
  axios
    .get(`${apiUrl}/users`)
    .then(function (response) {
      console.log(response);
      users.value = response.data.data;
    })
    .catch(function (error) {
      console.log(error);
    });
};

const getStatuses = () => {
  axios
    .get(`${apiUrl}/statuses`)
    .then(function (response) {
      console.log(response);
      statuses.value = response.data.data;
    })
    .catch(function (error) {
      console.log(error);
    });
};

const updateStatus = (userId, statusId) => {
  return axios.put(`/api/users/${userId}/status`, { status_id: statusId })
    .then(response => {
      console.log(response.data.message); // 'User status updated successfully'
      // Handle success here
    })
    .catch(error => {
      console.error(error);
      // Handle error here
    });
};


onMounted(() => {
  getUser();
  getStatuses();
  console.log(users);
});
</script>