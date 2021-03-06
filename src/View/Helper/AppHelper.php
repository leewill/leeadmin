<?php
/**
 * 项目模板助手基础
 *
 * @copyright LeeAdmin
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @package   App.View.Helper
 */

namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\Utility\Time;
use Cake\View\Helper;

class AppHelper extends Helper {

/**
 * 字符串url解析
 * url格式规则
 * 插件格式:plugin.controller/action 和 plugin.prefix/controller/action
 * 基本格式:controller/action 和 prefix/controller/action
 *
 * @param string $url url地址
 * @param string $param 参数 json_encode后的字符串
 * @return array
 */
	public function parseUrl($url, $param = null) {
		list($plugin, $link) = pluginSplit($url);
		$link = explode('/', $link);
		if (isset($link[2])) {
			$url = ['plugin' => $plugin, 'controller' => $link[1], 'action' => $link[2], 'prefix' => $link[0]];
		} else {
			$url = ['plugin' => $plugin, 'controller' => $link[0], 'action' => $link[1], 'prefix' => false];
		}
		if ($param) {
			$param = json_decode($param, true);
			if (is_array($param) && !empty($param)) {
				return array_merge($url, $param);
			}
		}
		return $url;
	}
}
