-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03 Nov 2015 pada 09.08
-- Versi Server: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `utomos_c45`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `c45_mining`
--

CREATE TABLE IF NOT EXISTS `c45_mining` (
  `c45_mining_id` int(11) NOT NULL,
  `c45_mining_sequence` int(11) NOT NULL DEFAULT '0',
  `c45_mining_ct_id` int(11) NOT NULL DEFAULT '0',
  `c45_mining_rule_id` int(11) NOT NULL DEFAULT '0',
  `c45_mining_parent` varchar(40) DEFAULT NULL,
  `c45_mining_value` varchar(40) DEFAULT NULL,
  `c45_mining_set` varchar(40) DEFAULT NULL,
  `c45_mining_total` int(11) NOT NULL,
  `c45_mining_yes` int(11) NOT NULL,
  `c45_mining_no` int(11) NOT NULL,
  `c45_mining_entropy` double NOT NULL,
  `c45_mining_gain` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `c45_mining`
--

INSERT INTO `c45_mining` (`c45_mining_id`, `c45_mining_sequence`, `c45_mining_ct_id`, `c45_mining_rule_id`, `c45_mining_parent`, `c45_mining_value`, `c45_mining_set`, `c45_mining_total`, `c45_mining_yes`, `c45_mining_no`, `c45_mining_entropy`, `c45_mining_gain`) VALUES
(1, 1, 3, 0, 'Hasil Penjualan', NULL, NULL, 0, 0, 0, 0, 0.0050195768440778),
(2, 1, 3, 7, 'Hasil Penjualan', 'Low', '>=0<=30', 29, 13, 16, 0.9922666387195, 0),
(3, 1, 3, 8, 'Hasil Penjualan', 'Medium', '>=31<=60', 44, 23, 21, 0.99850909891763, 0),
(4, 1, 3, 9, 'Hasil Penjualan', 'High', '>=61<=90', 27, 15, 12, 0.99107605983822, 0),
(5, 1, 1, 0, 'Minimal Stock', NULL, NULL, 0, 0, 0, 0, 0.14426888345441),
(6, 1, 1, 1, 'Minimal Stock', 'Sedikit', '>=0<=15', 48, 26, 22, 0.99498482818597, 0),
(7, 1, 1, 2, 'Minimal Stock', 'Sedang', '>=16<=25', 15, 14, 1, 0.35335933502142, 0),
(8, 1, 1, 3, 'Minimal Stock', 'Banyak', '>=26<=35', 37, 11, 26, 0.87796200139439, 0),
(9, 1, 4, 0, 'Sisa Stock', NULL, NULL, 0, 0, 0, 0, 0.043894199568915),
(10, 1, 4, 10, 'Sisa Stock', 'Sangat Sedikit', '>=0<=15', 10, 5, 5, 1, 0),
(11, 1, 4, 11, 'Sisa Stock', 'Sedikit', '>=16<=25', 20, 11, 9, 0.99277445398781, 0),
(12, 1, 4, 12, 'Sisa Stock', 'Sedang', '>=26<=35', 40, 25, 15, 0.95443400292496, 0),
(13, 1, 4, 13, 'Sisa Stock', 'Banyak', '>=36<=45', 30, 10, 20, 0.91829583405449, 0),
(14, 1, 2, 0, 'Waktu Tunggu (Hari)', NULL, NULL, 0, 0, 0, 0, 0.40019242919463),
(15, 1, 2, 4, 'Waktu Tunggu (Hari)', 'Lama', '5', 20, 20, 0, 0, 0),
(16, 1, 2, 5, 'Waktu Tunggu (Hari)', 'Biasa', '2', 60, 31, 29, 0.99919835426364, 0),
(17, 1, 2, 6, 'Waktu Tunggu (Hari)', 'Cepat', '1', 20, 0, 20, 0, 0),
(18, 2, 3, 0, 'Hasil Penjualan', NULL, NULL, 0, 0, 0, 0, 0.076512429628249),
(19, 2, 3, 7, 'Hasil Penjualan', 'Low', '>=0<=30', 12, 3, 9, 0.81127812445913, 0),
(20, 2, 3, 8, 'Hasil Penjualan', 'Medium', '>=31<=60', 28, 14, 14, 1, 0),
(21, 2, 3, 9, 'Hasil Penjualan', 'High', '>=61<=90', 20, 14, 6, 0.88129089923069, 0),
(22, 2, 1, 0, 'Minimal Stock', NULL, NULL, 0, 0, 0, 0, 0.55855290464829),
(23, 2, 1, 1, 'Minimal Stock', 'Sedikit', '>=0<=15', 30, 21, 9, 0.88129089923069, 0),
(24, 2, 1, 2, 'Minimal Stock', 'Sedang', '>=16<=25', 10, 10, 0, 0, 0),
(25, 2, 1, 3, 'Minimal Stock', 'Banyak', '>=26<=35', 20, 0, 20, 0, 0),
(26, 2, 4, 0, 'Sisa Stock', NULL, NULL, 0, 0, 0, 0, 0.11365362181183),
(27, 2, 4, 10, 'Sisa Stock', 'Sangat Sedikit', '>=0<=15', 6, 4, 2, 0.91829583405449, 0),
(28, 2, 4, 11, 'Sisa Stock', 'Sedikit', '>=16<=25', 12, 6, 6, 1, 0),
(29, 2, 4, 12, 'Sisa Stock', 'Sedang', '>=26<=35', 27, 18, 9, 0.91829583405449, 0),
(30, 2, 4, 13, 'Sisa Stock', 'Banyak', '>=36<=45', 15, 3, 12, 0.72192809488736, 0),
(31, 3, 3, 0, 'Hasil Penjualan', NULL, NULL, 0, 0, 0, 0, 0.46297052826011),
(32, 3, 3, 7, 'Hasil Penjualan', 'Low', '>=0<=30', 5, 0, 5, 0, 0),
(33, 3, 3, 8, 'Hasil Penjualan', 'Medium', '>=31<=60', 15, 11, 4, 0.83664074194117, 0),
(34, 3, 3, 9, 'Hasil Penjualan', 'High', '>=61<=90', 10, 10, 0, 0, 0),
(35, 3, 4, 0, 'Sisa Stock', NULL, NULL, 0, 0, 0, 0, 0.3609695500828),
(36, 3, 4, 10, 'Sisa Stock', 'Sangat Sedikit', '>=0<=15', 5, 4, 1, 0.72192809488736, 0),
(37, 3, 4, 11, 'Sisa Stock', 'Sedikit', '>=16<=25', 6, 4, 2, 0.91829583405449, 0),
(38, 3, 4, 12, 'Sisa Stock', 'Sedang', '>=26<=35', 11, 11, 0, 0, 0),
(39, 3, 4, 13, 'Sisa Stock', 'Banyak', '>=36<=45', 8, 2, 6, 0.81127812445913, 0),
(40, 4, 4, 0, 'Sisa Stock', NULL, NULL, 0, 0, 0, 0, 0.83664074194117),
(41, 4, 4, 10, 'Sisa Stock', 'Sangat Sedikit', '>=0<=15', 3, 3, 0, 0, 0),
(42, 4, 4, 11, 'Sisa Stock', 'Sedikit', '>=16<=25', 2, 2, 0, 0, 0),
(43, 4, 4, 12, 'Sisa Stock', 'Sedang', '>=26<=35', 6, 6, 0, 0, 0),
(44, 4, 4, 13, 'Sisa Stock', 'Banyak', '>=36<=45', 4, 0, 4, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `c45_tree`
--

CREATE TABLE IF NOT EXISTS `c45_tree` (
  `c45_tree_id` int(11) NOT NULL,
  `c45_tree_loop` int(11) NOT NULL DEFAULT '0',
  `c45_tree_ct_id` int(11) NOT NULL,
  `c45_tree_rule_id` int(11) NOT NULL,
  `c45_tree_parent` varchar(40) NOT NULL,
  `c45_tree_value` varchar(40) DEFAULT NULL,
  `c45_tree_set` varchar(40) DEFAULT NULL,
  `c45_tree_total` int(11) NOT NULL DEFAULT '0',
  `c45_tree_yes` int(11) NOT NULL DEFAULT '0',
  `c45_tree_no` int(11) NOT NULL DEFAULT '0',
  `c45_tree_decision` enum('Y','T','?','Root') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `c45_tree`
--

INSERT INTO `c45_tree` (`c45_tree_id`, `c45_tree_loop`, `c45_tree_ct_id`, `c45_tree_rule_id`, `c45_tree_parent`, `c45_tree_value`, `c45_tree_set`, `c45_tree_total`, `c45_tree_yes`, `c45_tree_no`, `c45_tree_decision`) VALUES
(1, 3, 3, 7, 'Hasil Penjualan', 'Low', '>=0<=30', 5, 0, 5, 'T'),
(2, 3, 3, 8, 'Hasil Penjualan', 'Medium', '>=31<=60', 15, 11, 4, '?'),
(3, 3, 3, 9, 'Hasil Penjualan', 'High', '>=61<=90', 10, 10, 0, 'Y'),
(4, 2, 1, 1, 'Minimal Stock', 'Sedikit', '>=0<=15', 30, 21, 9, '?'),
(5, 2, 1, 2, 'Minimal Stock', 'Sedang', '>=16<=25', 10, 10, 0, 'Y'),
(6, 2, 1, 3, 'Minimal Stock', 'Banyak', '>=26<=35', 20, 0, 20, 'T'),
(7, 4, 4, 10, 'Sisa Stock', 'Sangat Sedikit', '>=0<=15', 3, 3, 0, 'Y'),
(8, 4, 4, 11, 'Sisa Stock', 'Sedikit', '>=16<=25', 2, 2, 0, 'Y'),
(9, 4, 4, 12, 'Sisa Stock', 'Sedang', '>=26<=35', 6, 6, 0, 'Y'),
(10, 4, 4, 13, 'Sisa Stock', 'Banyak', '>=36<=45', 4, 0, 4, 'T'),
(11, 1, 2, 4, 'Waktu Tunggu (Hari)', 'Lama', '5', 20, 20, 0, 'Y'),
(12, 1, 2, 5, 'Waktu Tunggu (Hari)', 'Biasa', '2', 60, 31, 29, '?'),
(13, 1, 2, 6, 'Waktu Tunggu (Hari)', 'Cepat', '1', 20, 0, 20, 'T');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prediction`
--

CREATE TABLE IF NOT EXISTS `prediction` (
  `prediction_id` int(11) NOT NULL,
  `prediction_name` varchar(80) NOT NULL,
  `prediction_stock_buffer` varchar(15) NOT NULL,
  `prediction_time_delay` varchar(15) NOT NULL,
  `prediction_result_sales` varchar(15) NOT NULL,
  `prediction_stock_rest` varchar(15) NOT NULL,
  `prediction_decision` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(80) NOT NULL,
  `product_stock_buffer` varchar(15) NOT NULL,
  `product_time_delay` varchar(15) NOT NULL,
  `product_result_sales` varchar(15) NOT NULL,
  `product_stock_rest` varchar(15) NOT NULL,
  `product_decision` enum('Y','T') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_stock_buffer`, `product_time_delay`, `product_result_sales`, `product_stock_rest`, `product_decision`) VALUES
(1, 'Mie Sedap', '>=0<=15', '2', '>=0<=30', '>=16<=25', 'T'),
(2, 'Alimie', '>=16<=25', '2', '>=31<=60', '>=16<=25', 'Y'),
(3, 'Intermie', '>=0<=15', '2', '>=61<=90', '>=26<=35', 'Y'),
(4, 'Santrimie', '>=26<=35', '2', '>=0<=30', '>=16<=25', 'T'),
(5, 'Alhamie', '>=0<=15', '5', '>=0<=30', '>=0<=15', 'Y'),
(6, 'Roti Unibis', '>=0<=15', '5', '>=31<=60', '>=16<=25', 'Y'),
(7, 'ATB Mary', '>=0<=15', '2', '>=31<=60', '>=16<=25', 'Y'),
(8, 'Hatari Kelapa', '>=0<=15', '2', '>=31<=60', '>=26<=35', 'Y'),
(9, 'Hatari Banana', '>=16<=25', '5', '>=0<=30', '>=16<=25', 'Y'),
(10, 'Roma Kelapa', '>=26<=35', '5', '>=0<=30', '>=16<=25', 'Y'),
(11, 'Richesee Ahh', '>=26<=35', '5', '>=31<=60', '>=26<=35', 'Y'),
(12, 'Momogi Jagung Bakar', '>=0<=15', '2', '>=31<=60', '>=36<=45', 'T'),
(13, 'Slai Olai', '>=16<=25', '2', '>=0<=30', '>=26<=35', 'Y'),
(14, 'Zuperr Keju', '>=26<=35', '1', '>=0<=30', '>=16<=25', 'T'),
(15, 'Fullo', '>=0<=15', '2', '>=31<=60', '>=16<=25', 'Y'),
(16, 'Tango Waffle', '>=16<=25', '2', '>=0<=30', '>=26<=35', 'Y'),
(17, 'Cholatos', '>=0<=15', '2', '>=31<=60', '>=0<=15', 'Y'),
(18, 'Gery Salut', '>=26<=35', '2', '>=61<=90', '>=36<=45', 'T'),
(19, 'Apollo Pandan', '>=16<=25', '2', '>=61<=90', '>=16<=25', 'Y'),
(20, 'Top Chocolate', '>=26<=35', '1', '>=31<=60', '>=26<=35', 'T'),
(21, 'Apolio Jumbo', '>=26<=35', '2', '>=0<=30', '>=26<=35', 'T'),
(22, 'Delux Chokies', '>=26<=35', '2', '>=31<=60', '>=26<=35', 'T'),
(23, 'Gem Bunga', '>=0<=15', '2', '>=61<=90', '>=26<=35', 'Y'),
(24, 'Good Time', '>=0<=15', '1', '>=61<=90', '>=36<=45', 'T'),
(25, 'Mizone', '>=0<=15', '1', '>=31<=60', '>=0<=15', 'T'),
(26, 'Chincau', '>=26<=35', '2', '>=31<=60', '>=16<=25', 'T'),
(27, 'Buavita', '>=0<=15', '2', '>=31<=60', '>=0<=15', 'Y'),
(28, 'Buah Sari Mangga', '>=0<=15', '1', '>=0<=30', '>=16<=25', 'T'),
(29, 'Kelapa Gading', '>=26<=35', '2', '>=31<=60', '>=26<=35', 'T'),
(30, 'Jelly Segar', '>=26<=35', '2', '>=31<=60', '>=0<=15', 'T'),
(31, 'O''cafe', '>=26<=35', '2', '>=61<=90', '>=16<=25', 'T'),
(32, 'X-Teh', '>=0<=15', '2', '>=61<=90', '>=16<=25', 'Y'),
(33, 'Oblada', '>=16<=25', '5', '>=0<=30', '>=36<=45', 'Y'),
(34, 'Fast Cola', '>=26<=35', '5', '>=0<=30', '>=26<=35', 'Y'),
(35, 'Melon Madu', '>=16<=25', '1', '>=31<=60', '>=16<=25', 'T'),
(36, 'Jeruk Marqisah', '>=26<=35', '2', '>=31<=60', '>=26<=35', 'T'),
(37, 'Ale-Ale', '>=0<=15', '2', '>=61<=90', '>=36<=45', 'Y'),
(38, 'Frutang', '>=26<=35', '2', '>=61<=90', '>=16<=25', 'T'),
(39, 'Olaga Drink', '>=26<=35', '5', '>=0<=30', '>=26<=35', 'Y'),
(40, 'Teh Pucuk', '>=26<=35', '2', '>=31<=60', '>=26<=35', 'T'),
(41, 'Guava', '>=0<=15', '2', '>=31<=60', '>=26<=35', 'Y'),
(42, 'Teh Javana', '>=26<=35', '2', '>=31<=60', '>=26<=35', 'T'),
(43, 'Sarang Burung', '>=0<=15', '1', '>=61<=90', '>=0<=15', 'T'),
(44, 'Fanta', '>=26<=35', '5', '>=0<=30', '>=36<=45', 'Y'),
(45, 'Sprite', '>=26<=35', '1', '>=31<=60', '>=36<=45', 'T'),
(46, 'Coca-Cola', '>=16<=25', '2', '>=31<=60', '>=26<=35', 'Y'),
(47, 'Milo', '>=0<=15', '2', '>=61<=90', '>=36<=45', 'Y'),
(48, 'Lasegar', '>=26<=35', '1', '>=61<=90', '>=26<=35', 'T'),
(49, 'Floridina', '>=0<=15', '1', '>=31<=60', '>=26<=35', 'T'),
(50, 'Sabun Harmoni', '>=0<=15', '2', '>=31<=60', '>=36<=45', 'T'),
(51, 'Sabun Lifeboy', '>=0<=15', '2', '>=61<=90', '>=0<=15', 'Y'),
(52, 'Sabun Nuvo', '>=16<=25', '5', '>=31<=60', '>=26<=35', 'Y'),
(53, 'Sabun RRT', '>=26<=35', '2', '>=0<=30', '>=26<=35', 'T'),
(54, 'Lifeboy Cair', '>=0<=15', '2', '>=61<=90', '>=16<=25', 'Y'),
(55, 'Lux Cair', '>=16<=25', '2', '>=61<=90', '>=26<=35', 'Y'),
(56, 'Pepsodent', '>=26<=35', '5', '>=61<=90', '>=36<=45', 'Y'),
(57, 'Close Up', '>=0<=15', '1', '>=0<=30', '>=26<=35', 'T'),
(58, 'Sensodyen', '>=26<=35', '5', '>=31<=60', '>=36<=45', 'Y'),
(59, 'Shampo Pantene', '>=0<=15', '2', '>=61<=90', '>=26<=35', 'Y'),
(60, 'Shampo Sunsilk', '>=26<=35', '2', '>=61<=90', '>=36<=45', 'T'),
(61, 'Shampo Rejoice', '>=26<=35', '5', '>=31<=60', '>=36<=45', 'Y'),
(62, 'Shampo Dave', '>=0<=15', '1', '>=31<=60', '>=36<=45', 'T'),
(63, 'Shampo Jony Andrean', '>=0<=15', '1', '>=0<=30', '>=36<=45', 'T'),
(64, 'Shampo Lifeboy', '>=0<=15', '1', '>=0<=30', '>=36<=45', 'T'),
(65, 'Shampo Clear', '>=0<=15', '2', '>=61<=90', '>=26<=35', 'Y'),
(66, 'Shampo Head&Shoulders', '>=0<=15', '2', '>=0<=30', '>=16<=25', 'T'),
(67, 'Enzim', '>=0<=15', '2', '>=0<=30', '>=36<=45', 'T'),
(68, 'Sabun Giv', '>=16<=25', '2', '>=0<=30', '>=26<=35', 'Y'),
(69, 'Dettol', '>=26<=35', '2', '>=31<=60', '>=36<=45', 'T'),
(70, 'Shampo Loreal', '>=0<=15', '2', '>=31<=60', '>=26<=35', 'Y'),
(71, 'Shampo Emeron', '>=26<=35', '2', '>=0<=30', '>=36<=45', 'T'),
(72, 'Zack', '>=26<=35', '5', '>=0<=30', '>=26<=35', 'Y'),
(73, 'Shampo Tresemme', '>=16<=25', '2', '>=61<=90', '>=26<=35', 'Y'),
(74, 'Sabun Biore', '>=0<=15', '2', '>=0<=30', '>=36<=45', 'T'),
(75, 'Sabun OK', '>=0<=15', '2', '>=0<=30', '>=0<=15', 'T'),
(76, 'Sabun Sampan', '>=26<=35', '2', '>=31<=60', '>=36<=45', 'T'),
(77, 'Sabun Gajah', '>=0<=15', '2', '>=31<=60', '>=26<=35', 'Y'),
(78, 'Daia', '>=16<=25', '2', '>=31<=60', '>=26<=35', 'Y'),
(79, 'Rinso', '>=0<=15', '1', '>=61<=90', '>=36<=45', 'T'),
(80, 'Attact', '>=0<=15', '2', '>=31<=60', '>=0<=15', 'Y'),
(81, 'Deterjen Boom', '>=26<=35', '5', '>=0<=30', '>=36<=45', 'Y'),
(82, 'Woow', '>=26<=35', '1', '>=0<=30', '>=26<=35', 'T'),
(83, 'Sabun Cream Ekonomi', '>=0<=15', '1', '>=61<=90', '>=36<=45', 'T'),
(84, 'Sabun Cream Telephone', '>=16<=25', '2', '>=61<=90', '>=36<=45', 'Y'),
(85, 'Sabun Cream Wings', '>=0<=15', '5', '>=31<=60', '>=26<=35', 'Y'),
(86, 'Sunlight', '>=0<=15', '2', '>=61<=90', '>=26<=35', 'Y'),
(87, 'Molto', '>=26<=35', '1', '>=61<=90', '>=26<=35', 'T'),
(88, 'Ultra', '>=0<=15', '2', '>=31<=60', '>=36<=45', 'T'),
(89, 'Oxyclin', '>=16<=25', '5', '>=0<=30', '>=16<=25', 'Y'),
(90, 'Sabun KH', '>=0<=15', '1', '>=0<=30', '>=0<=15', 'T'),
(91, 'Dawny', '>=26<=35', '2', '>=31<=60', '>=36<=45', 'T'),
(92, 'Sabun Total', '>=0<=15', '5', '>=31<=60', '>=36<=45', 'Y'),
(93, 'Sabun Cream Dangdut', '>=0<=15', '2', '>=31<=60', '>=36<=45', 'T'),
(94, 'Softlain', '>=26<=35', '5', '>=31<=60', '>=26<=35', 'Y'),
(95, 'Wings', '>=0<=15', '5', '>=31<=60', '>=16<=25', 'Y'),
(96, 'Mama Lemon', '>=26<=35', '2', '>=61<=90', '>=26<=35', 'T'),
(97, 'Mama Lime', '>=26<=35', '2', '>=61<=90', '>=26<=35', 'T'),
(98, 'Deterjen B29', '>=0<=15', '2', '>=31<=60', '>=26<=35', 'Y'),
(99, 'BuKrim', '>=0<=15', '1', '>=31<=60', '>=36<=45', 'T'),
(100, 'Deterjen Jaz1', '>=0<=15', '2', '>=31<=60', '>=26<=35', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_rule`
--

CREATE TABLE IF NOT EXISTS `product_rule` (
  `product_rule_id` int(11) NOT NULL,
  `product_rule_ct_id` int(11) NOT NULL,
  `product_rule_set` varchar(20) NOT NULL,
  `product_rule_value` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_rule`
--

INSERT INTO `product_rule` (`product_rule_id`, `product_rule_ct_id`, `product_rule_set`, `product_rule_value`) VALUES
(1, 1, '>=0<=15', 'Sedikit'),
(2, 1, '>=16<=25', 'Sedang'),
(3, 1, '>=26<=35', 'Banyak'),
(4, 2, '5', 'Lama'),
(5, 2, '2', 'Biasa'),
(6, 2, '1', 'Cepat'),
(7, 3, '>=0<=30', 'Low'),
(8, 3, '>=31<=60', 'Medium'),
(9, 3, '>=61<=90', 'High'),
(10, 4, '>=0<=15', 'Sangat Sedikit'),
(11, 4, '>=16<=25', 'Sedikit'),
(12, 4, '>=26<=35', 'Sedang'),
(13, 4, '>=36<=45', 'Banyak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_rule_ct`
--

CREATE TABLE IF NOT EXISTS `product_rule_ct` (
  `product_rule_ct_id` int(11) NOT NULL,
  `product_rule_ct_name` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_rule_ct`
--

INSERT INTO `product_rule_ct` (`product_rule_ct_id`, `product_rule_ct_name`) VALUES
(1, 'Minimal Stock'),
(2, 'Waktu Tunggu (Hari)'),
(3, 'Hasil Penjualan'),
(4, 'Sisa Stock');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` bigint(20) NOT NULL,
  `users_username` varchar(80) NOT NULL,
  `users_password` varchar(80) DEFAULT NULL,
  `users_name` varchar(80) DEFAULT NULL,
  `users_email` varchar(80) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`users_id`, `users_username`, `users_password`, `users_name`, `users_email`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'admin@admin.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c45_mining`
--
ALTER TABLE `c45_mining`
  ADD PRIMARY KEY (`c45_mining_id`);

--
-- Indexes for table `c45_tree`
--
ALTER TABLE `c45_tree`
  ADD PRIMARY KEY (`c45_tree_id`);

--
-- Indexes for table `prediction`
--
ALTER TABLE `prediction`
  ADD PRIMARY KEY (`prediction_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_rule`
--
ALTER TABLE `product_rule`
  ADD PRIMARY KEY (`product_rule_id`),
  ADD KEY `product_rule_ct_id` (`product_rule_ct_id`),
  ADD KEY `product_rule_ct_id_2` (`product_rule_ct_id`);

--
-- Indexes for table `product_rule_ct`
--
ALTER TABLE `product_rule_ct`
  ADD PRIMARY KEY (`product_rule_ct_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`),
  ADD UNIQUE KEY `users_username` (`users_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c45_mining`
--
ALTER TABLE `c45_mining`
  MODIFY `c45_mining_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `c45_tree`
--
ALTER TABLE `c45_tree`
  MODIFY `c45_tree_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `prediction`
--
ALTER TABLE `prediction`
  MODIFY `prediction_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `product_rule`
--
ALTER TABLE `product_rule`
  MODIFY `product_rule_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `product_rule_ct`
--
ALTER TABLE `product_rule_ct`
  MODIFY `product_rule_ct_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `product_rule`
--
ALTER TABLE `product_rule`
  ADD CONSTRAINT `product_rule_ibfk_1` FOREIGN KEY (`product_rule_ct_id`) REFERENCES `product_rule_ct` (`product_rule_ct_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
