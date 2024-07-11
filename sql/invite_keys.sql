
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `invite_keys`
--

CREATE TABLE `invite_keys` (
  `id` int(11) NOT NULL,
  `key_value` varchar(10) NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invite_keys`
--

INSERT INTO `invite_keys` (`id`, `key_value`, `used`) VALUES
(1, 'F6L4XJTQQH', 1),
(2, 'JMT7YASAT7', 0),
(3, 'BTCTQNJZUA', 0),
(4, 'CSWJHFP8A0', 0),
(5, 'LE0XXJQ6ES', 0),
(6, 'H9GIWHQU7Q', 0),
(7, '6FUF857BY0', 0),
(8, '14TLK7OHOX', 0),
(9, 'NFDIISNETO', 0),
(10, 'OQN6YNSPPX', 0),
(11, 'OT1JRSWDZG', 0),
(12, 'SR0HXYTPLN', 0),
(13, 'DVMSC50DF8', 0),
(14, 'PWI32FB62V', 0),
(15, 'KMS17PCBN1', 0),
(16, 'C6Y68LUE8K', 0),
(17, 'PZ1EY4PWAR', 0),
(18, 'V1UFXPVDLT', 0),
(19, 'PB3YD3XZUO', 0),
(20, 'SJSJNE4U2F', 0),
(21, 'ADSLJ8Z9PD', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invite_keys`
--
ALTER TABLE `invite_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_value` (`key_value`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invite_keys`
--
ALTER TABLE `invite_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
