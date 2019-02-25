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
            <v-flex xs10 sm5 md4 lg4 xl3>
              <v-autocomplete
                :items="selectEmail"           
                v-model="employee"
                label="Choose Employee"
                @change="getSchedule(employee)"
              ></v-autocomplete>
              <v-card class="green darken-1">
                <span class="white--text">{{ employeeFullName }}</span>
              </v-card>
            </v-flex>
            <v-flex xs2 sm2 md4 lg4 xl6>              
              <v-btn
                v-if="employee!=null"
                color="success" 
                fab
                small
                title="Export to Excel"
                @click="onExport"
                >
                  <v-icon>import_export</v-icon>
              </v-btn> 
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs10 sm5 md4 lg4 xl3  v-if="employee!=null">
              <v-select
                :items="headers"           
                v-model="search_catergory"
                label="Search by category" 
                @change="searchTask(employee)"          
              ></v-select>    
              <v-text-field           
                v-model="search"
                append-icon="search"
                label="Search"           
                hide-details
                @keyup="searchTask(employee)"
              ></v-text-field>
            </v-flex>          
          </v-card-title>
          <v-data-table    
            :headers="headers"
            :items="obj_tasks"
            item-key="id"
            class="elevation-5"
            :search="search"           
          >           
            <template slot="items" slot-scope="props">
              <td>{{ props.item.task_name }}</td>
              <td>{{ props.item.comments }}</td>
              <td>{{ props.item.hours }}</td>
              <td>{{ props.item.minutes }}</td>
              <td>{{ props.item.day }}</td>
            </template>
          </v-data-table>
          <v-alert
            :value="es_alert"
            :type="es_alert_type"       
            transition="scale-transition"
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
      employee: null,   
      employeeFullName: '',  
      selectEmail: [],    
      obj_tasks: [],
      employees: [],
      rules: {
        required: value => !!value || 'Required.',
        min: value => value.length >= 3 || 'Min 3 characters',
        numeric: value => value > 0 || 'Enter the number',
        select: value => value >= 0 || 'Select from the list',
        emailMatch: [
          v => !!v || 'E-mail is required',
          v => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
        ]
      },
      datas: {
        'sheet':[]
      },
      search: '',  
      es_alert: false,
      es_alert_type: 'success',
      es_alert_text: 'Data was successfully changed.',
      headers: [
        { text: 'Task Name', value: 'task_name' },
        { text: 'Comments', value: 'comments' },
        { text: 'Hour(s)', value: 'hours' },
        { text: 'Minute(s)', value: 'minutes' },
        { text: 'Date', value: 'day' },
      ],
      search_catergory: '',
      new_first_name: '',
      new_last_name: '',
      new_email: '',
      new_pwd: '',
      dialog: false,     
      drawer: false,
      clipped: false,
      mini: true,
      right: null,
      exp_panel: [true, true, true]     
    }),
    props: ['url'],
    mounted: function() {
      this.url = this._props.url;
      this.search_catergory = this.headers[0].value;
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
          url: (this.url + "/admin/schedule/getus"),
          data: {
            name: 'users'
          }
        })
        .then(result => {          
          for(let i=0; i<result.data.length; i++){
            this.selectEmail.push({ text: result.data[i].email, fullname: result.data[i].first_name });     
          }
          this.employees = result.data;
        }).catch(error => {
            console.error(error);
        });
      },
      getSchedule: function(val){
        axios({ 
          method: "POST",
          url: (this.url + "/admin/schedule/getsch"),
          data: {
            email: val,
            key: false,
          }
        })
        .then(result => {
          this.obj_tasks = result.data;
          this.datas.sheet = this.obj_tasks;
          for(let i=0; i<this.employees.length; i++){
            if(this.employees[i].email === val){
              this.employeeFullName = this.employees[i].first_name + ' ' + this.employees[i].last_name;
            }
          }          
        }).catch(error => {
            console.error(error);
        });
      },
      searchTask: function(val){
        let search = false;
        this.search.trim() != '' ? search = this.search : search = false;
        axios({
          method: "POST",
          url: (this.url + "/admin/schedule/getsch"),
          data: {
            email: val,
            key: search,
            category: this.search_catergory
          }
        })
        .then(result => {
          this.obj_tasks = result.data;
          this.datas.sheet = this.obj_tasks;
        if(this.obj_tasks.length < 1){
            this.esAlert('false', 'error', 'Your search for ' + this.search + ' by category ' + this.search_catergory  + ' found no results.');
          }else{
            this.es_alert=false;
          }              
        }).catch(error => {
            console.error(error);
        });
      },
      onExport: function() {
        var sheetWS = XLSX.utils.json_to_sheet(this.datas.sheet) 
        var wb = XLSX.utils.book_new() // make Workbook of Excel
        XLSX.utils.book_append_sheet(wb, sheetWS, 'sheet') // sheetAName is name of Worksheet
        XLSX.writeFile(wb, this.employee + '.xlsx') // name of the file is 'book.xlsx'
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
