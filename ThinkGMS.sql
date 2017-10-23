/*
Navicat MySQL Data Transfer

Source Server         : 本机_wamp
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : thinkgms

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-08-08 14:45:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gms_action
-- ----------------------------
DROP TABLE IF EXISTS `gms_action`;
CREATE TABLE `gms_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL COMMENT '标识',
  `title` char(80) NOT NULL COMMENT '标题',
  `remark` char(140) NOT NULL COMMENT '描述',
  `rule` text NOT NULL COMMENT '行为规则',
  `log` text NOT NULL COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- ----------------------------
-- Records of gms_action
-- ----------------------------
INSERT INTO `gms_action` VALUES ('1', 'Admin_Login', '管理员登录', '系统记录', '', '[user|get_username]在[time|time_format]登录了后台', '1', '1', '1444460123');
INSERT INTO `gms_action` VALUES ('2', 'Admin_Logout', '管理员退出', '系统记录', '', '[user|get_username]在[time|time_format]退出系统', '1', '1', '1444460123');

-- ----------------------------
-- Table structure for gms_action_log
-- ----------------------------
DROP TABLE IF EXISTS `gms_action_log`;
CREATE TABLE `gms_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` varchar(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

-- ----------------------------
-- Records of gms_action_log
-- ----------------------------

-- ----------------------------
-- Table structure for gms_addons
-- ----------------------------
DROP TABLE IF EXISTS `gms_addons`;
CREATE TABLE `gms_addons` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '插件名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '插件中文名称',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `disabled` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `isconfig` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许配置',
  `config` text,
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `author` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL DEFAULT '0.0.0' COMMENT '版本号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='已安装模块列表';

-- ----------------------------
-- Records of gms_addons
-- ----------------------------
INSERT INTO `gms_addons` VALUES ('12', 'SiteStat', '站点统计信息', '统计站点的基础信息', '1', '1', '0', '\"\"', '0', '0', '管侯杰', '0.1');

-- ----------------------------
-- Table structure for gms_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `gms_auth_group`;
CREATE TABLE `gms_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL COMMENT '用户组标题',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '用户组状态',
  `rules` text NOT NULL COMMENT '用户权限',
  `sort` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gms_auth_group
-- ----------------------------
INSERT INTO `gms_auth_group` VALUES ('1', '超级管理组', '1', '1,41,42,4,33,36,35,34,45,46,47,48,61,49,52,51,50,29,32,31,30,5,62,38,37,40,39,2', '1');

-- ----------------------------
-- Table structure for gms_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `gms_auth_rule`;
CREATE TABLE `gms_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `name` varchar(200) DEFAULT NULL COMMENT '节点',
  `title` char(20) NOT NULL COMMENT '标题',
  `icon` varchar(100) NOT NULL DEFAULT 'iconfont icon-other' COMMENT '图标',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '菜单类型',
  `hide` tinyint(2) NOT NULL DEFAULT '0' COMMENT '隐藏',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `condition` char(100) NOT NULL COMMENT '附加规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gms_auth_rule
-- ----------------------------
INSERT INTO `gms_auth_rule` VALUES ('1', '0', '', '系统', 'iconfont icon-tip', '2', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('2', '0', '', '用户', 'iconfont icon-yonghu', '2', '0', '1', '3', '');
INSERT INTO `gms_auth_rule` VALUES ('3', '0', '', '扩展', 'iconfont icon-ht_expand', '2', '0', '1', '9', '');
INSERT INTO `gms_auth_rule` VALUES ('4', '1', '', '系统设置', 'iconfont icon-shezhi', '2', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('5', '1', '', '数据库管理', 'iconfont icon-database', '2', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('6', '2', '', '用户管理', 'iconfont icon-yonghu', '2', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('7', '2', '', '行为管理', 'iconfont icon-xingwei', '2', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('8', '3', '', '在线平台', 'iconfont icon-pingtai', '2', '1', '0', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('9', '3', '', '模块管理', 'iconfont icon-mokuai', '2', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('10', '3', '', '插件管理', 'iconfont icon-478chajianku', '2', '0', '1', '3', '');
INSERT INTO `gms_auth_rule` VALUES ('11', '8', 'Admin/Cloud/index?type=1', '模块商店', 'iconfont icon-shangdian', '2', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('13', '7', 'Admin/Action/index', '行为管理', 'iconfont icon-xingwei', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('14', '13', 'Admin/Action/add', '新增', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('15', '13', 'Admin/Action/edit', '编辑', 'iconfont icon-edit', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('16', '13', 'Admin/Action/del', '删除', 'iconfont icon-remove', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('17', '7', 'Admin/ActionLog/index', '日志管理', 'iconfont icon-rizhi', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('20', '17', 'Admin/ActionLog/del', '删除', 'iconfont icon-remove', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('25', '6', 'Admin/AuthGroup/index', '用户组管理', 'iconfont icon-yonghuzu', '1', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('26', '25', 'Admin/AuthGroup/add', '新增', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('27', '25', 'Admin/AuthGroup/edit', '编辑', 'iconfont icon-edit', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('28', '25', 'Admin/AuthGroup/del', '删除', 'iconfont icon-remove', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('29', '4', 'Admin/AuthRule/index', '菜单管理', 'iconfont icon-caidan', '1', '0', '1', '5', '');
INSERT INTO `gms_auth_rule` VALUES ('30', '29', 'Admin/AuthRule/add', '新增', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('31', '29', 'Admin/AuthRule/edit', '编辑', 'iconfont icon-edit', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('32', '29', 'Admin/AuthRule/del', '删除', 'iconfont icon-remove', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('33', '4', 'Admin/Config/index', '配置管理', 'iconfont icon-shezhi', '1', '0', '1', '9', '');
INSERT INTO `gms_auth_rule` VALUES ('34', '33', 'Admin/Config/add', '新增', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('35', '33', 'Admin/Config/edit', '编辑', 'iconfont icon-edit', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('36', '33', 'Admin/Config/del', '删除', 'iconfont icon-remove', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('37', '5', 'Admin/Database/index?type=export', '备份数据库', 'iconfont icon-c-databackup', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('38', '62', 'Admin/Database/del', '删除', 'iconfont icon-remove', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('39', '37', 'Admin/Database/repair', '修复表', 'iconfont icon-database', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('40', '37', 'Admin/Database/optimize', '优化表', 'iconfont icon-database', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('41', '1', 'Admin/Index/index', '后台首页', 'iconfont icon-home', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('45', '4', 'Admin/Model/index', '模型管理', 'iconfont icon-moxing', '1', '0', '1', '3', '');
INSERT INTO `gms_auth_rule` VALUES ('46', '45', 'Admin/Model/add', '新增', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('47', '45', 'Admin/Model/edit', '编辑', 'iconfont icon-edit', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('48', '45', 'Admin/Model/del', '删除', 'iconfont icon-remove', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('49', '4', 'Admin/ModelField/index', '字段管理', 'iconfont icon-ziduan', '1', '1', '1', '4', '');
INSERT INTO `gms_auth_rule` VALUES ('50', '49', 'Admin/ModelField/add', '新增', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('51', '49', 'Admin/ModelField/edit', '编辑', 'iconfont icon-edit', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('52', '49', 'Admin/ModelField/del', '删除', 'iconfont icon-remove', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('61', '4', 'Admin/Config/group', '系统设置', 'iconfont icon-shezhi', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('94', '6', 'Admin/UserAdmin/index', '管理用户', 'iconfont icon-yonghu', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('95', '94', 'Admin/UserAdmin/add', '新增', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('96', '94', 'Admin/UserAdmin/edit', '编辑', 'iconfont icon-edit', '1', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('62', '5', 'Admin/Database/index?type=import', '还原数据库', 'iconfont icon-c-databackup', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('79', '10', 'Admin/Addons/index', '插件管理', 'iconfont icon-478chajianku', '1', '0', '1', '44', '');
INSERT INTO `gms_auth_rule` VALUES ('80', '4', 'Admin/Hooks/index', '钩子管理', 'iconfont icon-biezhen', '1', '0', '1', '20', '');
INSERT INTO `gms_auth_rule` VALUES ('81', '80', 'Admin/Hooks/add', '新增', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('82', '80', 'Admin/Hooks/edit', '编辑', 'iconfont icon-edit', '1', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('83', '80', 'Admin/Hooks/del', '删除', 'iconfont icon-remove', '1', '1', '1', '3', '');
INSERT INTO `gms_auth_rule` VALUES ('84', '17', 'Admin/ActionLog/look', '查看', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('90', '9', 'Admin/Module/index', '模块管理', 'iconfont icon-mokuai', '1', '0', '1', '0', '');
INSERT INTO `gms_auth_rule` VALUES ('91', '90', 'Admin/Module/add', '安装', 'iconfont icon-add', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('92', '90', 'Admin/Module/disabled', '启用', 'iconfont icon-add', '1', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('93', '90', 'Admin/Module/del', '卸载', 'iconfont icon-remove', '1', '1', '1', '3', '');
INSERT INTO `gms_auth_rule` VALUES ('97', '94', 'Admin/UserAdmin/del', '删除', 'iconfont icon-remove', '1', '1', '1', '3', '');
INSERT INTO `gms_auth_rule` VALUES ('98', '45', 'Admin/Build/index', '生成文件', 'iconfont icon-edit', '1', '0', '1', '0', '');

-- ----------------------------
-- Table structure for gms_cache
-- ----------------------------
DROP TABLE IF EXISTS `gms_cache`;
CREATE TABLE `gms_cache` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `key` char(100) NOT NULL DEFAULT '' COMMENT '缓存key值',
  `name` char(100) NOT NULL DEFAULT '' COMMENT '名称',
  `module` char(20) NOT NULL DEFAULT '' COMMENT '模块名称',
  `model` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `action` char(30) NOT NULL DEFAULT '' COMMENT '方法名',
  `param` char(255) NOT NULL DEFAULT '' COMMENT '参数',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统',
  PRIMARY KEY (`id`),
  KEY `ckey` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='缓存更新列队';

-- ----------------------------
-- Records of gms_cache
-- ----------------------------
INSERT INTO `gms_cache` VALUES ('1', 'Config', '网站配置', 'Admin', 'Config', 'cache', '', '1');
INSERT INTO `gms_cache` VALUES ('2', 'Action', '行为列表', 'Admin', 'Action', 'cache', '', '0');
INSERT INTO `gms_cache` VALUES ('3', 'ActionLog', '行为日志', 'Admin', 'ActionLog', 'cache', '', '0');
INSERT INTO `gms_cache` VALUES ('4', 'Model', '模型缓存', 'Admin', 'Model', 'cache', '', '0');
INSERT INTO `gms_cache` VALUES ('5', 'Module', '模型缓存', 'Admin', 'Module', 'cache', '', '0');

-- ----------------------------
-- Table structure for gms_config
-- ----------------------------
DROP TABLE IF EXISTS `gms_config`;
CREATE TABLE `gms_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '配置类型',
  `title` varchar(50) NOT NULL COMMENT '配置标题',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '配置分组',
  `extra` text NOT NULL COMMENT '配置参数',
  `remark` varchar(100) NOT NULL COMMENT '说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` int(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gms_config
-- ----------------------------
INSERT INTO `gms_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1467543386', '1467543386', '1', 'Gms管理系统', '0');
INSERT INTO `gms_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1467543386', '1467543386', '1', 'ThinkGms内置：thinkphp,EasyUI,AmazeUI,KE编辑器', '1');
INSERT INTO `gms_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1467543386', '1467543386', '1', '让你的开发更便捷！~', '8');
INSERT INTO `gms_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭\r\n1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1467543386', '1467543386', '1', '1', '1');
INSERT INTO `gms_config` VALUES ('9', 'CONFIG_TYPE_LIST', '3', '配置类型', '4', '', '主要用于数据解析和页面表单的生成', '1467543386', '1470589451', '1', '0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举\r\n5:编辑器\r\n6:方法选择', '2');
INSERT INTO `gms_config` VALUES ('10', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1467543386', '1467543386', '1', '000-1', '9');
INSERT INTO `gms_config` VALUES ('20', 'CONFIG_GROUP_LIST', '3', '配置分组', '4', '', '用于系统配置中批量更改的分组', '1467543386', '1467543386', '1', '1:基本\r\n2:内容\r\n3:用户\r\n4:系统', '4');
INSERT INTO `gms_config` VALUES ('28', 'DATA_BACKUP_PATH', '1', '数据库备份根路径', '4', '', '路径必须以 / 结尾', '1467543386', '1467543386', '1', './Data/', '5');
INSERT INTO `gms_config` VALUES ('29', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '4', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1467543386', '1467543386', '1', '20971520', '7');
INSERT INTO `gms_config` VALUES ('30', 'DATA_BACKUP_COMPRESS', '4', '数据库备份启用压缩', '4', '0:不压缩\r\n1:压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1467543386', '1467877500', '1', '1', '9');
INSERT INTO `gms_config` VALUES ('31', 'DATA_BACKUP_COMPRESS_LEVEL', '4', '数据库备份文件压缩级别', '4', '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1467543386', '1467876920', '1', '1', '10');
INSERT INTO `gms_config` VALUES ('37', 'SHOW_PAGE_TRACE', '4', '是否显示页面Trace信息', '4', '0:关闭\r\n1:开启', '是否显示页面Trace信息', '1467543386', '1467876897', '1', '0', '1');
INSERT INTO `gms_config` VALUES ('58', 'ACTION_TYPE', '3', '行为类型', '3', '', '行为的类型', '1467543386', '1467543386', '1', '1:系统\r\n2:用户', '0');
INSERT INTO `gms_config` VALUES ('59', 'USER_STATUS_TYPE', '3', '用户状态类型', '3', '', '用户状态类型', '1467543386', '1467543386', '1', '0:禁用\r\n1:启用', '0');
INSERT INTO `gms_config` VALUES ('60', 'USERGROUP_STATUS_TYPE', '3', '用户组状态', '3', '', '用户组状态', '1467543386', '1467543386', '1', '0:禁用\r\n1:启用\r\n2:暂停\r\n3:废弃', '0');
INSERT INTO `gms_config` VALUES ('61', 'ADMIN_QQ', '1', '管理员QQ', '4', '管理员的QQ号码', '', '1467543386', '1467543386', '1', '912524639', '0');
INSERT INTO `gms_config` VALUES ('63', 'ADMIN_LOGIN_BG_TYPE', '4', '后台登录背景类型', '4', '0:纯色\r\n1:根据值\r\n2:随机（1-5）', '', '1467543386', '1467876873', '1', '1', '0');
INSERT INTO `gms_config` VALUES ('64', 'ADMIN_LOGIN_BG_IMG', '2', '后台登录背景图片路径', '4', '', '', '1467543386', '1470134896', '1', './Public/Admin/images/Login/bg_1.jpg', '0');
INSERT INTO `gms_config` VALUES ('65', 'ADMIN_REME', '0', '后台记住密码时间', '4', '', '', '1467543386', '1467543386', '1', '3600', '0');
INSERT INTO `gms_config` VALUES ('67', 'DEFAULT_MODULE', '6', '默认模块', '4', 'Admin/Function/get_module_list', '', '1470589842', '1470589842', '1', 'Admin', '0');

-- ----------------------------
-- Table structure for gms_hooks
-- ----------------------------
DROP TABLE IF EXISTS `gms_hooks`;
CREATE TABLE `gms_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '钩子名称',
  `description` text COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL COMMENT '插件',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gms_hooks
-- ----------------------------
INSERT INTO `gms_hooks` VALUES ('1', 'pageHeader', '页面顶部钩子，一般用于加载插件CSS文件和代码', '1', '1467953904', '', '1');
INSERT INTO `gms_hooks` VALUES ('2', 'pageFooter', '页面底部钩子，一般用于加载插件JS文件和JS代码', '1', '1467953894', '', '1');
INSERT INTO `gms_hooks` VALUES ('3', 'AdminIndex', '后台首页', '1', '1467953937', 'SiteStat', '1');
INSERT INTO `gms_hooks` VALUES ('4', 'app_begin', '应用开始', '2', '1467953944', '', '1');

-- ----------------------------
-- Table structure for gms_model
-- ----------------------------
DROP TABLE IF EXISTS `gms_model`;
CREATE TABLE `gms_model` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` char(30) NOT NULL COMMENT '标识',
  `title` char(30) NOT NULL COMMENT '名称',
  `table_name` varchar(50) NOT NULL COMMENT '表名',
  `is_extend` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '允许子模型',
  `extend` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `list_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '列表类型',
  `list_edit` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许行编辑',
  `model_build` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '模型生成',
  `field_group` varchar(255) NOT NULL DEFAULT '1:基础' COMMENT '数据库引擎',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` tinyint(2) NOT NULL DEFAULT '1',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  `index_extend` text COMMENT '列表页面扩展代码',
  `add_extend` text COMMENT '新增页面扩展代码',
  `edit_extend` text COMMENT '编辑页面扩展代码',
  `action_extend` text COMMENT '控制器扩展代码',
  `model_extend` text COMMENT '模型扩展代码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='模型表';

-- ----------------------------
-- Records of gms_model
-- ----------------------------
INSERT INTO `gms_model` VALUES ('1', 'User', '用户', 'user', '1', '0', '0', '1', '1', '1:基础\r\n2:扩展', '1467445326', '1469799131', '1', '1', 'MyISAM', '', '', '', '', '');
INSERT INTO `gms_model` VALUES ('2', 'Config', '配置', 'config', '0', '0', '0', '0', '0', '1:基础', '1467536256', '1470591246', '1', '1', 'MyISAM', '', '', '', '	/*\r\n	 * 批量配置\r\n	 * Auth : Ghj\r\n	 * Time : 2015年06月20日\r\n	 */\r\n	public function group() {\r\n		if (IS_POST) {\r\n			$config = I ( \'post.config\' );\r\n			if ($config &amp;&amp; is_array ( $config )) {\r\n				foreach ( $config as $name =&gt; $value ) {\r\n					$map = array (\'name\' =&gt; $name);\r\n					M ( \'Config\' )-&gt;where ( $map )-&gt;setField ( \'value\', $value );\r\n				}\r\n			}\r\n			$this-&gt;Model-&gt;cache();\r\n			action_log(\'Group_Config\', \'Config\', I(\'get.id\'));\r\n			$this-&gt;success ( \'保存成功！\', U ( \'?id=\' . I ( \'get.id\' ) ) );\r\n		} else {\r\n			$_Type = model_field_attr ( C ( \'CONFIG_GROUP_LIST\' ) );\r\n			$_List = M ( &quot;Config&quot; )-&gt;where ( array (\'status\' =&gt; 1) )-&gt;field ( \'id,name,title,extra,value,remark,type\' )-&gt;order ( \'sort\' )-&gt;select ();\r\n			foreach ($_List as $_One){\r\n				$_Type_List[$_One[\'type\']][] = $_One;\r\n			}\r\n			$this-&gt;assign ( \'_Type_List\', $_Type_List );\r\n			$this-&gt;assign ( \'_Type\', $_Type );\r\n			$this-&gt;display ();\r\n		}\r\n	}', '    /* 更新配置缓存数据 */\r\n	public function cache(){\r\n		$_Config = $this-&gt;where(array(\'status\'=&gt;1))-&gt;getField ( \'name,value\' );\r\n		file_put_contents( APP_PATH . \'Common/Conf/db_extend.php\',&quot;&lt;?php\\nreturn &quot; . var_export($_Config, true) . &quot;;\\n?&gt;&quot;);\r\n	}');
INSERT INTO `gms_model` VALUES ('3', 'UserAdmin', '管理用户', 'user_admin', '0', '1', '0', '1', '1', '1:基础\r\n2:扩展', '1467607867', '1467816080', '1', '1', 'MyISAM', null, '', '', '', '');
INSERT INTO `gms_model` VALUES ('5', 'AuthGroup', '用户组', 'auth_group', '0', '0', '0', '0', '0', '1:基础', '1467880238', '1467880261', '1', '1', 'MyISAM', '', '', '', '', '');
INSERT INTO `gms_model` VALUES ('6', 'AuthRule', '菜单', 'auth_rule', '0', '0', '1', '0', '0', '1:基础', '1467950200', '1467952244', '1', '1', 'MyISAM', '', '&lt;script type=&quot;text/javascript&quot;&gt;\r\n$(\'#for_icon\').combobox({    \r\n	formatter: function(row){\r\n		var opts = $(this).combobox(\'options\');\r\n		return \'&lt;i class=\\\'iconfont \'+row[opts.textField]+\'\\\'&gt;&lt;/i&gt; \'+row[opts.textField];\r\n	}\r\n}); \r\n&lt;/script&gt;\r\n', '&lt;script type=&quot;text/javascript&quot;&gt;\r\n$(\'#for_icon\').combobox({    \r\n	formatter: function(row){\r\n		var opts = $(this).combobox(\'options\');\r\n		return \'&lt;i class=\\\'iconfont \'+row[opts.textField]+\'\\\'&gt;&lt;/i&gt; \'+row[opts.textField];\r\n	}\r\n}); \r\n&lt;/script&gt;\r\n', '', '');
INSERT INTO `gms_model` VALUES ('7', 'Action', '行为', 'action', '0', '0', '0', '0', '0', '1:基础', '1467953358', '1467954058', '1', '1', 'MyISAM', '', '', '', '', '\r\n	public function cache(){\r\n		S(\'action_list\',null);\r\n		$action_list=$this-&gt;getField(\'id,name,title,remark,rule,log,type,status\');\r\n		S(\'action_list\',$action_list);\r\n	}');
INSERT INTO `gms_model` VALUES ('8', 'Hooks', '钩子', 'hooks', '0', '0', '0', '0', '0', '1:基础', '1467953391', '1467953431', '1', '1', 'MyISAM', '', '', '', '', '');

-- ----------------------------
-- Table structure for gms_model_field
-- ----------------------------
DROP TABLE IF EXISTS `gms_model_field`;
CREATE TABLE `gms_model_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `group_id` varchar(20) NOT NULL DEFAULT '1' COMMENT '字段分组ID',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `field` varchar(100) NOT NULL COMMENT '字段定义',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `extra` text NOT NULL COMMENT '参数',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `sort_l` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '列表',
  `sort_s` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '搜索',
  `sort_a` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '新增',
  `sort_e` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '修改',
  `is_sort` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序关键字',
  `l_width` varchar(10) NOT NULL DEFAULT '100' COMMENT '列表宽度',
  `is_fixed` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否在列表固定',
  `validate_rule` text NOT NULL COMMENT '验证规则',
  `auto_rule` text NOT NULL COMMENT '完成规则',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COMMENT='模型字段表';

-- ----------------------------
-- Records of gms_model_field
-- ----------------------------
INSERT INTO `gms_model_field` VALUES ('1', '1', 'username', '用户名', '1', 'string', 'varchar(64) NOT NULL ', '', '', 'a:1:{s:8:\"required\";s:1:\"0\";}', '1', '1', '1', '1', '1', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('2', '1', 'nickname', '昵称/姓名', '1', 'string', 'varchar(50) NOT NULL ', '', '', 'a:1:{s:8:\"required\";s:1:\"0\";}', '1', '2', '2', '2', '2', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('3', '1', 'password', '密码', '1', 'string', 'char(32) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"1\";s:5:\"style\";s:0:\"\";}', '1', '0', '0', '3', '3', '0', '100', '0', '', '', '1467543386', '1467865111');
INSERT INTO `gms_model_field` VALUES ('4', '1', 'last_login_time', '上次登录时间', '1', 'string', 'int(11) unsigned NULL ', '0', '', 'a:1:{s:8:\"required\";s:1:\"0\";}', '1', '0', '0', '0', '0', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('5', '1', 'last_login_ip', '上次登录IP', '1', 'string', 'varchar(40) NULL ', '', '', 's:49:\"a:1:{s:8:&quot;required&quot;;s:1:&quot;0&quot;;}\";', '1', '0', '0', '0', '0', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('8', '1', 'head_img', '头像', '1', 'pictures', 'varchar(255) NULL ', '', '', 'a:1:{s:11:\"updata_type\";s:3:\"Img\";}', '1', '0', '0', '8', '8', '0', '100', '0', '', '', '1467543386', '1467865416');
INSERT INTO `gms_model_field` VALUES ('9', '1', 'remark', '备注', '1', 'textarea', 'varchar(255) NULL ', '', '', 'a:2:{s:5:\"width\";s:5:\"300px\";s:6:\"height\";s:4:\"80px\";}', '1', '0', '0', '17', '17', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('10', '1', 'amount', '余额', '1', 'string', 'decimal(10,2) unsigned NULL ', '0.00', '', 's:49:\"a:1:{s:8:&quot;required&quot;;s:1:&quot;0&quot;;}\";', '1', '10', '0', '0', '0', '0', '50', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('11', '1', 'point', '积分', '1', 'string', 'tinyint(8) unsigned NULL ', '0', '', 's:83:\"s:49:&quot;a:1:{s:8:&amp;quot;required&amp;quot;;s:1:&amp;quot;0&amp;quot;;}&quot;;\";', '1', '11', '0', '0', '0', '0', '50', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('12', '1', 'vip', 'vip等级', '1', 'select', 'tinyint(4) unsigned NULL ', '0', '', 'a:7:{s:4:\"type\";s:8:\"Function\";s:6:\"option\";s:29:\"Admin/Function/get_user_level\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"1\";s:5:\"style\";s:0:\"\";}', '1', '12', '12', '12', '12', '0', '60', '0', '', '', '1467543386', '1470125872');
INSERT INTO `gms_model_field` VALUES ('13', '1', 'vip_end_time', 'vip到期时间', '1', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', '', 'a:4:{s:9:\"from_type\";s:11:\"datetimebox\";s:8:\"required\";s:1:\"0\";s:8:\"add_time\";s:1:\"1\";s:5:\"style\";s:0:\"\";}', '1', '13', '13', '13', '13', '0', '100', '0', '', '', '1467543386', '1467861053');
INSERT INTO `gms_model_field` VALUES ('14', '1', 'create_time', '创建时间', '1', 'datetime', 'int(11) unsigned NULL ', '0', '', 'a:2:{s:9:\"from_type\";s:7:\"datebox\";s:8:\"required\";s:1:\"0\";}', '1', '14', '14', '0', '0', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('15', '1', 'update_time', '更新时间', '1', 'datetime', 'int(11) unsigned NULL ', '0', '', 'a:2:{s:9:\"from_type\";s:7:\"datebox\";s:8:\"required\";s:1:\"0\";}', '1', '15', '15', '0', '0', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('16', '1', 'status', '状态', '1', 'select', 'varchar(10) NOT NULL', '1', '', 'a:7:{s:4:\"type\";s:6:\"Config\";s:6:\"option\";s:16:\"USER_STATUS_TYPE\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '16', '16', '16', '16', '0', '40', '0', '', '', '1467543386', '1467860871');
INSERT INTO `gms_model_field` VALUES ('18', '1', 'group_ids', '用户组ID', '1', 'string', 'varchar(255) NULL ', '', '', 'a:1:{s:8:\"required\";s:1:\"0\";}', '1', '6', '6', '0', '0', '0', '100', '0', '', '', '1467543386', '1467612482');
INSERT INTO `gms_model_field` VALUES ('19', '2', 'name', '配置名称', '1', 'string', 'varchar(30) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '1', '1', '1', '1', '0', '160', '1', '', '', '1467543386', '1467877469');
INSERT INTO `gms_model_field` VALUES ('20', '2', 'type', '配置类型', '1', 'select', 'tinyint(3) unsigned NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Config\";s:6:\"option\";s:16:\"CONFIG_TYPE_LIST\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '2', '2', '2', '2', '0', '60', '0', '', '', '1467543386', '1467877520');
INSERT INTO `gms_model_field` VALUES ('21', '2', 'title', '配置标题', '1', 'string', 'varchar(50) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '3', '3', '3', '3', '0', '160', '1', '', '', '1467543386', '1467877478');
INSERT INTO `gms_model_field` VALUES ('22', '2', 'group', '配置分组', '1', 'select', 'tinyint(3) unsigned NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Config\";s:6:\"option\";s:17:\"CONFIG_GROUP_LIST\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '4', '4', '4', '4', '0', '60', '0', '', '', '1467543386', '1467877528');
INSERT INTO `gms_model_field` VALUES ('23', '2', 'extra', '配置参数', '1', 'textarea', 'text NOT NULL ', '', '', 'a:2:{s:5:\"width\";s:5:\"300px\";s:6:\"height\";s:5:\"100px\";}', '1', '0', '0', '5', '5', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('24', '2', 'remark', '说明', '1', 'textarea', 'varchar(100) NOT NULL ', '', '', 'a:2:{s:5:\"width\";s:5:\"300px\";s:6:\"height\";s:5:\"100px\";}', '1', '0', '0', '6', '6', '0', '100', '0', '', '', '1467543386', '1467543386');
INSERT INTO `gms_model_field` VALUES ('25', '2', 'create_time', '创建时间', '1', 'datetime', 'int(11) unsigned NOT NULL ', '0', '', 'a:4:{s:9:\"from_type\";s:7:\"datebox\";s:8:\"required\";s:1:\"0\";s:8:\"add_time\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '7', '7', '0', '0', '0', '80', '0', '', '', '1467543386', '1467877539');
INSERT INTO `gms_model_field` VALUES ('26', '2', 'update_time', '更新时间', '1', 'datetime', 'int(11) unsigned NOT NULL ', '0', '', 'a:4:{s:9:\"from_type\";s:7:\"datebox\";s:8:\"required\";s:1:\"0\";s:8:\"add_time\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '8', '8', '0', '0', '0', '80', '0', '', '', '1467543386', '1467877546');
INSERT INTO `gms_model_field` VALUES ('27', '2', 'status', '状态', '1', 'select', 'int(3) unsigned NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:18:\"1:启用\r\n0:禁用\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '9', '9', '9', '9', '0', '50', '0', '', '', '1467543386', '1467877560');
INSERT INTO `gms_model_field` VALUES ('28', '2', 'value', '配置值', '1', 'textarea', 'text NOT NULL ', '', '', 'a:1:{s:5:\"style\";s:0:\"\";}', '1', '0', '0', '10', '10', '0', '100', '0', '', '', '1467543386', '1467877572');
INSERT INTO `gms_model_field` VALUES ('29', '2', 'sort', '排序', '1', 'num', 'int(4) unsigned NOT NULL ', '0', '', 'a:10:{s:8:\"required\";s:1:\"0\";s:5:\"style\";s:0:\"\";s:8:\"unsifned\";s:1:\"1\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:9:\"precision\";s:1:\"0\";s:16:\"decimalSeparator\";s:1:\".\";s:14:\"groupSeparator\";s:1:\",\";s:6:\"prefix\";s:0:\"\";s:6:\"suffix\";s:0:\"\";}', '1', '11', '0', '11', '11', '0', '50', '0', '', '', '1467543386', '1467877583');
INSERT INTO `gms_model_field` VALUES ('30', '1', 'email', '邮箱', '1', 'string', 'varchar(255) NOT NULL', '', '', 'a:1:{s:8:\"required\";s:1:\"0\";}', '1', '4', '4', '4', '4', '0', '100', '0', '', '', '1467606609', '1467606623');
INSERT INTO `gms_model_field` VALUES ('31', '1', 'phone', '手机', '1', 'string', 'varchar(20) NOT NULL', '', '', 'a:1:{s:8:\"required\";s:1:\"0\";}', '1', '5', '5', '5', '5', '0', '100', '0', '', '', '1467612421', '1467612432');
INSERT INTO `gms_model_field` VALUES ('32', '3', 'birthday', '生日', '1', 'datetime', 'int(11) UNSIGNED NOT NULL', '', '', 'a:4:{s:9:\"from_type\";s:7:\"datebox\";s:8:\"required\";s:1:\"0\";s:8:\"add_time\";s:1:\"1\";s:5:\"style\";s:0:\"\";}', '1', '6', '6', '6', '6', '0', '100', '0', '', '', '1467700861', '1467860887');
INSERT INTO `gms_model_field` VALUES ('33', '5', 'title', '用户组标题', '1', 'string', 'varchar(80) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '1', '1', '1', '1', '0', '120', '0', '', '', '1467880238', '1467880291');
INSERT INTO `gms_model_field` VALUES ('34', '5', 'status', '用户组状态', '1', 'select', 'tinyint(2) NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:18:\"0:禁用\r\n1:启用\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '2', '2', '2', '2', '0', '100', '0', '', '', '1467880238', '1467880395');
INSERT INTO `gms_model_field` VALUES ('35', '5', 'rules', '用户权限', '1', 'select', 'text NOT NULL ', '', '', 'a:7:{s:4:\"type\";s:8:\"Function\";s:6:\"option\";s:28:\"Admin/Function/get_auth_rule\";s:9:\"form_type\";s:1:\"2\";s:8:\"multiple\";s:1:\"1\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '0', '0', '3', '3', '0', '100', '0', '', '', '1467880238', '1467880451');
INSERT INTO `gms_model_field` VALUES ('36', '5', 'sort', '排序', '1', 'num', 'int(10) unsigned NOT NULL ', '1', '', 'a:10:{s:8:\"required\";s:1:\"0\";s:5:\"style\";s:24:\"width: 50px;height:30px;\";s:8:\"unsifned\";s:1:\"0\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:9:\"precision\";s:1:\"0\";s:16:\"decimalSeparator\";s:1:\".\";s:14:\"groupSeparator\";s:1:\",\";s:6:\"prefix\";s:0:\"\";s:6:\"suffix\";s:0:\"\";}', '1', '4', '4', '4', '4', '0', '100', '0', '', '', '1467880238', '1467882226');
INSERT INTO `gms_model_field` VALUES ('37', '6', 'pid', '上级菜单', '1', 'select', 'mediumint(8) unsigned NOT NULL ', '0', '', 'a:7:{s:4:\"type\";s:8:\"Function\";s:6:\"option\";s:28:\"Admin/Function/get_auth_rule\";s:9:\"form_type\";s:1:\"2\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '0', '1', '1', '1', '0', '100', '0', '', '', '1467950201', '1467952521');
INSERT INTO `gms_model_field` VALUES ('38', '6', 'name', '节点', '1', 'string', 'varchar(200) NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '2', '2', '2', '2', '0', '200', '0', '', '', '1467950201', '1467951958');
INSERT INTO `gms_model_field` VALUES ('39', '6', 'title', '标题', '1', 'string', 'char(20) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '1', '3', '3', '3', '0', '200', '0', '', '', '1467950201', '1467951951');
INSERT INTO `gms_model_field` VALUES ('40', '6', 'icon', '图标', '1', 'select', 'varchar(100) NOT NULL ', 'iconfont icon-other', '', 'a:7:{s:4:\"type\";s:8:\"Function\";s:6:\"option\";s:23:\"Admin/Function/get_icon\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '0', '0', '4', '4', '0', '100', '0', '', '', '1467950201', '1467952006');
INSERT INTO `gms_model_field` VALUES ('41', '6', 'type', '菜单类型', '1', 'select', 'tinyint(1) NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:28:\"1:节点\r\n2:菜单\r\n3:外链\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '5', '5', '5', '5', '0', '50', '0', '', '', '1467950201', '1467951865');
INSERT INTO `gms_model_field` VALUES ('42', '6', 'hide', '隐藏', '1', 'select', 'tinyint(2) NOT NULL ', '0', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:12:\"0:否\r\n1:是\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '6', '6', '6', '6', '0', '50', '0', '', '', '1467950201', '1467950362');
INSERT INTO `gms_model_field` VALUES ('43', '6', 'status', '状态', '1', 'select', 'tinyint(1) NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:18:\"1:启用\r\n0:禁用\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '7', '7', '7', '7', '0', '50', '0', '', '', '1467950201', '1467951823');
INSERT INTO `gms_model_field` VALUES ('44', '6', 'sort', '排序', '1', 'num', 'tinyint(4) unsigned NOT NULL ', '0', '', 'a:10:{s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";s:8:\"unsifned\";s:1:\"0\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:9:\"precision\";s:1:\"0\";s:16:\"decimalSeparator\";s:1:\".\";s:14:\"groupSeparator\";s:1:\",\";s:6:\"prefix\";s:0:\"\";s:6:\"suffix\";s:0:\"\";}', '1', '8', '8', '8', '8', '0', '50', '0', '', '', '1467950201', '1467950324');
INSERT INTO `gms_model_field` VALUES ('45', '6', 'condition', '附加规则', '1', 'textarea', 'char(100) NOT NULL ', '', '', 'a:1:{s:5:\"style\";s:26:\"width:300px; height:100px;\";}', '1', '0', '0', '9', '9', '0', '100', '0', '', '', '1467950201', '1467950343');
INSERT INTO `gms_model_field` VALUES ('46', '7', 'name', '标识', '1', 'string', 'char(30) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '1', '1', '1', '1', '0', '100', '1', '', '', '1467953358', '1470128435');
INSERT INTO `gms_model_field` VALUES ('47', '7', 'title', '标题', '1', 'string', 'char(80) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '2', '2', '2', '2', '0', '150', '1', '', '', '1467953358', '1467954332');
INSERT INTO `gms_model_field` VALUES ('48', '7', 'remark', '描述', '1', 'textarea', 'char(140) NOT NULL ', '', '', 'a:1:{s:5:\"style\";s:26:\"width:300px; height:100px;\";}', '1', '3', '3', '3', '3', '0', '180', '0', '', '', '1467953358', '1467954298');
INSERT INTO `gms_model_field` VALUES ('49', '7', 'rule', '行为规则', '1', 'textarea', 'text NOT NULL ', '', '', 'a:1:{s:5:\"style\";s:26:\"width:300px; height:100px;\";}', '1', '0', '0', '4', '4', '0', '100', '0', '', '', '1467953358', '1467954274');
INSERT INTO `gms_model_field` VALUES ('50', '7', 'log', '日志规则', '1', 'textarea', 'text NOT NULL ', '', '', 'a:1:{s:5:\"style\";s:26:\"width:300px; height:100px;\";}', '1', '0', '0', '5', '5', '0', '100', '0', '', '', '1467953358', '1467954260');
INSERT INTO `gms_model_field` VALUES ('51', '7', 'type', '类型', '1', 'select', 'tinyint(2) unsigned NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:18:\"1:系统\r\n2:用户\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '6', '6', '6', '6', '0', '50', '0', '', '', '1467953358', '1467954233');
INSERT INTO `gms_model_field` VALUES ('52', '7', 'status', '状态', '1', 'select', 'tinyint(2) NOT NULL ', '0', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:18:\"1:启用\r\n0:禁用\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '7', '7', '7', '7', '0', '50', '0', '', '', '1467953358', '1467954120');
INSERT INTO `gms_model_field` VALUES ('53', '7', 'update_time', '修改时间', '1', 'datetime', 'int(11) unsigned NOT NULL ', '0', '', 'a:4:{s:9:\"from_type\";s:7:\"datebox\";s:8:\"required\";s:1:\"0\";s:8:\"add_time\";s:1:\"1\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '8', '8', '0', '0', '0', '100', '0', '', '', '1467953358', '1467954075');
INSERT INTO `gms_model_field` VALUES ('54', '8', 'name', '钩子名称', '1', 'string', 'varchar(40) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '1', '1', '1', '1', '0', '180', '1', '', '', '1467953392', '1467953539');
INSERT INTO `gms_model_field` VALUES ('55', '8', 'description', '描述', '1', 'textarea', 'text NULL ', '', '', 'a:1:{s:5:\"style\";s:26:\"width:300px; height:100px;\";}', '1', '0', '0', '2', '2', '0', '100', '0', '', '', '1467953392', '1467953453');
INSERT INTO `gms_model_field` VALUES ('56', '8', 'type', '类型', '1', 'select', 'tinyint(1) unsigned NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:21:\"1:视图\r\n2:控制器\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '3', '3', '3', '3', '0', '50', '0', '', '', '1467953392', '1467953531');
INSERT INTO `gms_model_field` VALUES ('57', '8', 'update_time', '更新时间', '1', 'datetime', 'int(10) unsigned NOT NULL ', '0', '', 'a:4:{s:9:\"from_type\";s:7:\"datebox\";s:8:\"required\";s:1:\"0\";s:8:\"add_time\";s:1:\"1\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '4', '4', '0', '0', '0', '100', '0', '', '', '1467953392', '1467953576');
INSERT INTO `gms_model_field` VALUES ('58', '8', 'addons', '插件', '1', 'textarea', 'varchar(255) NOT NULL ', '', '以“,”分割', 'a:1:{s:5:\"style\";s:26:\"width:300px; height:100px;\";}', '1', '0', '0', '5', '5', '0', '100', '0', '', '', '1467953392', '1467953808');
INSERT INTO `gms_model_field` VALUES ('59', '8', 'status', '状态', '1', 'select', 'tinyint(1) unsigned NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:18:\"0:禁用\r\n1:启用\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '6', '6', '6', '6', '0', '100', '0', '', '', '1467953392', '1467953856');
INSERT INTO `gms_model_field` VALUES ('97', '36', 'modelid', '模型ID', '1', 'select', 'smallint(5) unsigned NOT NULL ', '0', '', 'a:7:{s:4:\"type\";s:8:\"Function\";s:6:\"option\";s:21:\"Home/Api/get_model_id\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '4', '4', '4', '4', '0', '100', '0', '', '', '1470126124', '1470229684');
INSERT INTO `gms_model_field` VALUES ('98', '36', 'domain', '栏目绑定域名', '1', 'string', 'varchar(200) NOT NULL ', '', '', 'a:1:{s:8:\"required\";s:1:\"0\";}', '1', '5', '5', '5', '5', '0', '100', '0', '', '', '1470126124', '1470126124');
INSERT INTO `gms_model_field` VALUES ('99', '36', 'pid', '上级分类', '1', 'select', 'smallint(5) unsigned NOT NULL ', '0', '', 'a:7:{s:4:\"type\";s:8:\"Function\";s:6:\"option\";s:21:\"Home/Api/get_category\";s:9:\"form_type\";s:1:\"2\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '6', '6', '6', '6', '0', '100', '0', '', '', '1470126124', '1470230957');
INSERT INTO `gms_model_field` VALUES ('100', '36', 'arrparentid', '所有父ID', '1', 'string', 'varchar(255) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '0', '0', '0', '0', '0', '100', '0', '', '', '1470126124', '1470126756');
INSERT INTO `gms_model_field` VALUES ('101', '36', 'child', '终极栏目', '1', 'select', 'tinyint(1) unsigned NOT NULL ', '0', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:12:\"1:是\r\n0:否\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '8', '8', '8', '8', '0', '100', '1', '', '', '1470126124', '1470126818');
INSERT INTO `gms_model_field` VALUES ('102', '36', 'arrchildid', '所有子栏目ID', '1', 'string', 'mediumtext NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '0', '0', '0', '0', '0', '100', '0', '', '', '1470126124', '1470126842');
INSERT INTO `gms_model_field` VALUES ('103', '36', 'title', '栏目名称', '1', 'string', 'varchar(30) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '10', '10', '10', '10', '0', '100', '0', '', '', '1470126124', '1470126868');
INSERT INTO `gms_model_field` VALUES ('104', '36', 'image', '栏目图片', '1', 'pictures', 'varchar(100) NOT NULL ', '', '', 'a:1:{s:11:\"updata_type\";s:3:\"Img\";}', '1', '0', '0', '11', '11', '0', '100', '0', '', '', '1470126124', '1470126887');
INSERT INTO `gms_model_field` VALUES ('105', '36', 'description', '栏目描述', '1', 'textarea', 'mediumtext NULL ', '', '', 'a:1:{s:5:\"style\";s:26:\"width:300px; height:100px;\";}', '1', '0', '0', '12', '12', '0', '100', '0', '', '', '1470126124', '1470126919');
INSERT INTO `gms_model_field` VALUES ('108', '36', 'url', '链接地址', '1', 'string', 'varchar(100) NOT NULL ', '', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '0', '0', '0', '0', '0', '100', '0', '', '', '1470126124', '1470126934');
INSERT INTO `gms_model_field` VALUES ('109', '36', 'hits', '点击', '1', 'num', 'int(10) unsigned NOT NULL ', '0', '', 'a:10:{s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";s:8:\"unsifned\";s:1:\"0\";s:3:\"min\";s:0:\"\";s:3:\"max\";s:0:\"\";s:9:\"precision\";s:1:\"0\";s:16:\"decimalSeparator\";s:1:\".\";s:14:\"groupSeparator\";s:1:\",\";s:6:\"prefix\";s:0:\"\";s:6:\"suffix\";s:0:\"\";}', '1', '16', '16', '16', '16', '0', '40', '0', '', '', '1470126124', '1470126962');
INSERT INTO `gms_model_field` VALUES ('111', '36', 'sort', '排序', '1', 'string', 'smallint(5) unsigned NOT NULL ', '0', '', 'a:3:{s:8:\"required\";s:1:\"0\";s:11:\"is_password\";s:1:\"0\";s:5:\"style\";s:0:\"\";}', '1', '18', '0', '18', '18', '0', '40', '0', '', '', '1470126124', '1470126986');
INSERT INTO `gms_model_field` VALUES ('112', '36', 'ismenu', '显示', '1', 'select', 'tinyint(1) unsigned NOT NULL ', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:12:\"0:否\r\n1:是\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '19', '19', '19', '19', '0', '50', '0', '', '', '1470126124', '1470153238');
INSERT INTO `gms_model_field` VALUES ('115', '36', 'status', '状态', '1', 'select', 'int(10) UNSIGNED NOT NULL', '1', '', 'a:7:{s:4:\"type\";s:6:\"Option\";s:6:\"option\";s:18:\"1:启用\r\n0:禁用\";s:9:\"form_type\";s:1:\"1\";s:8:\"multiple\";s:1:\"0\";s:8:\"editable\";s:5:\"false\";s:8:\"required\";s:1:\"0\";s:5:\"style\";s:12:\"height:30px;\";}', '1', '14', '0', '14', '14', '0', '100', '0', '', '', '1470230687', '1470232067');

-- ----------------------------
-- Table structure for gms_module
-- ----------------------------
DROP TABLE IF EXISTS `gms_module`;
CREATE TABLE `gms_module` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '模块名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '模块中文名称',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `disabled` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `isconfig` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许配置',
  `config` text,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `author` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL DEFAULT '0.0.0' COMMENT '版本号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='已安装模块列表';

-- ----------------------------
-- Records of gms_module
-- ----------------------------

-- ----------------------------
-- Table structure for gms_user
-- ----------------------------
DROP TABLE IF EXISTS `gms_user`;
CREATE TABLE `gms_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL COMMENT '用户名',
  `nickname` varchar(50) NOT NULL COMMENT '昵称/姓名',
  `password` char(32) NOT NULL COMMENT '密码',
  `last_login_time` int(11) unsigned DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(40) DEFAULT NULL COMMENT '上次登录IP',
  `head_img` varchar(255) DEFAULT '' COMMENT '头像',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `amount` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '余额',
  `point` tinyint(8) unsigned DEFAULT '0' COMMENT '积分',
  `vip` tinyint(4) unsigned DEFAULT '0' COMMENT 'vip等级',
  `vip_end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'vip到期时间',
  `create_time` int(11) unsigned DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  `status` varchar(10) NOT NULL DEFAULT '1' COMMENT '状态',
  `group_ids` varchar(255) DEFAULT NULL COMMENT '用户组ID',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `extend_model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展模型ID',
  `phone` varchar(20) NOT NULL COMMENT '手机',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of gms_user
-- ----------------------------
INSERT INTO `gms_user` VALUES ('1', 'admin', '超级管理员', '21232f297a57a5a743894a0e4a801fc3', '1458905437', '127.0.0.1', '/ThinkGMS/Uploads/1/image/2016-07-27/57979d21f27db.jpg', '哈哈', '0.00', '0', '0', '1469554326', '1458034376', '1469554342', '1', '1,2', '123', '3', '123');

-- ----------------------------
-- Table structure for gms_user_admin
-- ----------------------------
DROP TABLE IF EXISTS `gms_user_admin`;
CREATE TABLE `gms_user_admin` (
  `id` int(10) unsigned NOT NULL COMMENT '主键',
  `birthday` int(11) unsigned NOT NULL COMMENT '生日',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gms_user_admin
-- ----------------------------
INSERT INTO `gms_user_admin` VALUES ('1', '1469548800');

-- ----------------------------
-- Table structure for gms_user_level
-- ----------------------------
DROP TABLE IF EXISTS `gms_user_level`;
CREATE TABLE `gms_user_level` (
  `id` int(10) unsigned NOT NULL COMMENT '主键',
  `title` varchar(30) NOT NULL COMMENT '名称',
  `level` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '等级',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gms_user_level
-- ----------------------------
INSERT INTO `gms_user_level` VALUES ('1', '非VIP', '0', '1');
INSERT INTO `gms_user_level` VALUES ('2', '普通会员', '1', '1');
