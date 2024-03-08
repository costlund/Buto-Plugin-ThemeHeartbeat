# Buto-Plugin-ThemeHeartbeat

<p>Check every 10 minutes if theme version diff or signed user is signed out.
This will normaly keep users session alive.</p>

<a name="key_0"></a>

## Settings

<p>Add page to theme settings.</p>
<pre><code>plugin_modules:
  heartbeat:
    plugin: theme/heartbeat</code></pre>
<p>Add widget to page head section.</p>
<pre><code>type: widget
data:
  plugin: 'theme/heartbeat'
  method: include
  data:</code></pre>
<p>Set minutes (default 10) for heartbeat (optional).
Normaly Apache server has session timeout of 24 minutes. 
Set a value above that (30) to not keep users session alive.</p>
<pre><code>    minutes: 10</code></pre>

<a name="key_1"></a>

## Usage



<a name="key_2"></a>

## Pages



<a name="key_2_0"></a>

### page_pull



<a name="key_3"></a>

## Widgets



<a name="key_3_0"></a>

### widget_include



<a name="key_4"></a>

## Event



<a name="key_5"></a>

## Construct



<a name="key_5_0"></a>

### __construct



<a name="key_6"></a>

## Methods



