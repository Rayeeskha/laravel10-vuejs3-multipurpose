import Dashboard from './components/Dashboard.vue'
import ListAppointments from './pages/appointments/ListAppointments.vue'
import AppointmentForms from './pages/appointments/AppointmentForms.vue'
import UserList from './pages/users/UserList.vue';
import UpdateSettings from './pages/settings/UpdateSettings.vue'
import UpdateProfile from './pages/profile/UpdateProfile.vue'

export default [
	{
		path:'/admin/dashboard',
		name:'admin.dashboard',
		component:Dashboard,
	},
	{
		path:'/admin/appointments',
		name:'admin.appointments',
		component:ListAppointments,
	},
	{
		path:'/admin/appointments/create',
		name:'admin.appointments.create',
		component:AppointmentForms,
	},
	{
		path:'/admin/appointments/:id/edit',
		name:'admin.appointments.edit',
		component:AppointmentForms,
	},
	{
		path:'/admin/users',
		name:'admin.users',
		component:UserList,
	},
	{
		path:'/admin/settings',
		name:'admin.settings',
		component:UpdateSettings,
	},
	{
		path:'/admin/profile',
		name:'admin.profile',
		component:UpdateProfile,
	},
	
]