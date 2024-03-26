<?php
class PluginThemeHeartbeat{
  function __construct() {
    wfPlugin::includeonce('wf/yml');
  }
  public function widget_include($data){
    /**
     * is_plugin_modules
     */
    $in_plugin_modules = false;
    if(wfGlobals::get('settings/plugin_modules/heartbeat/plugin')=='theme/heartbeat'){
      $in_plugin_modules = true;
    }
    /**
     * 
     */
    $data = new PluginWfArray($data);
    /**
     * minutes
     */
    if(!$data->get('data/minutes')){
      $data->set('data/minutes', 10);
    }
    if(wfUser::hasRole('webmaster') && $data->get('data/minutes') > 10){
      $data->set('data/minutes', 10);
    }
    if(wfServer::isHost('localhost')){
      /**
       * If localhost always 1 minute.
       */
      $data->set('data/minutes', 1);
    }
    /**
     * 
     */
    wfDocument::renderElementFromFolder(__DIR__, __FUNCTION__);
    /**
     * i18n
     */
    wfPlugin::includeonce('i18n/translate_to_json');
    $i18n_translate_to_json = new PluginI18nTranslate_to_json();
    $json_i18n = $i18n_translate_to_json->get_json(__DIR__.'/element/i18n.yml', '/plugin/theme/heartbeat/i18n');
    /**
     * 
     */
    $version = wfUser::getSession()->get('theme_data/version');
    $client = "0";
    if(wfUser::hasRole('client')){
      $client = "1";
    }
    /**
     * minutes
     */
    $minutes = $data->get('data/minutes');
    /**
     * 
     */
    $element = wfDocument::getElementFromFolder(__DIR__, __FUNCTION__.'_init');
    if($in_plugin_modules){
      $element->setByTag(array('script' => "$( document ).ready(function() { PluginThemeHeartbeat.init('$version', $client, $json_i18n, $minutes);});"));
    }else{
      $element->setByTag(array('script' => "$( document ).ready(function() { PluginThemeHeartbeat.error();});"));
    }
    wfDocument::renderElement($element);
  }
  public function page_pull(){
    $manifest = new PluginWfYml(wfGlobals::getAppDir().'/theme/[theme]/config/manifest.yml');
    $data = new PluginWfArray();
    $data->set('version/current', wfRequest::get('version'));
    $data->set('version/new', (string)$manifest->get('version'));
    $data->set('client/current', wfRequest::get('client'));
    $client = "0";
    if(wfUser::hasRole('client')){
      $client = "1";
    }
    $data->set('client/new', $client);
    /**
     * sign out
     */
    if(wfRequest::get('version') && wfRequest::get('version') != $manifest->get('version')){
      session_destroy();
    }
    exit(json_encode($data->get()));
  }
}