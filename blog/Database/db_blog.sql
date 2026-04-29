-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 12:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `id_penulis` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `hari_tanggal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `id_penulis`, `id_kategori`, `judul`, `isi`, `gambar`, `hari_tanggal`) VALUES
(2, 2, 2, '3726 MDPL', '3726 mdpl merupakan sebuah novel karya Nurwina Sari yang diterbitkan pada tahun 2024 oleh Romancious. Novel ini berawal dari au atau Alternative Universe yang populer di kalangan pembaca daring dan kemudian dikembangkan menjadi sebuah novel lengkap. 3726 mdpl menceritakan tentang kisah perjalanan asmara mahasiswa fakultas kehutanan yang bernama Rangga Raja dan Andini Hangura. Judul novel ini diambil dari ketinggian Gunung Rinjani yang terletak di Nusa Tenggara Barat yang berjumlah 3726 meter di atas permukaan laut.', '69f193486c0d7.jpg', 'Rabu, 29 April 2026 | 12:12'),
(3, 6, 4, 'GOA Ergendang', 'Nama \"Ergendang\" sendiri berasal dari bahasa lokal yang berarti \"menabuh gendang.\" Konon, masyarakat sekitar sering mendengar suara tabuhan gendang dari dalam goa pada waktu-waktu tertentu, meskipun tidak ada yang sedang bermain musik di sana. Kejadian ini memunculkan berbagai spekulasi tentang asal-usul suara tersebut, yang kemudian menambah kesan mistis pada tempat ini. Goa ini dahulu dikenal sebagai tempat pemandian bagi putri-putri kerajaan yang berkuasa di daerah tersebut.', '69f194601c544.jpg', 'Rabu, 29 April 2026 | 12:17'),
(4, 7, 4, 'Menua Bersama', 'Menceritakan tentang kisah sepasang kekasih yang ingin menua bersama.', '69f1e2b221e73.jpg', 'Rabu, 29 April 2026 | 12:24');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_artikel`
--

INSERT INTO `kategori_artikel` (`id`, `nama_kategori`, `keterangan`) VALUES
(2, 'Novel', 'Novel adalah karangan prosa panjang yang mengandung rangkaian cerita kehidupan seseorang dengan orang di sekelilingnya yang menonjolkan watak serta sifat setiap pelaku.'),
(4, 'Komik', 'Komik merupakan kumpulan gambar atau lambang yang memiliki urutan tertentu, tujuannya untuk memberi informasi dan mencapai kesan estetis dari pembaca.'),
(5, 'Karya Ilmiah', 'Karya ilmiah merupakan dokumen tertulis yang memaparkan temuan riset melalui prosedur dan metode yang terstruktur.');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(100) NOT NULL,
  `nama_belakang` varchar(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`id`, `nama_depan`, `nama_belakang`, `user_name`, `password`, `foto`) VALUES
(2, 'Nurwina', 'Sari', 'nurwinn', '$2y$10$lIu5.bxx/gGGkezJbSkrJ.OtJ.aWGQxeKZGo0t63U0YNOtC.g7t.q', '69f0c2b4d04f1.jpg'),
(6, 'Hadric', 'Movic', 'Movicta', '$2y$10$r5j8H1Mtlpf7FswEQ6Gnu.u.uCXQBlPXWs/yYGOsljY5d.FnQwQKG', '69f193f71eaf1.png'),
(7, 'Abdi', 'Agung', 'Abed', '$2y$10$ljkJKcIKtLqSNaRlN54Vw.ClCNslZiQnx1zZCCqbdeQ95NnRBMXly', '69f1952076aac.png'),
(9, 'Bapak', 'Random', 'randomisasi', '$2y$10$n1eAvgmWUd/44dWn3F5y3uLZAoiUgH9.BYbk2XWWZRE2OalB22RkG', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artikel_penulis` (`id_penulis`),
  ADD KEY `fk_artikel_kategori` (`id_kategori`);

--
-- Indexes for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_nama_kategori` (`nama_kategori`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_artikel_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_artikel` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_artikel_penulis` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
