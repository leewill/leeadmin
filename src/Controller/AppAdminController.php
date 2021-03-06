<?php
/**
 * 项目管理端控制器基础
 *
 * @copyright LeeAdmin
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @package   App.Controller
 */
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;

class AppAdminController extends AppController {

/**
 * 模板助手
 *
 * @var array
 */
	public $helpers = ['Admin'];

/**
 * 默认分页参数
 *
 * @var array
 */
	public $paginate = [
		// 默认显示数量
		'limit' => 10,
		// 最大显示数量
		'maxLimit' => 100,
		// 允许排序字段
		'sortWhitelist' => ['id']
	];

/**
 * 页面主标题
 *
 * @var string
 */
	protected $_mainTitle = null;

/**
 * 页面副标题
 *
 * @var string
 */
	protected $_subTitle = null;

/**
 * 初始化钩子方法
 *
 * @return void
 */
	public function initialize() {
		parent::initialize();
		// Auth组件
		$this->loadComponent('Auth', [
			'authenticate' => [
				'Form' => [
					'userModel' => 'Users',
					'fields' => ['username' => 'email'],
					'contain' => ['Groups'],
					'passwordHasher' => 'Default'
				],
			],
			'loginAction' => [
				'plugin' => false,
				'controller' => 'Users',
				'action' => 'login',
				'prefix' => 'admin'
			],
			'loginRedirect' => [
				'plugin' => false,
				'controller' => 'Dashboard',
				'action' => 'index',
				'prefix' => 'admin'
			],
			'flash' => ['element' => 'error'],
			'authError' => '请先登录系统！'
		]);
		// 菜单节点组件
		$this->loadComponent('MenuNode');
	}

/**
 * 控制器操作执行前回调方法
 *
 * @param Cake\Event\Event $event 事件对象
 * @return void
 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		if ($this->Auth->user()) {
			Configure::write('Auth.User.id', $this->request->session()->read('Auth.User.id'));
			// 权限验证
			$this->__checkUserAccess();
			// 刷新核心和插件定义菜单和节点
			$this->__refreshMenuNodes();
		}
	}

/**
 * 模板渲染前回调方法
 *
 * @param Cake\Event\Event $event 事件对象
 * @return void
 */
	public function beforeRender(Event $event) {
		parent::beforeRender($event);
		$this->set('mainTitle', $this->_mainTitle);
		$this->set('subTitle', $this->_subTitle);
		// 登陆后设置左侧菜单
		if ($this->Auth->user()) {
			$this->set('sidebarMenus', $this->MenuNode->sidebarMenus());
			$sidebarParentIds = [];
			if (!empty($this->request->cookies['siderbarIds'])) {
				$sidebarParentIds = explode('.', $this->request->cookies['siderbarIds']);
			}
			$this->set('sidebarParentIds', $sidebarParentIds);
		}
	}

/**
 * 刷新核心和插件定义菜单和节点
 *
 * @return boolean
 */
	private function __refreshMenuNodes() {
		if ($this->request->query('_refresh_menu') !== null && Configure::read('debug') === true) {
			if ($this->MenuNode->refreshMenuNodes()) {
				$this->Flash->success('菜单节点刷新成功！');
			} else {
				$this->Flash->error('菜单节点刷新失败！');
			}
		}
	}

/**
 * 当前登陆用户权限验证
 *
 * @return void
 * @throws Cake\Network\Exception\ForbiddenException
 */
	private function __checkUserAccess() {
		// 排除不需要验证的操作
		$action = $this->request->params['action'];
		if (!in_array($action, $this->Auth->allowedActions)) {
			if ($this->request->session()->read('Auth.User.group_id') != INIT_GROUP_ID) {
				$plugin = null;
				if (!empty($this->request->params['plugin'])) {
					$plugin = $this->request->params['plugin'] . '.';
				}
				$node = sprintf(
						'%s%s/%s/%s',
						$plugin,
						$this->request->params['prefix'],
						$this->request->params['controller'],
						$action
				);
				if (!in_array($node, $this->request->session()->read('Auth.Access'))) {
					throw new ForbiddenException();
				}
			}
		}
	}
}
