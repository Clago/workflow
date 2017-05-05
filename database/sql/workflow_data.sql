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

 Date: 05/05/2017 14:50:06 PM
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
--  Records of `dept`
-- ----------------------------
BEGIN;
INSERT INTO `dept` VALUES ('1', '董事会', '0', '8', '9', '1', '2017-05-02 10:18:55', '2017-05-02 10:18:55'), ('2', '产品部', '1', '6', '6', '1', '2017-04-28 10:37:56', '2017-04-28 10:37:56'), ('3', '技术部', '2', '0', '0', '100', '2017-04-19 07:00:45', '2017-04-19 07:00:45'), ('4', 'PHP部', '3', '2', '3', '1', '2017-04-19 15:02:49', '2017-04-19 07:02:21'), ('5', '综管部', '1', '4', '4', '2', '2017-04-28 10:38:20', '2017-04-28 10:38:20');
COMMIT;

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
--  Records of `emp`
-- ----------------------------
BEGIN;
INSERT INTO `emp` VALUES ('1', '张三', '1044176017@qq.com', '$2y$10$FE1AOX1zg1IjyJn97r3qWOjpff5nhzB/hZsPO8QDpGm612vP2x9C2', '0001', '4', '0', 'n8eIaBUVOHygrfwJKJkuiEXC5hwahA9hLEYUMYgHaEASkvrpV76nDPN5I7sG', '2017-04-18 09:00:15', '2017-04-19 07:31:41', null), ('2', '李四', '1044176018@qq.com', '$2y$10$FE1AOX1zg1IjyJn97r3qWOjpff5nhzB/hZsPO8QDpGm612vP2x9C2', '0002', '4', '0', 'nlZs7VFBUHfs40fXgEtvgStuYYnkD3zRrzAfIfoCYPkxdfQyUIglfDph9Aac', '2017-04-18 17:15:04', '2017-04-19 07:31:46', null), ('3', '王二', '1044176019@qq.com', '$2y$10$FE1AOX1zg1IjyJn97r3qWOjpff5nhzB/hZsPO8QDpGm612vP2x9C2', '0003', '2', '0', 'YP8Vm1KCuJBUmCxENEhqr7zZonreBkqGMIAiBgU6J3VgbFMZmiYJY74bUYzv', '2017-04-18 17:16:54', '2017-04-19 07:31:52', null), ('4', '王芳', '1044176020@qq.com', '$2y$10$FE1AOX1zg1IjyJn97r3qWOjpff5nhzB/hZsPO8QDpGm612vP2x9C2', '0004', '5', '0', 'ZEpcPOnMwWy1CelRG1qhkVFcI6sKoDGoiWodw9IqtWsSLv9AiEoq2jft425w', '2017-04-18 17:17:22', '2017-04-19 07:35:04', null), ('5', '李八', '1044176027@qq.com', '$2y$10$bBzs2e6oUD3JAwNzOOMpou2z77CdM6fC8FO3F07SN62RUOjlweOo2', '897132', '4', '0', null, '2017-04-19 07:26:53', '2017-04-19 07:26:53', null), ('6', '赵武', '1044176021@qq.com', '$2y$10$2LAdd4qks1REHX7dBNvMBuJXe.K.gkw3v2FMf8ePyxAZTKgN8Tz.O', '897134', '2', '0', null, '2017-04-28 10:37:44', '2017-04-28 10:37:44', null), ('7', '王六', '1044176022@qq.com', '$2y$10$AvgpIqdHOtTMW8os5lMFKOyq5SCwSarNLxaAmYj8X.MBIneaSK1UC', '897135', '5', '0', 'P0zfoCgU59gXwTkiilHkcK76J16uvWMjtde8vFM1RjL0ViQYsdnbzMIVpP18', '2017-04-28 14:26:49', '2017-04-28 14:26:49', null), ('8', '测试人员1', '1044176023@qq.com', '$2y$10$fDNvxuD.RWy9HefNJZBLNudxn4xeyJsCW7ORl.vmni0HV.evYrDxO', '897139', '1', '0', 'Ewm68YYejqy3K41Z4QSiUFoZtZh2ANUOY0YvMxnZiXrDtp3BLS09NxfOyc7x', '2017-05-02 10:17:31', '2017-05-02 10:17:31', null), ('9', '测试人员2', '1044176030@qq.com', '$2y$10$GgDahZqrOFXMIyd4tnJjruybF.tdU5RFH3Jz1SpQVxyaSb12wkiCm', '897138', '1', '0', 'vUx9VowXnySdNSSQJr99UdFlclVBxhyTqOH3UVS2f64jZ5hIbXk2clR9raVZ', '2017-05-02 10:18:37', '2017-05-02 10:18:37', null);
COMMIT;

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
--  Records of `entry`
-- ----------------------------
BEGIN;
INSERT INTO `entry` VALUES ('1', '请假一天', '3', '1', '60', '2', '0', '0', '0', '0', '75', '2017-05-04 14:39:13', '2017-05-05 14:39:58'), ('2', '请假5天', '3', '2', '74', '2', '0', '0', '0', '0', '0', '2017-05-04 14:41:18', '2017-05-04 17:50:47'), ('3', '请假一天', '4', '1', '75', '2', '0', '1', '60', '10', '0', '2017-05-05 14:39:58', '2017-05-05 14:39:58');
COMMIT;

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
--  Records of `entry_data`
-- ----------------------------
BEGIN;
INSERT INTO `entry_data` VALUES ('1', '1', '3', 'leave_type', '病假', '', null, null), ('2', '1', '3', 'reason', '身体不舒服', '', null, null), ('3', '1', '3', 'day', '1', '', null, null), ('4', '1', '3', 'start_date', '2017-05-05', '', null, null), ('5', '1', '3', 'end_date', '2017-05-06', '', null, null), ('6', '1', '3', 'sex', '女', '', null, null), ('7', '1', '3', 'hobby', '篮球', '', null, null), ('8', '2', '3', 'leave_type', '病假', '', null, null), ('9', '2', '3', 'reason', '中二病', '', null, null), ('10', '2', '3', 'day', '5', '', null, null), ('11', '2', '3', 'start_date', '2017-05-05', '', null, null), ('12', '2', '3', 'end_date', '2017-05-09', '', null, null), ('13', '2', '3', 'sex', '女', '', null, null), ('14', '2', '3', 'hobby', '足球', '', null, null);
COMMIT;

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
--  Records of `flow`
-- ----------------------------
BEGIN;
INSERT INTO `flow` VALUES ('3', '0000003', '请假', '1', null, '{\"total\":4,\"list\":{\"0\":{\"id\":57,\"flow_id\":3,\"process_name\":\"\\u5458\\u5de5\\u63d0\\u4ea4\\u7533\\u8bf7\",\"process_to\":\"73\",\"icon\":\"icon-heart\",\"style\":\"width:150px;height:30px;line-height:30px;color:#d54e21;left:112px;top:122px;\"},\"3\":{\"id\":60,\"flow_id\":3,\"process_name\":\"\\u7efc\\u7ba1\\u62a5\\u5907\",\"process_to\":\"\",\"icon\":\"icon-ok\",\"style\":\"width:30px;height:30px;line-height:30px;color:#f70;left:751px;top:493px;\"},\"4\":{\"id\":73,\"flow_id\":3,\"process_name\":\"\\u90e8\\u95e8\\u4e3b\\u7ba1\\u5ba1\\u6838\",\"process_to\":\"60,74\",\"icon\":\"icon-refresh\",\"style\":\"width:150px;height:30px;line-height:30px;color:#78a300;left:382px;top:342px;\"},\"5\":{\"id\":74,\"flow_id\":3,\"process_name\":\"\\u90e8\\u95e8\\u7ecf\\u7406\\u5ba1\\u6838\",\"process_to\":\"60\",\"icon\":\"icon-refresh\",\"style\":\"width:150px;height:30px;line-height:30px;color:#78a300;left:963px;top:154px;\"}}}', '1', '1', '1', '2017-05-02 15:42:27', '2017-05-02 15:42:27'), ('4', '000004', '报备', '1', null, '{\"total\":2,\"list\":[{\"id\":75,\"flow_id\":4,\"process_name\":\"\\u5165\\u6863\",\"process_to\":\"76\",\"icon\":null,\"style\":\"width:30px;height:30px;line-height:30px;color:#78a300;left:330px;top:161px;\"},{\"id\":76,\"flow_id\":4,\"process_name\":\"\\u603b\\u7ecf\\u7406\\u590d\\u5ba1\",\"process_to\":\"\",\"icon\":null,\"style\":\"width:30px;height:30px;line-height:30px;color:#78a300;left:762px;top:388px;\"}]}', '0', '1', '0', '2017-05-02 17:37:01', '2017-05-02 17:37:01');
COMMIT;

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
--  Records of `flow_type`
-- ----------------------------
BEGIN;
INSERT INTO `flow_type` VALUES ('1', '测试类型', '2017-04-25 16:54:53', '2017-04-25 16:54:54');
COMMIT;

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
--  Records of `flowlink`
-- ----------------------------
BEGIN;
INSERT INTO `flowlink` VALUES ('52', '3', 'Condition', '60', '-1', '0', '', '100', '2017-04-21 08:09:31', '2017-05-02 15:42:24'), ('90', '3', 'Condition', '57', '73', '0', '', '100', '2017-04-24 03:26:17', '2017-04-24 03:26:17'), ('98', '3', 'Sys', '73', '0', '-1001', '', '100', '2017-04-28 10:31:01', '2017-04-28 10:31:01'), ('99', '3', 'Sys', '74', '0', '-1002', '', '100', '2017-04-28 10:42:37', '2017-04-28 10:42:37'), ('100', '3', 'Condition', '73', '60', '0', '$day <= 3', '100', '2017-04-28 10:46:42', '2017-04-28 10:48:21'), ('101', '3', 'Condition', '73', '74', '0', '$day > 3', '100', '2017-04-28 10:46:42', '2017-04-28 10:48:21'), ('102', '3', 'Condition', '74', '60', '0', '', '100', '2017-04-28 10:46:42', '2017-04-28 10:46:42'), ('103', '3', 'Dept', '60', '0', '5', '', '100', '2017-04-28 14:20:42', '2017-04-28 14:20:42'), ('104', '4', 'Condition', '75', '76', '0', '', '100', '2017-05-02 10:15:27', '2017-05-02 10:15:27'), ('105', '4', 'Condition', '76', '-1', '0', '', '100', '2017-05-02 10:15:27', '2017-05-02 10:20:22'), ('106', '4', 'Emp', '75', '0', '9', '', '100', '2017-05-02 10:19:57', '2017-05-02 10:19:57'), ('107', '4', 'Emp', '76', '0', '8', '', '100', '2017-05-02 10:20:07', '2017-05-02 10:20:07'), ('108', '5', 'Condition', '77', '78', '0', '', '100', '2017-05-04 15:46:44', '2017-05-04 15:46:44'), ('109', '5', 'Condition', '78', '79', '0', '$day > 3', '100', '2017-05-04 15:46:44', '2017-05-04 15:48:19'), ('110', '5', 'Condition', '79', '-1', '0', '', '100', '2017-05-04 15:46:44', '2017-05-04 15:46:44');
COMMIT;

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
--  Records of `proc`
-- ----------------------------
BEGIN;
INSERT INTO `proc` VALUES ('1', '1', '3', '57', '员工提交申请', '1', '张三', 'PHP部', '1', '张三', 'PHP部', '9', null, '0', '1', '1', null, '1493879953', '2017-05-04 14:39:13', '2017-05-04 14:39:13'), ('2', '1', '3', '73', '部门主管审核', '2', '李四', 'PHP部', '2', '李四', 'PHP部', '9', '同意', '0', '1', '1', null, '1493879953', '2017-05-04 14:40:40', '2017-05-04 14:40:40'), ('3', '1', '3', '60', '综管报备', '4', '王芳', '综管部', '4', '王芳', '综管部', '-1', null, '0', '1', '1', null, '1493880040', '2017-05-04 14:41:50', '2017-05-04 14:41:50'), ('4', '1', '3', '60', '综管报备', '7', '王六', '综管部', '4', '王芳', '综管部', '-1', null, '0', '1', '1', null, '1493880040', '2017-05-04 14:41:50', '2017-05-04 14:41:50'), ('5', '2', '3', '57', '员工提交申请', '2', '李四', 'PHP部', '2', '李四', 'PHP部', '9', null, '0', '1', '1', null, '1493880078', '2017-05-04 14:41:18', '2017-05-04 14:41:18'), ('6', '2', '3', '73', '部门主管审核', '2', '李四', 'PHP部', '2', '李四', 'PHP部', '9', null, '0', '1', '1', null, '1493880078', '2017-05-04 14:41:21', '2017-05-04 14:41:21'), ('7', '2', '3', '74', '部门经理审核', '3', '王二', '产品部', '3', '王二', '产品部', '-1', null, '0', '1', '1', null, '1493880081', '2017-05-04 14:41:59', '2017-05-04 14:41:59'), ('8', '1', '3', '57', '员工提交申请', '1', '张三', 'PHP部', '1', '张三', 'PHP部', '9', null, '0', '1', '2', null, '1493880143', '2017-05-04 14:42:23', '2017-05-04 14:42:23'), ('9', '1', '3', '73', '部门主管审核', '2', '李四', 'PHP部', '2', '李四', 'PHP部', '9', null, '0', '1', '2', null, '1493880143', '2017-05-04 17:47:41', '2017-05-04 17:47:41'), ('10', '1', '3', '60', '综管报备', '4', '王芳', '综管部', '4', '王芳', '综管部', '9', null, '0', '1', '2', null, '1493891261', '2017-05-05 14:39:58', '2017-05-05 14:39:58'), ('11', '1', '3', '60', '综管报备', '7', '王六', '综管部', '4', '王芳', '综管部', '9', null, '0', '1', '2', null, '1493891261', '2017-05-05 14:39:58', '2017-05-05 14:39:58'), ('12', '2', '3', '57', '员工提交申请', '2', '李四', 'PHP部', '2', '李四', 'PHP部', '9', null, '0', '1', '2', null, '1493891439', '2017-05-04 17:50:39', '2017-05-04 17:50:39'), ('13', '2', '3', '73', '部门主管审核', '2', '李四', 'PHP部', '2', '李四', 'PHP部', '9', null, '0', '1', '2', null, '1493891439', '2017-05-04 17:50:47', '2017-05-04 17:50:47'), ('14', '2', '3', '74', '部门经理审核', '3', '王二', '产品部', '0', '', '', '0', null, '0', '1', '2', null, '1493891447', '2017-05-04 17:50:47', '2017-05-04 17:50:47'), ('15', '3', '4', '75', '入档', '9', '测试人员2', '董事会', '0', '', '', '0', null, '0', '1', '2', null, '1493966398', '2017-05-05 14:39:58', '2017-05-05 14:39:58');
COMMIT;

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
--  Records of `process`
-- ----------------------------
BEGIN;
INSERT INTO `process` VALUES ('57', '3', '员工提交申请', '0', 'operation', 'icon-heart', '', 'width:150px;height:150px;line-height:30px;color:#d54e21;left:112px;top:122px;', '#d54e21', '30', '150', '112px', '122px', '0', '0', '2', '0', '', '2017-04-20 09:17:59', '2017-04-25 03:19:33'), ('60', '3', '综管报备', '0', 'operation', 'icon-ok', '', 'width:30px;height:30px;line-height:30px;color:#f70;left:751px;top:493px;', '#f70', '30', '30', '751px', '493px', '2', '4', '1', '73', '', '2017-04-20 09:18:08', '2017-05-02 15:42:11'), ('73', '3', '部门主管审核', '0', 'operation', 'icon-refresh', '', 'width:150px;height:150px;line-height:30px;color:#78a300;left:382px;top:342px;', '#78a300', '30', '150', '382px', '342px', '1', '0', '2', '0', '', '2017-04-24 03:24:26', '2017-04-28 13:58:34'), ('74', '3', '部门经理审核', '0', 'operation', 'icon-refresh', '', 'width:150px;height:150px;line-height:30px;color:#78a300;left:963px;top:154px;', '#78a300', '30', '150', '963px', '154px', '1', '0', '2', '0', '', '2017-04-24 03:26:30', '2017-04-28 10:46:42'), ('75', '4', '入档', '0', 'operation', null, '', 'width:30px;height:30px;line-height:30px;color:#78a300;left:330px;top:161px;', '#78a300', '30', '30', '330px', '161px', '0', '0', '1', '0', '', '2017-05-02 10:12:38', '2017-05-02 13:49:51'), ('76', '4', '总经理复审', '0', 'operation', null, '', 'width:30px;height:30px;line-height:30px;color:#78a300;left:762px;top:388px;', '#78a300', '30', '30', '762px', '388px', '1', '0', '2', '0', '', '2017-05-02 10:12:43', '2017-05-02 10:16:38');
COMMIT;

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
--  Records of `process_var`
-- ----------------------------
BEGIN;
INSERT INTO `process_var` VALUES ('1', '33', '1', 'day'), ('3', '73', '3', 'day');
COMMIT;

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
--  Records of `template`
-- ----------------------------
BEGIN;
INSERT INTO `template` VALUES ('1', '请假模板', '2017-04-21 10:36:07', '2017-04-21 10:36:08');
COMMIT;

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

-- ----------------------------
--  Records of `template_form`
-- ----------------------------
BEGIN;
INSERT INTO `template_form` VALUES ('1', '1', 'day', '请假天数', 'text', null, null, null, '100', '2017-04-25 13:48:16', '0000-00-00 00:00:00'), ('2', '1', 'reason', '请假原因', 'textarea', null, null, null, '100', '2017-04-25 07:10:19', '2017-04-25 07:10:19'), ('3', '1', 'start_date', '开始日期', 'date', null, null, null, '900', '2017-04-27 16:05:21', '2017-04-27 06:39:51'), ('4', '1', 'end_date', '结束日期', 'date', null, null, null, '901', '2017-04-27 06:42:44', '2017-04-27 06:42:44'), ('5', '1', 'leave_type', '请假类型', 'select', '病假\r\n婚假', '病假', null, '50', '2017-04-27 07:12:01', '2017-04-27 07:12:01'), ('6', '1', 'sex', '性别', 'radio', '男\r\n女\r\n保密', '保密', null, '1000', '2017-04-27 08:34:10', '2017-04-27 08:34:10'), ('7', '1', 'hobby', '兴趣爱好', 'checkbox', '足球\r\n篮球\r\n乒乓球', null, null, '1002', '2017-04-27 08:35:28', '2017-04-27 08:35:28'), ('8', '1', 'bingli', '病例', 'file', null, null, null, '1200', '2017-04-28 09:48:16', '2017-04-28 09:48:16');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
