import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/HomeView.vue'
import Technologies from '../views/TechnologiesView.vue'
import Member from '../views/MembersView.vue'
import Contributions from '../views/ContributionView'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Projects',
    component: Home
  },
  {
    path: '/technologies',
    name: 'Technologies',
    component: Technologies
  },
  {
    path: '/membres',
    name: 'Membres',
    component: Member
  },
  {
    path: '/contributions',
    name: 'Contributions',
    component: Contributions
  }

]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
