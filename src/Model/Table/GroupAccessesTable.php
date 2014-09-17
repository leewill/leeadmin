<?php
/**
 * 用户组权限表
 *
 * @copyright LeeAdmin
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @package   App.Model.Table
 */
namespace App\Model\Table;

use App\Model\Table\AppTable;

class GroupAccessesTable extends AppTable {

/**
 * 初始化方法
 *
 * @param array $config 配置项
 * @return void
 */
	public function initialize(array $config) {
		$this->table('group_accesses');
		$this->primaryKey(['group_id', 'menu_node_id']);
		parent::initialize($config);
	}

/**
 * 获取用户组权限节点ID列表
 * 
 * @param int $id 用户组ID
 * @return array
 */
	public function getGroupAccessNodeIdList($id) {
		$query = $this->find('list', ['idField' => 'menu_node_id', 'valueField' => 'menu_node_id'])
					->where(['group_id' => $id]);
		return array_values($query->toArray());
	}
}
