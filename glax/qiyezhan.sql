/*
Navicat MySQL Data Transfer

Source Server         : yida_181_021mc_
Source Server Version : 50555
Source Host           : 61.152.175.76:3306
Source Database       : yida_181_021mc_

Target Server Type    : MYSQL
Target Server Version : 50555
File Encoding         : 65001

Date: 2017-12-11 15:19:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yd_admin
-- ----------------------------
DROP TABLE IF EXISTS `yd_admin`;
CREATE TABLE `yd_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `role_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '角色id',
  `header_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '头像',
  `login_time` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yd_admin
-- ----------------------------
INSERT INTO `yd_admin` VALUES ('1', 'admin', 'c56d0e9a7ccec67b4ea131655038d604', '1234567', '123#cc.cc', '1', '\\static\\upload\\admin\\20171204164321_84462.jpeg', '1512974058');

-- ----------------------------
-- Table structure for yd_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `yd_admin_menu`;
CREATE TABLE `yd_admin_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '菜单名称',
  `menu_url` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `menu_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '菜单图',
  `pid` int(11) NOT NULL,
  `is_show` int(1) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yd_admin_menu
-- ----------------------------
INSERT INTO `yd_admin_menu` VALUES ('1', '网站管理', '', 'icon-cogs', '0', '1');
INSERT INTO `yd_admin_menu` VALUES ('2', '管理员管理', '/admin/admin/admin_list', '', '1', '1');
INSERT INTO `yd_admin_menu` VALUES ('3', '网站基本信息', '/admin/admin/setwebconf', '', '1', '1');
INSERT INTO `yd_admin_menu` VALUES ('4', '权限管理', '/admin/role/role_list', '', '1', '1');
INSERT INTO `yd_admin_menu` VALUES ('5', '广告管理', '', 'icon-picture', '0', '1');
INSERT INTO `yd_admin_menu` VALUES ('6', '广告位置', '/admin/banner/banner_pos', '', '5', '1');
INSERT INTO `yd_admin_menu` VALUES ('7', '广告列表', '/admin/banner/banner_list', '', '5', '1');
INSERT INTO `yd_admin_menu` VALUES ('8', '案例预约管理', '', 'icon-list', '0', '1');
INSERT INTO `yd_admin_menu` VALUES ('9', '案例列表', '/admin/cases/case_list', '', '8', '1');
INSERT INTO `yd_admin_menu` VALUES ('10', '行业管理', '/admin/cases/trade_list', '', '8', '1');
INSERT INTO `yd_admin_menu` VALUES ('11', '软件签约管理', '', 'icon-list', '0', '1');
INSERT INTO `yd_admin_menu` VALUES ('12', '软件列表', '/admin/soft/soft_list', '', '11', '1');
INSERT INTO `yd_admin_menu` VALUES ('13', '签约管理', '/admin/soft/sign_list', '', '11', '1');
INSERT INTO `yd_admin_menu` VALUES ('14', '页面管理', '', 'icon-desktop', '0', '1');
INSERT INTO `yd_admin_menu` VALUES ('15', '内容管理', '/admin/page/page_info', '', '14', '1');
INSERT INTO `yd_admin_menu` VALUES ('16', '客户管理', '', 'icon-list', '0', '1');
INSERT INTO `yd_admin_menu` VALUES ('17', '合作客户列表', '/admin/custom/custom_list', '', '16', '1');
INSERT INTO `yd_admin_menu` VALUES ('18', '客服管理', '', 'icon-list', '0', '1');
INSERT INTO `yd_admin_menu` VALUES ('19', '客服列表', '/admin/server/server_list', '', '18', '1');
INSERT INTO `yd_admin_menu` VALUES ('20', '客服位置', '/admin/server/pos_list', '', '18', '1');
INSERT INTO `yd_admin_menu` VALUES ('21', '企业之家', '/admin/admin/under_com', '', '1', '1');
INSERT INTO `yd_admin_menu` VALUES ('22', '预约管理', '/admin/cases/make', '', '8', '1');
INSERT INTO `yd_admin_menu` VALUES ('23', '专家观点', '/admin/soft/expert_list', '', '11', '1');
INSERT INTO `yd_admin_menu` VALUES ('24', '易大实景', '/admin/admin/edit_yida', '', '1', '1');

-- ----------------------------
-- Table structure for yd_banner
-- ----------------------------
DROP TABLE IF EXISTS `yd_banner`;
CREATE TABLE `yd_banner` (
  `bn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `bn_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '广告名称',
  `bn_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `bn_pos` varchar(255) COLLATE utf8_bin NOT NULL,
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  `add_time` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`bn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yd_banner
-- ----------------------------
INSERT INTO `yd_banner` VALUES ('17', '4', '/static/uploads/banner/20171211/6397acd26e0317ce4053f172b3b6d427.jpg', '1', '1', '1512638583');
INSERT INTO `yd_banner` VALUES ('18', '5', '/static/uploads/banner/20171211/f20073292c8e1b36d79ce74002aa9836.jpg', '1', '1', '1512638598');
INSERT INTO `yd_banner` VALUES ('20', '3', '/static/uploads/banner/20171207/221cda033d7d90c80918f9470398d8e3.jpg', '', '1', '1512638627');
INSERT INTO `yd_banner` VALUES ('21', '3', '/static/uploads/banner/20171211/153910c224198c0f527f9d07b27445c8.png', '1', '1', '1512638637');
INSERT INTO `yd_banner` VALUES ('22', '2', '/static/uploads/banner/20171211/158e05137a05f8b00128f615755169f0.jpg', '1', '1', '1512638649');
INSERT INTO `yd_banner` VALUES ('16', '1', '/static/uploads/banner/20171211/8e83dbc0843d63e2145e730a90269774.jpg', '1', '1', '1512638570');

-- ----------------------------
-- Table structure for yd_banner_pos
-- ----------------------------
DROP TABLE IF EXISTS `yd_banner_pos`;
CREATE TABLE `yd_banner_pos` (
  `pos_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '位置id',
  `pos_name` varchar(255) NOT NULL COMMENT '位置名称',
  `pos_desc` varchar(255) NOT NULL COMMENT '描述',
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_banner_pos
-- ----------------------------
INSERT INTO `yd_banner_pos` VALUES ('1', '主页', '图片');
INSERT INTO `yd_banner_pos` VALUES ('2', '客服', '图片');

-- ----------------------------
-- Table structure for yd_case
-- ----------------------------
DROP TABLE IF EXISTS `yd_case`;
CREATE TABLE `yd_case` (
  `case_id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '行业id',
  `soft_id` int(11) NOT NULL COMMENT '用户id',
  `com_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '公司名称',
  `com_desc` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '公司描述',
  `case_desc` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '案例描述',
  `case_content` varchar(255) COLLATE utf8_bin NOT NULL,
  `case_img` varchar(255) COLLATE utf8_bin NOT NULL,
  `is_groom` int(1) NOT NULL COMMENT '是否为经典案例',
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  PRIMARY KEY (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yd_case
-- ----------------------------
INSERT INTO `yd_case` VALUES ('1', '1', '2', '【宁波祥丰进出口有限公司】', '拥有100多业务人员的,集文具用品，日用品，休闲用户，玩具等为主的进出口大型国际贸易公司', '由于部门较多，有日用品事业部，休闲用品事业部,进口事业部等，部门的产品各有特色，人数众多，要求也各不相同,对软件的要求比较高,在选择软件公司及选择软件时也颇有难度,真是众口难调.公司在选择软件时,历时一年半时间,全国几乎有点名气的跟外贸软件有关的软件公司都到公司演示过,公司的有关人员也是看了这家的软件,看哪家的软件,凡感觉还可以的软件,还有看好几遍.下面的操作的人员看了,公司的部门领导再看,然后公司高层再看,好后公司总裁再看.真是一项认真仔细,层层把关的工作.\r\n        经过公司所有人员的艰苦的、', '&lt;p&gt;fuidshifhdsaiokjfldksafdsafdlkfhdsajkhfkldsafdsafdsafdsa&lt;/p&gt;', '/static/upload/case/20171208/67bfce51618769c34a03d345f453a003.jpg', '1', '1');
INSERT INTO `yd_case` VALUES ('2', '4', '2', '软件案例2', '软件案例2软件案例2', '软件案例2软件案例2软件案例2软件案例2软件案例2软件案例2软件案例2软件案例2', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');
INSERT INTO `yd_case` VALUES ('3', '4', '2', '软件案例3', '软件案例3软件案例3', '软件案例3软件案例3软件案例3软件案例3软件案例3', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');
INSERT INTO `yd_case` VALUES ('4', '1', '10', '软件案例4', '软件案例4软件案例4', '软件案例4软件案例4软件案例4软件案例4软件案例4软件案例4软件案例4软件案例4', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');
INSERT INTO `yd_case` VALUES ('8', '1', '3', '软件案例5', '软件案例5软件案例5', '软件案例5案例5软件案例5', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');
INSERT INTO `yd_case` VALUES ('9', '1', '2', '软件案例6', '软件案例6软件案例6', '软件案例6软件案例6软件案例6软件案例6软件案例6软件案例6', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');
INSERT INTO `yd_case` VALUES ('10', '2', '3', '软件案例7', '软件案例7软件案例7', '软件案例7软件案例7软件案例7软件案例7软件案例7软件案例7软件案例7软件案例7', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');
INSERT INTO `yd_case` VALUES ('11', '3', '2', '软件案例8', '软件案例8软件案例8', '软件案例8软件案例8软件案例8软件案例8软件案例8', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');
INSERT INTO `yd_case` VALUES ('12', '2', '2', '软件案例9', '软件案例9软件案例9', '软件案例9软件案例9软件案例9软件案例9软件案例9软件案例9软件案例9', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');
INSERT INTO `yd_case` VALUES ('13', '2', '2', '软件案例10', '软件案例10软件案例10', '软件案例10软件案例10软件案例10软件案例10软件案例10软件案例10', '123456', '/static/upload/case/20171207\\306660ab97d9584a53d8d786e61211e4.png', '1', '1');

-- ----------------------------
-- Table structure for yd_company
-- ----------------------------
DROP TABLE IF EXISTS `yd_company`;
CREATE TABLE `yd_company` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '网站标题',
  `com_name` varchar(255) NOT NULL COMMENT '公司名称',
  `logo` varchar(255) NOT NULL COMMENT 'logo',
  `com_img` varchar(255) NOT NULL COMMENT '公司图片',
  `com_phone` varchar(255) NOT NULL COMMENT '公司电话',
  `com_email` varchar(255) NOT NULL COMMENT '邮箱',
  `sale_phone` varchar(255) NOT NULL COMMENT '销售热线',
  `server_phone` varchar(255) NOT NULL COMMENT '客服热线',
  `free_server_phone` varchar(255) NOT NULL COMMENT '全国免费服务热线',
  `control_phone` varchar(255) NOT NULL COMMENT '监督热线',
  `free` varchar(255) NOT NULL COMMENT '备案信息',
  `summary` text NOT NULL COMMENT '简介',
  `qrcode` varchar(255) NOT NULL COMMENT '二维码',
  `update_time` varchar(100) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_company
-- ----------------------------
INSERT INTO `yd_company` VALUES ('1', '范德萨发ds', ' 打算', '/static/upload/company/20171207\\eac72c8be2ceecc76747009e28bde7b3.png', '/static/upload/company/20171207/9395914edfcf6d5cb27d9417343d7d33.png', '13123456789', '123@cc.cc', '0574-88888888', '0574-88888888', '4008-166-580', '0574-88888888', ' ICP备123456789号', '&lt;p class=&quot;textIndent&quot;&gt;宁波神易大软件有限公司(简称易大软件)始创于2000年1月，是全国具有竞争力的外贸软件、企业ERP、工贸软件、客户关系CRM软件，商贸软件为主的企业管理软件开发商、服务商之一。易大人一直致力于应用软件的开发，形成了智赢天下外贸管理软件平台、智赢天下企业管理ERP平台、智赢天下客户关系CRM，智赢天下工贸通等一系列精品软件。&lt;/p&gt;&lt;p class=&quot;textIndent&quot;&gt;智赢天下软件以“先进的技术、创新的产品和周到的服务”在广大客户中享有盛誉。“智赢天下--助企业智造未来!”,以企业信息化建设为已任，为外贸型企业、内销型企业、内销外销兼有的企业,为贸易性企业，生产制造型企业提供了完备有效的管理系统平台及管理解决方案和电子商务解决方案。智赢天下软件市场占有率一直保持快速增长，在众多外贸软件及企业管理软件厂商中快速提升，已成为业界增长最快的公司之一，“想智造企业，用智赢天下”，已成了众多中小企业的共识!。\r\n &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&amp;nbsp;智赢天下软件目前拥有一支具有丰富的软件和行业经验的,由系统分析员、高级程序员、行业实施顾问、客户支持顾问等组成的研发和实施服务团队。尤其是软件研发部成员都有在国内著名软件公司开发和实施工作经验,他们具备有精湛的专业知识，丰富的行业知识和宝贵的软件研发经验，使得公司产品不断创新，领先同行。&lt;/p&gt;&lt;p class=&quot;textIndent&quot;&gt;“智赢天下--助你智造赢未来!”是智赢天下人始终不变的追求, 继续“打造中小企业管理软件知名品牌“为目标，“用先进的管理思想和软件技术，创新打磨软件产品、真诚服务,\r\n &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;不断提升企业运营管理能力”,为中小企业的可持续发展提供强有力的支持和保障，使之领先同行,做强做大！&lt;/p&gt;', '/static/upload/company/20171207\\0305ed002e78f0d06633f9e0bb6079ca.png', '1512715233');

-- ----------------------------
-- Table structure for yd_custom
-- ----------------------------
DROP TABLE IF EXISTS `yd_custom`;
CREATE TABLE `yd_custom` (
  `custom_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客户id',
  `cus_com_name` varchar(255) NOT NULL COMMENT '客户公司名称',
  `cus_com_desc` varchar(255) NOT NULL COMMENT '客户公司描述',
  `cus_com_te` varchar(255) NOT NULL,
  `cus_com_content` varchar(255) NOT NULL COMMENT '内容',
  `cus_com_img` varchar(255) NOT NULL,
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_custom
-- ----------------------------
INSERT INTO `yd_custom` VALUES ('1', '【宁波艺海国际贸有限公司】', '专业工艺品，玩具出口商及生产制造商', '&lt;p&gt;123456&lt;/p&gt;', '经过软件实施服务，智赢天下软件在工厂的运行与智赢天下软件在外贸公司的运行一样成功。为工厂的良好运行提供了信息化支持。外贸与工厂的衔接也很顺畅，基本达到无纸化办公的要求，大大提高工作效率，为公司的进一步的发展壮大，奠定了坚实的基础！', '/static/upload/custom/20171208/501e28cc96d3e320212f8f455ab1eabd.jpg', '1');
INSERT INTO `yd_custom` VALUES ('2', '合作客户2', '合作客户2合作客户2合作客户2', '123456', '合作客户2合作客户2合作客户2合作客户2合作客户2合作客户2', '/static/upload/custom/20171208/526fcbcd162d233183ff0a3b160e4ea1.png', '1');
INSERT INTO `yd_custom` VALUES ('3', '合作客户3', '合作客户3合作客户3合作客户3合作客户3合作客户3', '123456', '合作客户3合作客户3合作客户3合作客户3合作客户3合作客户3合作客户3合作客户3合作客户3', '/static/upload/custom/20171208/35185a8e9ead73cf760cc6a58ed67846.png', '1');
INSERT INTO `yd_custom` VALUES ('4', '合作客户4', '合作客户4合作客户4合作客户4合作客户4', '123456', '合作客户4合作客户4合作客户4合作客户4合作客户4合作客户4', '/static/upload/custom/20171208/68155fc84627762f8519e9456ba7d3de.png', '1');
INSERT INTO `yd_custom` VALUES ('5', '合作客户5', '合作客户5合作客户5合作客户5合作客户5', '123456', '合作客户5合作客户5合作客户5合作客户5合作客户5合作客户5合作客户5合作客户5合作客户5合作客户5', '/static/upload/custom/20171208/9ad469543112275cd8083cb02faff153.png', '1');
INSERT INTO `yd_custom` VALUES ('7', '合作客户6', '合作客户6合作客户6合作客户6合作客户6合作客户6', '123456', '合作客户6合作客户6合作客户6合作客户6合作客户6合作客户6', '/static/upload/custom/20171208/9cdb7c3981ff14cccd6efea38adba80b.png', '1');

-- ----------------------------
-- Table structure for yd_expert
-- ----------------------------
DROP TABLE IF EXISTS `yd_expert`;
CREATE TABLE `yd_expert` (
  `expert_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '名下公司id',
  `expert_name` varchar(255) NOT NULL COMMENT '名下公司名称',
  `expert_desc` varchar(255) NOT NULL COMMENT 'com_desc',
  `expert_img` varchar(255) NOT NULL,
  `expert_content` text NOT NULL COMMENT '企业详情',
  `add_time` varchar(100) NOT NULL,
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  PRIMARY KEY (`expert_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_expert
-- ----------------------------
INSERT INTO `yd_expert` VALUES ('3', '专家观点', '专家观点专家观点专家观点专家观', '/static/upload/under/20171207/9b7b443c16252b56e35025cbd0e58ff2.jpg', '&lt;p&gt;&lt;span style=&quot;font-family: 楷体, 楷体_GB2312, SimKai;&quot;&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;&lt;/span&gt;专家观点专家观点专家观点专家观点专家观点专家观点专家观点专家观点专家观点专家观点专家观点专家观点专家观点专家观点&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-size: 14px; text-align: center;&quot;&gt;&lt;img src=&quot;/ueditor/php/upload/image/20171207/1512627012898903.jpg&quot; title=&quot;1512627012898903.jpg&quot; alt=&quot;2012-07-09 12.44.58.jpg&quot; width=&quot;683&quot; height=&quot;620&quot;/&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;', '1512627109', '1');
INSERT INTO `yd_expert` VALUES ('4', '专家观点', '专家观点专家观点', '/static/upload/under/20171208/456b1089777da310b53fd6d806fc63f3.png', '&lt;p&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;img src=&quot;/ueditor/php/upload/image/20171207/1512627138340145.jpg&quot; title=&quot;1512627138340145.jpg&quot; alt=&quot;2012-08-14 14.10.39.jpg&quot;/&gt;&lt;/p&gt;', '1512627140', '1');

-- ----------------------------
-- Table structure for yd_make
-- ----------------------------
DROP TABLE IF EXISTS `yd_make`;
CREATE TABLE `yd_make` (
  `make_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '预约id',
  `com_name` varchar(255) NOT NULL COMMENT '公司名称',
  `name` varchar(100) NOT NULL COMMENT '姓名',
  `mobile` varchar(50) NOT NULL COMMENT '联系电话',
  `email` varchar(100) NOT NULL COMMENT '邮箱',
  `qq` varchar(50) NOT NULL COMMENT 'QQ',
  `wechat` varchar(100) NOT NULL COMMENT '微信',
  `add_time` varchar(100) NOT NULL COMMENT '预约时间',
  PRIMARY KEY (`make_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_make
-- ----------------------------

-- ----------------------------
-- Table structure for yd_page
-- ----------------------------
DROP TABLE IF EXISTS `yd_page`;
CREATE TABLE `yd_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_page
-- ----------------------------
INSERT INTO `yd_page` VALUES ('1', '感谢客户', '1');
INSERT INTO `yd_page` VALUES ('2', '公司简介', '1');

-- ----------------------------
-- Table structure for yd_page_info
-- ----------------------------
DROP TABLE IF EXISTS `yd_page_info`;
CREATE TABLE `yd_page_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '页面展示id',
  `info_content` text NOT NULL COMMENT '内容',
  `page_id` int(11) NOT NULL COMMENT '页面id',
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_page_info
-- ----------------------------
INSERT INTO `yd_page_info` VALUES ('2', '宁波神易大软件', '2');
INSERT INTO `yd_page_info` VALUES ('3', '<p>fdddddddddd214312</p>', '1');

-- ----------------------------
-- Table structure for yd_real
-- ----------------------------
DROP TABLE IF EXISTS `yd_real`;
CREATE TABLE `yd_real` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(255) NOT NULL COMMENT '图片地址',
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_real
-- ----------------------------
INSERT INTO `yd_real` VALUES ('36', '/static/upload/company/20171211145059_86868.png');
INSERT INTO `yd_real` VALUES ('37', '/static/upload/company/20171211145059_14613.png');
INSERT INTO `yd_real` VALUES ('38', '/static/upload/company/20171211145059_83655.png');
INSERT INTO `yd_real` VALUES ('39', '/static/upload/company/20171211145059_25946.png');
INSERT INTO `yd_real` VALUES ('40', '/static/upload/company/20171211145059_38217.png');
INSERT INTO `yd_real` VALUES ('41', '/static/upload/company/20171211145100_77137.png');
INSERT INTO `yd_real` VALUES ('42', '/static/upload/company/20171211145100_63352.png');

-- ----------------------------
-- Table structure for yd_role
-- ----------------------------
DROP TABLE IF EXISTS `yd_role`;
CREATE TABLE `yd_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(255) NOT NULL COMMENT '角色名称',
  `role_desc` varchar(255) NOT NULL,
  `is_show` int(1) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_role
-- ----------------------------
INSERT INTO `yd_role` VALUES ('1', '超级管理员', '至高无上的权利', '1');

-- ----------------------------
-- Table structure for yd_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `yd_role_menu`;
CREATE TABLE `yd_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_role_menu
-- ----------------------------
INSERT INTO `yd_role_menu` VALUES ('2', '4');
INSERT INTO `yd_role_menu` VALUES ('1', '1');
INSERT INTO `yd_role_menu` VALUES ('1', '2');
INSERT INTO `yd_role_menu` VALUES ('1', '3');
INSERT INTO `yd_role_menu` VALUES ('1', '4');
INSERT INTO `yd_role_menu` VALUES ('1', '21');
INSERT INTO `yd_role_menu` VALUES ('1', '24');
INSERT INTO `yd_role_menu` VALUES ('1', '5');
INSERT INTO `yd_role_menu` VALUES ('1', '6');
INSERT INTO `yd_role_menu` VALUES ('1', '7');
INSERT INTO `yd_role_menu` VALUES ('1', '8');
INSERT INTO `yd_role_menu` VALUES ('1', '9');
INSERT INTO `yd_role_menu` VALUES ('1', '10');
INSERT INTO `yd_role_menu` VALUES ('1', '22');
INSERT INTO `yd_role_menu` VALUES ('1', '11');
INSERT INTO `yd_role_menu` VALUES ('1', '12');
INSERT INTO `yd_role_menu` VALUES ('1', '13');
INSERT INTO `yd_role_menu` VALUES ('1', '23');
INSERT INTO `yd_role_menu` VALUES ('1', '14');
INSERT INTO `yd_role_menu` VALUES ('1', '15');
INSERT INTO `yd_role_menu` VALUES ('1', '16');
INSERT INTO `yd_role_menu` VALUES ('1', '17');
INSERT INTO `yd_role_menu` VALUES ('1', '18');
INSERT INTO `yd_role_menu` VALUES ('1', '19');
INSERT INTO `yd_role_menu` VALUES ('1', '20');

-- ----------------------------
-- Table structure for yd_server
-- ----------------------------
DROP TABLE IF EXISTS `yd_server`;
CREATE TABLE `yd_server` (
  `server_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客服id',
  `server_pos` int(11) NOT NULL COMMENT '属于哪个位置',
  `qq` varchar(50) NOT NULL COMMENT 'QQ',
  `wechat` varchar(50) NOT NULL COMMENT '微信号',
  `mobile` varchar(100) NOT NULL COMMENT '联系电话',
  `trade_num` varchar(100) NOT NULL COMMENT '贸易通',
  PRIMARY KEY (`server_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_server
-- ----------------------------
INSERT INTO `yd_server` VALUES ('3', '1', '123', '123456', '123456', '123');

-- ----------------------------
-- Table structure for yd_server_pos
-- ----------------------------
DROP TABLE IF EXISTS `yd_server_pos`;
CREATE TABLE `yd_server_pos` (
  `server_pos` int(11) NOT NULL AUTO_INCREMENT COMMENT '客服位置id',
  `pos_name` varchar(255) NOT NULL COMMENT '位置名称',
  PRIMARY KEY (`server_pos`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_server_pos
-- ----------------------------
INSERT INTO `yd_server_pos` VALUES ('2', '华南');

-- ----------------------------
-- Table structure for yd_sign
-- ----------------------------
DROP TABLE IF EXISTS `yd_sign`;
CREATE TABLE `yd_sign` (
  `sign_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '签约id',
  `sign_desc` varchar(255) NOT NULL,
  `is_show` int(1) NOT NULL,
  PRIMARY KEY (`sign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_sign
-- ----------------------------
INSERT INTO `yd_sign` VALUES ('13', '宁波旭盛文具正式启用智赢天下ERP软件', '1');
INSERT INTO `yd_sign` VALUES ('14', '东莞宜同电子子正式启用智赢天下软件', '1');
INSERT INTO `yd_sign` VALUES ('15', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('16', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('17', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('18', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('19', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('20', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('21', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('22', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('23', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('24', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('25', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('26', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('27', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('28', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('29', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('30', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('31', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('32', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('33', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('34', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('35', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('36', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('37', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('38', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('39', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('40', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('41', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('42', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('43', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('44', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('45', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('46', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('47', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('48', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('49', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('50', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('51', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('52', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('53', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('54', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('55', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('56', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('57', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('58', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('59', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('60', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('61', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('62', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('63', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('64', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('65', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('66', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('67', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('68', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('69', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('70', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('71', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('72', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('73', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('74', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('75', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('76', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('77', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('78', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('79', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('80', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('81', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('82', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('83', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('84', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('87', 'mmm成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('88', '哪家公司成功签约易大', '1');
INSERT INTO `yd_sign` VALUES ('89', 'mmm成功签约易大哦', '0');
INSERT INTO `yd_sign` VALUES ('90', '哪家公司成功签约易大哦', '0');
INSERT INTO `yd_sign` VALUES ('91', '尺寸签约易大哦', '0');

-- ----------------------------
-- Table structure for yd_software
-- ----------------------------
DROP TABLE IF EXISTS `yd_software`;
CREATE TABLE `yd_software` (
  `soft_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'soft_id',
  `soft_name` varchar(255) NOT NULL COMMENT '软件名称',
  `soft_desc` text NOT NULL COMMENT '描述',
  `soft_img_to` varchar(255) NOT NULL,
  `soft_img` varchar(255) NOT NULL COMMENT '图片地址',
  `soft_apply` varchar(255) NOT NULL COMMENT '适用行业',
  `fun_img` varchar(255) NOT NULL COMMENT '功能流程图',
  `soft_cost` varchar(255) NOT NULL COMMENT '功能以及价值',
  `fun_list` text NOT NULL COMMENT '功能列表，多个功能用逗号隔开',
  `video_url` varchar(255) NOT NULL COMMENT '视频地址',
  `is_show` int(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `is_groom` int(1) NOT NULL DEFAULT '2' COMMENT '是否推荐',
  PRIMARY KEY (`soft_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_software
-- ----------------------------
INSERT INTO `yd_software` VALUES ('2', '智赢天下通用外贸A9', '&lt;p&gt;&lt;span style=&quot;font-size: 12px;&quot;&gt;◆针对出口产品多样化的专业外贸软件	&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 12px;&quot;&gt;◆贴身于杂货外贸的业务流程人性化，稳定性,可操作强&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '/static/upload/soft/20171208/3b31a754308f77ec8fc4d735eb0f730e.jpg', '/static/upload/soft/20171208/217992419600ab849684942fa22e4029.jpg', '杂货、机械、电子、五金、塑料制品，化工，日用品等进出口公司', '/static/upload/soft/20171208/75d72369c1e51178176af2b2e28b6e52.png', '/static/upload/soft/20171208/f0ab547e0e0361a1b073720f02f28bd7.png', '销售管理，销售出库，生产领料，采购管理，生产入库，采购入库，财务应收，利润 统计，财务应付，总经理', '<iframe height=498 width=510 src=\'http://player.youku.com/embed/XMzE1MTUzMTM3Mg==\' frameborder=0 \'allowfullscreen\'></iframe>', '1', '1');
INSERT INTO `yd_software` VALUES ('3', '智赢天下企业ERP E9', '国内批专业研究开发中小企业工贸一体化软件的软件公司,掌握ERP，MRP核心技术。.专门针对产品出口或内销，或既有出口又有内销的，生产一体化的中小制造企业量身定做的专业工贸软件,针对性强，业务流程非常贴身于工贸一体化业务生产流程，人性化，稳定性，可操作性强，且直接解决了当前工贸一体化公司管理上关心的问题，能有效的节省成本，提升公司管理水平。', '/static/upload/soft/20171208/97e6d828bcf5ab92e87d930b6d3d1a9d.jpg', '/static/upload/soft/20171208/a332883a2174d057d30964298b5d9979.jpg', '机械、电子、五金、塑料、化工、日用品等工贸一体的制造企业', '/static/upload/soft/20171208/fec92940ed036a37014f4d429f10a13b.png', '/static/upload/soft/20171208/1ae2523006887ddbcaee6bad0a7d963e.png', '出口管理，销售出库，生产领料，采购管理，生产入库，采购入库，财务应收，利润 统计，财务应付', '<iframe height=498 width=510 src=\'http://player.youku.com/embed/XMzE1MTUzMTM3Mg==\' frameborder=0 \'allowfullscreen\'></iframe>', '1', '1');
INSERT INTO `yd_software` VALUES ('4', '软件3', '软件3软件3软件3软件3软件3软件3软件3', '/static/upload/soft/20171208/677b2826d8aed604a9375b7bd6e08539.png', '/static/upload/soft/20171208/1aafd8a270795aa6fa474a0117b50c34.png', '生产行业', '/static/upload/soft/20171208/d26a35015c3a7f030c2c464b8ac50225.png', '/static/upload/soft/20171208/f581fc411b421eaa93acbf04815364fe.png', '销售管理，销售出库，生产领料，采购管理，生产入库，采购入库，财务应收，利润 统计，财务应付', '<iframe height=498 width=510 src=\'http://player.youku.com/embed/XMzE1MTUzMTM3Mg==\' frameborder=0 \'allowfullscreen\'></iframe>', '1', '1');
INSERT INTO `yd_software` VALUES ('5', '软件4', '软件4软件4软件4软件4软件4软件4', '/static/upload/soft/20171208/e717958b64dc68776b1a41ba944a4eef.png', '/static/upload/soft/20171208/e41d779b8982aa1c044ec39ae5bbb7b2.png', '软件4', '/static/upload/soft/20171208/c84a71d1a7d8c3e04c01e2c91a2e6df5.png', '/static/upload/soft/20171208/361bccce8e23f35669804508d16aff0f.png', '销售管理，销售出库，生产领料，采购管理，生产入库，采购入库，财务应收，利润 统计，财务应付', '<iframe height=498 width=510 src=\'http://player.youku.com/embed/XMzE1MTUzMTM3Mg==\' frameborder=0 \'allowfullscreen\'></iframe>', '1', '1');
INSERT INTO `yd_software` VALUES ('6', '软件5', '软件5软件5软件5', '/static/upload/soft/20171208/e101536f302df3bbea4510bf81bbc408.png', '/static/upload/soft/20171208/c10c80e9daf484ad12768bd0375979bd.png', '软件5软件5', '/static/upload/soft/20171208/bc7d5588d07af16938211c939f53e9ec.png', '/static/upload/soft/20171208/5f97968e18082b384b102575d3b587db.png', '销售管理，销售出库，生产领料，采购管理，生产入库，采购入库，财务应收，利润 统计，财务应付', '<iframe height=498 width=510 src=\'http://player.youku.com/embed/XMzE1MTUzMTM3Mg==\' frameborder=0 \'allowfullscreen\'></iframe>', '1', '1');
INSERT INTO `yd_software` VALUES ('7', '软件6', '软件6软件6软件6软件6软件6软件6软件6软件6软件6软件6软件6', '/static/upload/soft/20171208/cc0f4d562ffaefd93f5cf6ad20b37b2e.png', '/static/upload/soft/20171208/9d37e36cdb0fb9bb2b6a4760e9df5161.png', '软件6', '/static/upload/soft/20171208/98bacb0677aac9107facec4e388d2047.png', '/static/upload/soft/20171208/4ed31e88342c6c8508ba9223d8d55a75.png', '销售管理，销售出库，生产领料，采购管理，生产入库，采购入库，财务应收，利润 统计，财务应付', '<iframe height=498 width=510 src=\'http://player.youku.com/embed/XMzE1MTUzMTM3Mg==\' frameborder=0 \'allowfullscreen\'></iframe>', '1', '1');
INSERT INTO `yd_software` VALUES ('8', '软件7', '软件7软件7软件7软件7软件7软件7软件7', '/static/upload/soft/20171208/e81ce5dcdc48d060dd8dd287b5f5b7d4.png', '/static/upload/soft/20171208/4be18ad0b1b1d3cf255bd6091f2315f9.png', '软件7软件7软件7软件7', '/static/upload/soft/20171208/de06c40fdb5c81f543d0e0796ce60fe8.png', '/static/upload/soft/20171208/e2592d945bf0482600b074ce32537067.png', '销售管理，销售出库，生产领料，采购管理，生产入库，采购入库，财务应收，利润 统计，财务应付', '<iframe height=498 width=510 src=\'http://player.youku.com/embed/XMzE1MTUzMTM3Mg==\' frameborder=0 \'allowfullscreen\'></iframe>', '1', '1');
INSERT INTO `yd_software` VALUES ('10', '软件8', '软件8软件8软件8软件8软件8软件8', '/static/upload/soft/20171208/0037c9d3ed6f518d2eb918eb5e99f691.png', '/static/upload/soft/20171208/97b967ada769c66c357d55f28b76ef12.png', '软件8软件8软件8', '/static/upload/soft/20171208/38314c849af37fdeaaf47f198fdce8c5.png', '/static/upload/soft/20171208/beb7f38ce8adf32e01e4175c87f9436d.png', '销售管理，销售出库，生产领料，采购管理，生产入库，采购入库，财务应收，利润 统计，财务应付', '<iframe height=498 width=510 src=\'http://player.youku.com/embed/XMzIxMTIzMDg0MA==\' frameborder=0 \'allowfullscreen\'></iframe>', '1', '1');

-- ----------------------------
-- Table structure for yd_trade
-- ----------------------------
DROP TABLE IF EXISTS `yd_trade`;
CREATE TABLE `yd_trade` (
  `trade_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '行业id',
  `trade_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '行业名称',
  `pid` int(11) NOT NULL COMMENT '父级id',
  `sort` int(11) NOT NULL COMMENT '排序字段',
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  PRIMARY KEY (`trade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yd_trade
-- ----------------------------
INSERT INTO `yd_trade` VALUES ('1', '生产制造', '0', '4', '1');
INSERT INTO `yd_trade` VALUES ('2', '机电行业', '1', '41', '1');
INSERT INTO `yd_trade` VALUES ('3', '办公文具行业', '1', '46', '1');
INSERT INTO `yd_trade` VALUES ('4', '制造行业', '0', '21', '1');
INSERT INTO `yd_trade` VALUES ('6', '加工行业', '0', '5', '0');
INSERT INTO `yd_trade` VALUES ('7', '外贸出口', '0', '1', '0');
INSERT INTO `yd_trade` VALUES ('8', '服装 服饰 家纺 纺织工艺品', '0', '2', '0');
INSERT INTO `yd_trade` VALUES ('9', '国内贸易', '0', '3', '0');
INSERT INTO `yd_trade` VALUES ('10', '汽车零部件', '1', '42', '0');
INSERT INTO `yd_trade` VALUES ('11', '电子行业', '1', '43', '0');
INSERT INTO `yd_trade` VALUES ('12', '五金行业', '1', '44', '0');
INSERT INTO `yd_trade` VALUES ('13', '设备行业', '1', '45', '0');
INSERT INTO `yd_trade` VALUES ('14', '办公文具行业', '1', '47', '0');
INSERT INTO `yd_trade` VALUES ('15', '中大企业', '1', '48', '0');
INSERT INTO `yd_trade` VALUES ('17', '中小企业', '1', '50', '0');
INSERT INTO `yd_trade` VALUES ('18', '中小企业', '1', '2', '0');

-- ----------------------------
-- Table structure for yd_under_com
-- ----------------------------
DROP TABLE IF EXISTS `yd_under_com`;
CREATE TABLE `yd_under_com` (
  `under_com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '名下公司id',
  `com_name` varchar(255) NOT NULL COMMENT '名下公司名称',
  `com_desc` varchar(255) NOT NULL COMMENT 'com_desc',
  `com_img` varchar(255) NOT NULL,
  `com_content` text NOT NULL COMMENT '企业详情',
  `add_time` varchar(100) NOT NULL,
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  PRIMARY KEY (`under_com_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_under_com
-- ----------------------------
INSERT INTO `yd_under_com` VALUES ('1', '某某某某某木木木木木木木木', '某某某某某木木木木木木木木', '/static/upload/under/20171208/98c2e9d2059930796eb904e101acf5fd.png', '&lt;p&gt;某某某某某木木木木木木木木fdsfsssssssssssssss6546546&lt;/p&gt;', '1512555476', '1');
INSERT INTO `yd_under_com` VALUES ('3', '某某某某某木木木木木木木木', '某某某某某木木木木木木木木', '/static/upload/under/20171207/9b7b443c16252b56e35025cbd0e58ff2.jpg', '&lt;p&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木&lt;img src=&quot;/ueditor/php/upload/image/20171207/1512627012898903.jpg&quot; title=&quot;1512627012898903.jpg&quot; alt=&quot;2012-07-09 12.44.58.jpg&quot; width=&quot;683&quot; height=&quot;620&quot;/&gt;&lt;/span&gt;&lt;/p&gt;', '1512627109', '1');
INSERT INTO `yd_under_com` VALUES ('4', '某某某某某木木木木木木木木', '某某某某某木木木木木木木木', '/static/upload/under/20171208/456b1089777da310b53fd6d806fc63f3.png', '&lt;p&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;background-color: rgb(242, 242, 242); color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center;&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;span style=&quot;color: rgb(57, 57, 57); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: rgb(242, 242, 242);&quot;&gt;某某某某某木木木木木木木木&lt;/span&gt;&lt;img src=&quot;/ueditor/php/upload/image/20171207/1512627138340145.jpg&quot; title=&quot;1512627138340145.jpg&quot; alt=&quot;2012-08-14 14.10.39.jpg&quot;/&gt;&lt;/p&gt;', '1512627140', '1');

-- ----------------------------
-- Table structure for yd_visit
-- ----------------------------
DROP TABLE IF EXISTS `yd_visit`;
CREATE TABLE `yd_visit` (
  `v_id` int(11) NOT NULL,
  `v_count` int(11) NOT NULL,
  `is_visit` int(1) NOT NULL,
  `edit_time` varchar(100) NOT NULL COMMENT '更改时间',
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yd_visit
-- ----------------------------
INSERT INTO `yd_visit` VALUES ('1', '359', '1', '1512954015');
