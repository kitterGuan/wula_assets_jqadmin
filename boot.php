<?php
/*
 * This file is part of wulacms.
 *
 * (c) Leo Ning <windywany@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
define('JQ_VERSION', '1.0.0');

/**
 * 加载界面样式资源.
 *
 * @param bool|array $styles jqadmin提供的css样式.
 *
 * @return string
 */
function smarty_function_loaduicss($styles = false) {
	$base = WWWROOT_DIR . ASSETS_DIR;
	$css  = <<<EOF
	<link rel="stylesheet" type="text/css" href="{$base}/wula/jqadmin/css/font.min.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="{$base}/wula/jqadmin/css/layui.css" media="all"/>
    	
EOF;

	if ($styles) {
		foreach ($styles as $id => $style) {
			if ($style) $css .= "<link rel=\"stylesheet\" id=\"{$id}\" type=\"text/css\" href=\"{$base}/wula/jqadmin/css/{$style}\" media=\"all\"/>\n";
		}
	}

	return $css;
}

/**
 * 初始化界面.
 *
 * @param bool $config
 *             config:加载配置
 *             page:  页面,
 *             modules:自定义模块
 *
 * @return string
 */
function smarty_function_initjq($config = false) {
	$ver  = JQ_VERSION;
	$base = WWWROOT_DIR . ASSETS_DIR;
	$jq[] = "<script type=\"text/javascript\" src=\"{$base}/wula/jqadmin/layui.js?v={$ver}\"></script>";
	if ($config && isset($config['config'])) {
		$ms            = apply_filter('wula\jqadmin\reg_module', []);
		$ms['jqelem']  = 'js/jqelem';
		$ms['jqmenu']  = 'js/jqmenu';
		$ms['tabmenu'] = 'js/tabmenu';
		$ms['jqtags']  = 'js/jqtags';
		// lib
		$ms['bootstrap']  = 'lib/bootstrap';
		$ms['highlight']  = 'lib/highlight';
		$ms['fuelux']     = 'lib/fuelux/fuelux';
		$ms['plupload']   = 'lib/plupload';
		$ms['select2']    = 'lib/select2';
		$ms['datepicker'] = 'lib/datepicker';
		$ms['validate']   = 'lib/validate';
		$ms['sortable']   = 'lib/sortable';
		$ms['toastr']     = 'js/toastr';
		$ms['ztree']      = 'js/ztree';
		$ms['ztree.edit'] = 'js/ztree_edit';
		$ms['ztree.hide'] = 'js/ztree_hide';
		$ms['wulaui']     = 'js/wulaui';
		$modules          = json_encode($ms, JSON_UNESCAPED_SLASHES);
		$groups           = wulaphp\app\App::$prefix;
		unset($groups['check'], $config['config']);
		$config['key']             = 'config';
		$config['value']['base']   = WWWROOT_DIR;
		$config['value']['assets'] = WWWROOT_DIR . ASSETS_DIR . '/';
		$config['value']['medias'] = apply_filter('get_media_domains', null);
		$config['value']['ids']    = wulaphp\app\App::id2dir(null);
		$config['value']['groups'] = $groups ? $groups : ['char' => []];
		$cfg                       = json_encode($config, JSON_UNESCAPED_SLASHES);
		$jq[]                      = "<script type=\"text/javascript\">layui.config({base:'{$base}/wula/jqadmin/',version:'{$ver}'}).extend({$modules}).data('wulaui',{$cfg});layui.data('wulaui',{key:'modules',value:{$modules}})</script>";
	} else {
		$jq[] = "<script type=\"text/javascript\">layui.config({base:'{$base}/wula/jqadmin/',version:'{$ver}'}).extend(layui.data('wulaui','modules'))</script>";
	}
	$ms = [];
	if ($config && isset($config['modules']) && $config['modules']) {
		$ms = (array)$config['modules'];
	}
	if ($config && isset($config['page'])) {
		$ms = apply_filter('wula\jqadmin\module_for_' . $config['page'], $ms);
	}
	if ($ms) {
		$ms   = json_encode($ms);
		$jq[] = "<script type=\"text/javascript\">layui.use($ms)</script>";
	}

	return implode("\n", $jq);
}