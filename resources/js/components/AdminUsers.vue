<template>
  <v-app>
    <v-navigation-drawer 
      id="navigation-drawer"     
      enable-resize-watcher 
      app 
      v-model="drawer"
      :mini-variant="mini"
      mini-variant-width="116"
      fixed        
      mobile-break-point="0"
      class="green lighten-3"
    >
      <v-expansion-panel
          v-model="exp_panel"
          expand
          focusable
          popout
        >
          <v-expansion-panel-content       
            id="templates_group"
            class="green lighten-3"
          >          
            <v-btn icon @click.stop="sidebar('close_drawer')">
              <v-icon color="#435b71">cancel</v-icon>
            </v-btn>
            <v-btn icon v-if="mini" @click.stop="sidebar('mini')">
              <v-icon color="#435b71">arrow_right</v-icon>
            </v-btn>
            <v-btn icon v-else-if="!mini" @click.stop="sidebar('stand')" style="float:right">
              <v-icon color="#435b71">arrow_left</v-icon>
            </v-btn> 
          </v-expansion-panel-content>
          <v-expansion-panel-content  class="green lighten-3">        
            <v-icon 
              v-if="exp_panel[1]==true"
              slot="header" 
              color="#435b71"
            >
              view_stream
            </v-icon>
            <v-icon 
              v-if="exp_panel[1]==false" 
              slot="header"              
            >
              view_stream
            </v-icon>
            <div v-if="!mini" slot="header">Panel</div>
            <v-list dense>
                
            </v-list>
          </v-expansion-panel-content>
          <v-expansion-panel-content class="green lighten-3">
            <v-icon v-if="exp_panel[2]==true" slot="header" color="#435b71">visibility</v-icon>
            <v-icon v-if="exp_panel[2]==false" slot="header">visibility_off</v-icon>
            <div v-if="!mini" slot="header">View</div>
            
          </v-expansion-panel-content> 
      </v-expansion-panel>
    </v-navigation-drawer>
    
 <v-toolbar-side-icon style="position:fixed; top:-4px; left:20px;" @click.stop="sidebar('open_drawer')"></v-toolbar-side-icon>




 









  <v-layout justify-center row wrap mt-4>
    <v-flex xs10>
      <v-card>
      <v-card-title>
        <v-btn  color="error" fab medium title="Delete" @click="deleteUsers">
          <v-icon>delete_forever</v-icon>
        </v-btn>
        <v-btn color="warning" fab medium title="Edit" @click="editUsers">
          <v-icon>edit</v-icon>
        </v-btn>














<v-dialog v-model="dialog" max-width="500px">



        <v-btn slot="activator" color="success" fab medium title="Add" >
          <v-icon>person_add</v-icon>
        </v-btn>

          <!-- <v-btn  color="success" dark class="mb-2">New Item</v-btn> -->
          <v-card>
            <v-card-title>
              <span class="headline">Add new user</span>
            </v-card-title>
             
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                   <v-flex xs12>
                    <v-text-field 
                      v-model="new_first_name"
                      class="new_users_field"
                      label="First Name"
                      :rules="[rules.required]"
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field                       
                      v-model="new_last_name"
                      class="new_users_field"
                      label="Last Name"
                      :rules="[rules.required]"
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field                     
                      v-model="new_email"
                      label="Email"
                      class="new_users_field"
                      :rules="rules.emailMatch"
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field 
                      autofocus
                      v-model="new_pwd"
                      class="new_users_field"
                      label="Password"                      
                      :rules="[rules.required, rules.min]"                      
                    ></v-text-field>
                  </v-flex> 
                </v-layout>
              </v-container>
            </v-card-text>
  
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click="closeDialog">Cancel</v-btn>
              <v-btn color="blue darken-1" flat @click="saveUsers">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>


















        <v-btn fab medium title="Disable" @click="disableUsers">
          <v-icon>person_add_disabled</v-icon>
        </v-btn>

        <!-- <v-btn color="success" fab small title="Export to Excel" @click="onExport">
          <v-icon>import_export</v-icon>
        </v-btn> -->
        <v-spacer></v-spacer>

         <v-flex xs8 sm6 md4 lg3 lx2>
          <v-text-field        
            v-model="search"
            append-icon="search"
            label="Search"
            single-line
            hide-details
            @click="es_alert=false"
          ></v-text-field>
         </v-flex>
      </v-card-title>


          <v-data-table
            v-model="selected"
            :headers="headers"
            :items="obj_users"
            item-key="id"
            select-all
            class="elevation-5"
            :search="search"
           
          >           
            <template slot="items" slot-scope="props">
              <td >
                <v-checkbox               
                  v-model="props.selected"                 
                  color="success"             
                  hide-details                  
                  :data="props.item.id"
                  class="checkboxes"   
                 
                ></v-checkbox>
              </td>
              <td>{{ props.item.id }}</td>
              <td class='user_first_name' :data="props.item.first_name"><v-text-field v-model="props.item.first_name"></v-text-field></td>
              <td class='user_last_name' :data="props.item.last_name"><v-text-field v-model="props.item.last_name"></v-text-field></td>
              <td class='user_email' :data="props.item.email"><v-text-field v-model="props.item.email"></v-text-field></td>
              <td class='user_password' :data="props.item.password"><v-text-field v-model="props.item.password"></v-text-field></td>
              <td>{{ props.item.created_at }}</td>
              <td>{{ props.item.updated_at }}</td>
            </template>
              <v-alert 
                slot="no-results" 
                :value="true"
                color="error" 
                icon="warning"
              >
                Your search for "{{ search }}" found no results.
              </v-alert>
          </v-data-table>

      <v-alert
        :value="es_alert"
        :type="es_alert_type"       
        transition="scale-transition"
        @click="es_alert=false"
      >
        {{ es_alert_text }}
      </v-alert>
 </v-card>  
      </v-flex>
 </v-layout>



        
  </v-app>   
</template>

<script>
  export default {   
    data: () => ({
      rules: {
        required: value => !!value || 'Required.',
        min: value => value.length >= 3 || 'Min 3 characters',
        numeric: value => value > 0 || 'Enter the number',
        emailMatch: [
          v => !!v || 'E-mail is required',
          v => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
        ]
      },
      datas: {
        'sheet':[]
      },
      search: '',
      selected: [],
      es_alert: false,
      es_alert_type: 'success',  
      es_alert_text: 'Data was successfully changed.',   
      headers: [
        { text: 'ID', value: 'id' },
        { text: 'First Name', value: 'first_name' },
        { text: 'Last Name', value: 'last_name' },
        { text: 'Email', value: 'email' },
        { text: 'Password', value: 'password' },
        { text: 'Created At', value: 'created_at' },
        { text: 'Updated At', value: 'updated_at' },
      ],
      new_first_name: '',
      new_last_name: '',
      new_email: '',
      new_pwd: '',
      dialog: false,
      obj_users: [],
      drawer: false,
      clipped: false,
      mini: true,
      right: null,
      exp_panel: [true, true, true]     
    }),
    props: ['url'],
    mounted: function() {
      this.url = this._props.url;
    //  this.obj_users = JSON.parse(this.users);
   //   console.log(this.obj_users);
   //   console.log(this.rules.emailMatch);
    },   
    created: function(){
      this.getUsers();
    },
    methods: {
      esAlert: function(value, type, text){        
        this.es_alert = value;
        this.es_alert_type = type;
        this.es_alert_text = text;        
      },
      getUsers: function(){
        axios({ 
          method: "POST",
          url: (this.url + "/admin/getus"),
          data: {
            //  id: arrCheckboxes,
            name: 'users'
          }
        })
        .then(result => {
        //   location.reload();
          this.obj_users = result.data;
        //  console.log(this.obj_users)
        }).catch(error => {
            console.error(error)
        });

      },
      saveUsers: function(){
        let new_users_field = document.getElementsByClassName('new_users_field'),
            new_user = [],
            new_user_arr = [];

        new_user.push({
          'new_first_name': this.new_first_name,
          'new_last_name': this.new_last_name,
          'new_email': this.new_email,
          'new_pwd': this.new_pwd
        });

        for(let i=0; i<new_users_field.length; i++){
          if(new_users_field[i].classList.contains('error--text')){
            new_user_arr.push(i);          
          }
        }

        if(new_user_arr.length == 0){
          axios({ 
            method: "POST",
            url: (this.url + "/admin/users/store"),
            data: {
              user: new_user,
              action: 'add'
            }
          })
          .then(result => {
            this.getUsers();
            this.dialog = false;
          }).catch(error => {
            this.esAlert('false', 'error', 'Please fill in all required fields.');
            console.error(error);
          });
        } else {
          this.esAlert('false', 'error', 'Please fill in all required fields correctly.');
        }
      },
      editUsers: function(){
       // this.esAlert();
        let checkboxes = document.getElementsByClassName('checkboxes'),
            arrCheckboxes = [];
       
        for(let i = 0; i < checkboxes.length; i++) {
          if(checkboxes[i].classList.contains("v-input--is-label-active")) {
                arrCheckboxes.push({
                  'id': checkboxes[i].getAttribute('data'), 
                  'user_first_name': document.getElementsByClassName('user_first_name')[i].getAttribute('data'),
                  'user_last_name': document.getElementsByClassName('user_last_name')[i].getAttribute('data'),
                  'user_email': document.getElementsByClassName('user_email')[i].getAttribute('data'),
                  'user_password': document.getElementsByClassName('user_password')[i].getAttribute('data')
                });
          }         
        }

        axios({ 
          method: "POST",
          url: (this.url + "/admin/users/update"),
          data: {
            id: arrCheckboxes,
            action: 'update'
          }
        })
        .then(result => {
         // console.log(result.data.length);
          for(let i=0; i<result.data.length; i++){
            console.log(document.getElementsByClassName('user_first_name')[i].getAttribute('data'));
            console.log(result.data[i].user_first_name);
            if(document.getElementsByClassName('user_first_name')[i].getAttribute('data') !== result.data[i].first_name ){
              this.esAlert('true', 'success', 'Data was successfully changed.');
              this.getUsers();
            }
          }
        }).catch(error => {          
          this.esAlert('false', 'error', 'The Email has already been used.');
          console.error(error)
        });

     //   console.log(arrCheckboxes);
      },
      deleteUsers: function() {
        let checkboxes = document.getElementsByClassName('checkboxes');
        let arrCheckboxes = [];
       
        for(let i = 0; i < checkboxes.length; i++) {
          if(checkboxes[i].classList.contains("v-input--is-label-active")) {
            arrCheckboxes.push(checkboxes[i].getAttribute('data'));            
          }         
        }

        axios({ 
          method: "DELETE",
          url: (this.url + "/admin/destroy"),
          data: {
            id: arrCheckboxes,
            action: 'delete'
          }
        })
        .then(result => {
          this.esAlert('true', 'success', 'Data was successfully removed.');
          this.getUsers();
        }).catch(error => {
          this.esAlert('false', 'error', 'Unknown error');
          console.error(error)
        });
      },
      disableUsers: function() {

      }, 
      closeDialog () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
          }, 300)
      },





      onExport: function() {
        var sheetWS = XLSX.utils.json_to_sheet(this.datas.sheet) 
        var wb = XLSX.utils.book_new() // make Workbook of Excel

        XLSX.utils.book_append_sheet(wb, sheetWS, 'sheet') // sheetAName is name of Worksheet
        XLSX.writeFile(wb, 'vbe_received.xlsx') // name of the file is 'book.xlsx'
      },
      sidebar: function(val) {
        switch(val){
          case 'mini':
            this.mini = !this.mini;
            this.vbe_animation(document.getElementById('es_logo'),14,0,0.4);
            document.getElementById('navigation-drawer').style.width = "116px";
            document.getElementById('templates_group').style.display = 'block';
          break;
          case 'stand':
            this.mini = !this.mini;
            this.vbe_animation(document.getElementById('es_logo'),5,0,0.4);
            document.getElementById('navigation-drawer').style.width = "300px";
            document.getElementById('templates_group').style.display = 'block';
          break;
          case 'open_drawer':
          this.drawer = !this.drawer;
          if(document.getElementById('navigation-drawer').style.width == '116px') {
            this.vbe_animation(document.getElementById('es_logo'),5,0,0.4);
          } else {
            this.vbe_animation(document.getElementById('es_logo'),14,0,0.4);
          }
          break;
          case 'close_drawer':
            this.drawer = !this.drawer;
            this.vbe_animation(document.getElementById('es_logo'),2,0,0.4);
          break;
          default:
           console.log('miss');
          break;  
        }        
      },
      vbe_animation : function(elm,x,y,time){
          elm.style.webkitTransition = time +"s ease-in-out";
          elm.style.mozTransition = time +"s ease-in-out";
          elm.style.oTransition = time +"s ease-in-out";
          elm.style.transition= time +"s ease-in-out";
          elm.style.webkitTransform = "translate(" + x + "em,0)";
          elm.style.mozTransform = "translate(" + x + "em,0)";
          elm.style.oTransform = "translate(" + x + "em,0)";
          elm.style.transform = "translate(" + x + "em,0)";
      },  
    }
  }
</script>

<style>


[v-cloak] {
  display: none;
}

.img-mode{
  cursor: pointer;
  margin: 4px 4px 50px 4px;
}

.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: .5;
  position: absolute;
  width: 100%;
}

.aspire_ul{
  overflow: scroll;
  height: 100px;
  width: 400px;
}

.v-datatable > thead{
  background-color:#757575;
}

.v-datatable > thead > tr > th.column{ 
  color:white;
}


</style>
