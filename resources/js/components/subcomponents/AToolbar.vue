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
      slider-color="#cfd8dc"  
      v-model="active"     
      active-class="default-class tab-link-href"
    >
      <v-tab
        id="toolbar_users"
        :href= "`${url}/admin/users`"
        class="link-btn"
      >        
        <v-icon>people</v-icon>
        &nbsp;
        <span class="hidden-xs-only">Users</span>
      </v-tab>
      <v-tab
        id="toolbar_schedule"
        :href= "`${url}/admin/schedule`"
        class="link-btn"
      >        
        <v-icon>schedule</v-icon>
        &nbsp;
        <span class="hidden-xs-only">Schedule</span>
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
        case 'users':
          document.getElementById('toolbar_users').classList.add("link-btn-active");
        break;
        case 'schedule':
          document.getElementById('toolbar_schedule').classList.add("link-btn-active");
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
