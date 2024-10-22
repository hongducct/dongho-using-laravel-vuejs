<template>
  <div>
    <a-card title="Tài khoản" style="width: 90%">
      <div class="flex items-center justify-between">
        <!-- Search bar -->
        <SearchForm @search="handleSearch" />
      </div>
      <div class="row">
        <div class="col-12">
          <a-table
            :dataSource="filteredItems"
            :columns="columns"
            :scroll="{ x: 1500, y: tableHeight }"
          >
            <template #bodyCell="{ column, index, record }">
              <template v-if="column.key === 'index'">
                <span>{{ index + 1 }}</span>
              </template>
              <template v-if="column.key === 'avatar'">
                <!-- <a-image
                  v-if="record.avatar"
                  :width="100"
                  :src="`${record.avatar}`"
                  :alt="record.name"
                /> -->
                <a-image
                  v-if="record.avatar"
                  :width="100"
                  :src="record.avatar"
                  :alt="record.name"
                />
                <span v-else>Không có ảnh đại diện</span>
              </template>
              <template v-if="column.key === 'status'">
                <span v-if="record.status_id === 1" class="text-primary">
                  <a @click="showModal(record)">{{
                    record.status ? record.status : "Hoạt động"
                  }}</a>
                </span>
                <span v-else class="text-danger">
                  <a @click="showModal(record)">{{
                    record.status ? record.status : "Tạm khóa"
                  }}</a>
                </span>
              </template>
            </template>
          </a-table>
        </div>
      </div>
    </a-card>
    <a-modal
      v-model:open="isModalVisible"
      title="Thay đổi tình trạng"
      @ok="() => updateStatus(selectedUser.id, selectedStatus)"
    >
      <a-select v-model:value="selectedStatus" style="width: 100%">
        <a-select-option
          v-for="status in statuses"
          :key="status.id"
          :value="status.id"
          >{{ status.name }}</a-select-option
        >
      </a-select>
    </a-modal>
  </div>
</template>

<script setup>
import { onMounted, ref, computed, inject } from "vue";

const tableHeight = inject('tableHeight');

const users = ref([]);
const isModalVisible = ref(false);
const selectedUser = ref(null);
const selectedStatus = ref(null);

const showModal = (user) => {
  isModalVisible.value = true;
  selectedUser.value = user;
  selectedStatus.value = user.status_id;
};

const columns = [
  {
    title: "STT",
    // dataIndex: 'id',
    key: "index",
    width: '60px',
  },
  {
    title: "username",
    dataIndex: "username",
    key: "username",
    width: '150px'
  },
  {
    title: "Email",
    dataIndex: "email",
    key: "email",
    width: '250px',
  },
  {
    title: "Avatar",
    dataIndex: "avatar",
    key: "avatar",
    width: '150px'
  },
  {
    title: "Tên",
    dataIndex: "name",
    key: "name",
    width: '250px'
  },
  {
    title: "Tình trạng",
    dataIndex: "status",
    key: "status",
    fixed: "right",
    width: "100px"
  },
];

// Search
import SearchForm from "@/components/SearchForm.vue";

const searchFilter = ref("");

const handleSearch = (search) => {
  searchFilter.value = search;
};

const filteredItems = computed(() => {
  return users.value.filter((item) => {
    const searchTerm = searchFilter.value.toLowerCase();
    return (
      item.username.toLowerCase().includes(searchTerm) ||
      item.email.toLowerCase().includes(searchTerm)
    );
  });
});
// ...

const apiUrl = inject("apiUrl");
console.log(`${apiUrl}/users`);
const getUser = () => {
  axios
    .get(`${apiUrl}/users`)

    .then(function (response) {
      // handle success
      users.value = response.data.data;
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    });
};

const statuses = ref([]);
const getStatuses = () => {
  axios
    .get(`${apiUrl}/userstatus`)
    .then((response) => {
      console.log("response userstatus:", response);
      statuses.value = response.data;
    })
    .catch(function (error) {
      console.log(error);
    });
};

const updateStatus = (userId, statusId) => {
  return axios
    .put(`${apiUrl}/users/${userId}/status`, { status_id: statusId })
    .then((response) => {
      console.log(response.data.message); // 'User status updated successfully'

      // Lấy dữ liệu người dùng đã cập nhật
      const updatedUser = response.data.data;

      // Cập nhật trạng thái và đường dẫn ảnh đầy đủ (nếu cần)
      const userIndex = users.value.findIndex((user) => user.id === userId);
      if (userIndex !== -1) {
        const userStatus = statuses.value.find(
          (status) => status.id === statusId
        );
        updatedUser.status = userStatus ? userStatus.name : "";

        // Kiểm tra và cập nhật đường dẫn ảnh đầy đủ
        if (!updatedUser.avatar.startsWith("http")) {
          updatedUser.avatar = `http://127.0.0.1:8000/storage/${updatedUser.avatar}`;
        }

        users.value.splice(userIndex, 1, updatedUser);
      }

      // Đóng modal sau khi cập nhật thành công
      isModalVisible.value = false;
    })
    .catch((error) => {
      console.error(error);
      // Xử lý lỗi ở đây
    });
};

onMounted(() => {
  getUser();
  getStatuses();
});
</script>
