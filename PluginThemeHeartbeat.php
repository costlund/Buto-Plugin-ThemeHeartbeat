<?php
class PluginThemeHeartbeat{
  function __construct() {
    wfPlugin::includeonce('wf/yml');
  }
  public function widget_include($data){
    $data = new PluginWfArray($data);
    /**
     * minutes
     */
    if(!$data->get('data/minutes')){
      $data->set('data/minutes', 10);
    }
    if(wfUser::hasRole('webmaster')){
      $data->set('data/minutes', 10);
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
    $element->setByTag(array('script' => "$( document ).ready(function() { PluginThemeHeartbeat.init('$version', $client, $json_i18n, $minutes);});"));
    wfDocument::renderElement($element);
  }
  public function page_pull(){
    $manifest = new PluginWfYml(wfGlobals::getAppDir().'/theme/[theme]/config/manifest.yml');
    $data = new PluginWfArray();
    $data->set('version/current', wfRequest::get('version'));
    $data->set('version/new', $manifest->get('version'));
    $data->set('client/current', wfRequest::get('client'));
    
    $client = "0";
    if(wfUser::hasRole('client')){
      $client = "1";
    }
    $data->set('client/new', $client);
    /**
     * sign out
     */
    if(wfRequest::get('version') != $manifest->get('version')){
      session_destroy();
    }
    exit(json_encode($data->get()));
  }
}