/*
 Navicat Premium Data Transfer

 Source Server         : Local.DB
 Source Server Type    : MySQL
 Source Server Version : 100428
 Source Host           : localhost:3306
 Source Schema         : sportdb

 Target Server Type    : MySQL
 Target Server Version : 100428
 File Encoding         : 65001

 Date: 30/10/2025 20:28:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for booking
-- ----------------------------
DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `SportFieldID` int NOT NULL,
  `FieldNumber` int NOT NULL,
  `CustomerID` int NOT NULL,
  `CustomerName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CustomerPhone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CustomerEmail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `StartTime` tinyint NOT NULL,
  `EndTime` tinyint NOT NULL,
  `PaymentStatus` enum('PAID','UNPAID') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `BookingDate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `SportFieldID`(`SportFieldID` ASC) USING BTREE,
  INDEX `CustomerID`(`CustomerID` ASC) USING BTREE,
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`SportFieldID`) REFERENCES `sportfield` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of booking
-- ----------------------------
INSERT INTO `booking` VALUES (1, 3, 1, 6, 'Nguyễn Văn Customer', '0372337713', 'customer@gmail.com', 4, 1, 'PAID', '30/10/2025', '2025-10-29 20:05:29', '2025-10-30 20:27:07');

-- ----------------------------
-- Table structure for fieldowner
-- ----------------------------
DROP TABLE IF EXISTS `fieldowner`;
CREATE TABLE `fieldowner`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `OwnerID` int NOT NULL,
  `Status` tinyint NOT NULL,
  `BusinessName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `BusinessAddress` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PhoneNumber` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `OwnerID`(`OwnerID` ASC) USING BTREE,
  CONSTRAINT `fieldowner_ibfk_1` FOREIGN KEY (`OwnerID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of fieldowner
-- ----------------------------
INSERT INTO `fieldowner` VALUES (3, 8, 0, 'Owner Arena', '1358 Quang Trung/39 Đ. Quang TrungPhường 14, Gò Vấp, Thành phố Hồ Chí Minh', '0372337713', '2025-10-29 19:27:50', '2025-10-29 19:27:50');

-- ----------------------------
-- Table structure for fieldreview
-- ----------------------------
DROP TABLE IF EXISTS `fieldreview`;
CREATE TABLE `fieldreview`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `SportFieldID` int NOT NULL,
  `UserID` int NOT NULL,
  `Rating` tinyint NOT NULL,
  `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ImageReview` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `SportFieldID`(`SportFieldID` ASC) USING BTREE,
  INDEX `UserID`(`UserID` ASC) USING BTREE,
  CONSTRAINT `fieldreview_ibfk_1` FOREIGN KEY (`SportFieldID`) REFERENCES `sportfield` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fieldreview_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of fieldreview
-- ----------------------------
INSERT INTO `fieldreview` VALUES (2, 3, 6, 4, 'sân ổn giá ok', 'https://res.cloudinary.com/dnwemzbtm/image/upload/v1761743000/sport-court-rental-system/sport-field/image-review/lflwxfektpu8izoxugjk.jpg', '2025-10-29 20:03:24', '2025-10-29 20:03:24');
INSERT INTO `fieldreview` VALUES (3, 3, 6, 5, 'thêm ảnh của sân', 'https://res.cloudinary.com/dnwemzbtm/image/upload/v1761743094/sport-court-rental-system/sport-field/image-review/spwlwx88kjqnvzylupvv.jpg', '2025-10-29 20:04:55', '2025-10-29 20:04:55');

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BookingID` int NOT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `TotalAmount` double NULL DEFAULT NULL,
  `PaymentDate` datetime NULL DEFAULT NULL,
  `PaymentMethod` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `BookingID`(`BookingID` ASC) USING BTREE,
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of invoice
-- ----------------------------
INSERT INTO `invoice` VALUES (3, 1, '2025-10-30 20:27:07', '2025-10-30 20:27:07', 150000, NULL, 'in-person');

-- ----------------------------
-- Table structure for liked
-- ----------------------------
DROP TABLE IF EXISTS `liked`;
CREATE TABLE `liked`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `FieldReviewID` int NOT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `UserID`(`UserID` ASC) USING BTREE,
  INDEX `FieldReviewID`(`FieldReviewID` ASC) USING BTREE,
  CONSTRAINT `liked_ibfk_2` FOREIGN KEY (`FieldReviewID`) REFERENCES `fieldreview` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `liked_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of liked
-- ----------------------------
INSERT INTO `liked` VALUES (17, 8, 3, '2025-10-30 20:01:49', '2025-10-30 20:01:49');

-- ----------------------------
-- Table structure for notification
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `user_trigger_id` int NOT NULL,
  `user_receiver_id` int NOT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `action` enum('like','comment','follow','payment','booking','owner_register','lock','unlock') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint NULL DEFAULT 0,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `user_id`(`user_receiver_id` ASC) USING BTREE,
  CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_receiver_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of notification
-- ----------------------------
INSERT INTO `notification` VALUES (33, 8, 6, 'Đã thích bình luận của bạn', 'like', '2025-10-30 20:01:38', '2025-10-30 20:28:21', 1);

-- ----------------------------
-- Table structure for sportfield
-- ----------------------------
DROP TABLE IF EXISTS `sportfield`;
CREATE TABLE `sportfield`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `OwnerID` int NOT NULL,
  `SportTypeID` int NOT NULL,
  `FieldName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Status` tinyint NOT NULL,
  `PriceDay` decimal(10, 2) NOT NULL,
  `PriceEvening` decimal(10, 2) NOT NULL,
  `NumberOfFields` int NOT NULL,
  `FieldSize` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `OpeningTime` tinyint NOT NULL,
  `ClosingTime` tinyint NOT NULL,
  `Address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `Image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `OwnerID`(`OwnerID` ASC) USING BTREE,
  INDEX `SportTypeID`(`SportTypeID` ASC) USING BTREE,
  CONSTRAINT `sportfield_ibfk_2` FOREIGN KEY (`SportTypeID`) REFERENCES `sporttype` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sportfield_ibfk_3` FOREIGN KEY (`OwnerID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sportfield
-- ----------------------------
INSERT INTO `sportfield` VALUES (3, 8, 5, 'owner san so 1', 1, 150000.00, 250000.00, 2, '7', 4, 6, '12321323', '<h2 style=\"margin: 0px 0px 10px; padding: 0px; font-weight: 400; font-family: DauphinPlain; font-size: 24px; line-height: 24px; background-color: #ffffff;\">What is Lorem Ipsum?</h2>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\"><strong style=\"margin: 0px; padding: 0px;\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<img src=\"/sport-court-rental-system/app/utils/uploads/description-image/8/690210320869f_mini-futbol-sahasi-ozellikleri-ve-olculeri.jpg\" alt=\"mini-futbol-sahasi-ozellikleri-ve-olculeri.jpg\" width=\"880\" height=\"495\" /></p>', 'https://res.cloudinary.com/dnwemzbtm/image/upload/v1761742907/sport-court-rental-system/sport-field/representation/agv0fsxzjec9y8jee0at.jpg', NULL, '2025-10-29 20:01:49', '2025-10-29 20:01:49');

-- ----------------------------
-- Table structure for sporttype
-- ----------------------------
DROP TABLE IF EXISTS `sporttype`;
CREATE TABLE `sporttype`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TypeName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sporttype
-- ----------------------------
INSERT INTO `sporttype` VALUES (1, 'Bóng rổ', '2025-10-29 19:59:26', '2025-10-29 19:59:26');
INSERT INTO `sporttype` VALUES (2, 'Bóng chuyền', '2025-10-29 19:59:30', '2025-10-29 19:59:30');
INSERT INTO `sporttype` VALUES (3, 'Tennis', '2025-10-29 19:59:32', '2025-10-29 19:59:32');
INSERT INTO `sporttype` VALUES (4, 'Cầu lông', '2025-10-29 19:59:34', '2025-10-29 19:59:34');
INSERT INTO `sporttype` VALUES (5, 'Bóng đá', '2025-10-29 20:00:13', '2025-10-29 20:00:13');
INSERT INTO `sporttype` VALUES (6, 'golf', '2025-10-29 20:00:16', '2025-10-29 20:00:16');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Role` enum('CUSTOMER','SYSTEMADMIN','OWNER') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'CUSTOMER',
  `FullName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `PhoneNumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `quotes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `www` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (6, 'CUSTOMER', 'Nguyễn Văn Customer', 'customer@gmail.com', '$2y$10$0nRb7mSIK9f7FI5gnGfYQup21UNLHRvXQeWHptdi6u1Rh2vYcW2Ru', 'https://res.cloudinary.com/dnwemzbtm/image/upload/v1761743043/sport-court-rental-system/user-avatar/ejnctdsug5un31aq5bxs.jpg', NULL, 'Hòa Hiệp, Tân Biên, Tây Ninh', NULL, NULL, NULL, NULL, NULL, '2025-10-29 20:04:04', '2025-10-29 20:04:04');
INSERT INTO `users` VALUES (7, 'SYSTEMADMIN', 'Nguyễn Văn Admin', 'admin@gmail.com', '$2y$10$NAa1DUhvd7osj9X/8kJvpe1M.W3jM5yxnUBUpYFW.CKuG/e5hrMru', NULL, NULL, 'Hòa Hiệp, Tân Biên, Tây Ninh', NULL, NULL, NULL, NULL, NULL, '2025-10-29 19:06:34', '2025-10-29 19:06:34');
INSERT INTO `users` VALUES (8, 'OWNER', 'Nguyễn Văn Owner', 'owner@gmail.com', '$2y$10$DodcKk2KiN6OEo/bgEXcGu3Nm.YSu18yIQixZq29sDg2mmni0NiPy', NULL, NULL, 'Hòa Hiệp, Tân Biên, Tây Ninh', NULL, NULL, NULL, NULL, NULL, '2025-10-29 19:27:50', '2025-10-29 19:27:50');

SET FOREIGN_KEY_CHECKS = 1;
