import { ref } from 'vue';

// useAuth.js
const isLoggedIn = ref(localStorage.getItem('isLoggedIn') === 'true');

const setIsLoggedIn = (value) => {
  isLoggedIn.value = value;
  localStorage.setItem('isLoggedIn', value.toString());
};

export { isLoggedIn, setIsLoggedIn };