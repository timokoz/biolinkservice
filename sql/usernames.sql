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
-- Table structure for table `usernames`
--

CREATE TABLE `usernames` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `power` varchar(10) NOT NULL DEFAULT 'Member',
  `bio` text DEFAULT NULL,
  `pfp` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cursor_url` varchar(255) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `music_url` varchar(255) DEFAULT NULL,
  `splash_text` varchar(255) DEFAULT NULL,
  `booster` tinyint(1) DEFAULT 0,
  `donator` tinyint(1) DEFAULT 0,
  `early_supporter` tinyint(1) DEFAULT 0,
  `verified` tinyint(1) DEFAULT 0,
  `discord_link` varchar(255) DEFAULT NULL,
  `telegram_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usernames`
--

INSERT INTO `usernames` (`id`, `username`, `password`, `power`, `bio`, `pfp`, `title`, `cursor_url`, `background`, `music_url`, `splash_text`, `booster`, `donator`, `early_supporter`, `verified`, `discord_link`, `telegram_link`, `instagram_link`, `twitter_link`) VALUES
(1, 'test', '1200', 'Admin', '@timokoz', '', 'test', '', '', '', 'click to enter', 1, 1, 1, 1, '', 't.me/timokoz', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `usernames`
--
ALTER TABLE `usernames`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usernames`
--
ALTER TABLE `usernames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
