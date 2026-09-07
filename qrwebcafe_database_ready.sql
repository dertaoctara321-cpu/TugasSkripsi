-- ========================================================
-- QR Web Cafe Database Export for InfinityFree / Hosting
-- Generated on 2026-09-07 15:39:28
-- ========================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Table structure for table `cache`
--
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `cache_locks`
--
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `failed_jobs`
--
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `job_batches`
--
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `jobs`
--
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `menus`
--
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '20',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `menus`
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('1', 'Indomie PAKAM', 'Indomie kuah/goreng spesial racikan bumbu khas Pakam dengan topping telur dan bumbu gurih mantap.', '20000.00', '4', 'Indomie Pakam.jpeg', 'Makanan', 'Menu PAKAM', '1', '2026-08-24 18:40:10', '2026-09-06 18:43:17');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('2', 'Nasi PAKAM', 'Nasi gurih harum spesial Pakam disajikan dengan lauk istimewa dan sambal sedap.', '25000.00', '4', 'Nasi Pakam.jpeg', 'Makanan', 'Menu PAKAM', '1', '2026-08-24 18:40:10', '2026-09-06 18:43:17');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('3', 'Bakso PAKAM', 'Bakso sapi kenyal gurih dengan kuah kaldu sapi kaya rempah khas resep Pakam.', '25000.00', '20', 'Bakso Pakam.jpeg', 'Makanan', 'Menu PAKAM', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('4', 'Mie Yamin Bandung', 'Mie yamin manis gurih kenyal khas Bandung disajikan dengan topping ayam cincang dan kuah kaldu.', '20000.00', '20', 'Mie Bandung Yamin.jpeg', 'Makanan', 'Menu Sarapan', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('5', 'Bubur Ayam Kuah Kuning', 'Bubur ayam lembut hangat dengan siraman kuah kuning gurih, suwiran ayam, cakwe, dan kerupuk.', '20000.00', '20', 'Bubur Ayam Kuah Kuning.jpeg', 'Makanan', 'Menu Sarapan', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('6', 'Sate Maranggi', 'Sate daging sapi empuk bakar dengan bumbu rempah maranggi meresap manis gurih disajikan dengan sambal tomat.', '35000.00', '20', 'Sate Maranggi.jpeg', 'Makanan', 'Menu Sarapan', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('7', 'Nasi Uduk Jakarta', 'Nasi uduk harum santan beraroma pandan dan serai, komplit dengan lauk gurih dan sambal khas.', '20000.00', '20', 'Nasi Uduk Jakarta.jpeg', 'Makanan', 'Menu Sarapan', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('8', 'Ikan Nila Goreng Sambal Matah', 'Ikan nila goreng renyah garing disiram sambal matah segar pedas beraroma serai dan jeruk limau.', '35000.00', '20', 'Ikan Nila Goreng Sambal Matah.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('9', 'Nasi Ayam Jodoh', 'Nasi ayam spesial racikan bumbu rahasia jodoh khas Little Palembang yang menggoda selera.', '35000.00', '20', 'Nasi Ayam Jodoh.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('10', 'Nasi Ayam Kungpao', 'Potongan ayam empuk ditumis dengan saus kungpao oriental manis pedas dan taburan kacang garing.', '28000.00', '20', 'Nasi Ayam Kungpao.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('11', 'Nasi Ayam Little Palembang', 'Menu signature ayam berbumbu khas Little Palembang disajikan dengan nasi hangat dan lalapan.', '28000.00', '20', 'Nasi Ayam Little Palembang.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('12', 'Nasi Ayam Telur Asin', 'Ayam goreng renyah berbalut lumuran saus telur asin (salted egg) gurih creamy wangi daun kari.', '28000.00', '20', 'Nasi Ayam Telur Asin.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('13', 'Nasi Ayam Pedas Manis', 'Ayam goreng crispy dibalut saus pedas manis karamel yang lezat menggigit.', '28000.00', '20', 'Nasi Ayam Pedas Manis.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('14', 'Udang Singgang Asam Manis Pedas', 'Udang singgang segar dimasak dalam bumbu kuah asam manis pedas khas pesisir yang harum nikmat.', '35000.00', '20', 'Udang Singgang.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('15', 'Nasi Tongseng Daging Sapi', 'Tongseng daging sapi empuk dengan kuah santan bumbu rempah gurih, kol renyah, dan tomat segar.', '38000.00', '20', 'Nasi Tongseng Daging Sapi.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('16', 'Iga Cabe Ijo', 'Iga sapi empuk bertabur sambal cabe ijo ulek pedas segar nan gurih.', '40000.00', '20', 'Iga Cabe Ijo.jpeg', 'Makanan', 'Main Course', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('17', 'Nasi Goreng Pakam', 'Nasi goreng signature Pakam dengan aroma smokey wok dan topping komplit daging serta telur.', '39000.00', '20', 'Nasi Goreng Pakam.jpeg', 'Makanan', 'Nasi Goreng', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('18', 'Nasi Goreng Nanas', 'Nasi goreng eksotis rasa gurih manis segar dengan potongan buah nanas tropis.', '30000.00', '20', 'Nasi Goreng Nanas.jpeg', 'Makanan', 'Nasi Goreng', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('19', 'Nasi Goreng Cabe Ijo', 'Nasi goreng dengan bumbu cabai hijau segar pedas mantap dan gurih sedap.', '25000.00', '20', 'Nasi Goreng Cabe Ijo.jpeg', 'Makanan', 'Nasi Goreng', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('20', 'Nasi Goreng Little Palembang', 'Nasi goreng racikan khas Little Palembang yang kaya rempah dan lauk gurih.', '30000.00', '20', 'Nasi Goreng Little Palembang.jpeg', 'Makanan', 'Nasi Goreng', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('21', 'Nasi Goreng Tek-Tek', 'Nasi goreng tradisional khas gerobak malam dengan rasa gurih manis otentik.', '23000.00', '20', 'Nasi Goreng Tek-Tek.jpeg', 'Makanan', 'Nasi Goreng', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('22', 'Nasi Goreng Aceh', 'Nasi goreng khas Serambi Mekkah beraroma rempah kari kuat nan menggoda selera.', '25000.00', '20', 'Nasi Goreng Aceh.jpeg', 'Makanan', 'Nasi Goreng', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('23', 'Spaghetti Meatballs', 'Spaghetti al dente dengan saus bolognese daging cincang kental dan bakso daging sapi lembut.', '45000.00', '20', 'Spaghetti Meatballs.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('24', 'Spaghetti Creamy Pasta', 'Spaghetti bersaus keju dan cream lembut gurih bertabur keju parmesan.', '45000.00', '20', 'Spaghetti Creamy Pasta.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('25', 'Spaghetti Sambal Matah', 'Spaghetti fusion nusantara dengan taburan sambal matah bali pedas wangi segar.', '29000.00', '20', 'Spaghetti Sambal Matah.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('26', 'Indomie Carbonara', 'Kreasi indomie creamy bersaus carbonara keju gurih nikmat.', '28000.00', '20', 'Indomie Carbonara.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('27', 'Mie Nyemek Bon Cabe', 'Mie nyemek berkuah sedikit kental bertabur bumbu pedas bon cabe yang bikin nagih.', '25000.00', '20', 'Mie Nyemek Bon Cabe.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('28', 'Mie Bangladesh', 'Mie kuah becek bumbu rempah pekat khas Aceh/Bangladesh dengan telur ceplok setengah matang.', '25000.00', '20', 'Mie Bangladesh.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('29', 'Mie Kangkung', 'Mie kenyal disajikan dengan kuah manis gurih kecap dan sayuran kangkung segar renyah.', '25000.00', '20', 'Mie Kangkung.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('30', 'Mie Goreng Cornet', 'Mie goreng gurih diselimuti kornet sapi melimpah.', '20000.00', '20', 'Mie Goreng Kornet.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('31', 'Mie Jodoh', 'Mie spesial resep jodoh rahasia Little Palembang.', '25000.00', '20', 'Mie Jodoh.jpeg', 'Makanan', 'Pasta & Spaghetti', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('32', 'Bakmi Ayam Rica-Rica', 'Bakmi kenyal disiram tumisan ayam rica-rica pedas gurih khas manado.', '20000.00', '20', 'Bakmi Ayam RIca-Rica.jpeg', 'Makanan', 'Bakmi', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('33', 'Bakmi Ayam Chili Oil', 'Bakmi berpadu minyak cabai wangi (chili oil) pedas aromatik dan daging ayam gurih.', '20000.00', '20', 'Bakmi Ayam Chili Oil.jpeg', 'Makanan', 'Bakmi', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('34', 'Bakmi Ayam Teriyaki', 'Bakmi oriental dengan topping potongan daging ayam bumbu teriyaki manis gurih.', '20000.00', '20', 'Bakmi Ayam Teriyaki.jpeg', 'Makanan', 'Bakmi', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('35', 'Steak Bakso Little Palembang', 'Steak bakso jumbo unik disajikan dengan saus steak gurih dan sayuran pendamping.', '45000.00', '20', 'Steak Bakso Little Palembang.jpeg', 'Makanan', 'Western & Steak', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('36', 'Steak Chicken Katsu', 'Daging ayam fillet berbalut tepung roti krispi tebal dengan siraman saus steak khas dan kentang.', '35000.00', '20', 'Steak Chicken Katsu.jpeg', 'Makanan', 'Western & Steak', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('37', 'Steak Meltique Tenderloin', 'Daging tenderloin meltique premium empuk juicy dipanggang sempurna dengan saus pilihan.', '116000.00', '20', 'Steak Meltique Tenderloin.jpeg', 'Makanan', 'Western & Steak', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('38', 'Steak Meltique Sirloin', 'Sirloin meltique lembut bertekstur juicy dengan cita rasa daging gurih aromatik.', '116000.00', '20', 'Steak Meltique Sirloin.jpeg', 'Makanan', 'Western & Steak', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('39', 'Pizza Sambal Matah', 'Pizza crispy dengan topping keju mozzarella dan lumuran sambal matah khas bali.', '39000.00', '20', 'Pizza Sambal Matah.jpeg', 'Makanan', 'Western & Steak', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('40', 'Pizza Mentai', 'Pizza renyah dengan lelehan saus mentai gurih lembut khas jepang yang dipanggang harum.', '39000.00', '20', 'Pizza Mentai.jpeg', 'Makanan', 'Western & Steak', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('41', 'Martabak HAR Telor Ayam', 'Martabak telor ayam khas HAR Palembang disajikan dengan kuah kari kentang kental nikmat.', '26000.00', '20', 'Martabak Har Telur Ayam.jpeg', 'Makanan', 'Western & Steak', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('42', 'Martabak HAR Telor Bebek', 'Martabak telor bebek renyah gurih disajikan dengan kuah kari kentang khas Palembang.', '30000.00', '20', 'Martabak Har Telur Bebek.jpeg', 'Makanan', 'Western & Steak', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('43', 'French Toast Classic', 'Roti panggang celup telur mentega lembut harum dengan siraman sirup manis.', '18000.00', '20', 'French Toast Classic.jpeg', 'Makanan', 'Toast', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('44', 'French Toast Biscoff', 'French toast tebal berselimut selai karamel lotus biscoff dan remahan biskuit renyah.', '27000.00', '20', 'French Toast Biscof.jpeg', 'Makanan', 'Toast', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('45', 'French Toast Hongkong', 'Roti bakar ala Hongkong yang lembut keemasan dengan potongan butter leleh dan selai.', '20000.00', '20', 'French Toast Hongkong.jpeg', 'Makanan', 'Toast', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('46', 'Sup Krim Ayam Jagung', 'Sup krim kental hangat bernutrisi dengan butiran jagung manis dan suwiran daging ayam gurih.', '32000.00', '20', 'Sup Krim Ayam Jagung.jpeg', 'Makanan', 'Appetizer', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('47', 'Dimsum Ayam', 'Dimsum olahan ayam lembut gurih disajikan hangat dengan saus asam manis pedas.', '22000.00', '20', 'Dimsum Ayam.jpeg', 'Makanan', 'Appetizer', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('48', 'Telur Ayam Kampung (Isi 2)', '2 butir telur ayam kampung setengah matang segar berprotein tinggi dengan kecap dan lada.', '17000.00', '20', 'Telur Ayam Kampung.jpeg', 'Makanan', 'Appetizer', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('49', 'Udang Keju', 'Olahan daging udang goreng tepung renyah berisikan keju leleh lumer.', '25000.00', '20', 'Udang Keju.jpeg', 'Makanan', 'Appetizer', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('50', 'Pempek Kecil (10 buah)', 'Porsi puas 10 buah pempek campur (adaan, kulit, telur, lenjer) asli ikan tenggiri disajikan dengan cuko kental pedas mantap.', '50000.00', '20', 'Pempek Kecil Isi 10.jpeg', 'Makanan', 'Palembang', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('51', 'Pempek Kapal Selam', 'Pempek ukuran besar berisi 1 butir telur utuh gurih, disajikan dengan mie, timun, dan cuko hitam sedap.', '20000.00', '20', 'Pempek Kapal Selam.jpeg', 'Makanan', 'Palembang', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('52', 'Model', 'Model ikan berisi tahu lembut dalam kuah kaldu udang hangat beraroma seledri dan bawang goreng.', '20000.00', '20', 'Model.jpeg', 'Makanan', 'Palembang', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('53', 'Tekwan', 'Pentol tekwan ikan kenyal disajikan dalam kuah udang gurih hangat bersama soun, jamur kuping, dan bengkuang.', '20000.00', '20', 'Tekwan.jpeg', 'Makanan', 'Palembang', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('54', 'Lenggang', 'Pempek yang dipanggang bersama kocokan telur dadar harum, disajikan dengan siraman cuko asli Palembang.', '20000.00', '20', 'Lenggang.jpeg', 'Makanan', 'Palembang', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('55', 'Pao Coklat (Isi 10)', 'Mini bakpao kukus hangat isi 10 buah dengan pasta coklat manis lumer.', '23000.00', '20', 'Pao Coklat Isi 10.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('56', 'Classic Donut', 'Donat klasik empuk lembut bertabur gula salju manis.', '23000.00', '20', 'Classic Donut.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('57', 'Cake Choco Lava', 'Kue coklat panggang hangat dengan lelehan coklat lava pekat saat dipotong.', '26000.00', '20', 'Cake Choco Lava.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('58', 'Spicy Chicken Wings', 'Sayap ayam goreng renyah dibalut bumbu cabai pedas gurih meresap.', '28000.00', '20', 'Chicken Wings Spicy.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('59', 'Chicken Wings Lemonpepper', 'Sayap ayam krispi bertabur bumbu lemon pepper asam pedas gurih aromatik.', '28000.00', '20', 'Chicken Wings lemonpapper.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('60', 'Jamur Enoki Crispy', 'Jamur enoki digoreng tepung sangat renyah dan gurih renyah.', '22000.00', '20', 'Jamur Enoki.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('61', 'Pangsit Goreng', 'Kulit pangsit isi goreng garing keemasan dengan saus cocolan nikmat.', '18000.00', '20', 'Pangsit Goreng.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('62', 'Tahu Lada Garam', 'Tahu crispy ditumis dengan potongan cabai rawit, bawang putih, dan taburan lada garam sedap.', '25000.00', '20', 'Tahu Lada Garam.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('63', 'Tahu Asam Manis', 'Tahu goreng renyah disiram saus asam manis lezat.', '25000.00', '20', 'Tahu Asam Manis.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('64', 'Roti Goreng', 'Roti goreng garing di luar, empuk di dalam dengan rasa gurih manis.', '28000.00', '20', 'Roti Goreng.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('65', 'Bakwan Pontianak Udang Ebi', 'Bakwan sayur tebal garing khas Pontianak dengan topping udang ebi gurih dan sambal cocol.', '15000.00', '20', 'Bakwan Pontianak Ebi.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('66', 'Tempe Mendoan', 'Tempe tepung setengah matang gurih lembut disajikan hangat dengan sambal kecap cabai rawit.', '18000.00', '20', 'Tempe Mendoan.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('67', 'Pisang Goreng', 'Pisang kepok manis digoreng tepung garing renyah keemasan.', '18000.00', '20', 'Pisang Goreng.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('68', 'French Fries', 'Kentang goreng stik renyah gurih asin dengan saus sambal.', '25000.00', '20', 'French Fries.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('69', 'French Fries Salted Egg', 'Kentang goreng renyah berlumur saus kuning telur asin gurih yang creamy.', '40000.00', '20', 'French Fries Salted Egg.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('70', 'Prata Coklat', 'Roti prata renyah berlapis disiram topping coklat manis nikmat.', '25000.00', '20', 'Prata Coklat.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('71', 'Prata Keju', 'Roti prata garing berlapis bertabur keju parut gurih melimpah.', '25000.00', '20', 'Prata Keju.jpeg', 'Camilan', 'Snack', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('72', 'Vanilla Sundae', 'Es krim sundae vanilla lembut dengan cita rasa manis segar.', '18000.00', '20', 'Vanila Sundae.jpeg', 'Camilan', 'Dessert', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('73', 'Chocolate Sundae', 'Es krim rasa coklat lembut disiram saus coklat pekat lezat.', '18000.00', '20', 'Chocolatte Sundae.jpeg', 'Camilan', 'Dessert', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('74', 'Mix Sundae', 'Paduan es krim sundae vanilla dan coklat dengan saus topping manis nikmat.', '20000.00', '20', 'Mix Sundae.jpeg', 'Camilan', 'Dessert', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('75', 'Coconut Shake', 'Minuman olahan kelapa muda segar asli yang diblend creamy menyegarkan dahaga.', '20000.00', '20', 'Coconut Shake.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('76', 'Tropical Shake', 'Shake kelapa segar berpadu aneka buah tropis manis nan segar.', '25000.00', '20', 'Tropical Shake.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('77', 'Oreo Shake', 'Shake susu kelapa creamy berpadu remahan biskuit oreo hitam renyah manis.', '24000.00', '20', 'Oreo Shake.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('78', 'Klepon Brown Sugar Shake', 'Shake unik rasa klepon pandan kelapa gurih berpadu sirup gula aren asli.', '30000.00', '20', 'Klepon Brown Sugar Shake.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('79', 'Lotus Biscoff Shake', 'Shake creamy manis gurih dengan selai biskuit lotus biscoff karamel lezat.', '30000.00', '20', 'Lotus Biscoff Shake.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('80', 'Double Choco Shake', 'Shake coklat ganda pekat berpadu susu kelapa lembut manis.', '30000.00', '20', 'Double Choco Shake.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('81', 'Mango Milk', 'Susu segar berpadu manis dan segarnya puree buah mangga harum.', '24000.00', '20', 'Mango Milk.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('82', 'Peach Current Tea', 'Teh dingin dengan aroma buah peach manis berpadu asam manis blackcurrant.', '15000.00', '20', 'Peach Current Tea.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('83', 'Strawberry Milk', 'Susu segar manis asam lembut dipadu selai buah strawberry asli.', '24000.00', '20', 'Strawberry Milk.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('84', 'Guava Honey Lemonade', 'Jus jambu biji merah dipadu madu alami dan perasan lemon segar.', '18000.00', '20', 'Guava Honey Lemonade.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('85', 'Lychee Berry Tea', 'Teh dingin beraroma leci wangi dan campuran buah berry segar.', '15000.00', '20', 'Lychee Berry Tea.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('86', 'Mango Honey Lemonade', 'Perpaduan sari buah mangga harum manis, madu, dan segarnya lemon.', '18000.00', '20', 'Mango Honey Lemonade.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('87', 'Klepon', 'Minuman dingin citarasa kue klepon pandan kelapa tradisional.', '27000.00', '20', 'Klepon.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('88', 'Chocolate Milk', 'Susu coklat segar manis lembut nikmat.', '27000.00', '20', 'Chocolate.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('89', 'Black Vanilla', 'Minuman vanilla dingin unik berpadu sentuhan black charcoal.', '27000.00', '20', 'Black Vanila.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('90', 'Avocado Juice', 'Jus buah alpukat mentega segar kental dan creamy.', '27000.00', '20', 'Avocado.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('91', 'Butterfly Blue Tea', 'Teh bunga telang biru alami menyegarkan berkhasiat antioksidan.', '27000.00', '20', 'Butterfly Blue Tea.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('92', 'Jasmine Green Tea', 'Teh hijau melati dingin beraroma wangi menenangkan.', '27000.00', '20', 'Jasmine Greentea.jpeg', 'Minuman', 'Little Coconut', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('93', 'Latte Hot Coffee', 'Kopi espresso hangat berpadu steamed milk lembut creamy.', '22000.00', '20', 'Latte Hot Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('94', 'Kopi Susu Kampung', 'Kopi susu khas kampung dengan rasa mantap nostalgia nikmat.', '18000.00', '20', 'Kopi Susu Kampung.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('95', 'Americano Hot', 'Kopi espresso panas murni diseduh air panas dengan crema tebal aromatik.', '20000.00', '20', 'Americano Hot.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:43:09');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('96', 'Cappuccino', 'Espresso berpadu susu dan lapisan foam susu tebal lembut.', '22000.00', '20', 'Cappucino.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('97', 'Moccachino', 'Kombinasi espresso, coklat pekat, dan susu lembut hangat/dingin.', '22000.00', '20', 'Moccachino.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('98', 'Caramel Coffee Latte', 'Coffee latte dengan sirup karamel manis wangi gurih.', '27000.00', '20', 'Caramel Coffe Latte.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('99', 'Vanilla Coffee Latte', 'Coffee latte lembut beraroma manis vanilla lembut.', '27000.00', '20', 'Vanila Coffe Latte.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('100', 'Red Velvet Latte', 'Latte red velvet manis legit berwarna merah cantik.', '27000.00', '20', 'Red Velvet Latte.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('101', 'Charcoal Latte', 'Latte arang aktif unik creamy menyehatkan tubuh.', '27000.00', '20', 'Charcoal Latte.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('102', 'Kopi Hitam Semendo', 'Kopi robusta asli dataran tinggi Semendo Sumsel dengan body tebal dan aroma pekat.', '15000.00', '20', 'Kopi HItam Samendo.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('103', 'Kopi Hitam Pagaralam', 'Kopi robusta asli Gunung Dempo Pagaralam yang harum dan berkarakter kuat.', '15000.00', '20', 'Kopi HItam Pagar Alam.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('104', 'Kopi Susu Bahagia', 'Kopi susu gula aren signature pembawa senyum dan bahagia.', '20000.00', '20', 'Kopi Susu Bahagia.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('105', 'Coconut Coffee', 'Perpaduan segar espresso dan air kelapa muda manis gurih alami.', '20000.00', '20', 'Coconut Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('106', 'Avocado Coffee', 'Jus alpukat lembut kental disiram shot espresso pekat pahit manis seimbang.', '28000.00', '20', 'Avocado Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('107', 'Chocolate Coffee', 'Paduan kopi espresso dan coklat pekat nikmat memanjakan lidah.', '28000.00', '20', 'Chocolatte Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('108', 'Chocolate Panas', 'Coklat hangat pekat creamy dengan rasa manis gurih pas.', '27000.00', '20', 'Chocolatte.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('109', 'Irish Coffee', 'Kopi espresso dengan sirup aroma khas irish cream yang wangi lembut.', '28000.00', '20', 'Irish Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('110', 'Brown Sugar Coffee', 'Kopi susu berpadu manis harum gula aren murni.', '25000.00', '20', 'Brown Sugar Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('111', 'Matcha Latte Ice Coffee', 'Layering indah matcha jepang, susu segar, dan espresso dingin.', '35000.00', '20', 'Matcha Latte Ice Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('112', 'Ice Caramel Coffee', 'Es kopi susu dingin dengan saus karamel lezat menggoda.', '29000.00', '20', 'Ice Caramel Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('113', 'Americano Ice', 'Es kopi hitam segar tanpa gula dengan citarasa kopi murni dingin.', '20000.00', '20', 'Americano Ice.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('114', 'Coffee Jodoh', 'Kopi racikan rahasia jodoh istimewa dari Little Palembang.', '25000.00', '20', 'Coffe Jodoh.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('115', 'Coffee Latte', 'Es kopi latte susu dingin lembut segar.', '22000.00', '20', 'Coffe Latte.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('116', 'Pakam Ice Coffee', 'Es kopi signature racikan barista Pakam.', '25000.00', '20', 'Pakam Ice Coffe.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('117', 'Pandan Kopi Pakam', 'Kopi susu dingin dengan aroma wangi daun pandan alami.', '28000.00', '20', 'Pandan Kopi Pakam.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('118', 'Cincau Kopi Pakam', 'Kopi susu manis dingin dengan potongan cincau hitam kenyal segar.', '28000.00', '20', 'Cincau Kopi Pakam.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('119', 'Hazelnut Kopi Pakam', 'Kopi susu dingin dengan aroma khas kacang hazelnut wangi.', '28000.00', '20', 'Huzzlenut Kopi Pakam.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('120', 'Peppermint Kopi Pakam', 'Sensasi kopi susu dingin dengan kesegaran semriwing mint peppermint.', '28000.00', '20', 'Peppermint Kopi Pakam.jpeg', 'Minuman', 'Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('121', 'Charcoal Latte Ice', 'Es latte arang bambu hitam yang creamy, unik, dan segar menyehatkan.', '28000.00', '20', 'Charcoal Latte Ice.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('122', 'Ice Earl Grey Milk Tea', 'Teh susu dingin beraroma bergamot earl grey wangi aromatik.', '20000.00', '20', 'Ice Gearl Grey Milk Tea.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:43:22');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('123', 'Strawberry Mango', 'Paduan buah strawberry dan mangga segar dingin kaya vitamin.', '28000.00', '20', 'Strawberry Mango.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('124', 'Pineapple Blue Curacao', 'Minuman nanas segar dengan warna biru eksotis sirup blue curacao.', '28000.00', '20', 'Pineapple Blue Guraca.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('125', 'Ice Matcha Latte', 'Es matcha jepang murni dengan susu segar creamy nikmat tanpa kopi.', '30000.00', '20', 'Ice Matcha Latte.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('126', 'Ice Moccachino', 'Minuman dingin coklat moccachino manis segar.', '22000.00', '20', 'Ice Moccachino.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('127', 'Ice Red Velvet Latte', 'Es red velvet latte manis legit nan cantik.', '27000.00', '20', 'Ice Red Velvet Latte.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('128', 'Ice Vanilla Coffee Latte', 'Es vanilla latte lembut dingin menyegarkan hari.', '28000.00', '20', 'Ice Vanila Coffe Latte.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('129', 'Mango Tea', 'Es teh beraroma buah mangga manis segar.', '17000.00', '20', 'Mango Tea.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('130', 'Strawberry Tea', 'Es teh buah strawberry asam manis segar.', '17000.00', '20', 'Strawberry Tea.jpeg', 'Minuman', 'Ice Non Coffee', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('131', 'Little Punch', 'Mocktail mixology racikan buah tropis segar signature Little Palembang.', '32000.00', '20', 'Little Punch.jpeg', 'Minuman', 'Mixology', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('132', 'Little Violet', 'Mocktail ungu eksotis dengan sensasi rasa manis asam segar menyengat.', '32000.00', '20', 'Little Violet.jpeg', 'Minuman', 'Mixology', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('133', 'Little Black Grey', 'Mocktail elegan berkarakter dengan rasa rempah buah segar unik.', '32000.00', '20', 'Little Black Grey.jpeg', 'Minuman', 'Mixology', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');
INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `sub_category`, `is_available`, `created_at`, `updated_at`) VALUES ('134', 'Little Spring', 'Mocktail kesegaran musim semi dengan rasa segar membangkitkan mood.', '32000.00', '20', 'Little Spring.jpeg', 'Minuman', 'Mixology', '1', '2026-08-24 18:40:10', '2026-08-24 18:40:10');

--
-- Table structure for table `migrations`
--
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2025_12_04_011535_create_menus_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2025_12_04_011536_create_tables_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2025_12_04_011540_create_orders_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2025_12_04_011541_create_order_items_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2025_12_04_022924_add_status_to_tables_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2025_12_04_034716_create_payment_methods_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_01_04_000622_add_location_to_tables_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_01_05_002551_add_require_location_setting', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_03_14_074105_add_floor_to_orders_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2026_03_17_021939_add_sub_category_to_menus_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('14', '2026_08_14_000000_remove_location_from_tables_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('15', '2026_08_19_000000_add_role_to_users_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('16', '2026_08_24_000000_add_waiter_name_to_orders_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('17', '2026_08_24_000001_create_ratings_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('18', '2026_09_07_000001_add_stock_to_menus_and_notes_to_order_items', '4');

--
-- Table structure for table `order_items`
--
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `menu_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_menu_id_foreign` (`menu_id`),
  CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `order_items`
INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `quantity`, `price`, `notes`, `created_at`, `updated_at`) VALUES ('2', '2', '6', '2', '18000.00', NULL, '2026-08-21 09:17:05', '2026-08-24 18:40:10');
INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `quantity`, `price`, `notes`, `created_at`, `updated_at`) VALUES ('3', '3', '3', '1', '10000.00', NULL, '2026-08-24 08:06:41', '2026-08-24 18:40:10');
INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `quantity`, `price`, `notes`, `created_at`, `updated_at`) VALUES ('4', '4', '57', '2', '26000.00', NULL, '2026-08-25 17:39:57', '2026-08-25 17:39:57');
INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `quantity`, `price`, `notes`, `created_at`, `updated_at`) VALUES ('5', '4', '65', '1', '15000.00', NULL, '2026-08-25 17:39:57', '2026-08-25 17:39:57');
INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `quantity`, `price`, `notes`, `created_at`, `updated_at`) VALUES ('6', '4', '73', '2', '18000.00', NULL, '2026-08-25 17:39:57', '2026-08-25 17:39:57');

--
-- Table structure for table `orders`
--
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `table_id` bigint unsigned NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waiter_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Lantai 1, Lantai 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_table_id_foreign` (`table_id`),
  CONSTRAINT `orders_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `orders`
INSERT INTO `orders` (`id`, `table_id`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `customer_name`, `waiter_name`, `floor`, `created_at`, `updated_at`) VALUES ('2', '1', '36000.00', 'QRIS All Payment', 'pending', 'completed', 'Leo', NULL, 'Lantai 1', '2026-08-21 09:17:05', '2026-08-21 09:18:22');
INSERT INTO `orders` (`id`, `table_id`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `customer_name`, `waiter_name`, `floor`, `created_at`, `updated_at`) VALUES ('3', '1', '10000.00', 'Cash', 'pending', 'completed', 'derta', 'Derti', 'Lantai 1', '2026-08-24 08:06:41', '2026-08-24 18:36:01');
INSERT INTO `orders` (`id`, `table_id`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `customer_name`, `waiter_name`, `floor`, `created_at`, `updated_at`) VALUES ('4', '1', '103000.00', 'Cash', 'pending', 'completed', 'Derta', NULL, 'Lantai 1', '2026-08-25 17:39:57', '2026-09-07 01:55:49');

--
-- Table structure for table `password_reset_tokens`
--
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `payment_methods`
--
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('bank_transfer','qris','cash') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bank_transfer',
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `payment_methods`
INSERT INTO `payment_methods` (`id`, `name`, `type`, `account_number`, `account_name`, `qr_code_image`, `instructions`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Cash', 'cash', NULL, NULL, NULL, 'Bayar langsung di kasir saat memesan atau setelah selesai makan.', '1', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `payment_methods` (`id`, `name`, `type`, `account_number`, `account_name`, `qr_code_image`, `instructions`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Transfer Bank BCA', 'bank_transfer', '8410928371', 'Little Palembang Cafe', NULL, 'Transfer ke rekening BCA dan tunjukkan bukti transfer ke kasir/pelayan.', '1', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `payment_methods` (`id`, `name`, `type`, `account_number`, `account_name`, `qr_code_image`, `instructions`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'QRIS All Payment', 'qris', NULL, NULL, NULL, 'Scan QRIS menggunakan GoPay, OVO, Dana, ShopeePay, BCA Mobile, dll.', '1', '2026-08-14 07:13:11', '2026-08-14 07:13:11');

--
-- Table structure for table `ratings`
--
DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `table_id` bigint unsigned NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waiter_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `food_rating` tinyint unsigned NOT NULL DEFAULT '5',
  `table_rating` tinyint unsigned NOT NULL DEFAULT '5',
  `waiter_rating` tinyint unsigned DEFAULT '5',
  `is_favorite_table` tinyint(1) NOT NULL DEFAULT '0',
  `review` text COLLATE utf8mb4_unicode_ci,
  `waiter_review` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_order_id_foreign` (`order_id`),
  KEY `ratings_table_id_foreign` (`table_id`),
  CONSTRAINT `ratings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `sessions`
--
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('wRkaO4Cs602arsTcIG00SzMUlxHZIT2jpsCpgfEz', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaGxobnNKRUU1ZVVCOWNPT0k0TGozZnkzeTg4b01XQ0s4Y3d2NFZUNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi90YWJsZXMiO3M6NToicm91dGUiO3M6MTI6InRhYmxlcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0MToiY2FydF9lOGYwNWNlMS04MzI4LTRiMzItODdhNS1kOWZkNDM3ZDkwYjQiO2E6Mjp7aTo1NzthOjU6e3M6NDoibmFtZSI7czoxNToiQ2FrZSBDaG9jbyBMYXZhIjtzOjg6InF1YW50aXR5IjtzOjE6IjEiO3M6NToicHJpY2UiO3M6ODoiMjYwMDAuMDAiO3M6NToiaW1hZ2UiO3M6MjA6IkNha2UgQ2hvY28gTGF2YS5qcGVnIjtzOjU6Im5vdGVzIjtzOjMwOiJUaWRhayBQZWRhcywgS3VhaC9DdWtvIERpcGlzYWgiO31pOjczO2E6NTp7czo0OiJuYW1lIjtzOjE2OiJDaG9jb2xhdGUgU3VuZGFlIjtzOjg6InF1YW50aXR5IjtzOjE6IjEiO3M6NToicHJpY2UiO3M6ODoiMTgwMDAuMDAiO3M6NToiaW1hZ2UiO3M6MjI6IkNob2NvbGF0dGUgU3VuZGFlLmpwZWciO3M6NToibm90ZXMiO047fX19', '1788747362');

--
-- Table structure for table `tables`
--
DROP TABLE IF EXISTS `tables`;
CREATE TABLE `tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `table_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_code_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('available','occupied') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tables_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `tables`
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('1', '1', 'e8f05ce1-8328-4b32-87a5-d9fd437d90b4', NULL, 'available', '2026-08-14 07:13:11', '2026-09-07 01:55:49');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('2', '2', '71f5d121-3f90-4afd-82bc-baa665f13b3a', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('3', '3', 'ab06b12f-be98-4847-aed7-a05630fcb897', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('4', '4', '0ecf0d89-098b-4376-b4ee-57765a1b6d5c', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('5', '5', '24d0f8b0-b190-4575-af5a-4e21816978e1', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('6', '6', 'fb902fec-ad13-4006-be21-f84d3dc85718', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('7', '7', '5cb74d9d-dc19-4422-bd10-484c532fbf8a', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('8', '8', 'd332da1c-f703-4b80-a683-b9cc042cbd12', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('9', '9', '349520b0-7856-48c1-b510-3ec991e40bf8', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('10', '10', '596cfdb2-f6ce-46b9-9cf2-99bfc0adeedf', NULL, 'available', '2026-08-14 07:13:11', '2026-08-14 07:13:11');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('11', '11', '6fed2ad2-5003-483f-baae-92764db70875', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('12', '12', 'a9214530-8242-4742-b133-f9278bd6edd9', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('13', '13', 'fe02f061-00fa-4fea-817f-72e74f7c5baa', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('14', '14', '8659a490-be47-424b-abca-9fe1242b9df3', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('15', '15', 'd5150706-8d31-453a-8803-fed0703e1f11', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('16', '16', '06b6ce74-f08d-4b1c-8e32-39354f271a7b', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('17', '17', '4b71e710-9e83-439b-8cbd-1d02e24036d7', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('18', '18', '527a6a58-f481-4820-831c-1e0116ff79a9', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('19', '19', '5f420c75-54cd-4ee3-860e-745d2f53d06a', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('20', '20', 'cedacb52-c1a7-4b86-be98-db196a1438fc', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('21', '21', '54dcd8f9-ffca-4f76-9829-d8ff6402f407', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('22', '22', 'bec80363-1e34-426a-b5bb-41c5d624f09b', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('23', '23', '4cc8b42a-5d0e-4785-896a-79f7cc0d0623', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('24', '24', '9810a713-a177-463c-8648-fd93c00db989', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('25', '25', 'a0204c91-8ed3-4c57-a720-3f92518b9e10', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('26', '26', 'ca046217-aebd-45ae-bcad-8bc506b8c7f4', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('27', '27', '5d3e7a22-3153-4e6d-a635-e1be01db3e21', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('28', '28', 'eea5e6e3-4672-457a-8baf-c3d4bf5703e0', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('29', '29', '2c0bcea7-e00c-46ce-bc52-b70217cdec91', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('30', '30', '81810c38-5c2e-441d-b66b-292e027f0db6', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('31', '31', '00cf4acb-7869-4c39-9470-9b05ea41af0e', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('32', '32', '65fb2aab-3ea0-467f-9898-a24e1551029a', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');
INSERT INTO `tables` (`id`, `table_number`, `uuid`, `qr_code_path`, `status`, `created_at`, `updated_at`) VALUES ('33', '33', '6a79a6bb-42f6-46be-b215-b07bf4815a10', NULL, 'available', '2026-08-28 19:08:24', '2026-08-28 19:08:24');

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','dapur','kasir','owner') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Administrator', 'admin@gmail.com', 'admin', '2026-08-19 13:19:43', '$2y$12$1yOYY6ffRVXQtbTpNFscnOiSdXv0PrXZKch8njDk6GauR51VuEF12', NULL, '2026-08-14 07:13:11', '2026-08-19 13:19:43');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('3', 'Admin', 'admin@example.com', 'admin', NULL, '$2y$12$p9ygWZd3lQT5C5rqI5wBz.b66VaWNEJ96vDBAzd7Ut.7ztAk2sBdu', NULL, '2026-08-18 16:44:54', '2026-08-18 16:44:54');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('4', 'Staf Kasir', 'kasir@gmail.com', 'kasir', '2026-08-19 13:19:43', '$2y$12$dbda74E2.C8HhVrRt0DD0u59cRdhJvDxL5KjE8atRWAS6cRd1v4g.', NULL, '2026-08-19 13:18:35', '2026-08-19 13:19:43');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('5', 'Staf Dapur', 'dapur@gmail.com', 'dapur', '2026-08-19 13:19:43', '$2y$12$tqePqtFKnBzqiQmp8.EM6eh0sS14sz5w1J5NkhuhhQMQj3S3ht0z.', NULL, '2026-08-19 13:18:36', '2026-08-19 13:19:43');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('6', 'Pemilik Usaha (Owner)', 'owner@gmail.com', 'owner', '2026-08-19 13:19:43', '$2y$12$aH5sSwfbRo2tcjnRUq3SreDUfl3H.yTCEsO.uYraAsAjKIqNoOlvK', NULL, '2026-08-19 13:18:36', '2026-08-19 13:19:43');

SET FOREIGN_KEY_CHECKS = 1;
