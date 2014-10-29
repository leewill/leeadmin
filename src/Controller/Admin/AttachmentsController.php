<?php
/**
 * 附件管理控制器
 *
 * @copyright LeeAdmin
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @package   App.Controller.Admin
 */
namespace App\Controller\Admin;

use App\Controller\AppAdminController;
use Cake\Core\Configure;

class AttachmentsController extends AppAdminController {

/**
 * 主标题
 *
 * @var string
 */
	protected $_mainTitle = '附件管理';

/**
 * 附件一览
 *
 * @return void
 */
	public function index() {
		$this->_subTitle = '附件一览';
	}

/**
 * 上传附件
 *
 * @return void
 */
	public function upload() {
		$this->_subTitle = '上传附件';
	}
}
