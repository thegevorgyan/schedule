<template>
  <v-app>
    <v-layout justify-center row wrap mt-4>
      <v-flex xs12 text-xs-center>      
        <h1 >Employee's main page</h1>
      </v-flex>
    </v-layout>
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
        { text: 'Website', align: 'left', value: 'website_addr' },
        { text: 'Age', value: 'age' },
        { text: 'Session Timeout', value: 'session_timeout' },
        { text: 'Type', value: 'type' },
        { text: 'Picture', value: 'filename' },
        { text: 'Add/Edit'},
        { text: 'Delete'},
        { text: 'Get Code'},
      ],
     
    }),
    props: ['url', 'username'],
    mounted: function() {
      this.url = this._props.url;
      this.username = this._props.username;
     
    },
    methods: {
      addWebsite: function(){
        window.location.href = this.url + '/home/add';
      },
      editWebsite: function(val){
        window.location.href = this.url + '/home/edit/' + val;
      },
      openDeleteWebsite: function(val){
        this.dialog_delete = true;
        this.id = val        
      },
      deleteWebsite: function(val){
        axios({ 
          method: "POST",
          url: (this.url+"/destroy"),
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
