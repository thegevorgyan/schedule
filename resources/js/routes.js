import VueRouter from 'vue-router';
//import Logs from './components/Logs.vue';
//import Profile from './components/Profile.vue';

//import AdminStat from './components/AdminUsers.vue';
//import AdminStor from './components/AdminStor.vue';
/*
const Attractions = { template: '<div>Attractions</div>' }
const Breakfast = { template: '<div>Breakfast</div>' }
const Meat = { template: '<div>Meat</div>' }
const Sushi = { template: '<div>Sushi</div>' }

const routes = [
  { path: '/', component: Attractions },
  { path: '/breakfast', component: Breakfast },
  { path: '/meat', component: Meat },
  { path: '/sushi', component: Sushi },
]

*/





export default new VueRouter({

   /* routes: [
        {
            name: 'stat',
            path: '/stat',
            component: AdminStat
           
        },
        {
            name: 'stor',
            path: '/stor',
            component: AdminStor
        }
    ],*/
    mode: 'history'
});
