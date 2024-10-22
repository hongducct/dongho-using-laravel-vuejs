import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import SignIn from '../views/SignIn.vue'
import Upload from '../views/Upload.vue'
import DetailProduct from '../views/DetailProduct.vue'
import SignUp from '../views/SignUp.vue'
import Test from '../views/Test.vue'
import Profile from '../views/Profile.vue'
import Checkout from '@/views/Checkout.vue'
import SearchView from '@/views/SearchView.vue'
import LienHe from '../views/LienHe.vue'
import admin from './admin.js'
import customer from './customer.js'
import payment from '@/views/checkout/payment/index.vue'
// import paymentSuccess from '@/views/checkout/payment/success.vue'
import donghonam from '@/views/products/donghonam/index.vue'
import donghonu from '@/views/products/donghonu/index.vue'
import donghothongminh from '@/views/products/donghothongminh/index.vue'

import  { isLoggedIn, setIsLoggedIn } from '../views/useAuth'

const routes = [
  { path: '/', component: HomeView },
  { path: '/signin', component: SignIn },
  { path: '/upload', component: Upload },
  { path: '/product/:id', component: DetailProduct, name: 'ProductDetail'},
  { path: '/signup', component: SignUp },
  { path: '/test', component: Test },
  { path: '/profile', component: Profile },
  { path: '/checkout', component: Checkout},
  { path: '/search', component: SearchView, name: 'SearchView'},
  { path: '/lienhe', component: LienHe},
  { path: '/checkout/payment', component: payment},
  { path: '/donghonam', component: donghonam},
  { path: '/donghonu', component: donghonu},
  { path: '/donghothongminh', component: donghothongminh},
  { path: '/:pathMatch(.*)*', component: HomeView },
  admin,
  customer,
]


const router = createRouter({
  history: createWebHistory(),
  routes,
})

// router.beforeEach((to, from, next) => {
//   setIsLoggedIn(false);
//   localStorage.removeItem('user')
//   console.log(localStorage)
// })

export default router
