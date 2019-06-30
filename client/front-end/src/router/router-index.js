import Vue from 'vue'
import Router from 'vue-router'
import CarsList from '@/containers/CarsList'
import CarDitail from '@/containers/CarDitail'
import AdvancedSearch from '@/containers/AdvancedSearch'

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
      name: 'CarDitail',
      component: CarDitail
    },
    {
      path: '/advanced-search',
      name: 'AdvancedSearch',
      component: AdvancedSearch
    },
  ]
})
