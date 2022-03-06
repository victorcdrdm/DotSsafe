import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/HomeView.vue'
import Technologies from '../views/TechnologiesView.vue'
import Members from '../views/MembersView.vue'
import Contributions from '../views/ContributionView'
import Project from '../views/ProjectView'
import Technology from '../views/TechnologyView'
import Member from '../views/MemberView'

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
    component: Members
  },
  {
    path: '/contributions',
    name: 'Contributions',
    component: Contributions
  },
  {
    path: '/projet/:name',
    name: 'Project',
    component: Project
  },
  {
    path: '/technologie/:name',
    name: 'Technology',
    component: Technology,
  },
  {
    path: '/membre/:name',
    name: 'Member',
    component: Member 
  }

]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
