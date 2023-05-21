<script setup>
import { formatDate } from '../../helper.js';

import { ref } from 'vue';
import axios from 'axios';

const userIdBeingDeleted = ref(null);

//Event 
const emit = defineEmits(['userDeleted','editUser', 'confirmUserDeletion']);

//pass data on user list page component it is props 
const props = defineProps({
  user: Object,
  index: Number,
  selectAll: Boolean,
});

//Select role constant
const roles = ref([
  { name: 'ADMIN', value: 1 },{ name: 'USER', value: 2,}
]);

const changeRole = (user, role) => {
  axios.patch(window.url +`api/users/${user.id}/change-role`, {
    role: role,
  }).then(() => {
    toastr.success('Role changed successfully!');
  })
};

//Edit user event another approach
//const editUser = (user) => {
  //emit('editUser', user);
//}

//Bulk delete event
const toggleSelection = () => {
  emit('toggleSelection', props.user);
}

</script>
<template>
<tr >
 <td><input type="checkbox" :checked="selectAll" @change="toggleSelection" /></td>
 <td>{{ index + 1 }}</td>
 <td>{{ user.name }}</td>
 <td>{{ user.email }}</td>
 <td>
  <select class="form-control" @change="changeRole(user, $event.target.value)">
    <option v-for="role in roles" :value="role.value" :selected="(user.role === role.name)">{{ role.name }}</option>
  </select>
 </td>
 <td>{{ formatDate(user.created_at) }}</td>
 <td>
    <!-- <a class="me-3" href="javascript:void(0)" @click.prevent="editUser(user)"> -->
    <a class="me-3" href="javascript:void(0)" @click.prevent="$emit('editUser', user)">
    <img :src="url+'assets/img/icons/edit.svg'" alt="img">
    </a>
   <!-- <a class="confirm-text" href="javascript:void(0);" @click.prevent="confirmUserDeletion(user.id)"> -->
    <a class="confirm-text" href="javascript:void(0);" @click.prevent="$emit('confirmUserDeletion', user.id)">
    <img :src="url+'assets/img/icons/delete.svg'" alt="img">
    </a>
 </td>
</tr>
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