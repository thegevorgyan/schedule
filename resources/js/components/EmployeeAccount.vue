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



          <v-text-field
            v-model="info.first_name"
            label="First Name"
          ></v-text-field>
          <v-text-field
            v-model="info.last_name" 
            label="Last Name"
          ></v-text-field>
          <v-text-field 
            v-model="info.email" 
            label="E-mail Address"
            readonly
          ></v-text-field>
          <v-text-field
            v-model="info.current_pwd"
            :append-icon="showPwd1 ? 'visibility_off' : 'visibility'"
            :rules="[rules.required]"
            :type="showPwd1 ? 'text' : 'password'"
            name="input-10-1"
            label="Password"           
            counter
            @click:append="showPwd1 = !showPwd1;"
          ></v-text-field> 
           <v-checkbox
            v-model="info.change_pwd"
            label="I want to change my password:"
          ></v-checkbox> 




          <v-text-field
            v-if="info.change_pwd==true"
            v-model="new_pwd"
            :append-icon="showPwd2 ? 'visibility_off' : 'visibility'"
            :rules="[rules.required]"
            :type="showPwd2 ? 'text' : 'password'"
            name="input-10-1"
            label="New password"           
            counter
            @click:append="showPwd2 = !showPwd2;"
          ></v-text-field> 
          <v-text-field
            v-if="info.change_pwd==true"
            v-model="confirm_new_pwd"
            :append-icon="showPwd3 ? 'visibility_off' : 'visibility'"
            :rules="[rules.required]"
            :type="showPwd3 ? 'text' : 'password'"
            name="input-10-1"
            label="Confirm New password"           
            counter
            @click:append="showPwd3 = !showPwd3;"
          ></v-text-field> 


        <v-btn
          id="save_info"
          color="success"
          class="upload_trig"
          large
          @click="changeAccount"
        >
          <v-icon left>save</v-icon>
          Save
        </v-btn>

             


        <v-alert
        :value="es_alert"
        :type="es_alert_type"       
        transition="scale-transition"
        @click="es_alert=false"
      >
        {{ es_alert_text }}
      </v-alert>


      </v-flex>   
          
   
    </v-layout> 






  </v-app>   
</template>

<script>  
  export default {   
    data: () => ({

      showPwd1: true,
      showPwd2: true,
      showPwd3: true,
      info: {
              first_name:'', 
              last_name:'',
              email:'', 
              current_pwd:'',
              change_pwd:false
            },
      new_pwd : '',
      confirm_new_pwd: '',
      new_pwd_value: '',

      drawer: true,
      clipped: false,
      mini: true,
      right: null,
      exp_panel: [true, true, true],

      es_alert: false,
      es_alert_type: 'success',  
      es_alert_text: 'Data was successfully changed.',

      dialog_delete: false,
      dialog_getcode: false,
      pagination: {
        sortBy: 'name'
      },
      selected: [],



   

      rules: {
        required: value => !!value || 'Required.',
        min: value => value.length >= 3 || 'Min 3 characters',
        numeric: value => value > 0 || 'Enter the number',
        //same: value => value ==  || 'the same',
        emailMatch: [
          v => !!v || 'E-mail is required',
          v => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
        ]
      },



    }),
    props: ['url'],
    mounted: function() {
      this.url = this._props.url;
     
    /*  this.username = this._props.username;
      this.obj_tasks = JSON.parse(this.tasks);
      console.log(this.obj_tasks);*/
    },
    created: function(){
      this.getAccount();
    //  this.debouncedGetAnswer = _.debounce(this.getAnswer, 500);
    },
    watch: {
    /*  new_pwd: function (newQuestion, oldQuestion) {
        this.new_pwd_value = newQuestion;
      //  this.debouncedGetAnswer()
        console.log(this.new_pwd_value);
      },
      confirm_new_pwd: function (newQuestion, oldQuestion) {
        
      //  this.debouncedGetAnswer()
      if(this.new_pwd_value == newQuestion){
console.log('sasas');
console.log(this.rules.same(false));
      }
        
      }*/
    },
    methods: {
      esAlert: function(value, type, text){        
        this.es_alert = value;
        this.es_alert_type = type;
        this.es_alert_text = text;        
      },
      getAccount: function(){
        axios({ 
          method: "POST",
          url: (this.url + "/employee/account/show")
        })
        .then(result => {          
          this.info = {
            first_name: result.data.first_name,
            last_name: result.data.last_name,
            email: result.data.email,
            change_pwd: false,
            current_pwd:''
          }        
        }).catch(error => {
          console.error(error);
        }).finally(function(){         
        });
      },
      changeAccount: function(){
        axios({ 
          method: "POST",
          url: (this.url + "/employee/account/update"),
          data:{
            info: Array(this.info)
          }
        })
        .then(result => {
          switch(result.data){
            case 200:
              this.esAlert('true', 'success', 'Data was successfully changed.');
              break;
            case 203:
              this.esAlert('false', 'error', 'The password is incorrect please try again.');
              break;
            default:
              console.log(result);
              break;  
          }          
        }).catch(error => {
            this.esAlert('false', 'error', 'Please fill in password field.');
            console.error(error);
        });
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
</style>
