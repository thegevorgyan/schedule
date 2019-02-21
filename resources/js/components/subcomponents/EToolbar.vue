<template>
	<v-toolbar
    height="28"        
    color="green lighten-3"
  > 
    <v-tabs       
      slot="extension"
      color="transparent"
      fixed-tabs
      height="56"
      style="margin: -28px 0 0;"
      slider-color="#a5d6a7"
      v-model="active"
      active-class="default-class tab-link-href"
    >
      <v-tab
        id="toolbar_tasks"
        :href= "`${url}/employee/tasks`"
        class="link-btn"
      >
        <v-icon>event_note</v-icon>
        &nbsp;
        <span class="hidden-xs-only">Tasks</span>
      </v-tab>
      <v-tab 
        id="toolbar_account"
        :href= "`${url}/employee/account`" 
        class="link-btn"
      >
        <v-icon>account_box</v-icon>
        &nbsp;
        <span class="hidden-xs-only">My Account</span>             
      </v-tab>
    </v-tabs>    
  </v-toolbar>    
</template>
  
<script>
  export default {
    data: () => ({
    currentUrl: '',    
		active: 0    
    }),
    props: ['url'],
    mounted: function() {
      this.url = this._props.url;
      this.currentUrl = window.location.pathname.split("/").pop();
      switch(this.currentUrl){
        case 'tasks':
          document.getElementById('toolbar_tasks').classList.add("link-btn-active");
        break;
        case 'account':
          document.getElementById('toolbar_account').classList.add("link-btn-active");
        break;
        default:
          console.log('Nothing selected');
        break;
      }
    }   
  }
</script>

<style>
[v-cloak] {
  display: none;
}
</style>
