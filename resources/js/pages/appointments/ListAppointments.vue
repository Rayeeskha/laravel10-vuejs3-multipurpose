<script setup>
import { onMounted, ref, computed,watch } from 'vue';
import axios from 'axios';
import { debounce } from 'lodash';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

//Get Appointment
const selectedStatus = ref();
const appointments = ref([]);

const searchQuery = ref(null);

const getAppointments = (page = 1, status="") => {    
    window.emitter.emit('changeLoaderStatus', true)
    selectedStatus.value = status;
    const params = {};
    if (status) {
        params.status = selectedStatus.value;        
    }
    params.query = searchQuery.value;
    axios.get(window.url + `api/appointments?page=${page}`, {
        params: params,
    }).then((response) => {
        window.emitter.emit('changeLoaderStatus', false)
        appointments.value = response.data;

    })
};

watch(searchQuery, debounce(() => {
  getAppointments();
}, 300))

//get Appointment status
const appointmentStatus = ref([]);
const getAppointmentStatus = () => {
    axios.get(window.url + 'api/appointment-status')
        .then((response) => {
            appointmentStatus.value = response.data;
        })
};

//Total Appointment Count
const appointmentsCount = computed(() => {
    return appointmentStatus.value.map(status => status.count).reduce((acc, value) => acc + value, 0);
});


//Delete Appointment
const deleteAppointment = (id) => {
    swal({
        title: 'Are you Sure ?',
        text: 'You want to delete this Appointment ',
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((isConfirm) => {
        if (isConfirm === true) {
            axios.delete(window.url +`api/appointments/${id}`)
                .then((response) => {
                    appointments.value.data = appointments.value.data.filter(appointment => appointment.id !== id);
                    toastr.success('Deleted successfully!');
                    swal("", 'Appointment deleted successfully', "success");
                });
        }
    })
};



onMounted(() => {
    getAppointments();
    getAppointmentStatus();
});
</script>

<template>
<div class="page-header">
  <div class="page-title">
    <h4>Manage Appointment List</h4>
  </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between mb-2" >
                <div>
                    <router-link to="/admin/appointments/create">
                        <button class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add New Appointment</button>
                    </router-link>
                </div>
                <div class="btn-group" style="background:white">
                    <button @click="getAppointments('','')" type="button" class="btn"
                        :class="[typeof selectedStatus === 'undefined' ? 'btn-secondary' : 'btn-default']">
                        <span class="mr-4">All</span>
                        <span class="badge badge-pill bg-info">{{ appointmentsCount }}</span>
                    </button>

                    <button v-for="status in appointmentStatus" @click="getAppointments('',status.value)" type="button"
                        class="btn" :class="[selectedStatus === status.value ? 'btn-secondary' : 'btn-default']">
                        <span class="mr-1">{{ status.name }}</span>
                        <span class="badge badge-pill" :class="`bg-${status.color}`">{{ status.count }}</span>
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div></div>
                      <div><input type="text" v-model="searchQuery" class="form-control"  placeholder="Search.."></div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(appointment, index) in appointments.data" :key="appointment.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ appointment.client.first_name }} {{ appointment.client.last_name }}</td>
                                <td>{{ appointment.start_time }}</td>
                                <td>{{ appointment.end_time }}</td>
                                <td>
                                    <span class="badge" :class="`bg-${appointment.status.color}`">{{
                                                appointment.status.name }}</span>
                                </td>
                                <td>
                                  <router-link :to="`/admin/appointments/${appointment.id}/edit`" class="me-3" >
                                    <img :src="url+'assets/img/icons/edit.svg'" alt="img">
                                  </router-link>
                                  <a class="confirm-text" href="javascript:void(0);" @click.prevent="deleteAppointment(appointment.id)">
                                    <img :src="url+'assets/img/icons/delete.svg'" alt="img">
                                  </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between">
                  <div></div>
                  <div>
                  <Bootstrap5Pagination :data="appointments" @pagination-change-page="getAppointments" /> <br/></div>
                </div>
            </div>           
        </div>
    </div>
</div>
</template>

<script>
export default {
	data(){
		return {
			url:window.url + 'backend/',
		}
	},
}
</script>