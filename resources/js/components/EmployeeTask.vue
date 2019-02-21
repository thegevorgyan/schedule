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
          <!-- <td>
            <v-btn color="info" fab small title="Get Code" @click="getcodeWebsite(props.item.key)">
              <v-icon>code</v-icon>
            </v-btn>
          </td> -->
        </tr>
      </template> 
    </v-data-table>
    <v-dialog
      v-model="dialog_getcode"
      width="580"
    >  
      <v-card>
        <v-card-title
          class="headline blue-grey lighten-4"
        >
          Get Code
        </v-card-title>
        <v-card-text>
            Please copy and place this code on every page of your webite right after opening the &#60;body&#62; tag.
        <br>    
            To do so, you would usually place this code in header.html or header.php file.
        </v-card-text>
        <v-textarea         
          outline
          :value="key"            
          max-height="120" 
          no-resize     
          style="color:#435b71"               
        ></v-textarea>
        <v-divider></v-divider>  
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn           
            color="primary"
            flat
            @click="dialog_getcode = false"
          >
           <v-icon>cancel</v-icon>
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
      dialog_getcode: false,
      pagination: {
        sortBy: 'name'
      },
      selected: [],
      id: '',
      key: '',
      headers: [
        { text: 'Task Name', align: 'left', value: 'task_name' },
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
      getcodeWebsite: function(key){
        this.dialog_getcode = true;
        this.key = '<script src="' + this.url + '/cache/' + key +  '.js" type="text/javascript"><\/script>';
     //   this.key = '<script src="https://dev.aspirevapeco.com/cache/' + key +  '.js" type="text/javascript"><\/script>';
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
