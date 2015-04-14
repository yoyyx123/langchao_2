-- phpMyAdmin SQL Dump
-- version 3.3.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 �?02 �?10 �?10:27
-- 服务器版本: 5.6.17
-- PHP 版本: 5.5.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `langchao`
--

-- --------------------------------------------------------

--
-- 表的结构 `ldb_biil_order_list`
--

CREATE TABLE IF NOT EXISTS `ldb_biil_order_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_order_id` int(11) NOT NULL COMMENT '工单id',
  `type` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0去程费用/1返程费用',
  `go_time` varchar(20) NOT NULL COMMENT '出发时间',
  `arrival_time` varchar(20) NOT NULL COMMENT '到达时间',
  `start_place` varchar(500) NOT NULL COMMENT '起始地',
  `arrival_place` varchar(500) NOT NULL COMMENT '目的地',
  `transportation` int(11) NOT NULL DEFAULT '0' COMMENT '交通方式id',
  `transportation_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '交通费',
  `hotel_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '住宿费',
  `food_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '加班餐费',
  `other_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '其他费用',
  `memo` varchar(500) NOT NULL COMMENT '备注',
  `bill_no` varchar(255) NOT NULL COMMENT '单据编号',
  `rel_fee` decimal(10,2) NOT NULL COMMENT '纠正费用',
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1未审核/2已审核',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=45 ;

--
-- 转存表中的数据 `ldb_biil_order_list`
--

INSERT INTO `ldb_biil_order_list` (`id`, `work_order_id`, `type`, `go_time`, `arrival_time`, `start_place`, `arrival_place`, `transportation`, `transportation_fee`, `hotel_fee`, `food_fee`, `other_fee`, `memo`, `bill_no`, `rel_fee`, `status`, `date`) VALUES
(0, 4, '1', '11111', '222', '333', '444', 11, 666.00, 777.00, 888.00, 999.00, 'aaa', 'bbbb', 2500.00, '2', '2015-01-24 21:55:31'),
(6, 4, '0', '11111', '222', '333', '444', 11, 666.00, 777.00, 888.00, 999.00, 'aaa', 'aaa', 0.00, '2', '2015-01-24 22:34:00'),
(34, 4, '0', '11111', '222', '333', '444', 12, 666.00, 777.00, 888.00, 999.00, 'aaa', 'aaaa', 0.00, '1', '2015-01-24 23:36:12'),
(38, 4, '1', '11111', '222', '333', '444', 12, 666.00, 777.00, 888.00, 999.00, 'aaa', 'bbbb', 0.00, '1', '2015-01-25 00:01:49'),
(39, 5, '0', '1', '1', '1', '1', 11, 1.00, 1.00, 1.00, 1.00, '1', '1', 0.00, '1', '2015-01-26 23:05:21'),
(40, 5, '1', '1', '1', '1', '1', 12, 1.00, 1.00, 1.00, 1.00, '1', '1', 0.00, '1', '2015-01-26 23:05:22'),
(41, 9, '0', '2015-02-02 04:30:06', '2015-02-02 11:30:06', '北京', '上海', 11, 1568.00, 798.00, 77.00, 56.00, '第一天费用', '123123', 0.00, '2', '2015-02-01 23:41:59'),
(42, 9, '0', '2015-02-05 04:30:06', '2015-02-05 11:30:06', '北京', '上海', 12, 1668.00, 798.00, 77.00, 56.00, '第二次费用', '456456', 0.00, '2', '2015-02-01 23:43:00'),
(43, 9, '1', '2015-02-03 04:30:06', '2015-02-03 11:30:06', '上海', '北京', 11, 1668.00, 798.00, 77.00, 56.00, '回程费用', '999', 0.00, '2', '2015-02-01 23:43:48'),
(44, 9, '1', '2015-02-06 04:30:06', '2015-02-06 11:30:06', '上海', '北京', 11, 1668.00, 0.00, 0.00, 79.00, '回程 打车费用', '888', 0.00, '2', '2015-02-01 23:45:56');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_check_event_list`
--

CREATE TABLE IF NOT EXISTS `ldb_check_event_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL COMMENT '时间id',
  `is_complain` enum('0','1') NOT NULL COMMENT '0未投诉/1已投诉',
  `status` enum('0','1') NOT NULL COMMENT '0无效/1有效',
  `performance_id` int(11) NOT NULL COMMENT '绩效完成率id',
  `memo` varchar(500) NOT NULL COMMENT '备注',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加/修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `ldb_check_event_list`
--

INSERT INTO `ldb_check_event_list` (`id`, `event_id`, `is_complain`, `status`, `performance_id`, `memo`, `date`) VALUES
(1, 0, '1', '1', 0, '测试测试', '2015-01-25 23:51:48'),
(5, 1, '1', '0', 14, 'sdf ', '2015-01-26 01:35:52');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_ctl_list`
--

CREATE TABLE IF NOT EXISTS `ldb_ctl_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `ctl_file` varchar(255) NOT NULL COMMENT '控制器名称',
  `ctl_act` varchar(255) DEFAULT NULL COMMENT '控制器动作',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '组id',
  `display` enum('0','1') NOT NULL DEFAULT '1' COMMENT '左边显示',
  `istopmenu` enum('0','1') NOT NULL DEFAULT '0',
  `type` enum('ctl','business') NOT NULL DEFAULT 'ctl',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `ldb_ctl_list`
--

INSERT INTO `ldb_ctl_list` (`id`, `name`, `ctl_file`, `ctl_act`, `pid`, `display`, `istopmenu`, `type`, `sort`) VALUES
(1, '登录首页', 'home', 'index', 0, '1', '0', 'ctl', NULL),
(2, '首页个人信息', 'home', 'index', 1, '1', '0', 'ctl', NULL),
(3, '个人设置', 'user', 'info', 1, '1', '0', 'ctl', NULL),
(4, '账户模块', '', NULL, 0, '1', '0', 'ctl', NULL),
(5, '账户添加', 'user', 'add', 4, '1', '0', 'ctl', NULL),
(6, '账户管理', 'user', 'manage', 4, '1', '0', 'ctl', NULL),
(12, '外勤模块', '', NULL, 0, '1', '0', 'ctl', NULL),
(13, '事件开设', 'event', 'index', 12, '1', '0', 'ctl', NULL),
(14, '工单列表', 'event', 'event_list', 12, '1', '0', 'ctl', NULL),
(15, '事件审核', 'event', 'event_check', 12, '1', '0', 'ctl', NULL),
(16, '费用审核', 'event', 'cost_check', 12, '1', '0', 'ctl', NULL),
(17, '事件查询', 'event', 'event_search', 12, '1', '0', 'ctl', NULL),
(18, '云模块', '', NULL, 0, '1', '0', 'ctl', NULL),
(19, '数据下载', 'cloud', 'doc_download', 18, '1', '0', 'ctl', NULL),
(20, '绩效查询', '', NULL, 0, '1', '0', 'ctl', NULL),
(21, '业务查询', 'search', 'data_search', 20, '1', '0', 'ctl', NULL),
(22, '数据导出', 'search', 'data_export', 20, '1', '0', 'ctl', NULL),
(23, '后台模块', '', NULL, 0, '1', '0', 'ctl', NULL),
(24, '角色管理', 'system', 'role_list', 23, '1', '0', 'ctl', NULL),
(25, '基础信息设置', 'system', 'setting_list', 23, '1', '0', 'ctl', NULL),
(26, '事件类型/故障分类', 'system', 'event_list', 23, '1', '0', 'ctl', NULL),
(27, '时间设定', 'system', 'event_list', 23, '1', '0', 'ctl', NULL),
(28, '文档管理', 'system', 'doc_list', 23, '1', '0', 'ctl', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_date_setting`
--

CREATE TABLE IF NOT EXISTS `ldb_date_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('holiday','work_time') NOT NULL DEFAULT 'holiday' COMMENT '类型,holiday假期/work_time工作时间',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `value` varchar(50) NOT NULL COMMENT '值',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ldb_date_setting`
--

INSERT INTO `ldb_date_setting` (`id`, `type`, `name`, `value`, `date`) VALUES
(1, 'holiday', '公司假期1', '2015-02-05', '2015-02-01 16:36:28');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_doc_list`
--

CREATE TABLE IF NOT EXISTS `ldb_doc_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '文档名称',
  `look` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `download` int(11) NOT NULL DEFAULT '0' COMMENT '下载次数',
  `type` varchar(50) NOT NULL COMMENT '文件类型',
  `path` varchar(50) NOT NULL COMMENT '文档存放路径',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `ldb_doc_list`
--

INSERT INTO `ldb_doc_list` (`id`, `name`, `look`, `download`, `type`, `path`, `date`) VALUES
(5, '问题列表', 5, 0, '', './upload/doc/1_1423101007.pdf', '2015-02-05 09:50:07'),
(6, '登录显示', 1, 3, '', './upload/doc/1_1423101045.pdf', '2015-02-05 09:50:45');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_event_list`
--

CREATE TABLE IF NOT EXISTS `ldb_event_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `department_id` int(11) NOT NULL COMMENT '部门id',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `event_type_id` int(11) NOT NULL COMMENT '事件类型id',
  `work_type` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0非驻派/1驻派',
  `desc` varchar(500) NOT NULL COMMENT '描述',
  `worktime_id` int(11) NOT NULL COMMENT '工作日区间id',
  `event_time` varchar(255) NOT NULL COMMENT '事件时间',
  `event_month` varchar(20) NOT NULL COMMENT '事件月份',
  `status` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1待添加，2待审核，3已审核',
  `cost_status` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1未审核/2待报销/3已报销',
  `is_complain` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0未投诉/1已投诉',
  `event_status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0无效/1有效',
  `performance_id` int(11) NOT NULL DEFAULT '0' COMMENT '绩效完成率id',
  `memo` varchar(500) NOT NULL COMMENT '备注',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=57 ;

--
-- 转存表中的数据 `ldb_event_list`
--

INSERT INTO `ldb_event_list` (`id`, `member_id`, `department_id`, `user_id`, `event_type_id`, `work_type`, `desc`, `worktime_id`, `event_time`, `event_month`, `status`, `cost_status`, `is_complain`, `event_status`, `performance_id`, `memo`, `date`) VALUES
(1, 1, 4, 7, 2, '0', 'sadfADS', 7, '2015-01-18', '2015-01', '3', '3', '0', '1', 15, '十大发生发', '2015-01-17 16:32:50'),
(2, 2, 4, 7, 2, '0', '撒旦发', 7, '2015-01-20', '2015-01', '1', '3', '0', '1', 0, '0', '2015-01-17 16:34:10'),
(3, 1, 2, 1, 2, '0', '撒旦发撒旦发', 8, '2015-01-14', '2015-01', '1', '1', '0', '1', 0, '0', '2015-01-17 16:34:32'),
(4, 1, 2, 1, 3, '1', '驻派测试', 7, '2015-01-20', '2015-01', '1', '1', '0', '1', 0, '0', '2015-01-20 23:56:11'),
(5, 1, 2, 1, 3, '1', '撒旦飞洒发', 7, '2015-01-27', '2015-01', '1', '1', '0', '1', 0, '0', '2015-01-27 23:47:42'),
(6, 2, 4, 1, 3, '1', '阿斯顿发', 7, '2015-01-31 11:30:37', '2015-01', '3', '1', '0', '1', 0, '', '2015-01-31 14:32:11'),
(8, 3, 2, 1, 3, '1', '网络部署', 7, '2015-02-01 02:05:50', '2015-02', '3', '3', '0', '1', 0, '', '2015-02-01 14:52:12'),
(9, 3, 2, 1, 2, '0', 'asdf ', 7, '2015-01-28', '2015-01', '3', '1', '1', '0', 13, '11111', '2015-02-01 15:35:28'),
(10, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-01', '2015-02', '3', '3', '1', '0', 13, '111', '2015-02-01 16:36:40'),
(11, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-02', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(12, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-03', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(13, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-04', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(14, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-06', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(15, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-07', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(16, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-08', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(17, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-09', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(18, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-10', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(19, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-11', '2015-02', '2', '3', '0', '1', 0, '', '2015-02-01 16:36:40'),
(20, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-01', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(21, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-02', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(22, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-03', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(23, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-04', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(24, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-06', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(25, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-07', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(26, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-08', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(27, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-09', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(28, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-10', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(29, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-11', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:38:23'),
(30, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-02', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:39:16'),
(31, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-03', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:39:16'),
(32, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-04', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:39:16'),
(33, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-06', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:39:16'),
(34, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-09', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:39:16'),
(35, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-10', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:39:16'),
(36, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-11', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:39:16'),
(37, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-02', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:45:04'),
(38, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-03', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:45:04'),
(39, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-04', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:45:04'),
(40, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-05', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:45:04'),
(41, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-06', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:45:04'),
(42, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-09', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:45:04'),
(43, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-10', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:45:04'),
(44, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-11', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:45:04'),
(45, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-02', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:48:54'),
(46, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-04', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:48:54'),
(47, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-06', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:48:54'),
(48, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-09', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:48:54'),
(49, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-10', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:48:54'),
(50, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-11', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:48:54'),
(51, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-02', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:49:40'),
(52, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-04', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:49:40'),
(53, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-06', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:49:40'),
(54, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-09', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:49:40'),
(55, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-10', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:49:40'),
(56, 3, 2, 1, 3, '1', '正式测试1', 7, '2015-02-11', '2015-02', '1', '3', '0', '1', 0, '', '2015-02-01 16:49:40');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_event_type_list`
--

CREATE TABLE IF NOT EXISTS `ldb_event_type_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `department_id` varchar(100) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `ldb_event_type_list`
--

INSERT INTO `ldb_event_type_list` (`id`, `name`, `department_id`, `display`, `sort`) VALUES
(3, '网络部署', '信息部', '1', NULL),
(5, '是否', 'all', '1', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_member`
--

CREATE TABLE IF NOT EXISTS `ldb_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL COMMENT '客户编号',
  `name` varchar(200) NOT NULL COMMENT '客户全称',
  `short_name` varchar(200) NOT NULL COMMENT '客户简称',
  `city` int(11) NOT NULL COMMENT '城市id',
  `member_type` int(11) NOT NULL COMMENT '客户属性id',
  `addr` varchar(200) NOT NULL COMMENT '地址',
  `bus` varchar(500) NOT NULL COMMENT '公交/地铁',
  `contacts` varchar(200) NOT NULL COMMENT '客户联系人',
  `mobile` varchar(50) NOT NULL COMMENT '联系电话',
  `fax` varchar(50) NOT NULL COMMENT '传真',
  `project_man` varchar(50) NOT NULL COMMENT '工程项目负责人',
  `project_mobile` varchar(50) NOT NULL COMMENT '工程项目负责人联系电话',
  `business_man` varchar(50) NOT NULL COMMENT '日常业务负责人',
  `business_mobile` varchar(50) NOT NULL COMMENT '日常业务负责人联系电话',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ldb_member`
--

INSERT INTO `ldb_member` (`id`, `code`, `name`, `short_name`, `city`, `member_type`, `addr`, `bus`, `contacts`, `mobile`, `fax`, `project_man`, `project_mobile`, `business_man`, `business_mobile`, `addtime`) VALUES
(1, 'abc', '工行北京支行', '北京支行', 5, 10, '3里屯28号', '一号线3号出口一号线3号出口一号线3号出口一号线3号出口', '张三', '111111', '2342342', '李四', '22222', '王五', '3333', '2015-01-04 15:55:31'),
(2, '111', '李四', '小李', 6, 10, '1号线', '1号线', '1', '123132123', '1', '1', '123', '1', '1', '2015-01-08 23:09:53'),
(3, '001', '测试客户1', '测试1', 6, 9, '徐汇区33号', '1号线', '王总', '11111', '2222', '李工', '33333', '张秘', '4444', '2015-02-01 14:33:43');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_setting_list`
--

CREATE TABLE IF NOT EXISTS `ldb_setting_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `display` enum('0','1') NOT NULL DEFAULT '1',
  `type` enum('city','custom','department','worktime','performance','filetype','membertype','traffic','position') NOT NULL DEFAULT 'city',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `ldb_setting_list`
--

INSERT INTO `ldb_setting_list` (`id`, `name`, `display`, `type`, `sort`) VALUES
(2, '公司假期3', '1', '', NULL),
(4, '信息部', '1', 'department', NULL),
(5, '北京市', '1', 'city', NULL),
(6, '上海市', '1', 'city', NULL),
(7, '09:00:00_17:00:00', '1', 'worktime', NULL),
(9, '分行', '1', 'membertype', NULL),
(10, '支行', '1', 'membertype', NULL),
(11, '飞机', '1', 'traffic', NULL),
(12, '火车', '1', 'traffic', NULL),
(13, '100%', '1', 'performance', NULL),
(14, '90%', '1', 'performance', NULL),
(15, '50%', '1', 'performance', NULL),
(16, '工程师', '1', 'position', NULL),
(17, '主管', '1', 'position', NULL),
(18, '业务员', '1', 'position', NULL),
(19, '经理', '1', 'position', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_sms_captcha`
--

CREATE TABLE IF NOT EXISTS `ldb_sms_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `captcha` varchar(25) NOT NULL COMMENT '验证码',
  `task_id` varchar(50) NOT NULL COMMENT '短信发送任务ID',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0无效;1有效',
  `created` int(11) NOT NULL COMMENT '生成时间戳',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `ldb_sms_captcha`
--

INSERT INTO `ldb_sms_captcha` (`id`, `uid`, `captcha`, `task_id`, `status`, `created`) VALUES
(1, 1, 'aabbcc', '', '1', 2014),
(2, 1, 'ccddee', '', '1', 2011),
(3, 1, 'asdfadf', '', '1', 2013),
(4, 1, '192477', '233109', '1', 1417710112),
(5, 1, '897964', '233110', '1', 1417715857),
(6, 1, '381881', '233109', '1', 1427938783);

-- --------------------------------------------------------

--
-- 表的结构 `ldb_sms_setting`
--

CREATE TABLE IF NOT EXISTS `ldb_sms_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) NOT NULL COMMENT '短信平台用ID',
  `account` varchar(50) NOT NULL COMMENT '短信平台帐号',
  `passwd` varchar(50) NOT NULL COMMENT '短信平台密码',
  `url` varchar(255) NOT NULL COMMENT '短信平台地址',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0无效;1有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ldb_sms_setting`
--

INSERT INTO `ldb_sms_setting` (`id`, `userid`, `account`, `passwd`, `url`, `status`) VALUES
(1, '1038', 'lcgm', '666888', 'http://115.238.169.140:9999/sms.aspx', '1');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_user`
--

CREATE TABLE IF NOT EXISTS `ldb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `roles` int(11) NOT NULL COMMENT '用户角色',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `short_num` varchar(50) NOT NULL COMMENT '企业短号',
  `department` varchar(50) NOT NULL COMMENT '部门',
  `position` varchar(50) NOT NULL COMMENT '职位',
  `email` varchar(100) NOT NULL COMMENT '企业邮箱',
  `addr` int(11) NOT NULL COMMENT '工作地点id',
  `work_type` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0非驻场/1驻场',
  `expenses` float NOT NULL DEFAULT '0' COMMENT '基础报销，单位元',
  `work_time` int(11) NOT NULL COMMENT '上下班时间id',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0离职/1在职',
  `img` varchar(200) NOT NULL COMMENT '图片地址',
  `login_time` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `ldb_user`
--

INSERT INTO `ldb_user` (`id`, `username`, `password`, `name`, `roles`, `mobile`, `short_num`, `department`, `position`, `email`, `addr`, `work_type`, `expenses`, `work_time`, `status`, `img`, `login_time`, `created`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '测试1', 1, '13661850643', '13360', '4', '19', 'admin', 6, '0', 0, 8, '1', 'user_admin.jpg', '2014-12-03 23:26:47', '2014-12-03 15:26:47'),
(2, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', 1, '111', '222', '2', '17', '11@11', 6, '1', 0, 9, '1', '', '0000-00-00 00:00:00', '2014-12-10 16:40:14'),
(3, '三代富贵 ', '3d70ef0237e5b8ff729cc83277364056', '阿斯顿发', 1, '阿斯顿发', '', '4', '18', '', 5, '1', 0, 9, '1', 'user_.jpg', '0000-00-00 00:00:00', '2014-12-14 15:46:01'),
(7, '阿斯顿发生的', '9f10648f089cc3ba57c5ae46ba98e57a', '阿斯顿发生的', 3, '阿斯顿发', '', '4', '18', '', 5, '1', 0, 9, '1', 'user_阿斯顿发生的.jpg', '0000-00-00 00:00:00', '2014-12-14 15:55:26'),
(8, 'test2', 'fb351247ccb4bcaeadb70cf72a957699', '啊', 3, '啊', '啊', '4', ' 17', ' 啊', 5, '0', 0, 9, '1', 'user_test2.jpg', '0000-00-00 00:00:00', '2014-12-15 16:27:37'),
(9, 'wangyi', '40c7bc25c943b9e8977636aafe5d69e9', '王一', 3, '1111', '111', '2', '17', '111@11.com', 6, '1', 99, 7, '1', 'user_wangyi.jpg', '0000-00-00 00:00:00', '2015-01-17 11:09:18'),
(10, 'test222', '098f6bcd4621d373cade4e832627b4f6', 'test', 5, '1', '1', '4', '19', 'ss@xx.com', 6, '0', 0, 7, '1', 'user_test222.jpg', '0000-00-00 00:00:00', '2015-02-10 16:20:13');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_user_roles`
--

CREATE TABLE IF NOT EXISTS `ldb_user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `role_memo` text NOT NULL,
  `permission` text,
  `disabled` enum('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `ldb_user_roles`
--

INSERT INTO `ldb_user_roles` (`id`, `role_name`, `role_memo`, `permission`, `disabled`) VALUES
(1, '管理员', '有所有权限啊啊', 'a:9:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";i:5;s:1:"6";i:6;s:1:"7";i:7;s:1:"8";i:8;s:2:"10";}', 'false'),
(3, 'test', 'test', 'a:8:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"5";i:4;s:1:"6";i:5;s:1:"8";i:6;s:1:"9";i:7;s:2:"10";}', 'false'),
(4, '啊付笛声', '完全而', 'a:1:{i:0;s:1:"9";}', 'false'),
(5, 'test22', 'test', 'a:21:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";i:5;s:1:"6";i:6;s:2:"12";i:7;s:2:"13";i:8;s:2:"14";i:9;s:2:"15";i:10;s:2:"16";i:11;s:2:"17";i:12;s:2:"20";i:13;s:2:"21";i:14;s:2:"22";i:15;s:2:"23";i:16;s:2:"24";i:17;s:2:"25";i:18;s:2:"26";i:19;s:2:"27";i:20;s:2:"28";}', 'false');

-- --------------------------------------------------------

--
-- 表的结构 `ldb_work_order_list`
--

CREATE TABLE IF NOT EXISTS `ldb_work_order_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL COMMENT '事件id',
  `custom_department` varchar(200) NOT NULL COMMENT '客户部门',
  `arrive_time` datetime NOT NULL COMMENT '到达时间',
  `back_time` datetime NOT NULL COMMENT '离场时间',
  `symptom` text NOT NULL COMMENT '报修症状',
  `failure_mode` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '故障分类，0日常;1软件;2硬件,默认0',
  `failure_level` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '故障等级，0一级;1二级;2三级,默认0',
  `failure_analysis` text NOT NULL COMMENT '故障分析',
  `risk_profile` text NOT NULL COMMENT '风险预测',
  `solution` text NOT NULL COMMENT '解决方案',
  `desc` text NOT NULL COMMENT '使用人描述',
  `schedule` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '事件反馈，0已完成;1部分完成;2未完成，默认0',
  `memo` text NOT NULL COMMENT '备注',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_3` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ldb_work_order_list`
--

INSERT INTO `ldb_work_order_list` (`id`, `event_id`, `custom_department`, `arrive_time`, `back_time`, `symptom`, `failure_mode`, `failure_level`, `failure_analysis`, `risk_profile`, `solution`, `desc`, `schedule`, `memo`, `date`) VALUES
(1, 3, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '0', '', '', '', '', '0', '', '0000-00-00 00:00:00'),
(4, 1, '发生大幅', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '萨范德', '0', '1', '阿斯大法萨法是否', '啊撒旦发撒旦发撒旦发萨法上访', '阿斯顿发生', '阿斯顿发', '2', '阿斯顿发送方撒发萨法上访萨芬撒旦发撒旦发', '0000-00-00 00:00:00'),
(3, 1, '测试部', '2015-01-15 00:00:00', '2015-01-15 00:00:00', '我额头巍峨', '0', '0', '出大事了', '严重', '换机器', '不行啦', '0', '去问额外确认', '2015-01-27 00:00:00'),
(5, 2, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0', '0', '1', '1', '1', '1', '0', '1', '2015-01-05 00:00:00'),
(6, 6, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0', '1', '1', '1', '1', '1', '0', '1', '2015-01-14 00:00:00'),
(7, 5, '运维部', '2015-01-31 10:45:47', '2015-01-31 22:50:31', '机器坏了', '2', '2', '电源线断了', '高', '更换电源线', '问题不大', '2', '缺货', '2015-02-01 00:00:00'),
(8, 5, '运维部', '2015-01-31 10:45:47', '2015-01-31 22:50:31', '机器坏了', '2', '2', '电源线断了', '高', '更换电源线', '问题不大', '2', '缺货', '2015-02-02 00:00:00'),
(9, 19, '平台部', '2015-02-02 04:30:06', '2015-02-12 23:30:06', '系统错误', '1', '2', '系统错误', '系统错误', '系统错误', '系统错误', '0', '系统错误', '2015-02-16 00:00:00');
