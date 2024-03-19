function PluginThemeHeartbeat(){
  this.data = {version: {current: null, new: null}, client: {current: 0, new: 0}, minutes: null}
  this.i18n = {};
  this.halt = false;
  this.init = function(version, client, i18n, minutes){
    this.i18n = i18n;
    this.data.minutes = minutes;
    this.data.version.current = version;
    this.data.client.current = client;
    setInterval(function () {
      PluginThemeHeartbeat.pull();
    }, this.data.minutes*60*1000);
  }
  this.pull = function(){
    /**
     * 
     */
    if(this.halt){
      return null;
    }
    /**
     * 
     */
    $.getJSON( "/heartbeat/pull?version="+this.data.version.current+'&client='+this.data.client.current, function( json ) {
      $('#modal_plugin_theme_hearbeat').modal('hide');
      if(json.version.current != json.version.new){
        PluginThemeHeartbeat.halt = true;
        var content = PluginThemeHeartbeat.i18n.version_text+' <a href="/">'+PluginThemeHeartbeat.i18n.Restart+'</a>';
        PluginWfBootstrapjs.modal({id: 'modal_plugin_theme_hearbeat', label: PluginThemeHeartbeat.i18n.version_lable, content: content});
      }else if(json.client.current=="1" && json.client.new=="0"){
        PluginThemeHeartbeat.halt = true;
        var content = PluginThemeHeartbeat.i18n.client_text+' <a href="/">'+PluginThemeHeartbeat.i18n.Restart+'</a>';
        PluginWfBootstrapjs.modal({id: 'modal_plugin_theme_hearbeat', label: PluginThemeHeartbeat.i18n.client_lable, content: content});
      }
     });
  }
  this.error = function(){
    console.log('PluginThemeHeartbeat says: Page settings is missing!');
  }
}
var PluginThemeHeartbeat = new PluginThemeHeartbeat();