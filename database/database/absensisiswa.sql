/*
 Navicat Premium Data Transfer

 Source Server         : AISServer
 Source Server Type    : MySQL
 Source Server Version : 100240
 Source Host           : localhost:3306
 Source Schema         : absensisiswa

 Target Server Type    : MySQL
 Target Server Version : 100240
 File Encoding         : 65001

 Date: 13/06/2024 15:27:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for absensi
-- ----------------------------
DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `jadwal_id` bigint(20) UNSIGNED NOT NULL,
  `TanggalAbsen` datetime(0) NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `absensi_jadwal_id_foreign`(`jadwal_id`) USING BTREE,
  INDEX `absensi_siswa_id_foreign`(`siswa_id`) USING BTREE,
  CONSTRAINT `absensi_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwalpelajaran` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `absensi_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of absensi
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for generatebarcodeabsensi
-- ----------------------------
DROP TABLE IF EXISTS `generatebarcodeabsensi`;
CREATE TABLE `generatebarcodeabsensi`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Tanggal` datetime(0) NOT NULL,
  `jadwal_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `generatebarcodeabsensi_jadwal_id_foreign`(`jadwal_id`) USING BTREE,
  CONSTRAINT `generatebarcodeabsensi_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwalpelajaran` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of generatebarcodeabsensi
-- ----------------------------

-- ----------------------------
-- Table structure for guru
-- ----------------------------
DROP TABLE IF EXISTS `guru`;
CREATE TABLE `guru`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NIK` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaGuru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TempatLahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `TanggalLahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mapel_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `guru_mapel_id_foreign`(`mapel_id`) USING BTREE,
  CONSTRAINT `guru_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `matapelajaran` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of guru
-- ----------------------------
INSERT INTO `guru` VALUES (1, '240402580179', 'MUSTIKA RATU', 'ratu@gmail.com', '08155525882', 'SURAKARTA', '2024-12-31', 1, '2024-06-11 06:21:02', '2024-06-11 06:21:02');
INSERT INTO `guru` VALUES (2, '10001', 'LALA', 'lala@gmail.com', '15145154', 'SURAKARTA', '2024-12-31', 2, '2024-06-11 08:47:36', '2024-06-11 08:47:36');
INSERT INTO `guru` VALUES (3, '10002', 'yeye', 'yeye@gmail.com', '1894856184', 'SURAKARTA', '2024-02-09', 3, '2024-06-11 08:48:07', '2024-06-11 08:48:07');
INSERT INTO `guru` VALUES (4, '10003', 'KAKA', 'kaka@gmail.com', '1489415984', 'SURAKARTA', '2024-12-31', 4, '2024-06-11 08:48:33', '2024-06-11 08:48:33');
INSERT INTO `guru` VALUES (5, '10005', 'mama', 'mama@gmail.com', '154984891984', 'SURAKARTA', '2024-12-31', 5, '2024-06-11 08:49:16', '2024-06-11 08:49:16');
INSERT INTO `guru` VALUES (6, '10006', 'jaja', 'jaja@gmail.com', '156165186', 'SURAKARTA', '2024-12-31', 6, '2024-06-11 08:49:54', '2024-06-11 08:49:54');

-- ----------------------------
-- Table structure for jadwalpelajaran
-- ----------------------------
DROP TABLE IF EXISTS `jadwalpelajaran`;
CREATE TABLE `jadwalpelajaran`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Hari` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `mapel_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jadwalpelajaran_jam_id_foreign`(`jam_id`) USING BTREE,
  INDEX `jadwalpelajaran_kelas_id_foreign`(`kelas_id`) USING BTREE,
  INDEX `jadwalpelajaran_guru_id_foreign`(`guru_id`) USING BTREE,
  INDEX `jadwalpelajaran_mapel_id_foreign`(`mapel_id`) USING BTREE,
  CONSTRAINT `jadwalpelajaran_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `jadwalpelajaran_jam_id_foreign` FOREIGN KEY (`jam_id`) REFERENCES `jampelajaran` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `jadwalpelajaran_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `jadwalpelajaran_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `matapelajaran` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jadwalpelajaran
-- ----------------------------
INSERT INTO `jadwalpelajaran` VALUES (1, 'Kamis', 1, 1, 1, 1, '2024-06-12 07:29:08', '2024-06-13 06:35:41');
INSERT INTO `jadwalpelajaran` VALUES (2, 'Kamis', 2, 1, 1, 1, '2024-06-12 07:30:35', '2024-06-13 06:35:48');
INSERT INTO `jadwalpelajaran` VALUES (3, 'Kamis', 3, 1, 2, 2, '2024-06-12 07:30:50', '2024-06-13 06:35:54');

-- ----------------------------
-- Table structure for jampelajaran
-- ----------------------------
DROP TABLE IF EXISTS `jampelajaran`;
CREATE TABLE `jampelajaran`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `JamMulai` time(0) NOT NULL,
  `JamSelesai` time(0) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jampelajaran
-- ----------------------------
INSERT INTO `jampelajaran` VALUES (1, 'Jam Ke 1', '07:00:00', '08:00:00', '2024-06-08 05:45:57', '2024-06-08 05:46:13');
INSERT INTO `jampelajaran` VALUES (2, NULL, '08:00:00', '09:30:00', '2024-06-11 08:21:11', '2024-06-11 08:21:11');
INSERT INTO `jampelajaran` VALUES (3, NULL, '09:30:00', '11:00:00', '2024-06-11 08:21:26', '2024-06-11 08:21:26');
INSERT INTO `jampelajaran` VALUES (4, NULL, '11:00:00', '12:00:00', '2024-06-11 08:21:38', '2024-06-11 08:21:48');
INSERT INTO `jampelajaran` VALUES (5, 'Istirahat', '12:00:00', '12:45:00', '2024-06-11 08:22:07', '2024-06-11 08:22:19');
INSERT INTO `jampelajaran` VALUES (6, NULL, '12:45:00', '13:30:00', '2024-06-11 08:24:00', '2024-06-11 08:24:00');
INSERT INTO `jampelajaran` VALUES (7, NULL, '13:30:00', '14:00:00', '2024-06-11 08:24:18', '2024-06-11 08:24:18');

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NamaKelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kelas
-- ----------------------------
INSERT INTO `kelas` VALUES (1, '7 A', '2024-06-11 06:30:40', '2024-06-11 06:30:40');
INSERT INTO `kelas` VALUES (2, '7 B', '2024-06-11 06:30:46', '2024-06-11 06:30:46');

-- ----------------------------
-- Table structure for matapelajaran
-- ----------------------------
DROP TABLE IF EXISTS `matapelajaran`;
CREATE TABLE `matapelajaran`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NamaMataPelajaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of matapelajaran
-- ----------------------------
INSERT INTO `matapelajaran` VALUES (1, 'MATEMATIKA DASAR', NULL, '2024-06-08 05:36:39', '2024-06-08 05:37:13');
INSERT INTO `matapelajaran` VALUES (2, 'ILMU PENGETAHUAN ALAM', NULL, '2024-06-11 08:25:17', '2024-06-11 08:25:17');
INSERT INTO `matapelajaran` VALUES (3, 'ILMU PENGETAHUAN SOSIAL', NULL, '2024-06-11 08:25:32', '2024-06-11 08:25:32');
INSERT INTO `matapelajaran` VALUES (4, 'BAHASA INGRIS', NULL, '2024-06-11 08:25:45', '2024-06-11 08:25:45');
INSERT INTO `matapelajaran` VALUES (5, 'BAHASA INDONESIA', NULL, '2024-06-11 08:46:52', '2024-06-11 08:46:52');
INSERT INTO `matapelajaran` VALUES (6, 'KESENIAN DAERAH', NULL, '2024-06-11 08:47:06', '2024-06-11 08:47:06');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 78 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (55, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (56, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (57, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (58, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (59, '2024_04_15_205847_permission', 1);
INSERT INTO `migrations` VALUES (60, '2024_04_15_205900_roles', 1);
INSERT INTO `migrations` VALUES (61, '2024_04_15_205913_permissionrole', 1);
INSERT INTO `migrations` VALUES (62, '2024_04_15_205925_userrole', 1);
INSERT INTO `migrations` VALUES (63, '2024_04_22_130950_user', 1);
INSERT INTO `migrations` VALUES (64, '2024_06_08_042634_ruangan', 2);
INSERT INTO `migrations` VALUES (65, '2024_06_08_042738_mata_pelajaran', 3);
INSERT INTO `migrations` VALUES (66, '2024_06_08_042841_jam_pelajaran', 4);
INSERT INTO `migrations` VALUES (67, '2024_06_08_042937_tahun_ajaran', 5);
INSERT INTO `migrations` VALUES (69, '2024_06_10_082937_guru', 6);
INSERT INTO `migrations` VALUES (70, '2024_06_11_062514_kelas', 7);
INSERT INTO `migrations` VALUES (71, '2024_06_10_091008_siswa', 8);
INSERT INTO `migrations` VALUES (75, '2024_06_11_065949_jadwal_pelajaran', 9);
INSERT INTO `migrations` VALUES (76, '2024_06_12_073212_absensi', 10);
INSERT INTO `migrations` VALUES (77, '2024_06_12_083030_generate_barcode_absensi', 11);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `PermissionName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Level` int(11) NOT NULL,
  `MenuInduk` int(11) NOT NULL,
  `SubMenu` int(11) NOT NULL,
  `Order` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1, 'Master', 'dashboard', 'fas fa-boxes', 1, 0, 1, 1, 1, NULL, NULL);
INSERT INTO `permission` VALUES (2, 'Ruangan', 'ruangan', '', 2, 1, 0, 2, 1, NULL, NULL);
INSERT INTO `permission` VALUES (3, 'Mata Pelajaran', 'matapelajaran', '', 2, 1, 0, 3, 1, NULL, NULL);
INSERT INTO `permission` VALUES (4, 'Jam Pelajaran', 'jampelajaran', '', 2, 1, 0, 4, 1, NULL, NULL);
INSERT INTO `permission` VALUES (5, 'Tahun Ajaran', 'tahunajaran', '', 2, 1, 0, 5, 1, NULL, NULL);
INSERT INTO `permission` VALUES (6, 'Guru', 'guru', 'fas fa-chalkboard-teacher', 1, 0, 0, 6, 1, NULL, NULL);
INSERT INTO `permission` VALUES (7, 'Siswa', 'siswa', 'fas fa-user-graduate', 1, 0, 0, 7, 1, NULL, NULL);
INSERT INTO `permission` VALUES (8, 'Absensi', 'absensi', 'fas fa-qrcode', 1, 0, 0, 8, 1, NULL, NULL);
INSERT INTO `permission` VALUES (9, 'User Management', 'dashboard', 'fas fa-users', 1, 0, 1, 9, 0, NULL, NULL);
INSERT INTO `permission` VALUES (10, 'Kelompok Akses', 'roles', '', 2, 1, 0, 10, 1, NULL, NULL);
INSERT INTO `permission` VALUES (11, 'Users', 'user', '', 2, 1, 0, 11, 1, NULL, NULL);
INSERT INTO `permission` VALUES (13, 'Kelas', 'kelas', '', 2, 1, 0, 12, 1, NULL, NULL);
INSERT INTO `permission` VALUES (14, 'Jadwal Pelajaran', 'jadwalpelajaran', 'fas fa-clock', 1, 0, 0, 12, 1, NULL, NULL);

-- ----------------------------
-- Table structure for permissionrole
-- ----------------------------
DROP TABLE IF EXISTS `permissionrole`;
CREATE TABLE `permissionrole`  (
  `roleid` int(11) NOT NULL,
  `permissionid` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissionrole
-- ----------------------------
INSERT INTO `permissionrole` VALUES (1, 1, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 2, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 3, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 4, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 5, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 6, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 7, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 8, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 10, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 11, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 13, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (1, 14, '2024-06-11 07:07:04', '2024-06-11 07:07:04');
INSERT INTO `permissionrole` VALUES (2, 1, '2024-06-13 08:26:02', '2024-06-13 08:26:02');
INSERT INTO `permissionrole` VALUES (2, 3, '2024-06-13 08:26:02', '2024-06-13 08:26:02');
INSERT INTO `permissionrole` VALUES (2, 8, '2024-06-13 08:26:02', '2024-06-13 08:26:02');
INSERT INTO `permissionrole` VALUES (2, 14, '2024-06-13 08:26:02', '2024-06-13 08:26:02');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Super Admin', NULL, NULL);
INSERT INTO `roles` VALUES (2, 'Guru', NULL, NULL);
INSERT INTO `roles` VALUES (3, 'Siswa', NULL, NULL);

-- ----------------------------
-- Table structure for ruangan
-- ----------------------------
DROP TABLE IF EXISTS `ruangan`;
CREATE TABLE `ruangan`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NamaRuangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ruangan
-- ----------------------------
INSERT INTO `ruangan` VALUES (1, 'KELAS 7A', '2024-06-08 04:56:27', '2024-06-08 04:59:23');

-- ----------------------------
-- Table structure for siswa
-- ----------------------------
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NIS` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaSiswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TahunAjaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TempatLahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalLahir` date NOT NULL,
  `Kelas_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `siswa_nis_unique`(`NIS`) USING BTREE,
  INDEX `siswa_kelas_id_foreign`(`Kelas_id`) USING BTREE,
  CONSTRAINT `siswa_kelas_id_foreign` FOREIGN KEY (`Kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siswa
-- ----------------------------
INSERT INTO `siswa` VALUES (1, '99999999', 'TEST SISWA 2', '1', 'testsiswa@gmail.com', '7158865848', 'SURAKARTA', '2024-12-31', 1, '2024-06-11 06:51:48', '2024-06-11 06:52:28');

-- ----------------------------
-- Table structure for tahunajaran
-- ----------------------------
DROP TABLE IF EXISTS `tahunajaran`;
CREATE TABLE `tahunajaran`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `TahunAjaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tahunajaran
-- ----------------------------
INSERT INTO `tahunajaran` VALUES (1, '2022-2023', '2024-06-08 05:53:43', '2024-06-08 05:53:55');

-- ----------------------------
-- Table structure for userrole
-- ----------------------------
DROP TABLE IF EXISTS `userrole`;
CREATE TABLE `userrole`  (
  `userid` int(11) NOT NULL,
  `roleid` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of userrole
-- ----------------------------
INSERT INTO `userrole` VALUES (1, 1, NULL, NULL);
INSERT INTO `userrole` VALUES (4, 2, '2024-06-11 06:21:02', '2024-06-11 06:21:02');
INSERT INTO `userrole` VALUES (6, 3, '2024-06-11 06:51:49', '2024-06-11 06:51:49');
INSERT INTO `userrole` VALUES (7, 2, '2024-06-11 08:47:36', '2024-06-11 08:47:36');
INSERT INTO `userrole` VALUES (8, 2, '2024-06-11 08:48:07', '2024-06-11 08:48:07');
INSERT INTO `userrole` VALUES (9, 2, '2024-06-11 08:48:33', '2024-06-11 08:48:33');
INSERT INTO `userrole` VALUES (10, 2, '2024-06-11 08:49:16', '2024-06-11 08:49:16');
INSERT INTO `userrole` VALUES (11, 2, '2024-06-11 08:49:54', '2024-06-11 08:49:54');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Active` enum('Y','N','S') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'AIS System', 'aissystemsolo@gmail.com', NULL, '$2y$12$G3dDINFo2cH5cn44inSk8u2Cyud3jHWT0ndzeW/Nta9Ox.HkZpCTa', 'Y', NULL, NULL, NULL);
INSERT INTO `users` VALUES (4, 'MUSTIKA RATU', 'ratu@gmail.com', NULL, '$2y$12$D8eEDvkSSmBdaRMpvjU8ROztVaKuqaZ0/jBCxLCX4KvxN8F50cf12', 'Y', NULL, NULL, NULL);
INSERT INTO `users` VALUES (6, 'TEST SISWA 2', 'testsiswa@gmail.com', NULL, '$2y$12$wi/H/marv3BIM4jau3l8U.e6zuMyNWRrsz78uAZMikhEruKMqlQwi', 'Y', NULL, NULL, NULL);
INSERT INTO `users` VALUES (7, 'LALA', 'lala@gmail.com', NULL, '$2y$12$eWZKRb2qvVJuT.5sTk9aEO5niQq4J2sWTw/8wNVlsDOYuNKlMB.Ma', 'Y', NULL, NULL, NULL);
INSERT INTO `users` VALUES (8, 'yeye', 'yeye@gmail.com', NULL, '$2y$12$108dq6bzU9EJg46VstNr1ui5ytsOtylCAz17rCBqr06OA8B2EWe.S', 'Y', NULL, NULL, NULL);
INSERT INTO `users` VALUES (9, 'KAKA', 'kaka@gmail.com', NULL, '$2y$12$Ckv2ju9er38jdqa/25fPw.aVZuXMwRrG2yEOXHh157w1AenR7BWZO', 'Y', NULL, NULL, NULL);
INSERT INTO `users` VALUES (10, 'mama', 'mama@gmail.com', NULL, '$2y$12$DsPqxJ5XPiNxpqvq.619i.KAgDMoWRYXdySOYWeNwM7fFMV5wuULm', 'Y', NULL, NULL, NULL);
INSERT INTO `users` VALUES (11, 'jaja', 'jaja@gmail.com', NULL, '$2y$12$vSWoqVq0eXaJ2aBQrlYojuplFNZBXDjD1VGgWSRr04fW3xp6pYoC6', 'Y', NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
