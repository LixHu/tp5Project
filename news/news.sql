/*
Navicat MySQL Data Transfer

Source Server         : show_181_021mc_
Source Server Version : 50555
Source Host           : 61.152.175.76:3306
Source Database       : show_181_021mc_

Target Server Type    : MYSQL
Target Server Version : 50555
File Encoding         : 65001

Date: 2017-12-18 13:10:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for as_ad
-- ----------------------------
DROP TABLE IF EXISTS `as_ad`;
CREATE TABLE `as_ad` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `col_id` int(11) NOT NULL COMMENT '栏目id',
  `user_id` int(11) NOT NULL COMMENT '广告主id',
  `title` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `ad_img` text COLLATE utf8_bin NOT NULL COMMENT '广告图片',
  `see_count` int(100) NOT NULL COMMENT '浏览量',
  `price` float(50,2) NOT NULL COMMENT '价格',
  `stock` int(11) NOT NULL COMMENT '库存',
  `is_groom` int(1) NOT NULL,
  `t_id` int(11) NOT NULL COMMENT '推荐时间id',
  `groom_status` int(1) NOT NULL COMMENT '推荐状态 0 等待中 1 通过 2 拒绝',
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  `end_time` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '推荐结束时间',
  `add_time` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of as_ad
-- ----------------------------
INSERT INTO `as_ad` VALUES ('17', '6', '1', '雅马哈DM-305话筒有线家用型', 0xE99B85E9A9ACE59388444D2D333035E8AF9DE7AD92E69C89E7BABFE5AEB6E794A8E59E8B, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383130303331375F35303439322E6A706567, '3', '199.00', '30', '1', '2', '1', '1', '1543456910', '1511834597');
INSERT INTO `as_ad` VALUES ('18', '6', '1', '运动蓝牙耳机无线跑步挂耳式大康入耳式', 0xE8BF90E58AA8E8939DE78999E880B3E69CBAE697A0E7BABFE8B791E6ADA5E68C82E880B3E5BC8FE5A4A7E5BAB7E585A5E880B3E5BC8F, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383130303432335F36393534322E6A706567, '1', '128.00', '30', '1', '2', '1', '1', '1543456910', '1511834663');
INSERT INTO `as_ad` VALUES ('19', '6', '1', '美国oion空气净化器', 0xE7BE8EE59BBD6F696F6EE7A9BAE6B094E58780E58C96E599A8, 0x2F7374617469632F75706C6F6164732F61642F32303137313230373039333131315F39363932362E6A706567, '3', '1088.00', '2', '1', '5', '1', '1', '1543456910', '1512610271');
INSERT INTO `as_ad` VALUES ('20', '6', '1', '科沃斯地宝灵犀扫地机器人', 0xE7A791E6B283E696AFE59CB0E5AE9DE781B5E78A80E689ABE59CB0E69CBAE599A8E4BABA, 0x2F7374617469632F75706C6F6164732F61642F32303137313230373039333233315F37363734342E6A706567, '4', '899.00', '3', '1', '5', '1', '1', '1543456910', '1512610351');
INSERT INTO `as_ad` VALUES ('21', '7', '1', '小熊jsq-a20b1加湿器', 0xE5B08FE7868A6A73712D6132306231E58AA0E6B9BFE599A8, 0x2F7374617469632F75706C6F6164732F61642F32303137313230373039333335345F36383833372E6A706567, '0', '89.00', '3', '1', '5', '1', '1', '1543456910', '1512610434');
INSERT INTO `as_ad` VALUES ('23', '7', '1', '乐怡美三双装家务耐用性手套洗碗洗衣服', 0xE4B990E680A1E7BE8EE4B889E58F8CE8A385E5AEB6E58AA1E88090E794A8E680A7E6898BE5A597E6B497E7A297E6B497E8A1A3E69C8D, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383039353332365F35363837342E6A706567, '1', '13.90', '100', '1', '2', '4', '1', '1543456910', '1511834006');
INSERT INTO `as_ad` VALUES ('24', '7', '1', '老街口焦糖瓜子1斤装大颗粒黑糖味葵花籽', 0xE88081E8A197E58FA3E784A6E7B396E7939CE5AD9031E696A4E8A385E5A4A7E9A297E7B292E9BB91E7B396E591B3E891B5E88AB1E7B1BD, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383039353535395F37313139392E6A706567, '1', '18.90', '200', '1', '2', '1', '1', '1543456910', '1511834159');
INSERT INTO `as_ad` VALUES ('25', '7', '1', '三只松鼠无核白葡萄干280g零食果干', 0xE4B889E58FAAE69DBEE9BCA0E697A0E6A0B8E799BDE891A1E89084E5B9B232383067E99BB6E9A39FE69E9CE5B9B2, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383039353830355F39313334322E6A706567, '2', '15.90', '300', '1', '2', '1', '1', '1543456910', '1511834285');
INSERT INTO `as_ad` VALUES ('31', '9', '1', '科沃斯地宝灵犀扫地机器人', 0xE7A791E6B283E696AFE59CB0E5AE9DE781B5E78A80E689ABE59CB0E69CBAE599A8E4BABA, 0x2F7374617469632F75706C6F6164732F61642F32303137313230373039333233315F37363734342E6A706567, '3', '899.00', '3', '1', '5', '1', '1', '1543456910', '1512610351');
INSERT INTO `as_ad` VALUES ('32', '9', '1', '小熊jsq-a20b1加湿器', 0xE5B08FE7868A6A73712D6132306231E58AA0E6B9BFE599A8, 0x2F7374617469632F75706C6F6164732F61642F32303137313230373039333335345F36383833372E6A706567, '2', '89.00', '3', '1', '5', '1', '1', '1543456910', '1512610434');
INSERT INTO `as_ad` VALUES ('33', '9', '1', '美国家用自动旋转拖把', 0xE887AAE58AA8E6978BE8BDACE68B96E68A8A, 0x2F7374617469632F75706C6F6164732F61642F32303137313230373039333434335F33383439322E6A706567, '1', '899.00', '5', '1', '5', '1', '1', '1543456910', '1512610483');
INSERT INTO `as_ad` VALUES ('94', '10', '1', '乐怡美三双装家务耐用性手套洗碗洗衣服', 0xE4B990E680A1E7BE8EE4B889E58F8CE8A385E5AEB6E58AA1E88090E794A8E680A7E6898BE5A597E6B497E7A297E6B497E8A1A3E69C8D, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383039353332365F35363837342E6A706567, '1', '13.90', '100', '1', '2', '1', '1', '1543456910', '1511834006');
INSERT INTO `as_ad` VALUES ('95', '10', '1', '老街口焦糖瓜子1斤装大颗粒黑糖味葵花籽', 0xE88081E8A197E58FA3E784A6E7B396E7939CE5AD9031E696A4E8A385E5A4A7E9A297E7B292E9BB91E7B396E591B3E891B5E88AB1E7B1BD, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383039353535395F37313139392E6A706567, '0', '18.90', '200', '1', '2', '1', '1', '1543456910', '1511834159');
INSERT INTO `as_ad` VALUES ('96', '10', '1', '三只松鼠无核白葡萄干280g零食果干', 0xE4B889E58FAAE69DBEE9BCA0E697A0E6A0B8E799BDE891A1E89084E5B9B232383067E99BB6E9A39FE69E9CE5B9B2, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383039353830355F39313334322E6A706567, '4', '15.90', '300', '1', '2', '1', '1', '1543456910', '1511834285');
INSERT INTO `as_ad` VALUES ('97', '10', '1', '金龙鱼纯正玉米油4L*2食用油非转基', 0xE98791E9BE99E9B1BCE7BAAFE6ADA3E78E89E7B1B3E6B2B9344C2A32E9A39FE794A8E6B2B9E99D9EE8BDACE59FBA, 0x2F7374617469632F75706C6F6164732F61642F32303137313132383039353935325F31363638302E6A706567, '0', '79.80', '50', '1', '2', '1', '1', '1543456910', '1511834392');
INSERT INTO `as_ad` VALUES ('113', '1', '31', '复合塑料钢丝', 0xE5A48DE59088E5A191E69699E58AA0E7BABFE992A2E4B89DE7AEA131E5AFB8E588B034E5AFB8, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353035323432385F32303730342E6A706567, '9', '11.00', '2000', '1', '5', '3', '1', '', '1513286668');
INSERT INTO `as_ad` VALUES ('114', '1', '31', '防静电钢丝管', 0xE998B2E99D99E794B5E992A2E4B89DE7AEA131E5AFB8E588B034E5AFB8, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353038313630375F37363231362E6A706567, '9', '10.50', '10000', '1', '5', '3', '1', '', '1513296967');
INSERT INTO `as_ad` VALUES ('115', '12', '50', '塑料钢丝管', 0xE5A191E69699E992A2E4B89DE7AEA1, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353039303931345F34313130302E6A706567, '1', '0.00', '0', '1', '5', '3', '1', '', '1513300154');
INSERT INTO `as_ad` VALUES ('116', '12', '50', '高压钢丝编织胶管', 0xE992A2E4B89DE7BC96E7BB87EFBC8CE58685E69C89E4B880E5B182E992A2E4B89DEFBC8C32E5AFB8E992A2E4B89D, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353039313230345F33363932332E6A706567, '2', '0.00', '100', '1', '5', '3', '1', '', '1513300324');
INSERT INTO `as_ad` VALUES ('117', '1', '31', '白色硬塑料管', 0x36E58886E588B034E5AFB8, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353131303831305F33393831342E6A706567, '12', '12.00', '1777', '1', '5', '1', '1', '1516002534', '1513307290');
INSERT INTO `as_ad` VALUES ('118', '46', '49', '卷材', 0xE5A48DE59088E8838EE69F94E680A7E58DB7E69D90EFBC8CE4B880E58DB73130E7B1B3EFBC8CE58E9AE5BAA6332E30, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353134353532315F33393330392E6A706567, '4', '70.00', '10000', '1', '6', '1', '1', '1544860090', '1513320921');
INSERT INTO `as_ad` VALUES ('119', '46', '49', '卷材', 0xE8819AE985AFE8838EEFBC8CE5B8A6E9939DE7AE94EFBC8CE4B880E58DB73130E7B1B3EFBC8CE6A087332E30, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353134353833395F37353135312E6A706567, '8', '110.00', '10000', '1', '6', '1', '1', '1544860117', '1513321119');
INSERT INTO `as_ad` VALUES ('120', '46', '49', '卷材', 0xE69F94E680A7E5A48DE59088E8838EEFBC8CE4B880E58DB7392E35E7B1B3EFBC8CE699AE33E58E9AE38082, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353135303230355F36353639382E6A706567, '4', '70.00', '10000', '1', '6', '1', '1', '1544860148', '1513321325');
INSERT INTO `as_ad` VALUES ('121', '46', '49', '卷材', 0xE8819AE985AFE8838EE6A08733EFBC8C2D3130E5BAA6EFBC8C3130E7B1B3EFBC8C, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353135303533395F31323539342E6A706567, '2', '125.00', '10000', '1', '6', '1', '1', '1544860157', '1513321539');
INSERT INTO `as_ad` VALUES ('122', '46', '49', '自粘卷材', 0xE8819AE59088E789A9E694B9E680A7EFBC8CE4B880E58DB73230E7B1B3EFBC8C312E35E58E9A, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353135303934335F36333831352E6A706567, '0', '110.00', '10000', '1', '6', '3', '1', '', '1513321783');
INSERT INTO `as_ad` VALUES ('123', '46', '49', '胶粉', 0xE8819AE4B999E783AFE5B9B2E883B6E7B289EFBC8CE4B880E7AEB13130E8A28BEFBC8C, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353135313733315F33323938362E6A706567, '0', '40.00', '10000', '1', '6', '3', '1', '', '1513322251');
INSERT INTO `as_ad` VALUES ('124', '46', '49', '丙纶', 0xE59BBDE6A087EFBC8C333030E5858BEFBC8CE4B880E58DB7313030E5B9B3E696B9EFBC8C34E58583E6AF8FE5B9B3E696B9EFBC8C, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353135323131325F34333532352E6A706567, '0', '400.00', '10000', '1', '6', '3', '1', '', '1513322472');
INSERT INTO `as_ad` VALUES ('125', '46', '49', '丙纶', 0xE4B880E58DB7333030E5858BEFBC8CE4B880E58DB73738E7B1B3EFBC8C3930E5B9B3E696B9EFBC8CE6AF8FE5B9B3E696B9312E37E58583E38082E58685E4B8BAE7BBBFE889B2, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353135323431355F33313436382E6A706567, '0', '170.00', '10000', '1', '6', '3', '1', '', '1513322655');
INSERT INTO `as_ad` VALUES ('126', '46', '49', '油性聚氨酯', 0xE6AF8FE6A1B63134E585ACE696A4EFBC8C, 0x2F7374617469632F75706C6F6164732F61642F32303137313231353135323633365F36373233372E6A706567, '2', '55.00', '500', '1', '6', '3', '1', '', '1513322796');

-- ----------------------------
-- Table structure for as_ad_column
-- ----------------------------
DROP TABLE IF EXISTS `as_ad_column`;
CREATE TABLE `as_ad_column` (
  `col_id` int(11) NOT NULL AUTO_INCREMENT,
  `col_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `is_show` int(1) NOT NULL COMMENT '是否显示1是2否',
  PRIMARY KEY (`col_id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of as_ad_column
-- ----------------------------
INSERT INTO `as_ad_column` VALUES ('1', '家电', '1');
INSERT INTO `as_ad_column` VALUES ('2', '服装', '1');
INSERT INTO `as_ad_column` VALUES ('3', '灯具', '1');
INSERT INTO `as_ad_column` VALUES ('4', '玩具', '1');
INSERT INTO `as_ad_column` VALUES ('5', '文具', '1');
INSERT INTO `as_ad_column` VALUES ('19', '劳保用品', '1');
INSERT INTO `as_ad_column` VALUES ('8', '家用', '1');
INSERT INTO `as_ad_column` VALUES ('18', '农用机械', '1');
INSERT INTO `as_ad_column` VALUES ('16', '电线电缆', '1');
INSERT INTO `as_ad_column` VALUES ('17', '土杂', '1');
INSERT INTO `as_ad_column` VALUES ('12', '橡胶管', '1');
INSERT INTO `as_ad_column` VALUES ('20', '水暖洁具', '1');
INSERT INTO `as_ad_column` VALUES ('21', '消防器材', '1');
INSERT INTO `as_ad_column` VALUES ('22', '塑料制品', '1');
INSERT INTO `as_ad_column` VALUES ('23', '保温材料', '1');
INSERT INTO `as_ad_column` VALUES ('24', '阀门', '1');
INSERT INTO `as_ad_column` VALUES ('25', '五金制品', '1');
INSERT INTO `as_ad_column` VALUES ('26', '电动工具', '1');
INSERT INTO `as_ad_column` VALUES ('27', '电动工具', '1');
INSERT INTO `as_ad_column` VALUES ('28', '汽配商城', '1');
INSERT INTO `as_ad_column` VALUES ('29', '空压机', '1');
INSERT INTO `as_ad_column` VALUES ('30', '汽动工具', '1');
INSERT INTO `as_ad_column` VALUES ('31', '光源灯具', '1');
INSERT INTO `as_ad_column` VALUES ('32', '低压电器', '1');
INSERT INTO `as_ad_column` VALUES ('33', '水泵配件', '1');
INSERT INTO `as_ad_column` VALUES ('34', '水泵电机', '1');
INSERT INTO `as_ad_column` VALUES ('35', '起重机械', '1');
INSERT INTO `as_ad_column` VALUES ('36', '水管水带', '1');
INSERT INTO `as_ad_column` VALUES ('37', '电焊机', '1');
INSERT INTO `as_ad_column` VALUES ('38', '汽车配件', '1');
INSERT INTO `as_ad_column` VALUES ('39', '传动机械', '1');
INSERT INTO `as_ad_column` VALUES ('40', '钢丝绳', '1');
INSERT INTO `as_ad_column` VALUES ('41', '建筑机械', '1');
INSERT INTO `as_ad_column` VALUES ('42', '橡胶制品', '1');
INSERT INTO `as_ad_column` VALUES ('43', '塑料市场', '1');
INSERT INTO `as_ad_column` VALUES ('44', '土杂市场', '1');
INSERT INTO `as_ad_column` VALUES ('45', '机电市场', '1');
INSERT INTO `as_ad_column` VALUES ('46', '建材市场', '1');
INSERT INTO `as_ad_column` VALUES ('47', '汽配市场', '1');
INSERT INTO `as_ad_column` VALUES ('48', '灯具市场', '1');
INSERT INTO `as_ad_column` VALUES ('49', '五金市场', '1');
INSERT INTO `as_ad_column` VALUES ('50', '食品城', '1');
INSERT INTO `as_ad_column` VALUES ('51', '文体市场', '1');
INSERT INTO `as_ad_column` VALUES ('52', '文体市场', '1');
INSERT INTO `as_ad_column` VALUES ('53', '食品城', '1');
INSERT INTO `as_ad_column` VALUES ('54', '五金市场', '1');
INSERT INTO `as_ad_column` VALUES ('55', '灯具市场', '1');
INSERT INTO `as_ad_column` VALUES ('56', '汽配市场', '1');
INSERT INTO `as_ad_column` VALUES ('57', '建材市场', '1');
INSERT INTO `as_ad_column` VALUES ('58', '机电市场', '1');
INSERT INTO `as_ad_column` VALUES ('59', '土杂市场', '1');
INSERT INTO `as_ad_column` VALUES ('60', '防水材料', '1');

-- ----------------------------
-- Table structure for as_admin
-- ----------------------------
DROP TABLE IF EXISTS `as_admin`;
CREATE TABLE `as_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `head_img` varchar(255) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `nickname` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '昵称',
  `role_id` int(11) NOT NULL COMMENT '权限id',
  `add_time` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of as_admin
-- ----------------------------
INSERT INTO `as_admin` VALUES ('2', 'admin', 'c56d0e9a7ccec67b4ea131655038d604', '/static/uploads/head/20171127/e42054f5945226f72b285ac19ed43cc7.jpg', '13123456789', '不知道', '1', '1510631534');
INSERT INTO `as_admin` VALUES ('3', 'guanggao', 'c56d0e9a7ccec67b4ea131655038d604', '', '123456', '12', '5', '1512114706');
INSERT INTO `as_admin` VALUES ('4', 'Sui', 'bdac90489f1d9a9d739b955e5da9d8fc', '', '13056018688', '凤飞', '1', '1513295590');

-- ----------------------------
-- Table structure for as_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `as_admin_log`;
CREATE TABLE `as_admin_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员id',
  `log_info` varchar(255) NOT NULL COMMENT '日志描述',
  `log_ip` varchar(255) NOT NULL COMMENT 'ip地址',
  `log_url` varchar(255) NOT NULL COMMENT 'url',
  `log_time` varchar(100) NOT NULL COMMENT '日志时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_admin_log
-- ----------------------------
INSERT INTO `as_admin_log` VALUES ('81', '2', '登录', '114.88.139.169', 'http://show.181.021mc.net/admin/users/login', '1512982154');
INSERT INTO `as_admin_log` VALUES ('82', '2', '登录', '127.0.0.1', 'http://news.com/admin/users/login', '1512982456');
INSERT INTO `as_admin_log` VALUES ('83', '2', '登录', '127.0.0.1', 'http://news.com/admin/users/login', '1512983665');
INSERT INTO `as_admin_log` VALUES ('84', '2', '登录', '114.88.139.169', 'http://show.181.021mc.net/admin/users/login', '1512983603');
INSERT INTO `as_admin_log` VALUES ('85', '2', '登录', '127.0.0.1', 'http://news.com/admin/users/login', '1513047649');
INSERT INTO `as_admin_log` VALUES ('86', '2', '登录', '114.88.139.169', 'http://show.181.021mc.net/admin/users/login', '1513063982');
INSERT INTO `as_admin_log` VALUES ('87', '2', '登录', '127.0.0.1', 'http://news.com/admin/users/login', '1513065509');
INSERT INTO `as_admin_log` VALUES ('88', '2', '登录', '114.88.139.169', 'http://show.181.021mc.net/admin/users/login', '1513231006');
INSERT INTO `as_admin_log` VALUES ('89', '2', '登录', '114.88.139.169', 'http://show.181.021mc.net/admin/users/login', '1513231057');
INSERT INTO `as_admin_log` VALUES ('90', '2', '登录', '114.88.139.169', 'http://show.181.021mc.net/admin/users/login', '1513231273');
INSERT INTO `as_admin_log` VALUES ('91', '2', '登录', '127.0.0.1', 'http://news.com/admin/users/login', '1513231568');
INSERT INTO `as_admin_log` VALUES ('92', '2', '登录', '58.217.187.235', 'http://show.181.021mc.net/admin/users/login', '1513233412');
INSERT INTO `as_admin_log` VALUES ('93', '2', '登录', '127.0.0.1', 'http://news.com/admin/users/login', '1513235109');
INSERT INTO `as_admin_log` VALUES ('94', '2', '登录', '58.217.251.144', 'http://show.181.021mc.net/admin/users/login', '1513295209');
INSERT INTO `as_admin_log` VALUES ('95', '2', '登录', '58.217.251.144', 'http://show.181.021mc.net/admin/users/login', '1513298344');
INSERT INTO `as_admin_log` VALUES ('96', '2', '登录', '58.217.251.144', 'http://show.181.021mc.net/admin/users/login', '1513298941');
INSERT INTO `as_admin_log` VALUES ('97', '2', '登录', '58.217.251.144', 'http://show.181.021mc.net/admin/users/login', '1513309566');
INSERT INTO `as_admin_log` VALUES ('98', '2', '登录', '58.217.251.144', 'http://show.181.021mc.net/admin/users/login', '1513323510');
INSERT INTO `as_admin_log` VALUES ('99', '2', '登录', '58.217.251.144', 'http://show.181.021mc.net/admin/users/login', '1513323789');
INSERT INTO `as_admin_log` VALUES ('100', '2', '登录', '114.88.139.169', 'http://show.181.021mc.net/admin/users/login', '1513324961');
INSERT INTO `as_admin_log` VALUES ('101', '2', '登录', '122.96.40.21', 'http://show.181.021mc.net/admin/users/login', '1513381610');

-- ----------------------------
-- Table structure for as_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `as_admin_menu`;
CREATE TABLE `as_admin_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `menu_url` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '链接',
  `pid` int(11) NOT NULL,
  `is_show` int(1) NOT NULL COMMENT '是否显示1是0否',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of as_admin_menu
-- ----------------------------
INSERT INTO `as_admin_menu` VALUES ('1', '网站管理', '', '0', '1');
INSERT INTO `as_admin_menu` VALUES ('2', '管理员管理', 'admin/admin_list', '1', '1');
INSERT INTO `as_admin_menu` VALUES ('3', '权限管理', 'admin/role_list', '1', '1');
INSERT INTO `as_admin_menu` VALUES ('5', '会员管理', '', '0', '1');
INSERT INTO `as_admin_menu` VALUES ('6', '会员列表', 'users/user_list', '5', '1');
INSERT INTO `as_admin_menu` VALUES ('7', '广告主列表', 'users/ader_list', '5', '1');
INSERT INTO `as_admin_menu` VALUES ('8', '身份列表', 'users/iden_list', '5', '1');
INSERT INTO `as_admin_menu` VALUES ('4', '常见问题', 'admin/problem_list', '1', '1');
INSERT INTO `as_admin_menu` VALUES ('9', '广告管理', '', '0', '1');
INSERT INTO `as_admin_menu` VALUES ('10', '广告列表', 'ad/ad_list', '9', '1');
INSERT INTO `as_admin_menu` VALUES ('11', '意见管理', '', '0', '1');
INSERT INTO `as_admin_menu` VALUES ('12', '意见反馈', 'feedb/feedback', '11', '1');
INSERT INTO `as_admin_menu` VALUES ('13', '广告分类', 'ad/ad_col', '9', '1');
INSERT INTO `as_admin_menu` VALUES ('14', '页面广告', '', '0', '0');
INSERT INTO `as_admin_menu` VALUES ('15', '页面广告管理', 'banner/banner_list', '14', '0');
INSERT INTO `as_admin_menu` VALUES ('16', '页面广告位置', 'banner/banner_pos', '14', '0');
INSERT INTO `as_admin_menu` VALUES ('17', '推荐设置', 'admin/set_groom', '1', '1');
INSERT INTO `as_admin_menu` VALUES ('18', '网站设置', 'admin/setting', '1', '1');

-- ----------------------------
-- Table structure for as_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `as_admin_role`;
CREATE TABLE `as_admin_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '角色名称',
  `role_desc` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '角色描述',
  `is_show` int(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of as_admin_role
-- ----------------------------
INSERT INTO `as_admin_role` VALUES ('1', '超级管理员', '拥有至高无上的权利', '1');
INSERT INTO `as_admin_role` VALUES ('5', '广告管理员', '管理广告', '1');

-- ----------------------------
-- Table structure for as_banner
-- ----------------------------
DROP TABLE IF EXISTS `as_banner`;
CREATE TABLE `as_banner` (
  `bn_id` int(11) NOT NULL AUTO_INCREMENT,
  `bn_name` varchar(255) NOT NULL COMMENT '名称',
  `bn_url` varchar(255) NOT NULL COMMENT '地址',
  `bn_jump` varchar(255) NOT NULL COMMENT '广告跳转地址',
  `bn_pos` varchar(255) NOT NULL COMMENT '位置',
  `add_time` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`bn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_banner
-- ----------------------------
INSERT INTO `as_banner` VALUES ('3', '0.0', '/static/uploads/banner/20171124/4459dc4d7751028f44185211b49bce0e.jpg', '', '1', '1511487300');

-- ----------------------------
-- Table structure for as_banner_pos
-- ----------------------------
DROP TABLE IF EXISTS `as_banner_pos`;
CREATE TABLE `as_banner_pos` (
  `pos_id` int(11) NOT NULL AUTO_INCREMENT,
  `pos_name` varchar(255) NOT NULL,
  `pos_desc` varchar(255) NOT NULL,
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_banner_pos
-- ----------------------------
INSERT INTO `as_banner_pos` VALUES ('1', '主页', '主页banner');
INSERT INTO `as_banner_pos` VALUES ('2', '登录', '登录前');

-- ----------------------------
-- Table structure for as_collect
-- ----------------------------
DROP TABLE IF EXISTS `as_collect`;
CREATE TABLE `as_collect` (
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `ad_id` int(11) NOT NULL COMMENT '广告id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_collect
-- ----------------------------
INSERT INTO `as_collect` VALUES ('1', '66');
INSERT INTO `as_collect` VALUES ('1', '77');
INSERT INTO `as_collect` VALUES ('1', '78');
INSERT INTO `as_collect` VALUES ('1', '68');
INSERT INTO `as_collect` VALUES ('1', '81');
INSERT INTO `as_collect` VALUES ('1', '82');
INSERT INTO `as_collect` VALUES ('11', '96');
INSERT INTO `as_collect` VALUES ('1', '104');
INSERT INTO `as_collect` VALUES ('46', '105');

-- ----------------------------
-- Table structure for as_feedback
-- ----------------------------
DROP TABLE IF EXISTS `as_feedback`;
CREATE TABLE `as_feedback` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL COMMENT '1提建议 2申请添加类别 ',
  `content` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL COMMENT '联系方式',
  `add_time` varchar(100) NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_feedback
-- ----------------------------
INSERT INTO `as_feedback` VALUES ('61', '1', '干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥', '13123456789', '1511771822');
INSERT INTO `as_feedback` VALUES ('62', '1', '干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥', '', '1511771827');
INSERT INTO `as_feedback` VALUES ('63', '1', '干啥干 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥', '', '1511771830');
INSERT INTO `as_feedback` VALUES ('64', '1', '', '', '1511771835');
INSERT INTO `as_feedback` VALUES ('65', '1', '', '', '1511771900');
INSERT INTO `as_feedback` VALUES ('66', '2', '', '', '1511771925');
INSERT INTO `as_feedback` VALUES ('67', '1', '干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥', '13123456789', '1511772040');
INSERT INTO `as_feedback` VALUES ('68', '2', '干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥干啥干啥 添加啥', '13123456789', '1511772078');
INSERT INTO `as_feedback` VALUES ('69', '2', '干啥干', '13123456789', '1511772083');
INSERT INTO `as_feedback` VALUES ('70', '1', '，北辰', '13512345678', '1511772305');
INSERT INTO `as_feedback` VALUES ('71', '1', '建议增加“软件”分类', '18214848027', '1513063966');

-- ----------------------------
-- Table structure for as_groom
-- ----------------------------
DROP TABLE IF EXISTS `as_groom`;
CREATE TABLE `as_groom` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(255) NOT NULL COMMENT '推荐名称',
  `t_time` varchar(100) NOT NULL COMMENT '推荐时间',
  `t_type` int(11) NOT NULL COMMENT '推荐类型 1天 2周 3月',
  `is_show` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_groom
-- ----------------------------
INSERT INTO `as_groom` VALUES ('5', '一个月', '1', '2', '1');
INSERT INTO `as_groom` VALUES ('6', '一年', '12', '2', '1');
INSERT INTO `as_groom` VALUES ('7', '二年', '24', '2', '1');

-- ----------------------------
-- Table structure for as_iden
-- ----------------------------
DROP TABLE IF EXISTS `as_iden`;
CREATE TABLE `as_iden` (
  `iden_id` int(11) NOT NULL AUTO_INCREMENT,
  `iden_name` varchar(255) NOT NULL COMMENT '身份名称',
  `iden_power` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL DEFAULT '0' COMMENT '限制额度',
  PRIMARY KEY (`iden_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_iden
-- ----------------------------
INSERT INTO `as_iden` VALUES ('1', '会员', '查看广告', '0');
INSERT INTO `as_iden` VALUES ('2', '一级广告主', '一年10条', '10');
INSERT INTO `as_iden` VALUES ('3', '二级广告主', '一年30条', '30');
INSERT INTO `as_iden` VALUES ('4', '三级广告主', '一年50条', '50');

-- ----------------------------
-- Table structure for as_invite
-- ----------------------------
DROP TABLE IF EXISTS `as_invite`;
CREATE TABLE `as_invite` (
  `invite_id` int(11) NOT NULL AUTO_INCREMENT,
  `invite_code` varchar(255) NOT NULL COMMENT '邀请码',
  `iden` int(11) NOT NULL COMMENT '身份',
  `mobile` varchar(255) NOT NULL COMMENT '邀请码绑定手机号',
  PRIMARY KEY (`invite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_invite
-- ----------------------------
INSERT INTO `as_invite` VALUES ('6', '123456', '2', '18214848027');
INSERT INTO `as_invite` VALUES ('7', '123456', '2', '18214848027');
INSERT INTO `as_invite` VALUES ('8', '123456', '2', '18214848027');
INSERT INTO `as_invite` VALUES ('10', '500937', '2', '15589057680');
INSERT INTO `as_invite` VALUES ('11', '254790', '2', '15589057680');

-- ----------------------------
-- Table structure for as_problem
-- ----------------------------
DROP TABLE IF EXISTS `as_problem`;
CREATE TABLE `as_problem` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_name` varchar(255) NOT NULL COMMENT '问题名称',
  `pro_content` text NOT NULL COMMENT '问题回复',
  `add_time` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_problem
-- ----------------------------
INSERT INTO `as_problem` VALUES ('4', '什么是广告主？', '广告主是广告活动的发布者，是在网上销售或宣传自己产品和服务的商家，是联盟营销广告的提供者。任何推广、销售其产品或服务的商家都可以作为广告主。广告主发布广告活动，并按照网站主完成的广告活动中规定的营销效果的总数量及单位效果价格向网站主支付费用。', '1510725228');
INSERT INTO `as_problem` VALUES ('5', '如何联系我们？', '可以通过平台预留的客服电话，直接联系我们的客服。', '1511161108');
INSERT INTO `as_problem` VALUES ('6', '如何成为平台广告主？', '可以通过我们在平台预留的在线客服的电话联系电话客服说明您的需求，平台会对你成为广告主在平台发布广告通过线下交易来收取一定的管理费用，当费用到账后平台会发送邀请码给您，您可以通过邀请码注册升级为广告主，在平台发布您所需要的信息。', '1511161124');
INSERT INTO `as_problem` VALUES ('7', '广告主有什么相对应的权限？', '根据广告主对平台所交纳的管理费的金额，平台会给出相对应的广告位，管理费越少等级越低广告位越少，相对应的交纳的管理费越多，等级越高可以使用的广告位就会越多。', '1511161346');

-- ----------------------------
-- Table structure for as_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `as_role_menu`;
CREATE TABLE `as_role_menu` (
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_role_menu
-- ----------------------------
INSERT INTO `as_role_menu` VALUES ('1', '1');
INSERT INTO `as_role_menu` VALUES ('2', '1');
INSERT INTO `as_role_menu` VALUES ('3', '1');
INSERT INTO `as_role_menu` VALUES ('4', '1');
INSERT INTO `as_role_menu` VALUES ('17', '1');
INSERT INTO `as_role_menu` VALUES ('18', '1');
INSERT INTO `as_role_menu` VALUES ('5', '1');
INSERT INTO `as_role_menu` VALUES ('6', '1');
INSERT INTO `as_role_menu` VALUES ('7', '1');
INSERT INTO `as_role_menu` VALUES ('8', '1');
INSERT INTO `as_role_menu` VALUES ('9', '1');
INSERT INTO `as_role_menu` VALUES ('10', '1');
INSERT INTO `as_role_menu` VALUES ('13', '1');
INSERT INTO `as_role_menu` VALUES ('11', '1');
INSERT INTO `as_role_menu` VALUES ('12', '1');
INSERT INTO `as_role_menu` VALUES ('14', '1');
INSERT INTO `as_role_menu` VALUES ('15', '1');
INSERT INTO `as_role_menu` VALUES ('9', '5');
INSERT INTO `as_role_menu` VALUES ('10', '5');
INSERT INTO `as_role_menu` VALUES ('13', '5');

-- ----------------------------
-- Table structure for as_user_data
-- ----------------------------
DROP TABLE IF EXISTS `as_user_data`;
CREATE TABLE `as_user_data` (
  `data_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id（广告主id）',
  `column_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '行业类别',
  `name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '广告主公司名称',
  `tel` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '公司电话',
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `province` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '所属省',
  `city` varchar(100) COLLATE utf8_bin NOT NULL,
  `area` varchar(100) COLLATE utf8_bin NOT NULL,
  `add` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '具体地址',
  `com_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '公司图片',
  `license_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '营业执照',
  `lat` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '纬度',
  `lng` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '经度',
  `aud_status` int(1) NOT NULL COMMENT '审核状态 0 未审核 1通过2 未通过',
  `fnum` int(11) NOT NULL COMMENT '发布条数',
  `expire_time` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '过期时间',
  `add_time` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`data_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of as_user_data
-- ----------------------------
INSERT INTO `as_user_data` VALUES ('2', '1', '1', '上海市某某广告公司', '021-0000000', '13123456789', '上海市', '上海市', '虹口区', '岳阳医院后明明明明哦呵呵命命命命命', '/static/uploads/compony/20171123/ffe5f8a5d0b1ad96986dcdc82abf8f44.jpg', '/static/uploads/compony/20171123/d5e946c161602e84291bf119755a096e.jpg', '31.294679641724', '121.49454498291', '1', '26', '1544863819', '1513327819');
INSERT INTO `as_user_data` VALUES ('9', '11', '2', '目标', '021-25533123', '17721210285', '上海市', '上海市', '虹口区', '北宸佳苑', '/static/uploads/compony/20171124135505_33667.jpeg', '/static/uploads/compony/20171124135505_92891.jpeg', '31.294846202889', '121.49338579677', '1', '0', '1543038905', '1511502937');
INSERT INTO `as_user_data` VALUES ('10', '21', '1', '上海睦诚', '021-12345678', '18214848027', '上海市', '上海市', '闵行区', '滨浦新苑', '/static/uploads/compony/20171124124707_11199.jpeg', '/static/uploads/compony/20171124124707_37871.jpeg', '31.093538284302', '121.42502593994', '1', '0', '1543035082', '1511499082');
INSERT INTO `as_user_data` VALUES ('11', '22', '1', '45646', '+564654', '654645', '', '', '', '6+54654', '/static/uploads/compony/20171127/9930d0e252057770f8bf95bb02d9029a.jpg', '/static/uploads/compony/20171127/cc678bc2a89815b2149c695d0207d754.jpg', '', '', '1', '0', '1543302731', '1511766731');
INSERT INTO `as_user_data` VALUES ('13', '27', '1', '上海买买买广告公司', '021-1234567', '15512345648', '上海市', '上海市', '闸北区', '上海火车站', '/static/uploads/compony/20171127153657_80521.jpeg', '/static/uploads/compony/20171127153657_35323.jpeg', '31.256066245673', '121.4620888328', '1', '0', '1543304217', '1511768249');
INSERT INTO `as_user_data` VALUES ('16', '46', '1', '北辰三角洲', '021-12345678', '18214848027', '山东省', '临沂市', '兰山区', '北园小区', '/static/uploads/compony/20171212155139_41456.jpeg', '/static/uploads/compony/20171212155139_78412.jpeg', '35.089561462402', '118.33634185791', '1', '0', '1544601285', '1513065348');
INSERT INTO `as_user_data` VALUES ('17', '31', '1', '凤飞橡塑有限公司', '0517-83946491', '13056018688', '山东省', '临沂市', '兰山区', '十一路塑料市场', '/static/uploads/compony/20171214075503_81988.jpeg', '/static/uploads/compony/20171214075503_35265.jpeg', '35.132820129395', '118.28176116943', '1', '0', '1544745303', '1513231136');
INSERT INTO `as_user_data` VALUES ('18', '50', '12', '凤飞橡塑有限公司', '0517-83946491', '13852386043', '江苏省', '淮安市', '清河区', '䌓荣路8号', '/static/uploads/compony/20171215090729_60238.jpeg', '/static/uploads/compony/20171215090729_74106.jpeg', '33.595283508301', '119.13683319092', '1', '0', '1544836049', '1513323845');
INSERT INTO `as_user_data` VALUES ('19', '49', '46', '海天防水有限公司', '0539-3306158', '18669613596', '山东省', '临沂市', '兰山区', '临西十一路建材市场88号', '/static/uploads/compony/20171215142342_57471.jpeg', '/static/uploads/compony/20171215142342_47837.jpeg', '35.098648071289', '118.27330780029', '1', '0', '1544855022', '1513323696');

-- ----------------------------
-- Table structure for as_user_take
-- ----------------------------
DROP TABLE IF EXISTS `as_user_take`;
CREATE TABLE `as_user_take` (
  `user_id` int(11) NOT NULL,
  `col_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_user_take
-- ----------------------------
INSERT INTO `as_user_take` VALUES ('31', '2');
INSERT INTO `as_user_take` VALUES ('31', '6');
INSERT INTO `as_user_take` VALUES ('31', '7');
INSERT INTO `as_user_take` VALUES ('47', '1');
INSERT INTO `as_user_take` VALUES ('47', '2');
INSERT INTO `as_user_take` VALUES ('47', '3');
INSERT INTO `as_user_take` VALUES ('47', '4');
INSERT INTO `as_user_take` VALUES ('47', '5');
INSERT INTO `as_user_take` VALUES ('1', '7');
INSERT INTO `as_user_take` VALUES ('1', '11');
INSERT INTO `as_user_take` VALUES ('1', '9');
INSERT INTO `as_user_take` VALUES ('1', '10');
INSERT INTO `as_user_take` VALUES ('1', '6');
INSERT INTO `as_user_take` VALUES ('48', '1');
INSERT INTO `as_user_take` VALUES ('48', '2');
INSERT INTO `as_user_take` VALUES ('48', '3');
INSERT INTO `as_user_take` VALUES ('48', '4');
INSERT INTO `as_user_take` VALUES ('48', '5');
INSERT INTO `as_user_take` VALUES ('49', '1');
INSERT INTO `as_user_take` VALUES ('49', '3');
INSERT INTO `as_user_take` VALUES ('49', '4');
INSERT INTO `as_user_take` VALUES ('49', '5');
INSERT INTO `as_user_take` VALUES ('50', '1');
INSERT INTO `as_user_take` VALUES ('50', '2');
INSERT INTO `as_user_take` VALUES ('50', '3');
INSERT INTO `as_user_take` VALUES ('50', '4');
INSERT INTO `as_user_take` VALUES ('50', '5');
INSERT INTO `as_user_take` VALUES ('31', '12');
INSERT INTO `as_user_take` VALUES ('31', '20');
INSERT INTO `as_user_take` VALUES ('1', '24');
INSERT INTO `as_user_take` VALUES ('1', '28');
INSERT INTO `as_user_take` VALUES ('1', '35');
INSERT INTO `as_user_take` VALUES ('1', '34');
INSERT INTO `as_user_take` VALUES ('46', '18');
INSERT INTO `as_user_take` VALUES ('46', '19');
INSERT INTO `as_user_take` VALUES ('46', '16');
INSERT INTO `as_user_take` VALUES ('46', '17');
INSERT INTO `as_user_take` VALUES ('46', '12');
INSERT INTO `as_user_take` VALUES ('46', '20');
INSERT INTO `as_user_take` VALUES ('46', '21');
INSERT INTO `as_user_take` VALUES ('46', '22');
INSERT INTO `as_user_take` VALUES ('46', '23');
INSERT INTO `as_user_take` VALUES ('46', '24');
INSERT INTO `as_user_take` VALUES ('46', '25');
INSERT INTO `as_user_take` VALUES ('46', '30');
INSERT INTO `as_user_take` VALUES ('49', '46');
INSERT INTO `as_user_take` VALUES ('31', '46');
INSERT INTO `as_user_take` VALUES ('51', '1');
INSERT INTO `as_user_take` VALUES ('51', '2');
INSERT INTO `as_user_take` VALUES ('51', '3');
INSERT INTO `as_user_take` VALUES ('51', '4');
INSERT INTO `as_user_take` VALUES ('51', '5');
INSERT INTO `as_user_take` VALUES ('51', '12');
INSERT INTO `as_user_take` VALUES ('51', '60');
INSERT INTO `as_user_take` VALUES ('1', '46');
INSERT INTO `as_user_take` VALUES ('51', '57');
INSERT INTO `as_user_take` VALUES ('51', '53');
INSERT INTO `as_user_take` VALUES ('31', '1');
INSERT INTO `as_user_take` VALUES ('1', '2');

-- ----------------------------
-- Table structure for as_users
-- ----------------------------
DROP TABLE IF EXISTS `as_users`;
CREATE TABLE `as_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `head_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '头像',
  `mobile` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `nickname` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '昵称',
  `iden` int(1) NOT NULL COMMENT '身份1会员 2 广告主',
  `area` int(11) NOT NULL COMMENT '地区',
  `reg_time` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '注册时间',
  `is_login` int(1) NOT NULL COMMENT '是否登录',
  `session_id` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'session id',
  `login_time` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of as_users
-- ----------------------------
INSERT INTO `as_users` VALUES ('1', '13123456789', 'c56d0e9a7ccec67b4ea131655038d604', '/static/uploads/compony/20171116160646_63775.jpeg', '13123456789', '你的名字', '4', '0', '1513235029', '1', 'n5g4uhfl53bk7k373e4imm47r3', '1513326957');
INSERT INTO `as_users` VALUES ('11', '17721210285', 'c56d0e9a7ccec67b4ea131655038d604', '/static/uploads/compony/20171116184829_61159.jpeg', '17721210285', 'steven', '2', '0', '1511502937', '1', '2jtb44m2726cgq615mq6porgd5', '1512699052');
INSERT INTO `as_users` VALUES ('12', '13801613801', 'c56d0e9a7ccec67b4ea131655038d604', '/static/img/default.jpg', '13801613801', '13801613801', '4', '0', '1511153445', '0', '', '');
INSERT INTO `as_users` VALUES ('22', '15512345678', 'c56d0e9a7ccec67b4ea131655038d604', '/static/uploads/head/20171127/1e417c894c3ecd1b4bf69904261a1dd6.jpg', '15512345678', '8676回家', '2', '0', '1511766731', '1', 'bkvajfq6rl3vukfu1et0euj4m3', '1511766665');
INSERT INTO `as_users` VALUES ('31', '13056018688', '009590a4e9b7bf6402aabeb585bcf4c6', '/static/uploads/compony/20171215055138_58634.jpeg', '13056018688', '13056018688', '4', '0', '1513231136', '1', '0jhk1sjih0tjomilode9mps374', '1513328867');
INSERT INTO `as_users` VALUES ('46', '18214848027', 'c56d0e9a7ccec67b4ea131655038d604', '/static/uploads/compony/20171212142947_23173.jpeg', '18214848027', '北辰', '2', '0', '1513065348', '1', '41kjihodb4gon98t5qtafhfag5', '1513149635');
INSERT INTO `as_users` VALUES ('49', '18669613596', '72f152e7c5d5e5c08707b60bf752cfab', '/static/img/default.jpg', '18669613596', '18669613596', '4', '0', '1513323696', '1', 'nhg8i2pvhm81803n7lmg3u73b7', '1513299371');
INSERT INTO `as_users` VALUES ('50', '13852386043', 'c56d0e9a7ccec67b4ea131655038d604', '/static/img/default.jpg', '13852386043', '13852386043', '4', '0', '1513323845', '1', 'meeia94be42hrqe6enjge151m6', '1513300072');
INSERT INTO `as_users` VALUES ('51', '13327965263', '009590a4e9b7bf6402aabeb585bcf4c6', '/static/img/default.jpg', '13327965263', '13327965263', '1', '0', '1513325484', '1', 'kc2k56ed0fajvq0af5r4nfedp6', '1513325526');

-- ----------------------------
-- Table structure for as_websetting
-- ----------------------------
DROP TABLE IF EXISTS `as_websetting`;
CREATE TABLE `as_websetting` (
  `tel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of as_websetting
-- ----------------------------
INSERT INTO `as_websetting` VALUES ('13056018688');
