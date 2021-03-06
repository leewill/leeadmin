<?php
/**
 * 路由定义
 *
 * @copyright LeeAdmin
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author    Will.Lee <im.will.lee@gmail.com>
 */
use Cake\Core\Plugin;
use Cake\Routing\Router;

// 项目前端入口
Router::scope('/', function ($routes) {
	$routes->connect('/', ['controller' => 'Home', 'action' => 'index']);
	$routes->fallbacks();
});

// 项目管理端入口
Router::prefix('admin', function ($routes) {
	$routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
	$routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
	$routes->fallbacks();
});

// 加载所有插件默认路由定义
Plugin::routes();
