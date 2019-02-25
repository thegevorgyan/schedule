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
            <div v-if="!mini" slot="header">Patterns</div>
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
      <v-flex xs8 offset-xs2 sm9 offset-sm2 md6 offset-md0>
        <v-select              
          id="tsk_name"
          color="green darken-1"
          label="Tasks Name"
          :items= "task_types" 
          v-model="setselecttype"
          item-text="name"
          item-value="val"
          :rules="[rules.required]"
          @change="selectTaskTypes($event)"
          autofocus
        ></v-select>
        <v-text-field
          id="comments"
          color="green darken-1"
          label="Comments"
          v-model="comments"
        ></v-text-field>
        <v-select     
          id="hour"
          color="green darken-1"
          :data="setselecthours" 
          label="Hour(s)"
          :items= "hours" 
          v-model="setselecthours"
          item-text="val"
          @change="selectHours($event)"
        ></v-select>
        <v-select     
          id="minute"
          color="green darken-1"
          :data="setselectminutes" 
          label="Minute(s)"
          :items= "minutes" 
          v-model="setselectminutes"
          item-text="val"
          @change="selectMinutes($event)"
        ></v-select>
        <v-menu
          v-model="menu2"
          :close-on-content-click="false"
          :nudge-right="40"
          lazy
          transition="scale-transition"
          offset-y
          full-width
          min-width="290px"
        >
          <v-text-field
            color="green darken-1"
            slot="activator"
            v-model="date"
            label="Date"
            prepend-icon="event"
            readonly
          ></v-text-field>
          <v-date-picker color="green darken-1" v-model="date" @input="menu2 = false"></v-date-picker>
        </v-menu>
        <v-btn 
          id="save_info"
          color="success"
          class="upload_trig"
          large
          @click="editTask"
        >
          <v-icon left>save</v-icon>
          Save
        </v-btn>
      </v-flex>   
    </v-layout>
  </v-app>   
</template>

<script>
  export default {   
    data: () => ({
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      modal: false,
      menu2: false,
      drawer: false,
      clipped: false,
      mini: true,
      right: null,
      exp_panel: [true, true, true],
      es_alert: false,
      es_alert_type: 'success',  
      es_alert_text: 'Data was successfully changed.', 
      task_types: [  
                {'name':'Task1','val':'Task1'}, 
                {'name':'Task2','val':'Task2'},
                {'name':'Task3','val':'Task3'},
                {'name':'Task4','val':'Task4'},
                {'name':'Task5','val':'Task5'},
                {'name':'Task6','val':'Task6'}
             ],
      select_task_type: {'val':'Task1'},
      setselecttype: null,
      setselecthours: null,
      setselectminutes: null,
      comments: '',
      hours: [],
      select_hours: {'val':'1'},
      minutes: [],
      select_minutes: {'val':'5'},
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
    }),
    props: ['url', 'tasksrow'],
    mounted: function() {
      this.url = this._props.url;
      this.task = JSON.parse(this.tasksrow)[0];
      for(let i=0; i<=8; i++){ this.hours.push({'name': i, 'val': i});}
      for(let i=0; i<=55; i+=5){ this.minutes.push({'name': i, 'val': i});}
      this.setselecttype = this.task.task_name;
      this.comments = this.task.comments;
      this.setselecthours = this.task.hours;
      this.setselectminutes = this.task.minutes;
      this.date = this.task.day;
    },   
    methods: {
      esAlert: function(value, type, text){        
        this.es_alert = value;
        this.es_alert_type = type;
        this.es_alert_text = text;        
      },
      editTask: function() {
       axios({ 
          method: "POST",
          url: (this.url + "/employee/tasks/update/" + this.task.id),
          data: {
            'tsk_name': this.setselecttype,
            'comments':this.comments,
            'hour': this.setselecthours,
            'minute': this.setselectminutes,
            'date': this.date
          }  
        })
        .then(result => {
          window.location.href = this.url + "/employee/tasks";
        }, error => {          
          this.esAlert('false', 'error', 'Please fill in all required fields.');
          console.error(error);
        });       
      },
      selectTaskTypes: function(val) {
        this.select_task_type = val;
      },
      selectHours: function(val) {
        this.select_hours = val;
      },
      selectMinutes: function(val) {
        this.select_minutes = val;
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

</style>
