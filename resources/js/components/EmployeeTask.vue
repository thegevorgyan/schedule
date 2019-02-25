<template>
  <v-app>
    <v-data-table
      v-model="selected"
      :headers="headers"
      :items="obj_tasks"
      :pagination.sync="pagination"
      select-all
      item-key="id"
      class="elevation-4"
    >
      <template slot="headers" slot-scope="props">
        <tr>
          <th
            v-for="header in props.headers"
            :key="header.text"
            :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
            @click="changeSort(header.value)"
          >
            <v-icon small>arrow_upward</v-icon>
            {{ header.text }}
          </th>
        </tr>        
        <tr>
          <td colspan="4"></td>
          <td>
            <v-btn color="success" fab small title="Add" @click="addTask">
              <v-icon color="#FFFFFF">note_add</v-icon>
            </v-btn>
          </td> 
        </tr>
      </template>    
      <template slot="items" slot-scope="props">
        <tr>
          <td>{{ props.item.task_name }}</td>
          <td>{{ props.item.comments }}</td>
          <td>{{ props.item.hours }}</td>
          <td>{{ props.item.minutes }}</td>
          <td>{{ props.item.day }}</td>        
          <td>
            <v-btn color="warning" fab small title="Edit" @click="editWebsite(props.item.id)">
              <v-icon>edit</v-icon>
            </v-btn>
          </td>
          <td>
            <v-btn color="error" fab small title="Delete" @click="openDeleteWebsite(props.item.id)">
              <v-icon>delete_forever</v-icon>
            </v-btn>
          </td>
        </tr>
      </template> 
    </v-data-table>  
    <v-dialog v-model="dialog_delete" persistent max-width="290">
      <v-card>
        <v-card-title        
          class="headline blue-grey lighten-4"
        >          
          Delete
        </v-card-title>
        <v-card-text>Are you sure you want to delete this entry?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>          
          <v-btn color="error" flat @click="deleteWebsite(id)">
            <v-icon>delete_forever</v-icon>
            Delete
          </v-btn>
          <v-btn flat @click="dialog_delete = false">
            <v-icon>cancel</v-icon>
            Cancel
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>   
</template>

<script>  
  export default {   
    data: () => ({
      dialog_delete: false,
      pagination: {
        sortBy: 'name'
      },
      selected: [],
      id: '',
      key: '',
      headers: [
        { text: 'Task Name', align: 'left', value: 'task_name' },
        { text: 'Comments', value: 'comments' },
        { text: 'Hours', value: 'hours' },
        { text: 'Minutes', value: 'minutes' },
        { text: 'Day', value: 'day' },
        { text: 'Add/Edit'},
        { text: 'Delete'},
      ],
      obj_tasks: []
    }),
    props: ['url', 'username', 'tasks'],
    mounted: function() {
      this.url = this._props.url;
      this.username = this._props.username;
      this.obj_tasks = JSON.parse(this.tasks);
      console.log(this.obj_tasks);
    },
    methods: {
      addTask: function(){
        window.location.href = this.url + '/employee/tasks/add';
      },
      editWebsite: function(val){
        window.location.href = this.url + '/employee/tasks/edit/' + val;
      },
      openDeleteWebsite: function(val){
        this.dialog_delete = true;
        this.id = val        
      },
      deleteWebsite: function(val){
        axios({
          method: "POST",
          url: (this.url + "/employee/tasks/destroy"),
          data: {
            'id': val,
          }
        })
        .then(result => {
          this.dialog_delete = false;
          location.reload();
        }, error => {
          console.error(error);
        }); 
      },
      toggleAll () {
      if (this.selected.length) this.selected = []
      else this.selected = this.desserts.slice()
      },
      changeSort (column) {
        if (this.pagination.sortBy === column) {
          this.pagination.descending = !this.pagination.descending
        } else {
          this.pagination.sortBy = column
          this.pagination.descending = false
        }
      }
    }
  }
</script>

<style>
[v-cloak] {
  display: none;
}
</style>
