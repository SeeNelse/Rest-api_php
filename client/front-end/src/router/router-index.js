import Vue from 'vue'
import Router from 'vue-router'
import CarsList from '@/containers/CarsList'
import CarDetail from '@/containers/CarDetail'
import AdvancedSearch from '@/containers/AdvancedSearch'
import Profile from '@/containers/Profile'
import Order from '@/containers/Order'
import NoAccess from '@/containers/NoAccess'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'CarsList',
      component: CarsList
    },
    {
      path: '/car/:id',
      name: 'CarDetail',
      component: CarDetail
    },
    {
      path: '/advanced-search',
      name: 'AdvancedSearch',
      component: AdvancedSearch
    },
    {
      path: '/advanced-search-result',
      name: 'AdvancedSearchResult',
      component: CarsList
    },
    {
      path: '/profile',
      name: 'Profile',
      component: Profile
    },
    {
      path: '/order',
      name: 'Order',
      component: Order
    },
    {
      path: '/no-access',
      name: 'NoAccess',
      component: NoAccess
    },
  ]
})
