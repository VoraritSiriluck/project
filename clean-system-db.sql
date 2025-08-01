/*
 Navicat Premium Dump SQL

 Source Server         : cleaningsystem
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : clean-system-db

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 31/07/2025 13:20:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activity_log
-- ----------------------------
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log`  (
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `action` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`timestamp`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of activity_log
-- ----------------------------

-- ----------------------------
-- Table structure for clean_report
-- ----------------------------
DROP TABLE IF EXISTS `clean_report`;
CREATE TABLE `clean_report`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `reporter_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `reporter_fullname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `position` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `report_date` date NOT NULL,
  `room` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cleaner` enum('นางสาววาสนา มุสิกรัตน์','นางสาวอินทุอร รัตนบุญโณ','คนอื่น') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` enum('waiting','in_progress','done','cancel') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cancel_reason` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `fiscal_year` tinyint NOT NULL,
  `number` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clean_report
-- ----------------------------

-- ----------------------------
-- Table structure for room
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of room
-- ----------------------------
INSERT INTO `room` VALUES (0, 'อื่นๆ');
INSERT INTO `room` VALUES (1, 'ห้องประชุม');
INSERT INTO `room` VALUES (2, 'ห้องน้ำ');
INSERT INTO `room` VALUES (8, 'ห้องช่าง');
INSERT INTO `room` VALUES (9, 'ห้องพักนักวิทย์');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '$2y$10$fxGYpkvpdUcfbUf2Vqni3emy7NZdutrhBBLDVXj46TefHsKigwv6C');

SET FOREIGN_KEY_CHECKS = 1;
