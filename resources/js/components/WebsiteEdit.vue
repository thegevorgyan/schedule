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
      class="blue-grey lighten-4"
    >
      <v-expansion-panel
        v-model="exp_panel"
          expand
          focusable
          popout
        >
          <v-expansion-panel-content       
            id="templates_group"
            class="blue-grey lighten-4"
          >
            <v-btn icon @click.stop="drawer = !drawer">
              <v-icon color="#435b71">cancel</v-icon>
            </v-btn>
            <v-btn icon v-if="mini" @click="sidebar('mini')">
              <v-icon color="#435b71">arrow_right</v-icon>
            </v-btn>
            <v-btn icon v-else-if="!mini" @click="sidebar('stand')" style="float:right">
              <v-icon color="#435b71">arrow_left</v-icon>
            </v-btn> 
          </v-expansion-panel-content>
          <v-expansion-panel-content  class="blue-grey lighten-4">    
            <v-icon v-if="exp_panel[1]==true" slot="header" color="#435b71">view_stream</v-icon>
            <v-icon v-if="exp_panel[1]==false" slot="header">view_stream</v-icon>    
            <div v-if="!mini" slot="header">Patterns</div>
            <v-list dense >
              <v-img
                v-for="n in 3"
                :key="n"
                d-flex
                :src="`../../img/templates/template${n}.jpg`"
                :lazy-src="`../../img/templates/template${n}.jpg`"  
                ref="template"            
                class="mt-2"                
                @click="templateChoose(`${n}`)"
                style="width:90%; margin:auto auto"
              ></v-img>
            </v-list>
          </v-expansion-panel-content>
          <v-expansion-panel-content  class="blue-grey lighten-4">
            <v-icon v-if="exp_panel[2]==true" slot="header" color="#435b71">visibility</v-icon>
            <v-icon v-if="exp_panel[2]==false" slot="header">visibility_off</v-icon>
            <div v-if="!mini" slot="header">View</div>
            <popupview :info="template0_info"></popupview>
          </v-expansion-panel-content> 
      </v-expansion-panel>
    </v-navigation-drawer>
    <v-toolbar
      height="54"
      style="margin: -20px 0 0;"
      color="blue-grey lighten-4"
    >
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-spacer></v-spacer>
    </v-toolbar>
    <v-layout justify-center row wrap mt-4>
      <v-flex xs8 offset-xs2 sm9 offset-sm2 md6 offset-md0 v-for="items in obj" :key="items.id">
        <v-text-field
          id="website_addr"
          v-model = "items.website_addr"
          label="Website"
          :rules="[rules.required]"
        ></v-text-field>      
        <v-text-field
          id="header"
          v-model = "items.header"
          label="Header"
          :rules="[rules.required]"
        ></v-text-field>
        <v-textarea
          id="text"
          label="Content"
          :rules="[rules.required]"
          v-model = "items.text"
        ></v-textarea> 
         <v-text-field
          id="hint"
          v-model = "items.hint"
          label="Hint"
          :rules="[rules.required]"
        ></v-text-field>
        <v-text-field
          id="age"
          v-model = "items.age"
          label="Legal Age"
          :rules="[rules.required, rules.numeric]"
        ></v-text-field>
        <v-flex xs12>
          <v-card>
            <v-container grid-list-sm fluid>
              <v-layout row wrap>
                <v-flex
                  v-for="index in 12"
                  :key="index"
                  xs2                 
                >
                  <v-card flat tile class="d-flex">
                    <v-hover>
                      <v-card
                        slot-scope="{ hover }"
                        class="mx-auto"
                        color="grey lighten-4"                
                      >
                        <v-img
                          :src="`${url}/img/bg/bg${index}.jpeg`"
                          :lazy-src="`${url}/img/bg/bg${index}.jpeg`"
                          :ref="`imageDef${index}`"
                          class="grey lighten-2"
                          @click="chooseDefaultImages(index)"
                        >
                          <v-layout                    
                            slot="placeholder"
                            fill-height
                            align-center
                            justify-center
                            ma-2
                          >
                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                          </v-layout>
                          <v-expand-transition>
                            <div
                              v-if="hover"
                              class="d-flex transition-fast-in-fast-out blue darken-3 darken-2 v-card--reveal display-3 white--text"
                              style="height: 100%;"
                            ></div>
                          </v-expand-transition>
                        </v-img>
                      </v-card>
                    </v-hover>
                  </v-card>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
        </v-flex>
        <img 
          id="image_view"
          v-if="image"
          :src="image" 
          :lazy-src="image"
          height="150"
        />
				<v-text-field 
          label="Background Image"             
          v-model="imageName" 
          prepend-icon="attach_file"
          @click="pickFile"
        ></v-text-field>
				<input
          id="img_file"
				  type="file"
				  style="display: none"
					ref="image"
					accept="image/jpg, image/jpeg, image/png, image/gif"          
					@change="onFileChange"
				>
        <v-select
          id="type"
          :items="types"      
          v-model="settype"
          label="Popup Type"
          :data="`${select.val}`"    
          item-value="text"
          hide-details  
          @change="selectType($event)"    
        ></v-select>
        <v-text-field
          id="bg_color"
          v-model = "items.bg_color"
          label="Popup Background Color"
          :rules="[rules.required]"                           
        ></v-text-field>
        <v-text-field
          id="verified_redirect_url"
          v-model = "items.verified_redirect_url"
          label="Redirect URL"                
        ></v-text-field>
        <v-text-field
          id="reject_redirect_url"
          v-model = "items.reject_redirect_url"
          label="Reject URL"                 
        ></v-text-field>
        <v-text-field
          id="enter_btn_text"
          v-model = "items.enter_btn_text"
          label="<Enter> Button Text" 
          :rules="[rules.required]"                                 
        ></v-text-field>
        <v-text-field
          id="cancel_btn_text"
          v-model = "items.cancel_btn_text"
          label="<Cancel> Button Text"  
          :rules="[rules.required]"                      
        ></v-text-field>
        <v-text-field
          id="info_btn_text"
          v-model = "items.info_btn_text"
          label="<Info> Button Text"   
          :rules="[rules.required]"           
        ></v-text-field>
        <v-textarea
          id="info_description"
          label="Info Description"
          :rules="[rules.required]"
          v-model = "items.info_description"                
        ></v-textarea>
        <v-text-field
          id="session_timeout"
          v-model = "items.session_timeout"
          label="Session Timeout" 
          :rules="[rules.required, rules.numeric]"              
        ></v-text-field>
        <v-textarea       
          id="terms_conditions"
          v-model = "items.terms_conditions"
          label="Terms and Conditions"
          :rules="[rules.required]"
          ></v-textarea>
        <v-btn
          color="warning"
          large
          @click="editWebsite"
        >
          <v-icon left>save</v-icon>
          Save          
        </v-btn>
      </v-flex>     
    </v-layout>
  </v-app>
</template>

<script>
  import popupdobview from './subcomponents/PopupView.vue';

  export default {
    data: () => ({
      drawer: true,
      clipped: false,
      mini: true,
      right: null,
      exp_panel: [true, true, true],
      template0_info: {},
      template1_info: {
        'website_addr': 'https://wholesale.aspirevapeco.com', 
        'age': '21', 
        'header': 'AGE VERIFICATION', 
        'text': 'Intended for sale to adults 21 years or older. If you are not of legal age in the state where you live, please do not enter this site', 
        'hint': 'PLEASE ENTER YOUR DATE OF BIRTH',
        'type': 'Date of Birth', 
        'bg_color': '#fffff0',
        'verified_redirect_url': '',
        'reject_redirect_url': '',
        'enter_btn_text': 'Enter',
        'cancel_btn_text': 'Cancel',
        'info_btn_text': 'Info',
        'info_description': 'Description',
        'session_timeout': '60',
        'terms_conditions': '-',
        'img_bg_popup': '../../img/bg/bg1.jpeg',
        'styl': 'width:300%; font-size:9px; transform: scale(0.3); margin: -55% -100%;',
        'select_type': 'dob'
      },
      template2_info: {
        'website_addr': 'https://wholesale.aspirevapeco.com',
        'age': '21',
        'header': 'AGE VERIFICATION',
        'text': 'Intended for sale to adults 21 years or older. If you are not of legal age in the state where you live, please do not enter this site', 
        'hint': 'PLEASE ENTER YOUR DATE OF BIRTH',
        'type': 'Date of Birth', 
        'bg_color': '#52524c',
        'verified_redirect_url': '',
        'reject_redirect_url': '',
        'enter_btn_text': 'Enter',
        'cancel_btn_text': 'Cancel',
        'info_btn_text': 'Info',
        'info_description': 'Description',
        'session_timeout': '120',
        'terms_conditions': '-',
        'img_bg_popup': '../../img/bg/bg2.jpeg',
        'styl': 'width:300%; font-size:7px; transform: scale(0.3); margin: -60% -100%;',
        'select_type': 'dob'
      },
      template3_info: {
        'website_addr': 'https://wholesale.aspirevapeco.com', 
        'age': '21', 
        'header': 'AGE VERIFICATION', 
        'text': 'Intended for sale to adults 21 years or older. If you are not of legal age in the state where you live, please do not enter this site', 
        'hint': 'PLEASE ENTER YOUR DATE OF BIRTH',
        'type': 'Date of Birth', 
        'bg_color': '#1E88E5',
        'verified_redirect_url': '',
        'reject_redirect_url': '',
        'enter_btn_text': 'Enter',
        'cancel_btn_text': 'Cancel',
        'info_btn_text': 'Info',
        'info_description': 'Description',
        'session_timeout': '180',
        'terms_conditions': '-',
        'img_bg_popup': '../../img/bg/bg3.jpeg',
        'styl': 'width:300%; font-size:7px; transform: scale(0.3); margin: -60% -100%;',
        'select_type': 'dob'
      },
      imageDefault: this.url + '/img/bg/bg1.jpeg',
      imageNum: 0,
      imageName: '',
	  	imageFile: '',
      image: '',
      image_info: {},
      obj:[],
      selectedUploadFile: null,
      select: {'val':''},
      types: [
            { shortCode: 'dob', text:'Date of Birth' }, 
            { shortCode: 'age', text:'Age' }
      ],
      fetchedLocale: '',
      settype: 'null',
      rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 8 || 'Min 8 characters',
        numeric: value => value > 0 || 'Enter the number',
        emailMatch: () => ('The email and password you entered don\'t match')
      }
    }),
    props: ['websiterow', 'url'],
    mounted: function() {

      this.obj = JSON.parse(this._props.websiterow);      
      this.url = this._props.url;
      this.select.val = this.obj[0].type;
      this.image = this.url + '/cache/' + this.obj[0].filename;
      this.imageName = this.obj[0].filename;

      let file_ext =  this.obj[0].filename.split('.');
      this.image_info.size = '0';
      this.image_info.type = 'image/' + file_ext[1];

      this.template0_info =  this.obj[0];
      this.template0_info.styl= this.template1_info.styl;
      this.template0_info.select_type = this.obj[0].type; 

      this.obj[0].type == 'dob' ? this.fetchedLocale = 'Date of Birth' : this.fetchedLocale = 'Age';
      this.settype = this.fetchedLocale;
    },
    methods: {      
      editWebsite: function(){
            axios({ 
              method: "POST", 
              url: (this.url + "/update/" + this.obj[0].id),
              data: {
                'website_addr': document.getElementById('website_addr').value,
                'header': document.getElementById('header').value,
                'text': document.getElementById('text').value,
                'hint': document.getElementById('hint').value,
                'age': document.getElementById('age').value,                
                'type': document.getElementById('type').getAttribute('data'),
                'key': this.obj[0].key,
                'filename': this.obj[0].filename, 
                'bg_color': document.getElementById('bg_color').value,
                'verified_redirect_url': document.getElementById('verified_redirect_url').value,
                'reject_redirect_url': document.getElementById('reject_redirect_url').value,
                'enter_btn_text': document.getElementById('enter_btn_text').value,
                'cancel_btn_text': document.getElementById('cancel_btn_text').value,
                'info_btn_text': document.getElementById('info_btn_text').value,
                'info_description': document.getElementById('info_description').value,
                'session_timeout': document.getElementById('session_timeout').value,
                'terms_conditions': document.getElementById('terms_conditions').value,
                'image': this.image,
                'image_num': this.imageNum,
                'image_size': this.image_info.size,
                'image_type': this.image_info.type
              }
            })
            .then(result => {
              console.log(result.data);
          }, error => {
              console.error(error);
          });        
      },
      templateChoose: function(val) {   
        let mod_cont = document.getElementsByClassName('aspire_modal_content')[0].style; 
        this.settype = 'Date of Birth';
        switch(val){
          case '1':
            this.template0_info = Object.assign(this.obj[0], this.template1_info);
            break;
          case '2':
            this.template0_info = Object.assign(this.obj[0], this.template2_info);          
            break;
          case '3': 
            this.template0_info = Object.assign(this.obj[0], this.template3_info);
            break;
          default:
            console.log('There is not such a template');
            break;  
        }        
        
        if(this.mini == true){
          mod_cont.width = "300%";
          mod_cont.fontSize = "9px";
          mod_cont.transform = "scale(0.3)";
          mod_cont.margin="-65% -100%";
        }else{          
          mod_cont.width = "200%";
          mod_cont.fontSize = "18px";
          mod_cont.transform = "scale(0.5)";
          mod_cont.margin="-25% -50%";
        }
      },      
      onFileChange: function(e) {        
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length){
          this.imageName = "";
          this.imageFile = "";
          this.$refs.imageDef1[0].$el.click();
          return;
        }else{
          this.imageName = files[0].name;              
          this.createImage(files[0]);
        }
      },
      createImage: function(file) {       
        let reader = new FileReader();
        let vm = this;
        reader.onload = (e) => {
            vm.image = e.target.result;         
        };
        reader.readAsDataURL(file);
        this.image_info = file;
        this.imageNum = 0;
      },
      pickFile: function() {  
        this.$refs.image[0].click();
      },
      selectType: function(val) {
        if( val == 'Age') {
          this.select.val = 'age';
          this.template0_info.select_type = 'age';
          this.template0_info.hint = 'PLEASE CONFIRM YOUR AGE';
          if(this.mini == !true){
            this.template0_info.styl = "width:200%; font-size:18px; transform: scale(0.5); margin:-15% -50%;"
          }else{
            this.template0_info.styl = 'width:300%; font-size:9px; transform: scale(0.3); margin: -55% -100%;';
          }
          setTimeout(function(){
            document.getElementById('hint').value = 'PLEASE CONFIRM YOUR AGE';
          },100);
        } else {
          this.select.val = 'dob';
          this.template0_info.select_type = 'dob';  
          this.template0_info.hint = 'PLEASE ENTER YOUR DATE OF BIRTH';
          if(this.mini == true){
            this.template0_info.styl = 'width:300%; font-size:9px; transform: scale(0.3); margin: -65% -100%;';
          }else{
            this.template0_info.styl = 'width:200%; font-size:18px; transform: scale(0.5); margin:-25% -50%;';
          }
          setTimeout(function(){
            document.getElementById('hint').value = 'PLEASE ENTER YOUR DATE OF BIRTH';
          },100);
        } 
      },
      chooseDefaultImages: function(index){
        document.getElementById('image_view').setAttribute('src', this.url + '/img/bg/bg' + index + '.jpeg');        
        this.imageNum = index;
        this.image_info.size = '1';
      },
      onScroll: function(e) {
        this.offsetTop = e.target.scrollTop;
      },
      sidebar: function(val) {
        let mod_cont = document.getElementsByClassName('aspire_modal_content')[0].style,
            nav_dr = document.getElementById('navigation-drawer').style,
            temp_grp = document.getElementById('templates_group').style;

        switch(val){
          case 'mini':
            this.mini = !this.mini;
            if(this.template0_info.select_type == 'dob'){        
              mod_cont.width = "200%";
              mod_cont.fontSize = "18px";
              mod_cont.transform = "scale(0.5)";
              mod_cont.margin="-25% -50%";              
            }else if(this.template0_info.select_type == 'age'){
              mod_cont.width = "200%";
              mod_cont.fontSize = "18px";
              mod_cont.transform = "scale(0.5)";
              mod_cont.margin="-15% -50%";            
            }
            nav_dr.width = "116px";
            temp_grp.display = 'block';           
          break;
          case 'stand':
            this.mini = !this.mini;
            if(this.template0_info.select_type == 'dob'){
              mod_cont.width = "300%";
              mod_cont.fontSize = "9px";
              mod_cont.transform = "scale(0.3)";
              mod_cont.margin="-65% -100%";               
            }else if(this.template0_info.select_type == 'age'){
              mod_cont.width = "300%";
              mod_cont.fontSize = "9px";
              mod_cont.transform = "scale(0.3)";
              mod_cont.margin="-55% -100%";  
            }
            nav_dr.width = "300px";
            temp_grp.display = 'block';
          break;
          default:
           console.log('miss');
          break;  
        }        
      },      
    }
  }
</script>

<style>
[v-cloak] {
  display: none;
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
