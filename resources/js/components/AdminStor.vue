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
          <v-expansion-panel-content  class="blue-grey lighten-4">        
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
          <v-expansion-panel-content class="blue-grey lighten-4">
            <v-icon v-if="exp_panel[2]==true" slot="header" color="#435b71">visibility</v-icon>
            <v-icon v-if="exp_panel[2]==false" slot="header">visibility_off</v-icon>
            <div v-if="!mini" slot="header">View</div>
            
          </v-expansion-panel-content> 
      </v-expansion-panel>
    </v-navigation-drawer>
    
 <v-toolbar-side-icon style="margin:-68px 16px 0" @click.stop="sidebar('open_drawer')"></v-toolbar-side-icon>

 <v-layout justify-center row wrap mt-4>
      <v-flex xs10>
      <v-card>
      <v-card-title>
        <v-btn color="error" fab small title="Delete" @click="deleteRecData">
          <v-icon>delete_forever</v-icon>
        </v-btn>
        <v-btn color="success" fab small title="Export to Excel" @click="onExport">
          <v-icon>import_export</v-icon>
        </v-btn>
        <v-spacer></v-spacer>

         <v-flex xs8 sm6 md4 lg3 lx2>
          <v-text-field        
            v-model="search"
            append-icon="search"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
         </v-flex>
      </v-card-title>


          <v-data-table
            v-model="selected"
            :headers="headers"
            :items="obj_stat"
            item-key="id"
            select-all
            class="elevation-5"
            :search="search"
          >           
            <template slot="items" slot-scope="props">
              <td>
                <v-checkbox               
                  v-model="props.selected"
                  primary
                  hide-details                  
                  :data="props.item.id"
                  class="checkboxes"
                ></v-checkbox>
              </td>
              <td>{{ props.item.id }}</td>
              <td>{{ props.item.remote_ip_addr }}</td>
              <td>{{ props.item.key }}</td>
              <td>{{ props.item._token }}</td>
              <td>{{props.item._cookies}} 
                        
                <!--ul class="aspire_ul">
                  <li  v-for="(value, key) in JSON.parse(props.item._cookies)" :value="value" :key="key">
                    {{key}}: <span class="blue--text">{{value}}</span> 
                  </li>
                </ul-->
              </td>
              <td>{{ props.item.created_at }}</td>               
            </template>
             <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
          </v-data-table>
 </v-card>  
      </v-flex>
 </v-layout>









        
  </v-app>   
</template>

<script>

  export default {   
    data: () => ({
      datas: {
        'sheet':[]
      },
      search: '',
      selected: [],
      headers: [
        { text: 'ID', value: 'id' },
        { text: 'Remote IP Address', value: 'remote_ip_addr' },
        { text: 'Key', value: 'key' },
        { text: 'Token', value: '_token' },
        { text: 'Data', value: '_cookies' },
        { text: 'Timestamp', value: 'created_at' }
      ],
      obj_stat: [],
      drawer: false,
      clipped: false,
      mini: true,
      right: null,
      exp_panel: [true, true, true]     
    }),
    props: ['url', 'stor'],
    mounted: function() {
      this.url = this._props.url;
      this.obj_stat = JSON.parse(this.stor);
      this.datas.sheet = JSON.parse(this.stor);
    },   
    methods: {
      deleteRecData: function() {
        let checkboxes = document.getElementsByClassName('checkboxes');
        let arrCheckboxes = [];
       
        for(let i = 0; i < checkboxes.length; i++) {
          if(checkboxes[i].classList.contains("v-input--is-label-active")) {
            arrCheckboxes.push(checkboxes[i].getAttribute('data'));            
          }         
        }

        axios({ 
          method: "DELETE",
          url: (this.url+"/admin/destroy"),
          data: {
            id:arrCheckboxes,
            name:'stor'
          }
        })
        .then(result => {          
          location.reload();
        }).catch(error => {
          console.error(error)
        }).finally(() => {    
          //console.log(this.$store);
        });
      },   
      onExport: function() {
        var sheetWS = XLSX.utils.json_to_sheet(this.datas.sheet) 
        var wb = XLSX.utils.book_new() // make Workbook of Excel

        XLSX.utils.book_append_sheet(wb, sheetWS, 'sheet') // sheetAName is name of Worksheet
        XLSX.writeFile(wb, 'vbe_stored.xlsx') // name of the file is 'book.xlsx'
      },
      sidebar: function(val) {
        switch(val){
          case 'mini':
            this.mini = !this.mini;
            this.vbe_animation(document.getElementById('vbe_logo'),14,0,0.4);
            document.getElementById('navigation-drawer').style.width = "116px";
            document.getElementById('templates_group').style.display = 'block';
          break;
          case 'stand':
            this.mini = !this.mini;
            this.vbe_animation(document.getElementById('vbe_logo'),5,0,0.4);
            document.getElementById('navigation-drawer').style.width = "300px";
            document.getElementById('templates_group').style.display = 'block';
          break;
          case 'open_drawer':
          this.drawer = !this.drawer;
          if(document.getElementById('navigation-drawer').style.width == '116px') {
            this.vbe_animation(document.getElementById('vbe_logo'),5,0,0.4);
          } else {
            this.vbe_animation(document.getElementById('vbe_logo'),14,0,0.4);
          }
          break;
          case 'close_drawer':
            this.drawer = !this.drawer;
            this.vbe_animation(document.getElementById('vbe_logo'),0,0,0.4);
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
  background-color:#708598;
}

.v-datatable > thead > tr > th.column{ 
  color:white;
}

</style>
