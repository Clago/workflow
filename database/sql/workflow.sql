/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50542
 Source Host           : localhost
 Source Database       : workflow

 Target Server Type    : MySQL
 Target Server Version : 50542
 File Encoding         : utf-8

 Date: 05/05/2017 14:50:13 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `dept`
-- ----------------------------
DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0',
  `director_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门主管 0表示不存在',
  `manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门经理 0表示不存在',
  `rank` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `dept_name` (`dept_name`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='部门表';

-- ----------------------------
--  Table structure for `emp`
-- ----------------------------
DROP TABLE IF EXISTS `emp`;
CREATE TABLE `emp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workno` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工号',
  `dept_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门id',
  `leave` smallint(6) NOT NULL DEFAULT '0' COMMENT '离职状态',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_workno_unique` (`workno`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `entry`
-- ----------------------------
DROP TABLE IF EXISTS `entry`;
CREATE TABLE `entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '标题',
  `flow_id` int(11) NOT NULL DEFAULT '0',
  `emp_id` int(11) NOT NULL DEFAULT '0' COMMENT '发起人',
  `process_id` int(11) NOT NULL DEFAULT '0' COMMENT '当前步骤id',
  `circle` smallint(6) NOT NULL DEFAULT '1' COMMENT '第几轮申请',
  `status` int(11) NOT NULL COMMENT '当前状态 0处理中 9通过 -1驳回 -2撤销 -9草稿\n1：流程中\n9：处理完成',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父流程',
  `enter_process_id` int(11) NOT NULL DEFAULT '0' COMMENT '进入子流程的父流程步骤id',
  `enter_proc_id` int(11) NOT NULL DEFAULT '0' COMMENT '进入子流程的进程id',
  `child` int(11) NOT NULL DEFAULT '0' COMMENT '子流程 process_id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_id` (`flow_id`),
  KEY `emp_id` (`emp_id`),
  KEY `step_id` (`process_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='流程实例';

-- ----------------------------
--  Table structure for `entry_data`
-- ----------------------------
DROP TABLE IF EXISTS `entry_data`;
CREATE TABLE `entry_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL DEFAULT '0',
  `flow_id` int(11) NOT NULL DEFAULT '0',
  `field_name` varchar(128) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `field_value` text COLLATE utf8mb4_bin,
  `field_remark` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`),
  KEY `workflow_id` (`flow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='实例数据表';

-- ----------------------------
--  Table structure for `flow`
-- ----------------------------
DROP TABLE IF EXISTS `flow`;
CREATE TABLE `flow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_no` varchar(45) COLLATE utf8mb4_bin NOT NULL COMMENT '工作流编号',
  `flow_name` varchar(45) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '工作流名称',
  `template_id` int(255) NOT NULL DEFAULT '0',
  `flowchart` text COLLATE utf8mb4_bin,
  `jsplumb` text COLLATE utf8mb4_bin COMMENT 'jsplumb流程图数据',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '流程设计文件',
  `is_publish` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否发布，发布后可用',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='工作流定义表';

-- ----------------------------
--  Table structure for `flow_type`
-- ----------------------------
DROP TABLE IF EXISTS `flow_type`;
CREATE TABLE `flow_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `type_name` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='流程分类表';

-- ----------------------------
--  Table structure for `flowlink`
-- ----------------------------
DROP TABLE IF EXISTS `flowlink`;
CREATE TABLE `flowlink` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL COMMENT '流程id',
  `type` varchar(45) COLLATE utf8mb4_bin NOT NULL COMMENT 'Condition:表示步骤流转\nRole:当前步骤操作人',
  `process_id` int(11) NOT NULL COMMENT '当前步骤id',
  `next_process_id` int(11) NOT NULL DEFAULT '-1' COMMENT '下一个步骤 Condition -1未指定 0结束 -9上级查找\ntype=Role时为0，不启用',
  `auditor` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '0' COMMENT '审批人 系统自动 指定人员 指定部门 指定角色\ntype=Condition时不启用',
  `expression` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '条件判断表达式\n为1表示true，通过的话直接进入下一步骤',
  `sort` int(11) NOT NULL COMMENT '条件判断顺序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_id` (`flow_id`),
  KEY `step_id` (`process_id`),
  KEY `emp_id` (`auditor`(191))
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='流程步骤流转轨迹';

-- ----------------------------
--  Table structure for `proc`
-- ----------------------------
DROP TABLE IF EXISTS `proc`;
CREATE TABLE `proc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `flow_id` int(11) NOT NULL COMMENT '流程id',
  `process_id` int(11) NOT NULL COMMENT '当前步骤',
  `process_name` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '当前步骤名称',
  `emp_id` int(11) NOT NULL COMMENT '审核人',
  `emp_name` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '审核人名称',
  `dept_name` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '审核人部门名称',
  `auditor_id` int(11) NOT NULL DEFAULT '0' COMMENT '具体操作人',
  `auditor_name` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '操作人名称',
  `auditor_dept` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '操作人部门',
  `status` int(11) NOT NULL COMMENT '当前处理状态 0待处理 9通过 -1驳回\n0：处理中\n-1：驳回\n9：会签',
  `content` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '批复内容',
  `is_read` int(11) NOT NULL DEFAULT '0' COMMENT '是否查看',
  `is_real` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核人和操作人是否同一人',
  `circle` smallint(6) NOT NULL DEFAULT '1',
  `beizhu` text COLLATE utf8mb4_bin COMMENT '备注',
  `concurrence` int(11) NOT NULL DEFAULT '0' COMMENT '并行查找解决字段， 部门 角色 指定 分组用',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`),
  KEY `workflow_id` (`flow_id`),
  KEY `emp_id` (`emp_id`),
  KEY `step_id` (`process_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='处理明细表';

-- ----------------------------
--  Table structure for `process`
-- ----------------------------
DROP TABLE IF EXISTS `process`;
CREATE TABLE `process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL DEFAULT '0' COMMENT '流程id',
  `process_name` varchar(45) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '步骤名称',
  `limit_time` int(11) NOT NULL DEFAULT '0' COMMENT '限定时间,单位秒',
  `type` varchar(32) COLLATE utf8mb4_bin NOT NULL DEFAULT 'operation' COMMENT '流程图显示操作框类型',
  `icon` varchar(64) COLLATE utf8mb4_bin DEFAULT '' COMMENT '流程图显示图标',
  `process_to` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `style` text COLLATE utf8mb4_bin,
  `style_color` varchar(128) COLLATE utf8mb4_bin NOT NULL DEFAULT '#78a300',
  `style_height` smallint(6) NOT NULL DEFAULT '30',
  `style_width` smallint(6) NOT NULL DEFAULT '30',
  `position_left` varchar(128) COLLATE utf8mb4_bin NOT NULL DEFAULT '100px',
  `position_top` varchar(128) COLLATE utf8mb4_bin NOT NULL DEFAULT '200px',
  `position` smallint(6) NOT NULL DEFAULT '1' COMMENT '步骤位置',
  `child_flow_id` int(11) NOT NULL DEFAULT '0' COMMENT '子流程id',
  `child_after` tinyint(4) NOT NULL DEFAULT '2' COMMENT '子流程结束后 1.同时结束父流程 2.返回父流程',
  `child_back_process` int(11) NOT NULL DEFAULT '0' COMMENT '子流程结束后返回父流程进程',
  `description` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '步骤描述',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='流程步骤';

-- ----------------------------
--  Table structure for `process_var`
-- ----------------------------
DROP TABLE IF EXISTS `process_var`;
CREATE TABLE `process_var` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `process_id` int(11) NOT NULL,
  `flow_id` int(11) NOT NULL COMMENT '流程id',
  `expression_field` varchar(45) COLLATE utf8mb4_bin NOT NULL COMMENT '条件表达式字段名称',
  PRIMARY KEY (`id`),
  KEY `step_id` (`process_id`),
  KEY `workflow_id` (`flow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='步骤判断变量记录';

-- ----------------------------
--  Table structure for `template`
-- ----------------------------
DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `template_name` (`template_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='流程模板';

-- ----------------------------
--  Table structure for `template_form`
-- ----------------------------
DROP TABLE IF EXISTS `template_form`;
CREATE TABLE `template_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL DEFAULT '0',
  `field` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '表单字段英文名',
  `field_name` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '表单字段中文名',
  `field_type` varchar(64) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '表单字段类型',
  `field_value` text COLLATE utf8mb4_bin COMMENT '表单字段值，select radio checkbox用',
  `field_default_value` text COLLATE utf8mb4_bin COMMENT '表单字段默认值',
  `rules` text COLLATE utf8mb4_bin,
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='流程模板表单控件';

SET FOREIGN_KEY_CHECKS = 1;
