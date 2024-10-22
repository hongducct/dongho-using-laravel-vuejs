<template>
  <div v-if="showEmailModal" class="fixed inset-0 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 shadow-lg">
      <h2 class="text-lg font-bold mb-4">Cập nhật email</h2>
      <input
        v-model="newEmail"
        type="email"
        class="border rounded-md p-2 mb-4 w-full"
        placeholder="Nhập email mới"
      />
      <div class="flex justify-end">
        <button
          class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2"
          @click="updateEmail"
        >
          Lưu
        </button>
        <button
          class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md"
          @click="closeEmailModal"
        >
          Đóng
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  showEmailModal: Boolean,
});

const emit = defineEmits(['update:showEmailModal', 'updateEmail']);

const newEmail = ref('');

const updateEmail = () => {
  // Thực hiện logic cập nhật email ở đây
  emit('updateEmail', newEmail.value);
  newEmail.value = '';
  emit('update:showEmailModal', false);
};

const closeEmailModal = () => {
  emit('update:showEmailModal', false);
}
</script>