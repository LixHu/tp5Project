/*
Navicat MySQL Data Transfer

Source Server         : glax
Source Server Version : 50555
Source Host           : 61.152.175.76:3306
Source Database       : jaaa

Target Server Type    : MYSQL
Target Server Version : 50555
File Encoding         : 65001

Date: 2017-12-21 08:50:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yw_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `yw_admin_menu`;
CREATE TABLE `yw_admin_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '菜单名称',
  `menu_url` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `menu_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '菜单图',
  `pid` int(11) NOT NULL,
  `is_show` int(1) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yw_admin_menu
-- ----------------------------
INSERT INTO `yw_admin_menu` VALUES ('1', '后台管理', '', '&#xe646;', '0', '1');
INSERT INTO `yw_admin_menu` VALUES ('2', '管理员管理', '/admin/admin/admin_list', '&#xe689;', '1', '1');
INSERT INTO `yw_admin_menu` VALUES ('3', '站点配置信息', '', '&#xe653;', '0', '1');
INSERT INTO `yw_admin_menu` VALUES ('4', '权限管理', '/admin/role/role_list', '&#xe646;', '1', '1');
INSERT INTO `yw_admin_menu` VALUES ('5', 'Banner管理', '', '&#xe60b;', '0', '1');
INSERT INTO `yw_admin_menu` VALUES ('6', '广告位置', '/admin/banner/banner_pos', '&#xe606;', '5', '0');
INSERT INTO `yw_admin_menu` VALUES ('7', 'Banner列表', '/admin/banner/banner_list', '&#xe61a;', '5', '1');
INSERT INTO `yw_admin_menu` VALUES ('8', '产品管理', '', '&#xe61a;', '0', '1');
INSERT INTO `yw_admin_menu` VALUES ('9', '产品列表', '/admin/products/pro_list', '&#xe61a;', '8', '1');
INSERT INTO `yw_admin_menu` VALUES ('10', '产品分类', '/admin/products/category', '&#xe635;', '8', '1');
INSERT INTO `yw_admin_menu` VALUES ('11', '首页管理', '', '&#xe622;', '0', '1');
INSERT INTO `yw_admin_menu` VALUES ('12', '首页右侧信息', '/admin/shops/shop_list', '&#xe61a;', '11', '1');
INSERT INTO `yw_admin_menu` VALUES ('13', '文章管理', '', '&#xe64a;', '0', '1');
INSERT INTO `yw_admin_menu` VALUES ('14', '联系我们', '', '&#xe63d;', '0', '1');
INSERT INTO `yw_admin_menu` VALUES ('17', '文章列表', '/admin/admin/event', '&#xe64a;', '13', '1');
INSERT INTO `yw_admin_menu` VALUES ('16', '站点配置', '/admin/admin/setwebconf', '&#xe653;', '3', '1');
INSERT INTO `yw_admin_menu` VALUES ('18', '邮箱', '/admin/admin/email', '&#xe63d;', '14', '1');
INSERT INTO `yw_admin_menu` VALUES ('15', '联系我们', '/admin/admin/message', '&#xe63d;', '14', '1');
INSERT INTO `yw_admin_menu` VALUES ('19', '关于我们图片', '/admin/admin/edit_about', '&#xe653;', '3', '1');

-- ----------------------------
-- Table structure for yw_admins
-- ----------------------------
DROP TABLE IF EXISTS `yw_admins`;
CREATE TABLE `yw_admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `role_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '角色id',
  `header_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '头像',
  `login_time` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yw_admins
-- ----------------------------
INSERT INTO `yw_admins` VALUES ('1', 'admin', 'c56d0e9a7ccec67b4ea131655038d604', '1234567', '123#cc.ccc', '1', '/static/upload/admin/20171216\\dcf3e3e8ba2f40a5a802aef4e8d7eb18.png', '1513817208');

-- ----------------------------
-- Table structure for yw_banner
-- ----------------------------
DROP TABLE IF EXISTS `yw_banner`;
CREATE TABLE `yw_banner` (
  `bn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `bn_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '广告名称',
  `bn_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `bn_pos` varchar(255) COLLATE utf8_bin NOT NULL,
  `is_show` int(1) NOT NULL COMMENT '是否显示',
  `add_time` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`bn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yw_banner
-- ----------------------------
INSERT INTO `yw_banner` VALUES ('23', '1', '/static/uploads/banner/20171213/f1fc1b3a3f9201c00504a122b9d5221e.png', '1', '1', '1513132857');
INSERT INTO `yw_banner` VALUES ('27', '3', '/static/uploads/banner/20171218/82695ccfda0cdc3625b318822b1e07dc.jpg', '1', '1', '1513574815');
INSERT INTO `yw_banner` VALUES ('26', '2', '/static/uploads/banner/20171218/0cdd6fe924db198c8353739a57d37eb8.jpg', '1', '1', '1513416001');

-- ----------------------------
-- Table structure for yw_banner_pos
-- ----------------------------
DROP TABLE IF EXISTS `yw_banner_pos`;
CREATE TABLE `yw_banner_pos` (
  `pos_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '位置id',
  `pos_name` varchar(255) NOT NULL COMMENT '位置名称',
  `pos_desc` varchar(255) NOT NULL COMMENT '描述',
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_banner_pos
-- ----------------------------
INSERT INTO `yw_banner_pos` VALUES ('1', '首页', '首页banner');

-- ----------------------------
-- Table structure for yw_category
-- ----------------------------
DROP TABLE IF EXISTS `yw_category`;
CREATE TABLE `yw_category` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) NOT NULL COMMENT '类别名称',
  `pid` int(11) NOT NULL COMMENT '父级id',
  `cimg` varchar(255) NOT NULL,
  `cdesc` varchar(255) NOT NULL,
  `is_groom` int(1) NOT NULL,
  `is_btn1` int(1) NOT NULL DEFAULT '2' COMMENT '是否为产品分类第一个按钮',
  `is_btn2` int(1) NOT NULL,
  `is_btn3` int(1) NOT NULL,
  `is_btn4` int(1) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_category
-- ----------------------------
INSERT INTO `yw_category` VALUES ('1', 'Bed Sheet', '0', '/static/upload/product/20171214\\d796c62ff8706e6bc104254119853e42.png', 'Style your space with our new contemporary collection full of rich textures and modern prints.', '1', '1', '2', '2', '2');
INSERT INTO `yw_category` VALUES ('2', 'Quilt', '0', '/static/upload/product/20171221/ec3d723b0a4497e944bcd14a88721f49.jpg', 'Style your space with our new contemporary collection full of rich textures and modern prints.', '1', '2', '2', '1', '2');
INSERT INTO `yw_category` VALUES ('3', 'Blanket', '0', '/static/upload/product/20171221/a5fd461b382a661d80bc56a6d8bdbcc7.jpg', 'Style your space with our new contemporary collection full of rich textures and modern prints. SHOP INDUSTRIAL >', '1', '2', '1', '2', '2');
INSERT INTO `yw_category` VALUES ('4', 'Bathrode', '0', '/static/upload/product/20171221/ea5f7333ce319ccc0923e4927777dec3.jpg', 'Style your space with our new contemporary collection full of rich textures and modern prints.', '1', '2', '2', '2', '1');
INSERT INTO `yw_category` VALUES ('5', 'Blanket1', '3', '/static/upload/product/20171218\\9fdc1b93f7b9025a41627ad876cd772a.jpg', 'Blanket1', '2', '2', '1', '2', '2');
INSERT INTO `yw_category` VALUES ('6', 'Blanket2', '3', '/static/upload/product/20171218\\f66a7aa07c30eeb7dbf7e5d7c5b62f59.jpg', 'Blanket2', '2', '2', '1', '2', '2');
INSERT INTO `yw_category` VALUES ('7', 'Bathrode2', '4', '/static/upload/product/20171218\\c9869c09dacf79efe61ba593334ab5c0.jpg', 'Bathrode2Bathrode2Bathrode2', '2', '2', '2', '2', '1');
INSERT INTO `yw_category` VALUES ('8', 'Bathrode3', '4', '/static/upload/product/20171218\\65fc03e3a6e7c451412380c137902f3a.jpg', 'Bathrode3Bathrode3', '2', '2', '2', '2', '1');

-- ----------------------------
-- Table structure for yw_company
-- ----------------------------
DROP TABLE IF EXISTS `yw_company`;
CREATE TABLE `yw_company` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '网站标题',
  `com_name` varchar(255) NOT NULL COMMENT '公司名称',
  `logo` varchar(255) NOT NULL COMMENT 'logo',
  `com_img` varchar(255) NOT NULL COMMENT '公司图片',
  `com_phone` varchar(255) NOT NULL COMMENT '公司电话',
  `com_email` varchar(255) NOT NULL COMMENT '邮箱',
  `sale_phone` varchar(255) NOT NULL COMMENT '销售热线',
  `keywo` varchar(255) NOT NULL COMMENT '客服热线',
  `free_server_phone` varchar(255) NOT NULL COMMENT '全国免费服务热线',
  `control_phone` varchar(255) NOT NULL COMMENT '监督热线',
  `free` varchar(255) NOT NULL COMMENT '备案信息',
  `summary` text NOT NULL COMMENT '简介',
  `qrcode` varchar(255) NOT NULL COMMENT '二维码',
  `address` varchar(255) NOT NULL,
  `update_time` varchar(100) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_company
-- ----------------------------
INSERT INTO `yw_company` VALUES ('1', 'Glax', '1', '/static/upload/company/20171213\\084a8cc9007f0f3b951078fd44fb612f.png', '/static/upload/company/20171219/7d658627a997719176cfe95bbc89297d.png', '0086-25-84618472', 'info@glaxtex.com', '0086-25-84618472', 'Glax;Glax;Glax', '1', '1', '1', '&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 0px; list-style: none; color: rgb(153, 153, 153); font-size: 15px; font-family: REFSAN; line-height: 26px; text-indent: 2em; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;GLAX, located in Nanjing city as capital of Jiangsu Province of China and one and half hours to Shanghai by high-speed train. From 2003 we have worked in Home Textiles Industry for 14 years. As professional producer / exporter of high quality item, blankets, throw, bed sheet set, and soft home goods to wholesaler and top retailers customers as Shopping Mall and supermarket around the world.&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 0px; list-style: none; color: rgb(153, 153, 153); font-size: 15px; font-family: REFSAN; line-height: 26px; text-indent: 2em; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;Our advantage is prefessional, from fabric to made products. All products process are well controlled.&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 0px; list-style: none; color: rgb(153, 153, 153); font-size: 15px; font-family: REFSAN; line-height: 26px; text-indent: 2em; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;Products expanded over time, from blanket adding bed sheet set, quilt, bath robe for adult and kids. All along the wya, we created new, innovative, styles, designs for customers.&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 0px; list-style: none; color: rgb(153, 153, 153); font-size: 15px; font-family: REFSAN; line-height: 26px; text-indent: 2em; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;We bring good quality and reasonable cost to customers all the world. We&amp;#39;re pround of our professional Trading Team, Design Team and QC Team, for developing new item, controlling fabric production quality, excelletn sewing quality.&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 0px; list-style: none; color: rgb(153, 153, 153); font-size: 15px; font-family: REFSAN; line-height: 26px; text-indent: 2em; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;On behalf of all staff, we do sincerely and warmly welcome you, our honored customers to come to our company and visit our production base. We will be await for you and available at your service.&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '1', 'Glax Textiles Limited  15th Floor, New Century Plaza,  1st South Taiping Road, Nanjing,  210001 China', '1513678214');

-- ----------------------------
-- Table structure for yw_contact
-- ----------------------------
DROP TABLE IF EXISTS `yw_contact`;
CREATE TABLE `yw_contact` (
  `cont_id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '名字',
  `email` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `company` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '公司名',
  `tel` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '联系方式',
  `message` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '留言',
  `add_time` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`cont_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of yw_contact
-- ----------------------------
INSERT INTO `yw_contact` VALUES ('7', '134214', '423@ca.csd', 'fds', 'fdsfs', 'f', '1513323164');
INSERT INTO `yw_contact` VALUES ('5', '发顺丰', 'fdsa@cc.ccfd', 'fds', 'fds', '0', '1513320898');
INSERT INTO `yw_contact` VALUES ('6', 'fdsaf', 'dfs@cc.cc', 'fds', 'fds', '0', '1513320915');
INSERT INTO `yw_contact` VALUES ('8', 'fdsa', 'fdsa@cc.cc', 'fdsa', 'fds', '<script>alert(1);</script>', '1513323289');
INSERT INTO `yw_contact` VALUES ('9', 'fdas', 'fdsaf@qq.com', 'asfas', '32131321', 'fasfas', '1513323388');

-- ----------------------------
-- Table structure for yw_email
-- ----------------------------
DROP TABLE IF EXISTS `yw_email`;
CREATE TABLE `yw_email` (
  `eid` int(11) NOT NULL AUTO_INCREMENT COMMENT '提交的邮箱',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `add_time` varchar(100) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_email
-- ----------------------------
INSERT INTO `yw_email` VALUES ('15', 'fdsa@cc.cc', '1513577585');
INSERT INTO `yw_email` VALUES ('16', 'fdsa@cc.cc', '1513577877');

-- ----------------------------
-- Table structure for yw_event
-- ----------------------------
DROP TABLE IF EXISTS `yw_event`;
CREATE TABLE `yw_event` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `etitle` varchar(255) NOT NULL COMMENT '事件标题',
  `edesc` varchar(255) NOT NULL COMMENT '事件描述',
  `eimg` varchar(255) NOT NULL COMMENT '时间图片',
  `is_show` int(1) NOT NULL,
  `etime` varchar(100) NOT NULL COMMENT '事件时间',
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_event
-- ----------------------------
INSERT INTO `yw_event` VALUES ('1', 'We will attend the 21st China International Pet Show(CIPS) in Shanghai                         Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai', 'Glax Toy Co.,Ltd will attend the 21st China International Pet\r\n                        Show(CIPS) in Shanghai from November\r\n                        16th Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai', '/static/upload/event/20171220/072a8c745ea7efa21bf5e91a028ce54a.jpg', '1', '1513180800');
INSERT INTO `yw_event` VALUES ('2', 'We will attend the 21st China International Pet Show(CIPS) in Shanghai                         Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai', 'Glax Toy Co.,Ltd will attend the 21st China International Pet\r\n                        Show(CIPS) in Shanghai from November\r\n                        16th Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai Shanghai', '/static/upload/event/20171214\\68b15e853c0f724842892d2873fe5f47.png', '1', '1513180800');

-- ----------------------------
-- Table structure for yw_product
-- ----------------------------
DROP TABLE IF EXISTS `yw_product`;
CREATE TABLE `yw_product` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_title` varchar(255) NOT NULL COMMENT '产品标题',
  `p_img` varchar(255) NOT NULL COMMENT '产品图片',
  `p_desc` varchar(255) NOT NULL COMMENT '产品描述',
  `is_groom` int(1) NOT NULL COMMENT '是否推荐',
  `is_ab_us` int(1) NOT NULL COMMENT '是否关于我们页面展示',
  `cid` int(11) NOT NULL COMMENT '是否首页展示',
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_product
-- ----------------------------
INSERT INTO `yw_product` VALUES ('1', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171221/53776678a50456220744ec33aa0ce91c.jpg', '<p>VelvetLoft Basketweave Blanket</p>', '1', '2', '1');
INSERT INTO `yw_product` VALUES ('2', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171221/c8a0fc46bf14a28e697cbdfbc9294d90.jpg', '<p>VelvetLoft Basketweave Blanket</p>', '1', '2', '1');
INSERT INTO `yw_product` VALUES ('5', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/c9c7e1425bc09bd76b8e0b1f752ad146.jpg', '<p><span style=\"color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;PingFang SC&quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; background-color: rgb(248, 248, 248);\">VelvetLoft Basketweave Blanket</span></p>', '2', '2', '5');
INSERT INTO `yw_product` VALUES ('6', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/1a338c95a29247916c89dcb40c44d072.png', '<p>VelvetLoft Basketweave Blanket</p>', '2', '2', '3');
INSERT INTO `yw_product` VALUES ('14', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/4fd53a940804155d27f3a5278740d2d6.jpg', '<p>VelvetLoft Basketweave Blanket</p>', '2', '1', '1');
INSERT INTO `yw_product` VALUES ('16', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/14eb7f4f07227fee64b5db40eed1ff4e.jpg', '<p>VelvetLoft Basketweave Blanket</p>', '2', '1', '1');
INSERT INTO `yw_product` VALUES ('174', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/d79907548f1832d82e6fbb9548c8355f.jpg', '<p>VelvetLoft Basketweave Blanket</p>', '2', '1', '1');
INSERT INTO `yw_product` VALUES ('177', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/c46bc6a98861ae1089189a72a9387dcc.jpg', '<p><span style=\"color: rgb(102, 102, 102); font-family: \">VelvetLoft Basketweave Blanket</span></p>', '2', '2', '1');
INSERT INTO `yw_product` VALUES ('180', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171221/ee66b7d7d52f33f93eb9514b30a3430d.jpg', '<p><span style=\"color: rgb(102, 102, 102); font-family: \">VelvetLoft Basketweave Blanket</span></p>', '1', '2', '1');
INSERT INTO `yw_product` VALUES ('182', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171221/44870ef1b231f105c692da968555af11.jpg', '<p><span style=\"color: rgb(102, 102, 102); font-family: \">VelvetLoft Basketweave Blanket</span></p>', '1', '2', '1');
INSERT INTO `yw_product` VALUES ('183', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/05a99f0c47445eab57bd6c479026d623.png', '<p><span style=\"color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;PingFang SC&quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; background-color: rgb(248, 248, 248);\">VelvetLoft Basketweave Blanket</span></p>', '1', '2', '1');
INSERT INTO `yw_product` VALUES ('186', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/9a6ee0f335019c413b9ca753597ab213.jpg', '<p><span style=\"color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;PingFang SC&quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; background-color: rgb(248, 248, 248);\">VelvetLoft Basketweave Blanket</span></p>', '2', '2', '2');
INSERT INTO `yw_product` VALUES ('187', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/c9c7e1425bc09bd76b8e0b1f752ad146.jpg', '<p><span style=\"color: rgb(102, 102, 102); font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;PingFang SC&quot;, 微软雅黑, Tahoma, Arial, sans-serif; font-size: 14px; background-color: rgb(248, 248, 248);\">VelvetLoft Basketweave Blanket</span></p>', '2', '2', '4');
INSERT INTO `yw_product` VALUES ('188', 'VelvetLoft Basketweave Blanket', '/static/upload/product/20171220/8c4ba60a03be8cbfd83fda9a3f513a55.png', '<p>VelvetLoft Basketweave Blanket</p>', '2', '2', '5');

-- ----------------------------
-- Table structure for yw_real
-- ----------------------------
DROP TABLE IF EXISTS `yw_real`;
CREATE TABLE `yw_real` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(255) NOT NULL COMMENT '图片地址',
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_real
-- ----------------------------
INSERT INTO `yw_real` VALUES ('24', '/static/upload/company/20171220162120_92583.jpeg');
INSERT INTO `yw_real` VALUES ('25', '/static/upload/company/20171220162120_61855.jpeg');
INSERT INTO `yw_real` VALUES ('26', '/static/upload/company/20171220162120_73330.png');
INSERT INTO `yw_real` VALUES ('27', '/static/upload/company/20171220162120_93914.png');
INSERT INTO `yw_real` VALUES ('28', '/static/upload/company/20171220162120_28927.png');

-- ----------------------------
-- Table structure for yw_role
-- ----------------------------
DROP TABLE IF EXISTS `yw_role`;
CREATE TABLE `yw_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(255) NOT NULL COMMENT '角色名称',
  `role_desc` varchar(255) NOT NULL,
  `is_show` int(1) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_role
-- ----------------------------
INSERT INTO `yw_role` VALUES ('1', '超级管理员', '至高无上的权利', '1');

-- ----------------------------
-- Table structure for yw_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `yw_role_menu`;
CREATE TABLE `yw_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_role_menu
-- ----------------------------
INSERT INTO `yw_role_menu` VALUES ('1', '1');
INSERT INTO `yw_role_menu` VALUES ('1', '2');
INSERT INTO `yw_role_menu` VALUES ('1', '4');
INSERT INTO `yw_role_menu` VALUES ('1', '3');
INSERT INTO `yw_role_menu` VALUES ('1', '16');
INSERT INTO `yw_role_menu` VALUES ('1', '19');
INSERT INTO `yw_role_menu` VALUES ('1', '5');
INSERT INTO `yw_role_menu` VALUES ('1', '7');
INSERT INTO `yw_role_menu` VALUES ('1', '8');
INSERT INTO `yw_role_menu` VALUES ('1', '9');
INSERT INTO `yw_role_menu` VALUES ('1', '10');
INSERT INTO `yw_role_menu` VALUES ('1', '11');
INSERT INTO `yw_role_menu` VALUES ('1', '12');
INSERT INTO `yw_role_menu` VALUES ('1', '13');
INSERT INTO `yw_role_menu` VALUES ('1', '17');
INSERT INTO `yw_role_menu` VALUES ('1', '14');
INSERT INTO `yw_role_menu` VALUES ('1', '18');
INSERT INTO `yw_role_menu` VALUES ('1', '15');

-- ----------------------------
-- Table structure for yw_shop
-- ----------------------------
DROP TABLE IF EXISTS `yw_shop`;
CREATE TABLE `yw_shop` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `stitle` varchar(255) NOT NULL COMMENT '店铺标题',
  `sdesc` varchar(255) NOT NULL COMMENT '店铺描述',
  `simg` varchar(255) NOT NULL COMMENT '店铺图片',
  `is_groom` int(1) NOT NULL COMMENT '是否推荐',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_shop
-- ----------------------------
INSERT INTO `yw_shop` VALUES ('1', 'Extra-Fluffy', 'Extra-Fluffy is our fluffiest, most beloved blankets, pillows, and throwsfabric--it\'s like cuddling with a big teddy bear.', '/static/upload/shop/20171220/93e7732ed3ac2e9418711d362a7973b5.jpg', '1');
INSERT INTO `yw_shop` VALUES ('2', 'Fluffy-Extra', 'Extra-Fluffy is our fluffiest, most beloved blankets, pillows, and throwsfabric--it\'s like cuddling with a big teddy bear', '/static/upload/shop/20171220/fedd0d7da9b8933d1a885118bc7baf5a.png', '1');

-- ----------------------------
-- Table structure for yw_visit
-- ----------------------------
DROP TABLE IF EXISTS `yw_visit`;
CREATE TABLE `yw_visit` (
  `v_id` int(11) NOT NULL,
  `v_count` int(11) NOT NULL,
  `is_visit` int(1) NOT NULL,
  `edit_time` varchar(100) NOT NULL COMMENT '更改时间',
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yw_visit
-- ----------------------------
INSERT INTO `yw_visit` VALUES ('1', '47', '1', '1513009916');
