<script setup>
import axios from 'axios';
import { ref, onMounted, reactive, watch } from 'vue';
import { Form, Field, useResetForm } from 'vee-validate';
import UserListItem from './UserListItem.vue';
import * as yup from 'yup';
import { debounce } from 'lodash';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';



const form = ref(null);

const userIdBeingDeleted = ref(null);


//Get Users
const users = ref({'data': []});

const getUsers = (page = 1) => {
  setTimeout(function(){
    window.emitter.emit('changeLoaderStatus', true)
    axios.get(window.url + `api/users?page=${page}`, {
        params: {
          query: searchQuery.value
        }
      }).then(response =>{
        users.value  = response.data;
        window.emitter.emit('changeLoaderStatus', false)
      }).catch(errors =>{
        window.emitter.emit('changeLoaderStatus', false)
        toastr.error(errors.message);
    })
  }, 1000)
}

onMounted(() => {
  getUsers();
});


//Edit or Update handle

const editing = ref(false);

const formValues = ref();

const handleSubmit = (values, actions) => {
  if (editing.value) {
    updateUser(values, actions);
  }else {
    createUser(values, actions);
  }
}

//Add new user
const createUserModel = () => {
  editing.value = false;
  form.value.resetForm();  
  formValues.value = { id: '', name: '', email: '', password: ''};
  $('.userFormModal').modal('show')
}

//Edit new user
const editUser = (user) => {
  form.value.resetForm();
  editing.value = true;
  formValues.value = {
    id: user.id,
    name: user.name,
    email: user.email,
  };
  $('.userFormModal').modal('show')
}

//Create user schema 
const createUserSchema = yup.object({
  name: yup.string().required(),
  email: yup.string().email().required(),
  password: yup.string().required().min(8),
});


//Edit User schema
const editUserSchema = yup.object({
  name: yup.string().required(),
  email: yup.string().email().required(),
  password: yup.string().when((password, schema) => {
    return password ? schema.required().min(8) : schema;
  }),
});


//Create User
const createUser = (values, { resetForm, setErrors }) => {
  axios.post(window.url + 'api/users', values).then((response) => {    
    users.value.data.unshift(response.data);
    form.value.resetForm();
    $('.userFormModal').modal('hide')
    toastr.success('User Added successfully');
    swal("", 'User Added successfully', "success");    
  }).catch((error) => {
    if (error.response.data.errors) {      
      setErrors(error.response.data.errors);
    }else{
      toastr.error(error);
    }
  })
};


//Update user
const updateUser = (values, { setErrors }) => {
  axios.put(window.url + 'api/users/' + formValues.value.id, values)
  .then((response) => {
     const index = users.value.data.findIndex(user => user.id === response.data.id);
      users.value.data[index] = response.data;   
      form.value.resetForm();
      $('.userFormModal').modal('hide')
      toastr.success('User updated successfully!');
      swal("", 'User updated successfully', "success");
  }).catch((error) => {
    if (error.response.data.errors) {      
      setErrors(error.response.data.errors);
    }else{
      toastr.error(error);
    }
  });
}


//Confirm User deletion
const confirmUserDeletion = (id) => {
  userIdBeingDeleted.value = id;
  swal({
    title: 'Are you Sure ?',
    text: 'You want to delete',
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then(function (isConfirm) {
    if(isConfirm === true) {
      axios.delete(window.url +`api/users/${userIdBeingDeleted.value}`)
        .then(() => {
          toastr.success('User deleted successfully!');
          swal("", 'User deleted successfully', "success");
          users.value.data = users.value.data.filter(user => user.id !== userIdBeingDeleted.value);
      });
    }
  });
};

//Event
const userDeleted = (userId) =>{
  users.value =  users.value.filter(user => user.id !== userId)
}

//Search Query 
const searchQuery = ref(null); 

watch(searchQuery, debounce(() => {
  getUsers();
}, 300))


//Select bulk delete
const selectedUsers = ref([]);
const toggleSelection = (user) => {
  const index = selectedUsers.value.indexOf(user.id);
  if (index === -1) {
    selectedUsers.value.push(user.id);
  }else {
    selectedUsers.value.splice(index, 1);
  }
};

const selectAll = ref(false);
const selectAllUsers = () => {
  if (selectAll.value) {
    selectedUsers.value = users.value.data.map(user => user.id);
  }else {
    selectedUsers.value = [];
  }
}

const bulkDelete = () => {  
  swal({
    title: 'Are you Sure ?',
    text: 'You want to delete',
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then(function (isConfirm) {
    if(isConfirm === true) {
      axios.delete(window.url +'api/users', {
        data: {
          ids: selectedUsers.value
        }
      }).then(response => {
          users.value.data = users.value.data.filter(user => !selectedUsers.value.includes(user.id));
          selectedUsers.value = [];
          selectAll.value = false;
          toastr.success(response.data.message);
      });
    }
  });   
};

</script>
<template>
<div class="page-header">
  <div class="page-title">
     <h4>Users List</h4>
     <h6>Manage Users List</h6><br/>
    <div v-if="selectedUsers.length > 0">
      <button @click="bulkDelete" type="button" class="ml-2 mb-2 btn btn-danger">
        <i class="fa fa-trash mr-1"></i>
          Delete Selected 
      </button>
      <span class="ml-2" >Selected {{ selectedUsers.length }} users</span>
    </div>
  </div>
  <div class="page-btn">
     <button @click="createUserModel" class="btn btn-added"><img :src="url+'assets/img/icons/plus.svg'" alt="img" class="me-1">Add New Users</button>
  </div>
</div>
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between">
      <div></div>
      <div><input type="text" v-model="searchQuery" class="form-control"  placeholder="Search.."></div>
    </div>
     <div class="table-top"> </div>     
     <div >
        <table class="table table-nowrap mb-0">
           <thead>
              <tr>
                 <th><input type="checkbox" v-model="selectAll" @change="selectAllUsers" /></th>
                 <th style="width: 10px">#</th>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Role</th>
                 <th>Created By</th>
                 <th>Action</th>
              </tr>
           </thead>
            <tbody v-if="users.data.length > 0">
                <UserListItem v-for="(user, index) in users.data"
                  :key="user.id"
                  :user=user :index=index
                  @edit-user="editUser"  
                  @confirm-user-deletion="confirmUserDeletion" 
                  @toggle-selection="toggleSelection"
                  :select-all="selectAll" /> <!-- Listen event emit -->
            </tbody>
            <tbody v-else>
                <tr>
                  <td colspan="6" class="text-center">No results found...</td>
                </tr>
           </tbody>           
        </table>
     </div>
  </div>
  <div class="d-flex justify-content-between">
  <div></div>
  <div>
  <Bootstrap5Pagination :data="users" @pagination-change-page="getUsers" /> <br/></div>
  </div>
</div>


<!-- User Model -->
<div class="modal fade userFormModal" tabindex="-1" aria-labelledby="employeeFeedBack" aria-hidden="true">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">
              <span v-if="editing">Edit User</span>
              <span v-else>Add New User</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editUserSchema : createUserSchema"  v-slot="{ errors }" :initial-values="formValues">
            <input type="hidden" name="id" class="service_id">
            <div class="modal-body">
              <div class="row">
                 <div class="col-lg-12 col-sm-12 col-12">
                    <div class="form-group">
                       <label>Name</label>
                       <Field name="name" type="text" class="form-control" 
                                :class="{ 'is-invalid': errors.name  }" />

                        <span class="invalid-feedback">{{ errors.name }}</span>        
                    </div>
                 </div> 
                 <div class="col-lg-12 col-sm-12 col-12">
                    <div class="form-group">
                       <label>Email</label>
                       <Field name="email" type="email" class="form-control"  :class="{ 'is-invalid': errors.email  }" />

                       <span class="invalid-feedback">{{ errors.email }}</span>
                    </div>
                 </div> 
                 <div class="col-lg-12 col-sm-12 col-12">
                    <div class="form-group">
                       <label>Password</label>
                       <Field name="password" type="password" class="form-control" :class="{ 'is-invalid': errors.password  }" />

                       <span class="invalid-feedback">{{ errors.password }}</span>
                    </div>
                 </div>                   
              </div>
           </div>
           <div class="modal-footer">
              <button type="submit" class="btn btn-submit">Submit</button>
           </div>
         </Form>               
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