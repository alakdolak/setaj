-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2020 at 11:15 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abbas`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `mode` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `item_id`, `mode`) VALUES
(1, 1, 5, 1),
(2, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(76, 315, '2020-07-18 10:34:35', '2020-07-18 10:34:35'),
(77, 398, '2020-07-18 10:49:53', '2020-07-18 10:49:53'),
(78, 398, '2020-07-18 12:20:03', '2020-07-18 12:20:03'),
(79, 398, '2020-07-18 15:35:58', '2020-07-18 15:35:58'),
(80, 1, '2020-07-20 04:47:00', '2020-07-20 04:47:00'),
(81, 1, '2020-07-20 06:20:52', '2020-07-20 06:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `common_question`
--

CREATE TABLE `common_question` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `common_question`
--

INSERT INTO `common_question` (`id`, `category_id`, `question`, `answer`) VALUES
(6, 7, '<p>asdsadsaxz</p>\r\n', '<p>sadsxz</p>\r\n\r\n<p>sa</p>\r\n'),
(7, 5, '<p style=\"text-align:right\">چرا دکمه ورود به سایت برخی از مواقع کار نمی کند؟</p>\r\n', '<p>چون طبق قوانین کارستون امکان دسترسی به سایت فقط در روزهای پنجشنبه و جمعه از ساعت 9صبح تا 9شب وجود دارد و به همین علت امکان ورود به سایت در زمان هایی غیر از رمان های مذکور امکان پذیر نمی باشد.</p>\r\n'),
(8, 5, '<p>روز شمار بالای صفحه به چه معناست؟</p>\r\n', '<p>روز شمار بالای صفحه، تعداد روز و ساعت های باقی مانده به بازگشایی سایت در زمان های مذکور را می شمارد.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `change_rate` int(11) NOT NULL DEFAULT '10',
  `initial_point` int(11) NOT NULL DEFAULT '1000',
  `id` int(11) NOT NULL,
  `initial_star` int(11) NOT NULL DEFAULT '0',
  `project_limit` int(11) NOT NULL,
  `rev_change_rate` double NOT NULL,
  `service_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`change_rate`, `initial_point`, `id`, `initial_star`, `project_limit`, `rev_change_rate`, `service_limit`) VALUES
(25, 2000, 1, 0, 1, 0.04, 1);

-- --------------------------------------------------------

--
-- Table structure for table `faq_category`
--

CREATE TABLE `faq_category` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faq_category`
--

INSERT INTO `faq_category` (`id`, `name`) VALUES
(5, 'ورود به سایت'),
(6, 'انتخاب پروژه‌ها'),
(7, 'صفحه‌ی شخصی');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `name`) VALUES
(3, 'اول متوسطه'),
(4, 'دوم دبستان'),
(5, 'سوم دبستان'),
(8, 'ششم دبستان'),
(7, 'پنجم دبستان'),
(6, 'چهارم دبستان');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mode` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `item_id`, `user_id`, `mode`) VALUES
(3, 5, 1, 1),
(4, 11, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `is_me` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `msg`
--

INSERT INTO `msg` (`id`, `chat_id`, `text`, `is_me`, `created_at`, `updated_at`, `seen`) VALUES
(315, 76, 'سلام وقت بخیر', 1, '2020-07-18 10:34:35', '2020-07-18 10:34:35', 1),
(316, 76, 'سلام وقت بخیر', 1, '2020-07-18 10:34:35', '2020-07-18 10:34:35', 1),
(319, 76, 'سلام', 0, '2020-07-18 10:35:44', '2020-07-18 10:35:44', 1),
(323, 76, 'برای پروژه دوبله هنوز انیمیشن دریافت نکردیم لطفاً ارسال بفرمایید تا آقا علیرضا فرصت کافی داشته باشه', 1, '2020-07-18 10:38:48', '2020-07-18 10:38:48', 1),
(324, 76, 'متشکرم', 1, '2020-07-18 10:39:01', '2020-07-18 10:39:01', 1),
(325, 76, 'در سایت  از چند طریق امکان دانلود وجود دارد', 0, '2020-07-18 10:39:15', '2020-07-18 10:39:15', 1),
(326, 76, 'جهت راهنمایی بیشتر به فیلم آموزشی که در سایت قرار گرفته مراجعه بفرمایید', 0, '2020-07-18 10:39:39', '2020-07-18 10:39:39', 1),
(328, 77, 'من می خاهم بروم اشپزی می توانم؟', 1, '2020-07-18 10:49:53', '2020-07-18 10:49:53', 1),
(329, 77, 'سلام. متاسفانه خیر', 0, '2020-07-18 10:51:01', '2020-07-18 10:51:01', 1),
(332, 78, 'چرا؟', 1, '2020-07-18 12:20:03', '2020-07-18 12:20:03', 0),
(333, 78, 'حا لا اگر می توانیید تمام تلاش را بکنید', 1, '2020-07-18 12:21:05', '2020-07-18 12:21:05', 0),
(334, 78, 'چون من اصلا نمی توانم این کار را انجام بدهم', 1, '2020-07-18 12:21:52', '2020-07-18 12:21:52', 0),
(335, 79, 'چرا ؟', 1, '2020-07-18 15:35:58', '2020-07-18 15:35:58', 0),
(336, 79, 'حالا اگر می توانید همه ی تلاشتان را بکنید', 1, '2020-07-18 15:37:03', '2020-07-18 15:37:03', 0),
(337, 79, 'کار من در این پروزه سخت است', 1, '2020-07-18 15:37:46', '2020-07-18 15:37:46', 0),
(338, 79, 'خوا هش', 1, '2020-07-18 15:38:10', '2020-07-18 15:38:10', 0),
(339, 80, 'sad', 1, '2020-07-20 04:47:00', '2020-07-20 04:47:00', 0),
(340, 81, 'dqs', 1, '2020-07-20 06:20:52', '2020-07-20 06:20:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `star` int(1) NOT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_attach`
--

CREATE TABLE `product_attach` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_pic`
--

CREATE TABLE `product_pic` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_trailer`
--

CREATE TABLE `product_trailer` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_reg` varchar(8) NOT NULL,
  `end_reg` varchar(8) NOT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `capacity` int(11) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `title`, `description`, `price`, `created_at`, `updated_at`, `start_reg`, `end_reg`, `hide`, `capacity`) VALUES
(20, 'آموزش آشپزی', '<p style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">حتماً تا الان برنامه های زیادی در مورد آموزش آشپزی از تلویزیون دیدید، امّا تا به حال فکر کردید اگر بخواهید خودتان یک غذای خوشمزه را جلوی دوربین آموزش بدهید ، چه نکاتی را باید رعایت کنید؟در این فیلم آموزش می&zwnj;بینید تا </span></span></span></span><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">بتوانید غذایی را که نحوه&zwnj;ی پخت آن را بلد هستید به بقیه آموزش بدهید.&nbsp; </span></span></span></span></p>\r\n\r\n<hr />\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">برای اجرای هرچه بهتر این پروژه سه معیار می بایست مورد توجّه قرار بگیرد:</span></span> </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">1-آموزش قدم به قدم غذا</span></span></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">2-مناسب بودن غذای آموزش داده شده</span></span></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">3-ضبط فیلم در فضایی آرام و مناسب</span></span></span></span></p>\r\n', 0, '2020-07-16 14:12:34', '2020-07-16 14:12:34', '13990426', '13990428', 0, -1),
(21, 'هنر دوبله', '<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">دوبله یک فعّالیت هنری است که با استفاده از آن ، زبان فیلم&zwnj;های خارجی را به زبان کشور خود برمی گردانند و روی انیمیشن&zwnj;ها و موجدات کارتونی صدا می&zwnj;گذارند. در این پروژه با بعضی از فنون دوبله آشنا می شویم و می&zwnj;آموزیم که چگونه یک فیلم را دوبله کنیم.</span></span></span></span></p>\r\n\r\n<hr />\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">برای اجرای هرچه بهتر این پروژه سه معیار می بایست مورد توجّه قرار بگیرد:</span></span> </span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">1- هماهنگ بودن صدا با تصویر</span></span></span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">2- کیفیت صدا</span></span></span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">3- کلام کاملاً واضح و شمرده</span></span></span></span></p>\r\n', 0, '2020-07-16 14:38:45', '2020-07-16 14:38:45', '13990426', '13990428', 0, -1),
(22, 'ساخت زیرلیوانی', '<p dir=\"rtl\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">نمد یک نوع پارچه است که می&zwnj;توان به کمک آن کاردستی های زیادی تولید کرد. در این فیلم به شما آموزش داده می&zwnj;شود که چگونه با استفاده از قیچی، چسب و نمد یک زیر لیوانی زیبا و قابل استفاده درست کنید.</span></span></p>\r\n\r\n<hr />\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">برای اجرای هرچه بهتر این پروژه سه معیار می بایست مورد توجّه قرار بگیرد:</span></span> </span></span></p>\r\n\r\n<ol>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">درست برش دادن الگوها</span></span> </span></span></li>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">درست برش دادن نمدها با استفاده از الگو</span></span></span></span></li>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">استفاده کردن از تمام نمدهای برش خورده در جای مناسب خود</span></span></span></span></li>\r\n</ol>\r\n', 0, '2020-07-16 15:10:15', '2020-07-16 15:10:15', '13990426', '13990428', 0, 20),
(23, 'ساخت کمد کاغذی', '<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">اوریگامی هنری است که در آن با استفاده از کاغذ و تا کردن ، می&zwnj;توان کاردستی های زیبا و کاربردی درست کرد.</span></span></span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">در این پروژه هنر ساخت کاردستی هم به کمک اوریگامی آمده، تا محصول نهایی ویژه تر و جذّاب&zwnj;تر شود.</span></span></span></span></p>\r\n\r\n<p dir=\"rtl\"><span dir=\"RTL\" lang=\"AR-SA\" style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">محصولی که بعد از مشاهده ی این فیلم می توانید بسازید، کمد کاغذی زیبایی است که می توان وسایل کوچک را در آن قرار داد.</span></span></p>\r\n\r\n<hr />\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">برای اجرای هرچه بهتر این پروژه سه معیار می بایست مورد توجّه قرار بگیرد:</span></span> </span></span></p>\r\n\r\n<ol>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">شباهت محصول نهایی به الگوی موجود در فیلم شبیه باشد.</span></span></span></span></li>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">سالم بودن محصول نهایی. (پاره نبودن کاغذها)</span></span></span></span></li>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">استفاده از تمامی لوازم داده شده.</span></span></span></span></li>\r\n</ol>\r\n', 0, '2020-07-16 15:27:55', '2020-07-16 15:27:55', '13990426', '13990428', 0, 30),
(24, 'ساخت تابلوی میخ و کاموا', '<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">این پروژه ترکیبی از فعالیت نجّاری و بافتن کاموا یا نخ است . برای انجام این پروژه ، شما علاوه بر تعدادی میخ و&nbsp; یک عدد چکّش و مقداری کاموا ، به کمی علاقه ، خلّاقیت و البتّه صبر نیاز دارید. در پایان این پروژه ، یک تابلوی هنری بسیار دیدنی ، قابل ارائه می&zwnj;باشد.</span></span>&nbsp; </span></span></p>\r\n\r\n<hr />\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">برای اجرای هرچه بهتر این پروژه سه معیار می بایست مورد توجّه قرار بگیرد:</span></span> </span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">1- میخ های کوبیده شده در چوب در یک خط و هم اندازه و صاف باشند.</span></span> </span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">2-کاموا با دقّت نظر و با حوصله به دور میخ ها پیچیده شود.</span></span> </span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">3-</span></span> <span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">محصول نهایی به الگوی اوّلیه شبیه باشد.</span></span></span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n', 0, '2020-07-16 15:40:39', '2020-07-16 15:40:39', '13990426', '13990428', 0, 30),
(25, 'لوستر کاغذی', '<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">اوریگامی هنری است که در آن با استفاده از کاغذ و تا کردن، می&zwnj;توان کاردستی های زیبا و کاربردی درست کرد.</span></span></span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">در این پروژه ، هنر ساخت کاردستی هم به کمک اوریگامی آمده، تا محصول نهایی ویژه تر و جذّاب تر شود.</span></span></span></span></p>\r\n\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">محصولی که بعد از مشاهده&zwnj;ی این فیلم می توانید بسازید، لوستر کاغذی زیبایی است که از آن می&zwnj;توان به عنوان چراغ خواب استفاده کرد.</span></span></span></span></p>\r\n\r\n<hr />\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">برای اجرای هرچه بهتر این پروژه سه معیار می بایست مورد توجّه قرار بگیرد:</span></span> </span></span></p>\r\n\r\n<ol>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">شباهت محصول نهایی به الگوی موجود در فیلم.</span></span></span></span></li>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">سالم بودن محصول نهایی (پاره نبودن کاغذها)</span></span></span></span></li>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\"><span style=\"font-family:&quot;B Mitra&quot;\">استفاده از تمامی لوازم داده شده.</span></span></span></span></li>\r\n</ol>\r\n', 0, '2020-07-16 16:01:29', '2020-07-16 16:01:29', '13990426', '13990428', 0, 30),
(26, 'هنر دوبله 2', '<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\">دوبله یک فعّالیت هنری است که با استفاده از آن ، زبان فیلم&zwnj;های خارجی را به زبان کشور خود برمی گردانند و روی انیمیشن&zwnj;ها و موجدات کارتونی صدا می&zwnj;گذارند. در این پروژه با بعضی از فنون دوبله آشنا می شویم و می&zwnj;آموزیم که چگونه یک فیلم را دوبله کنیم.</span></span></span></p>\r\n\r\n<hr />\r\n<p dir=\"RTL\" style=\"margin-left:0cm; margin-right:0cm; text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\">برای اجرای هرچه بهتر این پروژه سه معیار می بایست مورد توجّه قرار بگیرد:</span> </span></span></p>\r\n\r\n<ol>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\">هماهنگ بودن صدا با تصویر</span></span></span></li>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\">مناسب بودن کیفیت ضبط</span></span></span></li>\r\n	<li dir=\"RTL\" style=\"text-align:right\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:16.0pt\">حسّ و لحن خوب</span></span></span></li>\r\n</ol>\r\n', 20, '2020-07-16 16:29:22', '2020-07-20 13:13:01', '13990426', '13990431', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `project_attach`
--

CREATE TABLE `project_attach` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_attach`
--

INSERT INTO `project_attach` (`id`, `name`, `project_id`) VALUES
(10, '1594924954Ashpazi Dore12-1.mp4', 20),
(11, '15949265261.mp4', 21),
(12, '15949265262.mp4', 21),
(13, '15949265263.mp4', 21),
(14, '15949265264.mp4', 21),
(15, '1594928416Zirlivani 01-1.mp4', 22),
(16, '1594929476Origami Dore 1 03-1.mp4', 23),
(17, '1594930239 تابلوی میخ و کاموا.mp4', 24),
(18, '1594931490Origami 01-1.mp4', 25),
(19, '15949331631.mp4', 26),
(20, '15949331632.mp4', 26),
(21, '15949331633.mp4', 26),
(22, '15949331634.mp4', 26);

-- --------------------------------------------------------

--
-- Table structure for table `project_buyers`
--

CREATE TABLE `project_buyers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_buyers`
--

INSERT INTO `project_buyers` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`, `status`) VALUES
(12, 1, 20, '2020-07-16 18:49:21', '2020-07-16 18:49:21', 0),
(13, 306, 20, '2020-07-16 18:52:34', '2020-07-16 18:52:34', 0),
(14, 330, 21, '2020-07-16 19:12:41', '2020-07-16 19:12:41', 0),
(15, 423, 24, '2020-07-16 22:36:27', '2020-07-16 22:36:27', 0),
(16, 332, 23, '2020-07-17 05:52:31', '2020-07-17 05:52:31', 0),
(17, 354, 22, '2020-07-17 06:01:02', '2020-07-17 06:01:02', 0),
(18, 298, 20, '2020-07-17 06:02:03', '2020-07-17 06:02:03', 0),
(19, 335, 22, '2020-07-17 06:07:53', '2020-07-17 06:07:53', 0),
(20, 368, 26, '2020-07-17 06:15:44', '2020-07-17 06:15:44', 0),
(21, 331, 21, '2020-07-17 06:19:36', '2020-07-17 06:19:36', 0),
(22, 392, 26, '2020-07-17 06:25:57', '2020-07-17 06:25:57', 0),
(23, 356, 22, '2020-07-17 06:26:58', '2020-07-17 06:26:58', 0),
(24, 291, 24, '2020-07-17 06:31:58', '2020-07-17 06:31:58', 0),
(25, 375, 24, '2020-07-17 06:36:19', '2020-07-17 06:36:19', 0),
(26, 336, 21, '2020-07-17 06:37:56', '2020-07-17 06:37:56', 0),
(27, 323, 22, '2020-07-17 07:05:51', '2020-07-17 07:05:51', 0),
(28, 370, 24, '2020-07-17 07:13:00', '2020-07-17 07:13:00', 0),
(30, 374, 24, '2020-07-17 07:21:32', '2020-07-17 07:21:32', 0),
(31, 295, 25, '2020-07-17 07:25:31', '2020-07-17 07:25:31', 0),
(32, 333, 21, '2020-07-17 07:38:00', '2020-07-17 07:38:00', 0),
(34, 388, 26, '2020-07-17 07:39:09', '2020-07-17 07:39:09', 0),
(35, 402, 26, '2020-07-17 07:40:50', '2020-07-17 07:40:50', 0),
(37, 364, 24, '2020-07-17 07:44:08', '2020-07-17 07:44:08', 0),
(38, 383, 25, '2020-07-17 07:46:45', '2020-07-17 07:46:45', 0),
(39, 411, 25, '2020-07-17 07:51:24', '2020-07-17 07:51:24', 0),
(40, 341, 21, '2020-07-17 08:03:13', '2020-07-17 08:03:13', 0),
(41, 297, 25, '2020-07-17 08:09:30', '2020-07-17 08:09:30', 0),
(42, 395, 25, '2020-07-17 08:19:03', '2020-07-17 08:19:03', 0),
(43, 377, 24, '2020-07-17 08:21:46', '2020-07-17 08:21:46', 0),
(44, 399, 26, '2020-07-17 08:26:31', '2020-07-17 08:26:31', 0),
(45, 409, 26, '2020-07-17 08:26:31', '2020-07-17 08:26:31', 0),
(46, 378, 24, '2020-07-17 08:27:24', '2020-07-17 08:27:24', 0),
(47, 299, 24, '2020-07-17 08:28:44', '2020-07-17 08:28:44', 0),
(48, 404, 24, '2020-07-17 08:29:30', '2020-07-17 08:29:30', 0),
(49, 380, 24, '2020-07-17 08:29:56', '2020-07-17 08:29:56', 0),
(50, 303, 26, '2020-07-17 08:30:20', '2020-07-17 08:30:20', 0),
(51, 304, 24, '2020-07-17 08:36:15', '2020-07-17 08:36:15', 0),
(52, 318, 22, '2020-07-17 08:37:15', '2020-07-17 08:37:15', 0),
(54, 398, 26, '2020-07-17 08:39:38', '2020-07-17 08:39:38', 0),
(55, 314, 22, '2020-07-17 08:40:52', '2020-07-17 08:40:52', 0),
(56, 343, 21, '2020-07-17 08:43:05', '2020-07-17 08:43:05', 0),
(57, 360, 24, '2020-07-17 08:44:29', '2020-07-17 08:44:29', 0),
(58, 382, 24, '2020-07-17 08:50:47', '2020-07-17 08:50:47', 0),
(59, 302, 25, '2020-07-17 09:02:54', '2020-07-17 09:02:54', 0),
(61, 340, 22, '2020-07-17 09:07:34', '2020-07-17 09:07:34', 0),
(62, 311, 22, '2020-07-17 09:19:38', '2020-07-17 09:19:38', 0),
(63, 309, 23, '2020-07-17 09:28:23', '2020-07-17 09:28:23', 0),
(64, 386, 25, '2020-07-17 09:35:37', '2020-07-17 09:35:37', 0),
(65, 371, 20, '2020-07-17 09:42:35', '2020-07-17 09:42:35', 0),
(66, 417, 25, '2020-07-17 09:56:00', '2020-07-17 09:56:00', 0),
(67, 361, 26, '2020-07-17 09:59:05', '2020-07-17 09:59:05', 0),
(68, 413, 24, '2020-07-17 10:01:36', '2020-07-17 10:01:36', 0),
(69, 420, 26, '2020-07-17 10:05:36', '2020-07-17 10:05:36', 0),
(70, 397, 26, '2020-07-17 10:13:30', '2020-07-17 10:13:30', 0),
(71, 403, 25, '2020-07-17 10:14:15', '2020-07-17 10:14:15', 0),
(72, 293, 24, '2020-07-17 10:21:40', '2020-07-17 10:21:40', 0),
(73, 412, 20, '2020-07-17 10:22:07', '2020-07-17 10:22:07', 0),
(74, 408, 24, '2020-07-17 10:27:10', '2020-07-17 10:27:10', 0),
(75, 328, 22, '2020-07-17 10:28:07', '2020-07-17 10:28:07', 0),
(76, 414, 24, '2020-07-17 10:36:40', '2020-07-17 10:36:40', 0),
(77, 405, 24, '2020-07-17 10:38:26', '2020-07-17 10:38:26', 0),
(78, 317, 22, '2020-07-17 10:54:27', '2020-07-17 10:54:27', 0),
(79, 346, 23, '2020-07-17 11:15:53', '2020-07-17 11:15:53', 0),
(80, 310, 20, '2020-07-17 11:25:50', '2020-07-17 11:25:50', 0),
(81, 363, 24, '2020-07-17 11:36:29', '2020-07-17 11:36:29', 0),
(82, 419, 20, '2020-07-17 11:56:39', '2020-07-17 11:56:39', 0),
(83, 387, 26, '2020-07-17 11:57:58', '2020-07-17 11:57:58', 0),
(84, 350, 20, '2020-07-17 12:08:01', '2020-07-17 12:08:01', 0),
(85, 381, 24, '2020-07-17 12:08:52', '2020-07-17 12:08:52', 0),
(86, 326, 20, '2020-07-17 12:20:30', '2020-07-17 12:20:30', 0),
(87, 416, 25, '2020-07-17 12:51:44', '2020-07-17 12:51:44', 0),
(88, 301, 24, '2020-07-17 13:12:14', '2020-07-17 13:12:14', 0),
(89, 369, 20, '2020-07-17 13:15:42', '2020-07-17 13:15:42', 0),
(90, 415, 24, '2020-07-17 13:26:24', '2020-07-17 13:26:24', 0),
(91, 327, 22, '2020-07-17 13:29:49', '2020-07-17 13:29:49', 0),
(92, 320, 20, '2020-07-17 13:44:39', '2020-07-17 13:44:39', 0),
(93, 324, 21, '2020-07-17 13:45:36', '2020-07-17 13:45:36', 0),
(94, 353, 22, '2020-07-17 13:52:25', '2020-07-17 13:52:25', 0),
(95, 379, 24, '2020-07-17 13:58:26', '2020-07-17 13:58:26', 0),
(96, 366, 20, '2020-07-17 14:03:50', '2020-07-17 14:03:50', 0),
(97, 394, 26, '2020-07-17 14:20:22', '2020-07-17 14:20:22', 0),
(98, 339, 21, '2020-07-17 14:36:40', '2020-07-17 14:36:40', 0),
(99, 348, 20, '2020-07-17 14:57:41', '2020-07-17 14:57:41', 0),
(100, 294, 24, '2020-07-17 15:06:45', '2020-07-17 15:06:45', 0),
(101, 367, 20, '2020-07-17 15:14:53', '2020-07-17 15:14:53', 0),
(102, 308, 20, '2020-07-17 15:49:07', '2020-07-17 15:49:07', 0),
(103, 396, 24, '2020-07-17 16:05:05', '2020-07-17 16:05:05', 0),
(104, 315, 21, '2020-07-17 16:09:45', '2020-07-17 16:09:45', 0),
(105, 401, 26, '2020-07-17 16:44:58', '2020-07-17 16:44:58', 0),
(106, 292, 25, '2020-07-17 17:03:18', '2020-07-17 17:03:18', 0),
(107, 342, 21, '2020-07-17 17:03:50', '2020-07-17 17:03:50', 0),
(108, 362, 26, '2020-07-17 17:06:51', '2020-07-17 17:06:51', 0),
(109, 389, 24, '2020-07-17 17:29:44', '2020-07-17 17:29:44', 0),
(110, 300, 26, '2020-07-17 17:37:18', '2020-07-17 17:37:18', 0),
(111, 344, 20, '2020-07-17 18:35:34', '2020-07-17 18:35:34', 0),
(112, 393, 25, '2020-07-17 18:41:09', '2020-07-17 18:41:09', 0),
(113, 325, 22, '2020-07-17 19:40:28', '2020-07-17 19:40:28', 0),
(114, 400, 20, '2020-07-17 20:16:54', '2020-07-17 20:16:54', 0),
(115, 307, 23, '2020-07-18 04:32:35', '2020-07-18 04:32:35', 0),
(116, 352, 21, '2020-07-18 05:43:01', '2020-07-18 05:43:01', 0),
(117, 376, 26, '2020-07-18 06:44:56', '2020-07-18 06:44:56', 0),
(118, 290, 20, '2020-07-18 06:51:17', '2020-07-18 06:51:17', 0),
(119, 316, 22, '2020-07-18 07:29:43', '2020-07-18 07:29:43', 0),
(120, 355, 21, '2020-07-18 07:55:06', '2020-07-18 07:55:06', 0),
(121, 390, 26, '2020-07-18 07:57:32', '2020-07-18 07:57:32', 0),
(122, 365, 20, '2020-07-18 08:19:31', '2020-07-18 08:19:31', 0),
(123, 391, 26, '2020-07-18 08:34:28', '2020-07-18 08:34:28', 0),
(124, 296, 26, '2020-07-18 09:09:04', '2020-07-18 09:09:04', 0),
(127, 319, 20, '2020-07-18 09:54:15', '2020-07-18 09:54:15', 0),
(128, 424, 24, '2020-07-18 10:17:45', '2020-07-18 10:17:45', 0),
(129, 351, 22, '2020-07-18 11:10:19', '2020-07-18 11:10:19', 0),
(130, 349, 22, '2020-07-18 12:42:01', '2020-07-18 12:42:01', 0),
(131, 334, 23, '2020-07-18 15:08:20', '2020-07-18 15:08:20', 0),
(132, 410, 26, '2020-07-18 15:44:07', '2020-07-18 15:44:07', 0),
(133, 337, 22, '2020-07-18 15:50:23', '2020-07-18 15:50:23', 0),
(134, 312, 22, '2020-07-18 16:08:11', '2020-07-18 16:08:11', 0),
(135, 421, 25, '2020-07-18 16:47:02', '2020-07-18 16:47:02', 0),
(136, 372, 20, '2020-07-18 18:54:36', '2020-07-18 18:54:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_grade`
--

CREATE TABLE `project_grade` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_grade`
--

INSERT INTO `project_grade` (`id`, `project_id`, `grade_id`) VALUES
(27, 20, 3),
(28, 20, 4),
(29, 20, 5),
(30, 20, 8),
(31, 20, 7),
(32, 20, 6),
(33, 21, 4),
(34, 21, 5),
(35, 22, 4),
(36, 22, 5),
(38, 23, 5),
(39, 24, 3),
(40, 24, 8),
(41, 24, 7),
(42, 24, 6),
(43, 25, 3),
(44, 25, 8),
(45, 25, 7),
(46, 25, 6),
(47, 26, 3),
(48, 26, 8),
(49, 26, 7),
(50, 26, 6),
(51, 23, 4);

-- --------------------------------------------------------

--
-- Table structure for table `project_pic`
--

CREATE TABLE `project_pic` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_pic`
--

INSERT INTO `project_pic` (`id`, `name`, `project_id`) VALUES
(29, '15949249541.jpg', 20),
(30, '15949249543.jpg', 20),
(31, '15949249544.jpg', 20),
(32, '15949249545.jpg', 20),
(33, '15949265261.jpg', 21),
(34, '15949265262.jpg', 21),
(35, '15949265263.jpg', 21),
(36, '15949265264.jpg', 21),
(37, '15949284151.jpg', 22),
(38, '15949284152.jpg', 22),
(39, '15949284153.jpg', 22),
(40, '15949284154.jpg', 22),
(41, '15949294751.jpg', 23),
(42, '15949294752.jpg', 23),
(43, '15949294753.jpg', 23),
(44, '15949294754.jpg', 23),
(45, '15949302391.jpg', 24),
(46, '15949302392.jpg', 24),
(47, '15949302393.jpg', 24),
(48, '15949302394.jpg', 24),
(49, '15949314891.jpg', 25),
(50, '15949314896.jpg', 25),
(51, '15949314897.jpg', 25),
(52, '15949314898.jpg', 25),
(57, '15952669823.png', 26),
(58, '159526698233.png', 26),
(59, '159526698234.png', 26),
(60, '1595266982قیمه.png', 26);

-- --------------------------------------------------------

--
-- Table structure for table `project_tag`
--

CREATE TABLE `project_tag` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_tag`
--

INSERT INTO `project_tag` (`id`, `tag_id`, `project_id`) VALUES
(15, 1, 20),
(17, 2, 21),
(18, 3, 22),
(19, 3, 23),
(20, 3, 24),
(21, 3, 25),
(22, 2, 26);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `star` int(11) NOT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `title`, `description`, `star`, `hide`, `created_at`, `updated_at`, `capacity`) VALUES
(10, 'تست2', '<p dir=\"rtl\">در این پروژه&zwnj;ی همیاری، مدرسه سراج از شما دعوت می کند تا برای طرح کارستون تبلیغ بسازید.</p>\r\n\r\n<p dir=\"rtl\">دانش آموزان سراجی با دیدن تبلیغ شما بیش از پیش تشویق می شوند تا در این طرح مشارکت جدّی تر و پر شور تری داشته باشند و کیفیت محصولات خود را برای درآمد زایی بیشتر، بهتر کنند.</p>\r\n\r\n<p dir=\"rtl\">پیشنهاد می کنیم&nbsp; فیلم زیر را ببینید تا&nbsp;بیشتر در مورد نحوه انجام و ساخت تبلیغات آشنا شوید.</p>\r\n\r\n<hr />\r\n<p dir=\"rtl\">ما همین ابتدای کار، روی همیاری شما حساب باز کردیم...&nbsp;</p>\r\n\r\n<p dir=\"rtl\">شما هم روی قول ما برای دریافت یکی دو عدد ستاره&zwnj;ی درخشان حساب باز کنید.&nbsp;<img alt=\"laugh\" src=\"https://cdn.ckeditor.com/4.10.1/full/plugins/smiley/images/teeth_smile.png\" style=\"height:23px; width:23px\" title=\"laugh\" /></p>\r\n', 4, 0, '2020-07-16 18:39:38', '2020-07-20 13:42:32', 100);

-- --------------------------------------------------------

--
-- Table structure for table `service_attach`
--

CREATE TABLE `service_attach` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_attach`
--

INSERT INTO `service_attach` (`id`, `service_id`, `name`) VALUES
(2, 10, '159494097815-1.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `service_buyer`
--

CREATE TABLE `service_buyer` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `star` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_buyer`
--

INSERT INTO `service_buyer` (`id`, `service_id`, `user_id`, `status`, `star`) VALUES
(8, 10, 1, 0, 0),
(9, 10, 385, 1, 2),
(10, 10, 423, 0, 0),
(11, 10, 392, 0, 0),
(12, 10, 354, 0, 0),
(13, 10, 335, 0, 0),
(14, 10, 298, 0, 0),
(15, 10, 331, 0, 0),
(16, 10, 291, 0, 0),
(17, 10, 336, 0, 0),
(18, 10, 323, 0, 0),
(19, 10, 364, 0, 0),
(20, 10, 295, 0, 0),
(21, 10, 374, 0, 0),
(22, 10, 322, 0, 0),
(23, 10, 345, 0, 0),
(24, 10, 388, 0, 0),
(25, 10, 333, 0, 0),
(26, 10, 347, 0, 0),
(27, 10, 402, 0, 0),
(28, 10, 398, 0, 0),
(29, 10, 360, 0, 0),
(30, 10, 409, 0, 0),
(31, 10, 380, 0, 0),
(32, 10, 318, 0, 0),
(33, 10, 299, 0, 0),
(34, 10, 303, 0, 0),
(35, 10, 311, 0, 0),
(36, 10, 371, 0, 0),
(37, 10, 420, 0, 0),
(38, 10, 317, 0, 0),
(39, 10, 314, 0, 0),
(40, 10, 326, 0, 0),
(41, 10, 397, 0, 0),
(42, 10, 416, 0, 0),
(43, 10, 324, 0, 0),
(44, 10, 353, 0, 0),
(45, 10, 367, 0, 0),
(46, 10, 315, 0, 0),
(47, 10, 396, 0, 0),
(48, 10, 300, 0, 0),
(49, 10, 389, 0, 0),
(50, 10, 342, 0, 0),
(51, 10, 343, 0, 0),
(52, 10, 297, 0, 0),
(53, 10, 304, 0, 0),
(54, 10, 417, 0, 0),
(55, 10, 290, 0, 0),
(56, 10, 413, 0, 0),
(57, 10, 390, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_grade`
--

CREATE TABLE `service_grade` (
  `id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_grade`
--

INSERT INTO `service_grade` (`id`, `grade_id`, `service_id`) VALUES
(13, 3, 10),
(14, 4, 10),
(15, 5, 10),
(16, 8, 10),
(17, 7, 10),
(18, 6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `service_pic`
--

CREATE TABLE `service_pic` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_pic`
--

INSERT INTO `service_pic` (`id`, `service_id`, `name`) VALUES
(8, 10, '15952687523.png'),
(9, 10, '159526875233.png'),
(10, 10, '159526875234.png'),
(11, 10, '1595268752قیمه.png');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'آموزشی'),
(2, 'سرگرمی'),
(3, 'هنری'),
(5, 'ورزشی');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `follow_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `nid` varchar(10) DEFAULT NULL,
  `level` int(1) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `phone_num` varchar(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` varchar(100) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  `grade_id` int(11) DEFAULT NULL,
  `stars` int(11) NOT NULL DEFAULT '0',
  `super_active` tinyint(1) NOT NULL DEFAULT '0',
  `pic` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `nid`, `level`, `updated_at`, `remember_token`, `phone_num`, `status`, `created_at`, `money`, `grade_id`, `stars`, `super_active`, `pic`) VALUES
(1, 'admin', '$2y$10$dliGAOnjCie3VWaLPDZQ7uSvSa5f4CiVAMXHf71QNNOkYTmw5N92u', 'محمد', 'قانع', '0018914372', 3, '2020-07-16 12:49:28', 'Uukun6Iwkh5tQHUzqgaD3jT3m764ozox9GEDfCkKtN2R6i2DmanjlunYohUR', '09214915905', 1, '', 2000, 4, 0, 0, NULL),
(290, 'D1.1.adhamian', '$2y$10$ZE3GObBf6TKj2QqlrNMIpOhBv1f./cAcbZSGX9B0qJ54kBZ2pwsCS', 'ماهان', 'ادهمیان', '0441589146', 1, '2020-07-16 18:22:09', 'JafG33ciZBWQxRNhJ7wr6tnbKrbVKxhHTs0dbN9EeS6gyTHeDegN8BoWm3q5', '', 1, '2020-07-16 18:22:09', 2000, 3, 0, 0, '1_01.png'),
(291, 'D1.2.behbahani', '$2y$10$QeOcPYdaRKUqzY7i0PcTHeH1bPZ0DBOqRof/hWdknHT0u89xTOJxq', 'سیدحسین', 'بهبهانی', '0441584497', 1, '2020-07-16 18:22:09', '2m2CW8YMMpcvSfTuXR82MjP1iRobFPdiAC9ldCb4gF2aNg8CwbvJkAeTZ1Du', '', 1, '2020-07-16 18:22:09', 2000, 3, 0, 0, '1_02.png'),
(292, 'D1.3.hoseini', '$2y$10$0dx3fpK9SQNRoHjrPHwWzuCFyErSI4xxZWEdUzKCcHUvQ4jXE2kOi', 'سیدابوالفضل', 'حسینی', '0151739374', 1, '2020-07-16 18:22:09', '3UZScNoEk9DX0Km9optkzndc3HC9AVH8sAhAVrttbbWUP7QAmxb8pgQQjR3R', '', 1, '2020-07-16 18:22:09', 2000, 3, 0, 0, '1_03.png'),
(293, 'D1.4.kharaghani', '$2y$10$1wGyR1MEt/bjBR1tLBrOUuX2u1PY4WyHHqSLi4Yt4.GmKV5ZC3TMa', 'حسین', 'خرقانی', '0026220245', 1, '2020-07-16 18:22:10', 'WqQyNFga974D4Xys8NPO8DAeN0fWFrsy429diX0V9LqWeJO6aXRCf3v55t9H', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_04.png'),
(294, 'D1.5.ziar', '$2y$10$kTror/z43VAlnzos9rzZAed8skGum3Pc19N6DwqwoGK7Mr.bZ3/du', 'محمدطاها', 'زیار', '0441645852', 1, '2020-07-16 18:22:10', 'H1dStTMMecOH1uqLPuyKi8r8SXZqCHy3HfYdWlDTFScWoW01t9NsvzmP1HzL', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_05.png'),
(295, 'D1.6.noori', '$2y$10$UNY1WHmdf7opT2btbJziS.Di6nx.o3NphqNOZRbXKqKGXVGgbOgCG', 'سیدحسین', 'سلاله نوری', '0151457761', 1, '2020-07-16 18:22:10', 'OcfhgarU0CAK3MSUfJgAMOxN0JBj210JWA1DrNemV93VxYRFYYz0ZMvQWCI8', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_06.png'),
(296, 'D1.7.soltanizad', '$2y$10$nmfUq7pIVeKmyQeGQEZaKuP5wqcdZgrUq2FOPcXHNEjv2rHwgkYwu', 'امیرعلی', 'سلطانی زاد', '0441599222', 1, '2020-07-16 18:22:10', 'xR3SMceETQ0nSLeOCgsCE67PGxgzjLa87pDNA3b1xeNnIdP6UACI2zaxEfpP', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_07.png'),
(297, 'D1.8.sadeghi', '$2y$10$lsXQEUGo51rcZz6eYIcpi.KROyITl.4vEKUnqjKb3ITcTLbC71cGS', 'محمدمهدی', 'صادقی', '0441553540', 1, '2020-07-16 18:22:10', 'WIFNEY3GsspLpqgpzQLq3JPgB28v0RTPXHQkFqEYG4n9Sz5vq713W15vgsfe', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_08.png'),
(298, 'D1.9.safadoost', '$2y$10$rf.6eUt94v5e05YZyQnSJOez12jZ64SoxzaDuhfQ2XdJ57NbFtNzW', 'علیرضا', 'صفادوست', '0250894734', 1, '2020-07-16 18:22:10', 'in96KiWgmGp90pmKdjkIKzMGreHlWf1tJya9boXNnDokS3PxxWRjJv7e3boP', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_09.png'),
(299, 'D1.10.taherian', '$2y$10$z8ZYs4QC6thpR/eGcPpNJuaU8QM4kHWZyhUSFzbGnWSOnA0k.R6HG', 'امیرمهدی', 'طاهریان', '0441600638', 1, '2020-07-16 18:22:10', 'zRk0QJl9rpu2x2zfj8P80xYAb1gGuzpwP1S9kx71MHAYeTBNCwHVKV7mj2eq', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_10.png'),
(300, 'D1.11.abdollahi', '$2y$10$tg8xANHlkRpduleqsP0n1eEpHgqTB96j35ryRufKwnOES9Nubmwfu', 'محمدمهدی', 'عبدالهی', '0441566383', 1, '2020-07-16 18:22:10', '5d5zMjfYYWNNfPQSXY2NBLbNi1szpgPHxvvX3lKFRmKA0NUOPnUDCHOi4YpZ', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_11.png'),
(301, 'D1.12.kayal', '$2y$10$xOvr60baWW9VCuv44IgO0u.gq1w3ybzJqK3eQ5ghBl7qWkpKGPEMW', 'سجاد', 'كیال', '0441563643', 1, '2020-07-16 18:22:10', 'dZTFLwJqoAghCcmrHtf5oDCeeZSbzidbqarNbtMKD2A8wsJTZCIRoMUv3633', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_12.png'),
(302, 'D1.13.moradi', '$2y$10$Mtv8sEiYZnWcc260HdQZK.HFBhGrwuMeslUG/J2vY9tbaj/Yqmqay', 'محمدحسن', 'مرادی', '0251033228', 1, '2020-07-19 11:50:20', 'OSJjKIJNi8V2pSwGvR0dU3YkZMDzI71F2y5B0XgWlrV8sb1M29zWvbHldNpk', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_13.png'),
(303, 'D1.14.moshkelgosha', '$2y$10$sNiKBs0RHh1C/I1dSsPWLehLwQxzWFrTPPG/sR0V9NmzjF.ouaOVC', 'محمدعرفان', 'مشكل گشاء', '0441591523', 1, '2020-07-16 18:22:10', 'mqgaoM9Ux6ktAwoCEVleyPCxG97gXFD1kijYz8gjUGPGZmzt1Uer6y6RVSnF', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_14.png'),
(304, 'D1.15.hashemi', '$2y$10$8ZzbCfVRmSWcZ1tr1Y2RgOhSCU3pChV4RURUYLdUGEd1isZ0d96FK', 'سهیل', 'هاشمی', '0441531865', 1, '2020-07-16 18:22:10', 'R7pZofsUNxuVU328HAlJ0NubjEYTH1nbT4kPp7YxUJlM2QzWF5XkXhKsmd7Q', '', 1, '2020-07-16 18:22:10', 2000, 3, 0, 0, '1_15.png'),
(305, 'test1', '$2y$10$eSbPYX7ornJ5CCm3LMDLleZy7goiFr7Gpjw43YNWssyGlWxSDLd2W', 'تست', 'تست', '123456', 1, '2020-07-16 22:19:59', '7KtiEujYJJeO5HqTQFETndDnBOCGaiNnwQvu6xP5CqixzvZ0ZptbAM0h4C4U', '', 1, '2020-07-16 18:22:11', 2000, 3, 0, 0, '1.png'),
(306, 'test2', '$2y$10$.B2rQlL4ZoUGYZ6Ys/QgouxxV9qSHQi/hKewM4dlcsY5P/Nt/rCq2', 'تست2', 'تست2', '123456', 1, '2020-07-16 18:28:02', 'rNfpKVGuZQUSGKBJlWxkFodfkDfXl3tfW15vR89Fm1KwpOHiuFXOdPhdVJwg', '', 1, '2020-07-16 18:22:11', 2000, 3, 0, 0, '2.png'),
(307, 'D6.1.ebrahimi', '$2y$10$PdVDNterPhtjfeXF9CTFruKqa7XCRfq2cw7bD.ZIwJU4E/1hfZ.UO', 'محمدطاها', 'ابراهیمی', '0442109441', 1, '2020-07-16 21:15:43', 'duV8vAY8PHNwpsHpr86DvvLMVg8R9TSdLCyqSKn6dF9Lo91XKOF6V3vHledg', '', 1, '2020-07-16 18:23:17', 2000, 4, 0, 0, '6_01.png'),
(308, 'D6.2.etedal', '$2y$10$aJP5kyCgjSgFCmtrd.sb/uIln68kHp8hd9ZLBBuguPilKRgXNgYcG', 'علی', 'اعتدال منفرد', '0441969879', 1, '2020-07-16 18:23:17', '7LY5Y1jEM51mwHCmMLs7iNZ1ytEEpNNW1XhXN38sXq3X1UVPIgcniKJnU4Xk', '', 1, '2020-07-16 18:23:17', 2000, 4, 0, 0, '6_02.png'),
(309, 'D6.3.basamtabar', '$2y$10$GK1bWi.6sD9KIWPnMNVwQe6lAQXed.GF8CASA8SAIHjwQlwA65nJ2', 'سیدمحمدحسین', 'بصام تبار', '0026818043', 1, '2020-07-16 18:23:17', '9RtXh7Wc8lvRvKuG9MwtucaV4tapHuYxUl6NFyekRj673zYFBxI7ididLZQX', '', 1, '2020-07-16 18:23:17', 2000, 4, 0, 0, '6_03.png'),
(310, 'D6.4.banitaba', '$2y$10$3i1gaXY7/E6IygiT7.WUUuTi69LIP9pnfECY6fUwjBTMKYR2YFnSa', 'سیدطاها', 'بنی طبا', '0442044811', 1, '2020-07-16 18:23:18', 'k8X4q0AERNO3L81VPtXlGF7OB6RIidrXWXjfBBerlgFTL2pCb8LCx983UYRi', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_04.png'),
(311, 'D6.5.hasankhani', '$2y$10$ZqyAeqcHTe3ioJKprwHzL.HKhNjFxyK7Ma9IyNeD9Gy.Cn.4C097O', 'علی', 'حسن خانی', '0442016107', 1, '2020-07-16 18:23:18', 'pcvv4xKLsC6bL9a06IoZwnw6mXPDGuJh49RdRbsUu6scAZgmUodTcC0IGwEE', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_05.png'),
(312, 'D6.6.khojasteh', '$2y$10$X9Px3GxOFmtXehmx1oObROmVLbmRP5H3j.SbPQRfHMl/3qUdH7/O2', 'محمدحسین', 'خجسته خدابنده لو', '0442045832', 1, '2020-07-16 18:23:18', 'qSvCDJhfaxwU5xVkgfm0ksOKR2w5zdHNxOgjUSJMsXRCQxPrlLX40Qv2HbAC', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_06.png'),
(313, 'D6.7.khatibi', '$2y$10$YjZjzMuOZRzmAt0aBpYlWOt6STJYSb3e3v67WGtWgtdaezyV8JnfO', 'علی', 'خطیبی', '0252049391', 1, '2020-07-16 18:23:18', 'SRVKuSvYN1vVP0HzUauXGLmLKKvXJQnsOujiixShhDDAGO8u0A5FkHXVQMi6', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_07.png'),
(314, 'D6.8.dezfooli', '$2y$10$snAZDmA0KQYcw3as27IZd.pCfs26F2ffV8f.eh1wTy0H0LtmssV92', 'محمدعلی', 'دزفولی', '0442062281', 1, '2020-07-16 18:23:18', '0l0UjRbmiBz8CZa3jEzmMNZQuSZgnghC7sVgWZPLmOD309jRJCtF00gL1HSg', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_08.png'),
(315, 'D6.9.zargari', '$2y$10$kHQzgy58Hhriu8n3WGIR3OibUfGpvZdacnmOk3H5VsMtdJRrH27Hu', 'علیرضا', 'زرگری', '0442098790', 1, '2020-07-16 18:23:18', 'lktykouVTy6XfxhmBqruXvP64cURWIeMJHbFnyt1m9AF3JRcaAAk5umjMRhk', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_09.png'),
(316, 'D6.10.sadeghi', '$2y$10$PpVDOyoCdSwbT.UMEHZ5lOYa9ol8Ub7dShjAC4jYCg9H4seDTw1vC', 'سیدامیرعلی', 'سجادصادقی', '0251874151', 1, '2020-07-16 18:23:18', 'ixrDmEtoLEtusLFlneF8CieTZwkdrelPTV9KHfazAqzt8D5eMQMjxOoBDLRS', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_10.png'),
(317, 'D6.11.soleimani', '$2y$10$iURddNp.y3Wdr0JVgyWdOedtNmjyYsg5R/VNxYtg4hnic7.BaJwEW', 'علی', 'سلیمانی', '0442130538', 1, '2020-07-16 18:23:18', 'WPdRcqkJMXSrl6afW73DX4aHEx03bjttdwZNsmUi1GIa8zQpQW3QO9eI9Z7j', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_11.png'),
(318, 'D6.12.seyyedifar', '$2y$10$PGEtGMM.u8Xv5/z9Zu2sBeghT.KklaJrDqAtT3wEQB4vSoUjUSuR2', 'محمدسجاد', 'سیدی فر', '0442103514', 1, '2020-07-16 18:23:18', '61Q9BfUreK0uoGJRG77ASpQQhqIP2Q97UkobLbuFeGZTr2TzUMLJlN3GjwPL', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_12.png'),
(319, 'D6.13.safavi', '$2y$10$IfXOKt7z7t62y//Ra.pb4ODC3BOkMHz6QF1labbLEFCHtYfn2Vm/m', 'سیدحسین', 'صفوی', '4712372011', 1, '2020-07-16 18:23:18', 'laRNdyJ2WKGm1PySqCdHsiusOLAbrt5DP2sK6uSCYdsaiAGdXI3bkRgsoA5H', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_13.png'),
(320, 'D6.14.taheri', '$2y$10$R7mi7fk6Fi7gner3sN.2POXV8KZIZPMRLOAHIfg8wRMcKDHXLR51.', 'توحید', 'طاهری', '0442091796', 1, '2020-07-16 18:23:18', 'RFyS27d6ACMRshIk6JMdFqkdzjATDwaRPHBbJCBizT6ZS6vjkw4omdhgmlT1', '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_14.png'),
(321, 'D6.15.nikfarjam', '$2y$10$rYGRim.Zv7Yv4eGU72LLpeShqVp0xe/53ENpx4EF1GeL.2SBdDCJW', 'حسین', 'نیك فرجام', '0442087160', 1, '2020-07-16 18:23:18', NULL, '', 1, '2020-07-16 18:23:18', 2000, 4, 0, 0, '6_15.png'),
(322, 'D6.16.mahmoodi', '$2y$10$OljYsGc0UuL5cBO9GHu6eOE6Txtvt00TrX8J2yVGUgdg06vblek0a', 'امیرحسین', 'محمودی', '0442031378', 1, '2020-07-16 18:23:19', 'FGLFkfZFdizYmZuCsoFVbBPhWijRG6lrlvvdugDlLrMNDVjA3yC6J480nI1Y', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '6_16.png'),
(323, 'D6.17.motahhari', '$2y$10$al9eWJDTXJK1HAM.3ucDc.bubAo5h.TIJyi9cs3zG80SXJIik.8X6', 'محمدصدرا', 'مطهری فریمانی', '0442003242', 1, '2020-07-16 18:23:19', 'ZJBvwTQVDWAKsiS3LPmq9GtuFReb9jBM6bvNUgAwgZ6LYYEpd5fUC6ClOxLa', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '6_17.png'),
(324, 'D6.18.motazedi', '$2y$10$.5P/rAl4QD6xBN9Qe/3H.OJ.nHvc1X1kjpTKngjx7dzh9YXTCIG9O', 'سیدامیرحسین', 'معتضدی', '0442020538', 1, '2020-07-16 18:23:19', 'mYs9VaWlJBscu26Cy1cWw5PBIzLdBcO1hEy8T9eamQBO9dPM1YX16Ai8OnPc', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '6_18.png'),
(325, 'D6.19.maghsoodi', '$2y$10$QjnvQgi1FLkAoaUSYFvkrOWy2mt8yqJpP/y8xu9H2vLoCeGLGwSCm', 'سیدعلی', 'مقصودی', '0442087799', 1, '2020-07-16 18:23:19', 'BBTao8iB5OjxVhl1F2cW6pyi7RKOgipoWK0AdlZgIKaOl9TiEdcIeTtlSVtO', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '6_19.png'),
(326, 'D6.20.najjari', '$2y$10$ANmTeeElmxOqFr4axjotQu1IHH69WGCH4J1UYJev8v4zJvIislFUe', 'علی', 'نجاری', '0442042167', 1, '2020-07-16 18:23:19', 'q0LifIhDlg4jVU8EtZhpAmO6AdgDFh3TSUDCTMom7dOiZDShvBrREsYtgahg', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '6_20.png'),
(327, 'D6.21.nikbakhtian', '$2y$10$K13A4QbH1Vg8Eg20BPQ6nekXfV/G4EADnJdB0pYeZ41.Tiec8zOk6', 'محمدحسین', 'نیك بختیان', '0251824152', 1, '2020-07-16 18:23:19', 'jYFQ3HpgLjaoMOvqtp9Kwz6geQmZEFE7H4jgVwmkgHZhhRWzsWKNq71Kj43U', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '6_21.png'),
(328, 'D6.22.velayati', '$2y$10$pi4cs/0FJu9I5bbFXeS1q.BRqag8YQe3Pmd0kECPvWP3fbJDhIKgq', 'محمدحسین', 'ولایتی', '0442101821', 1, '2020-07-16 18:23:19', 'ZPEmVJVdPW1eP4CteHcl7dYmRWD3TDaRvLPRIb4xE5PO6ECDUm5Bmboh9ofh', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '6_22.png'),
(329, 'test3', '$2y$10$8IhseuKhbZdTMgMUiRBTT.ONpcxTBJoxGBlY2UF1l7oHCpJ/QIQsW', 'تست', 'تست', '123456', 1, '2020-07-16 18:23:19', 'fdJtG5HJ8nG0OrgovUDmJoTopvcuc7yzVcDCoZsiwRe4F7djiGjS4rk0EPbN', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '1.png'),
(330, 'test4', '$2y$10$p3VdLsN.pkZD0Nd3hUrPfuIqgnxcgGaWIu6WBjxTCGZWdnir8dM9K', 'تست', '2 تست2', '123456', 1, '2020-07-16 18:27:26', 'MRhTECjXtSixTU5ZVEC7RImh8XQnLlJkNZfA8AxXaEnWmlOUBEg7yBk7CF8p', '', 1, '2020-07-16 18:23:19', 2000, 4, 0, 0, '2.png'),
(331, 'D5.1.abrishamkar', '$2y$10$.Aed70PVU4Dr7KRW3/29CeJoywZWZOVVFbETFJjlI0MniDYTfcHH6', 'ابوالفضل', 'آل ابریشم كار', '0251598527', 1, '2020-07-16 18:24:04', '7HfJfhDbKEFn6OFxqLVdZ2mw7ItVPWjdXN3mzrcwYhpFzjbvonDD3MwuVKYJ', '', 1, '2020-07-16 18:24:04', 2000, 5, 0, 0, '5_01.png'),
(332, 'D5.2.babaee', '$2y$10$sMuthJ7yIv.nqVbNnJ8RwO.cNL4uGytR/zq5nD3Z2Vl7HeHbCy.Hu', 'علی', 'بابائی نژاد', '0441964400', 1, '2020-07-16 18:24:04', 's2xEz029UbyHJOgbXSFSKMnl7wajP2bgz5UyzK9LBuqchqUgtzAHmWKWBbxE', '', 1, '2020-07-16 18:24:04', 2000, 5, 0, 0, '5_02.png'),
(333, 'D5.3.mh.bagheri', '$2y$10$IUndH3cxcAP5CEqDQSvK2e/EbSoIzwTADimaU0PwSemf/Si2J42IK', 'سیدمحمدحسین', 'باقری', '0441943268', 1, '2020-07-16 18:24:04', 'vSnPKsn41TceVympEpNLNZOeeiWvfQgrVrYqxwFQ9PVE3KNKGOpXyjj3mPbQ', '', 1, '2020-07-16 18:24:04', 2000, 5, 0, 0, '5_03.png'),
(334, 'D5.4.ma.bagheri', '$2y$10$irWguNq7DQxDjBGOQVGmBeObwpKHzkawQLh9swiNcDO5T5sUZTgqy', 'محمدامین', 'باقری', '0152882138', 1, '2020-07-16 18:24:05', 'cqvu1jBtC4DQOkrvv5jc4erhwq01ij4UqzfKvBqKUGL6Ze7n9GZOx5Diwz6y', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_04.png'),
(335, 'D5.5.bakhtiaripoor', '$2y$10$1d0wzk1PstPbnknE/mfl5uGBE1MABFMTnPN8R7DxIqKisJAj61xJK', 'علی', 'بختیاری پور', '0442001282', 1, '2020-07-16 18:24:05', 'RkmMWcgPl81ld60JbQh77ZA5B3x1dg0mSTFOc6oGcwGHGDp0khoQf4l0DYfn', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_05.png'),
(336, 'D5.6.behbahani', '$2y$10$CtnhFWBBkHmUO7XZmnHn1OPBUornLCqJBtNQYrSZ7NKzmGcBIZTxq', 'سیدمهدی', 'بهبهانی', '0442042809', 1, '2020-07-16 18:24:05', '2HtH0ltShMY2CpEIHEgUvg8D2ZFoPnbZVA2hPp81QmOetQIzrV0jXoiofTr1', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_06.png'),
(337, 'D5.7.tajik', '$2y$10$IqWZfwssREf/2RPkB2YqNOcYwz3FuOFF/awO9DN/resNdUHDJM9JG', 'محمدحسین', 'تاجیک', '0441972535', 1, '2020-07-16 18:24:05', 'a39i15CbJkmFjF19sbUQ84DKw4x4fG6wMspCClB06dnjLXJC19Zpp4CckK8x', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_07.png'),
(338, 'D5.8.hajkazemian', '$2y$10$RsC8TCnWyx3na7IPtzHkEuraFfyat5CHefZZEferojblFuDZvtnDq', 'محمدعلی', 'حاج کاظمیان', '0441992511', 1, '2020-07-19 11:50:33', NULL, '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_08.png'),
(339, 'D5.9.kharaghani', '$2y$10$WUUS1kApsVEztZnAnAGJh.Zg0pQF8/YawOUc/RlUcuI92KRKTXrAS', 'احسان', 'خرقانی', '0251562621', 1, '2020-07-16 18:24:05', 'S1slpsJFcNM970vhM0pPQJy12FFnpXsMa1kxcBOgVjEKSHEV2VbBw9Ld0rqr', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_09.png'),
(340, 'D5.10.khayyati', '$2y$10$dQ3OF2xfsgUZiT7VYFxpHOmXastjHFZgUZMAdCisCxMK.eyFWCOry', 'محمد', 'خیاطی', '0441967078', 1, '2020-07-16 18:24:05', 'qPCJRdLnEJG5gDhDslednQvFL2oezFxwrZcrMhleUVemdXs7GRP1rVYmQEXy', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_10.png'),
(341, 'D5.11.zakeri', '$2y$10$xCmmXxmWesKBzHXLlQ8AauztFuHecKUD4C36BUe7nx1zbAPme82Uu', 'سیدعلی', 'ذاكری', '0251780627', 1, '2020-07-16 18:24:05', 'rpqSM0IKlkX8DXMnTlirilAMlSCslWEOgvCWRwEKBKm2selAbEgZvoy7Thjd', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_11.png'),
(342, 'D5.12.rasekhi', '$2y$10$hWqE6XMCdNAOc8LxnuVoCeNcRkXs/4iwZUbGf.Kc1FnkxB72DhhUe', 'امیرعلی', 'راسخی', '0442029039', 1, '2020-07-16 18:24:05', 'EQ0bUApbjDsp5UFCRB3MM6HhH3grp15uDCmYqPXSGzkOGcrFDigfHA1ebCoH', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_12.png'),
(343, 'D5.13.rohani', '$2y$10$7G/aGJQqDPDh/ws7spgsh.VYqEFjp/vQgX2Ws644Uiwu386vOUH4m', 'سیدمجتبی', 'روحانی', '0441948138', 1, '2020-07-16 18:24:05', 'o9NH83aeGpKzfveBsg6CDxm7FuvyRmCZgtwTf4HqUHlhU5jSqB2KjeRmWdXB', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_13.png'),
(344, 'D5.14.saeedinejad', '$2y$10$MvK.O1Wyx6QYGXuLFbX.N.2nSSEqMPEYHM3sPopl1g6EN63Cp6kFO', 'امیرحسن', 'سعیدی نژاد', '0441978622', 1, '2020-07-16 18:24:05', 'A5i2oDSqB5t1G31MPBsVD4RXPVQDL57ztPwWkwNadm03biD2AApig7xEvc1o', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_14.png'),
(345, 'D5.15.noori', '$2y$10$fMQM6GjqAa/Q5yrO25o3jOZ/eJP0FhU3yInzalSpcHNh52OqEpD8O', 'سیدعباس', 'سلاله نوری', '0152877800', 1, '2020-07-16 18:24:05', 'xJCnC626stJBAdMFZfvhJzFKAPgU1sTOQdUKHt7QNkgl9wlUhxyb1A1DPjnI', '', 1, '2020-07-16 18:24:05', 2000, 5, 0, 0, '5_15.png'),
(346, 'D5.16.seifollahi', '$2y$10$Ei1pqcRGJNT5hnlb..XhuuSTfLdCgFu3l2Fz2FIevDfFpAEAj/EXy', 'امیرعباس', 'سیف الهی', '0442044119', 1, '2020-07-16 18:24:06', '2ij4EfDft8YggTaSe0GuO9KENUNaIiTxJjs5Q3rrsKzIn5lcOEPi9xD29nvw', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_16.png'),
(347, 'D5.17.salehnia', '$2y$10$6MA.q0PN9A.bVBtBcScmkOeD742uZW32G9cTaBChx/Pncupug8dqC', 'علی', 'صالح نیا', '1276366353', 1, '2020-07-16 18:24:06', 'NX8gSfcqmqxKpZCQmexZgVZblyDAswhntEhy36gk96LyFGuDirzkkVAh7e96', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_17.png'),
(348, 'D5.18.safakish', '$2y$10$CruIStXnFQNd2zCC2sMFCua2rKPH6PTvc6rRZp0UmAN9SVnrn.D3C', 'محمدپویا', 'صفاكیش', '0251689379', 1, '2020-07-16 18:24:06', 'RBKTPbxthncNg853T5LMfGyPOxXJoeVrwcQ7XUcJkxmmkNEMrHH5ZomrQj3G', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_18.png'),
(349, 'D5.19.safari', '$2y$10$jnxq5KmbEbh1KCGAFgn6cuUiOk6QAo82n1pDgiLqAs/nYrpbANCMu', 'امیرعلی', 'صفری', '0442004192', 1, '2020-07-16 18:24:06', 'zWFH6eWIDWzgj6zsKfHPpEMwMiOntfESGZhDJLY21kZvXhHgFsbCLTdGGfqt', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_19.png'),
(350, 'D5.20.taheri', '$2y$10$FfaRr8PlqlcT6H44ysZyQ.i9G5p8xwo940wcg9CWSEwOSsmOwQqxq', 'محمدباقر', 'طاهری', '0442012519', 1, '2020-07-16 18:24:06', '6LgveThoR2iQzDAraenIYTaTnsBead6tdLq87xiWvnRSGkqxby8cE3qu1PwR', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_20.png'),
(351, 'D5.21.alamolhoda', '$2y$10$r32gkj8ZrtMD3VEqcuGQfea.KilC0Z7bejdLh19ifXLbuqhUsJLhe', 'سیدمهدی', 'علم الهدی', '0441919979', 1, '2020-07-16 18:24:06', 'iPXXLgEe8bbQsd7joxpV3wWVHU64MzvYiogBuaTR8opJa2KVAYZvi9UtnC0F', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_21.png'),
(352, 'D5.22.ghazian', '$2y$10$KkzJ5yTLzbDF90HT9gPp3eUh5Gnma5OTTl3dc8ToLHz2SA/XgHT3e', 'محمدبرهان', 'قاضیان', '0441980384', 1, '2020-07-16 18:24:06', 'bFCWfj9j8YBSZTmiPWAMSOQTwlYhqAzh3GZx48oVV9og1K3KXcRTLZvqtinh', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_22.png'),
(353, 'D5.23.kashani', '$2y$10$d8xooRzw7LDulNmJ8JQUoeIuJHW5gp9GigF8dBIwPLHxFC8xSvryy', 'محمدفؤاد', 'كاشانی', '0251690822', 1, '2020-07-16 18:24:06', 'usxxMTpVLblWDcpQMaAoVcfc6cUMb6rufhG6FI0QKfvPJzpXwcmWwpaxrquE', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_23.png'),
(354, 'D5.24.mofatteh', '$2y$10$hJh.SN8tOveTrEOvTBiocOvxQCvYcQMS7mdI0eAEZXEH2MRK0q3Ja', 'علیرضا', 'مفتح', '0441903789', 1, '2020-07-16 18:24:06', 'JjX2AkrzyPFtDJmki0bqQEKiueyBUCQLr316YvnnlvhH2F3acC7PIZvahs5F', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_24.png'),
(355, 'D5.25.molaee', '$2y$10$063dS2yQUW5bXHyjiYIX9O8Ta2iemEwlwXFmMdAUxV9I8dAMwAyIm', 'محمدحسن', 'ملائی', '0441991531', 1, '2020-07-16 18:24:06', 't1zLqp19hTubAU7b1hga0OwC1drAfAvA3XZYrexYzO2t0KqSIYMolDm0a3Nu', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_25.png'),
(356, 'D5.26.mirdamadi', '$2y$10$rEGbOrW.LWkVyTO78jvt9ekiqqXHWmDSJsRS82dRvu4fYWZye6/9W', 'سیدمحمدصادق', 'میردامادی', '0442001959', 1, '2020-07-16 18:24:06', 'KuiOMsje9caG3hsyNjkJ7MtZsD37K9UPGppWDJpZBEZ85JrLYHHyEBe64tqk', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_26.png'),
(357, 'D5.27.tehrani', '$2y$10$y7/MjkDxT7Ae87gDKI/xyeP4i3nK49P4XVjH4G0IoxCNGRZVHOvGC', 'علی', 'طهرانی', '0441926241', 1, '2020-07-16 18:24:06', 'IZfJExAY6VPxu56wUnzZb715ap2XnQsRvge8vMed2wGZZkkEQNewFTGXTS6M', '', 1, '2020-07-16 18:24:06', 2000, 5, 0, 0, '5_27.png'),
(358, 'test5', '$2y$10$4OJe8QmmEMb2tc5BhGTN2.T4irlmq7kOvNr87Em135BrliC1l.iq2', 'تست', 'تست', '123456', 1, '2020-07-16 18:24:07', NULL, '', 1, '2020-07-16 18:24:07', 2000, 5, 0, 0, '1.png'),
(359, 'test6', '$2y$10$wt7SZ5yHg1WXEYufoHBas.jXSicOU4I/A/QDLjIbBrQjG/p6O9L.i', 'تست', '2 تست2', '123456', 1, '2020-07-16 18:27:50', 'zhUWu6SjlRHps8P8uD8AXzPL6J9LDPR3A6t4R56Z65R6MuqFKuzTgUAlct2Q', '', 1, '2020-07-16 18:24:07', 2000, 5, 0, 0, '2.png'),
(360, 'D4.1.hejazi', '$2y$10$e34L4enLg6eclLfVIfAriegip5BrP62ezPiZe2J268r1noXLRQIgi', 'مهدی', 'امیرزاده حجازی', '0251444491', 1, '2020-07-16 18:24:50', 'd6SrQcSVF40z1RLgroxZRWNQQnNPFr16gczwX2NNwhbo1mUKS6pVak04wA2P', '', 1, '2020-07-16 18:24:50', 2000, 6, 0, 0, '4_01.png'),
(361, 'D4.2.amini', '$2y$10$ZbD/Se8wPTVwdqLiBGBR9.52CLIHWA9qHqhqhaDqBQhpyjxxknHQu', 'علی‌محمد', 'امینی', '0441806724', 1, '2020-07-16 18:24:50', 'uVSIX9bWYu0ZxEl0irdnTEilZHoukowpqWiOwRH5gbXgQtacZkQkRt9rOPFr', '', 1, '2020-07-16 18:24:50', 2000, 6, 0, 0, '4_02.png'),
(362, 'D4.23.babaisaleh', '$2y$10$MVDjQ0gltfKmdaNDjmvfrOHgbBvUt1EuPUcRnxUR1irxKRkV0mNqG', 'امیرحسین', 'بابائی صالح', '0441903525', 1, '2020-07-16 18:24:50', 'vaVJdsT5n8UEUgSDcfOOVXsqUOcXyW2VJCDA6iwrA1ZqeFBy8tJv9s2EZId4', '', 1, '2020-07-16 18:24:50', 2000, 6, 0, 0, '4_03.png'),
(363, 'D4.3.bagheri', '$2y$10$UD9MJvwh5oz3T4xLUql/vOtVv/3kojXJJl8ocBMGnxL0VVBMrI14.', 'پارسا', 'باقری', '0251458202', 1, '2020-07-16 18:24:50', 'KMpEUhmcEugxPlgr3lEMNUwXraiqp6QYiU3sjhOi9wrh3Lu5Kjj6jyzUbbsn', '', 1, '2020-07-16 18:24:50', 2000, 6, 0, 0, '4_04.png'),
(364, 'D4.4.bordbar', '$2y$10$7bt3oO9Uelo.KnPnfazIzeAPdKZsQqi.CaB8aNKafC4N9Zh9nJ9HW', 'محمدعلی', 'بردبار', '0441887880', 1, '2020-07-16 18:24:50', 'KdYVUrEzYm7pLhG8D2ZasANZ8eB2O71v5iNnuvRLQE5vcdVNRMp4hABVkX26', '', 1, '2020-07-16 18:24:50', 2000, 6, 0, 0, '4_05.png'),
(365, 'D4.5.khanzadeh', '$2y$10$Ndcic.WAGy8nOceF6/MWTOqKJQ6Bl.D13bOjveaYcigtimtnIueoG', 'محمدامین', 'خانزاده', '0441814581', 1, '2020-07-16 18:24:50', '3Q93Qaifkw5r3l3fCpPCTq84XCn0bvdHLZSZZdC7lRgYwPoTTJaiLbVkE43r', '', 1, '2020-07-16 18:24:50', 2000, 6, 0, 0, '4_06.png'),
(366, 'D4.6.khaniha', '$2y$10$vMfu5lOAROvlFTR4KCRvVOWF/wRqFA7Gx760LslnVZ1s9OfpVHg6.', 'محمد', 'خانیها', '0441822533', 1, '2020-07-16 18:24:51', 'ao0gR2hP3HT5uU5xWs79hTaBJG2gytGpBIWZMKz4ZwSltCj6yMGioSKVGbIn', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_07.png'),
(367, 'D4.8.rahimi', '$2y$10$/GhBpkaXvfpOedRK6yBCX.GXziHxEfsSWLhDFeMCxwYIAeaGcQF4C', 'امیرحسین', 'رحیمی كشاری', '0441818854', 1, '2020-07-16 18:24:51', 'tPHVmtVEsIKKwF6hbti5IzeO3fdaXWvh6vBEll2cEGX7Zaa6Nw9d2XoGJT5R', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_08.png'),
(368, 'D4.9.ziar', '$2y$10$h0Wuvhi2MnfEFksc9HMDkuy4EyFuzkgIXbHlusF.E7OTGJYvNLxT6', 'محمدپارسا', 'زیار', '0441879837', 1, '2020-07-16 18:24:51', 'iy4f3lwNZpezMgbQHQuLOc0eOmfLLMpBLbCTIQgH2EmbAO1GyIUTNejqdayZ', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_09.png'),
(369, 'D4.10.saeedinejad', '$2y$10$4xGO63onqUOMOtrEGOUqBOLCqiaOnnIcXajeDWG6r5cbpRubBdvDu', 'محمد', 'سعیدی نژاد', '0441800033', 1, '2020-07-16 18:24:51', 'mSLQ2AXl5Af5VyCFvPkDfl7UwGLgKaYDZSoNYeSJ87kummO3YytivpUEw29C', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_10.png'),
(370, 'D4.11.shafaee', '$2y$10$Scix1yPVosmRcf2UqLbw7uB.eraCbCODe1i4tGB7AsnyR0gLRaSx.', 'محمدرضا', 'شفائی', '0251433242', 1, '2020-07-16 18:24:51', 'czMYQ7aqlfmF6MS1c1y8ivOsrAzZsiUl9EKPxiFGHOT0V1nsTl5t1AUwp6QK', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_11.png'),
(371, 'D4.12.shamsolahrari', '$2y$10$91vmam64jYPgLQG5FEKqvefASYUDjYLwZAbTkNgD611V/0znKMc2y', 'امیرحسن', 'شمس الاحراری', '0251540741', 1, '2020-07-16 18:24:51', 'DChwZZ5atkhHZw5OaETIZee3OmIoix5DJeUX4afFZ4tHyzRmVy54HycBBGiC', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_12.png'),
(372, 'D4.13.safavi', '$2y$10$8ij2T7Z9g7TmMNvdCRqDB.6LnnU3Hep0./tES8JbN7NnpSwd6Ycn2', 'سیدعلی', 'صفوی', '4712143479', 1, '2020-07-16 18:24:51', 'Oo3EMQMIqNetIZpmgMiFycrgECImHjiNMOfGxUKQtNW5v9c6TkcNBR7CF0Kh', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_13.png'),
(373, 'D4.22.fakharmanesh', '$2y$10$3Vron9zwKWG4CRCbEt/2kuz9AyiiHDX6iUwTJhSxksouKWjG2QP/K', 'علی‌عطا', 'فخارمنش', '0441895980', 1, '2020-07-16 18:24:51', 'HXTV08mYcGlpbqxwplPLfC2fdXWunXPK4LgyazByhnVPWo9VSk0q2Am2CY6J', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_14.png'),
(374, 'D4.14.ketabi', '$2y$10$y.SmEClw5LyYzgfsIVh0denaPAGuVHsKaB1Y.PrXNOma8M7iT9N86', 'محمدصالح', 'كتابی', '0251371336', 1, '2020-07-16 18:24:51', 'C7nlIflPksHj6fdysBNdOgtEDl0ePmcW0El5pzVI6ZphrGY6YyOLntWbeAvu', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_15.png'),
(375, 'D4.15.golshenas', '$2y$10$7HIGvq19WSwjb9YbpP8/..fGdDZymUHodUMzKn5uyYuo4ZNDrqmRK', 'محمدمهدی', 'گل شناس', '0441841740', 1, '2020-07-16 18:24:51', 'BgXqdOtelq4bafBiT4RAHOQwlwWdRQYRVkB2UXKmmUeRb4ZlFQs968wjpt87', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_16.png'),
(376, 'D4.16.merati', '$2y$10$pVknR94oG4pdX9AcUBDYK.a.PzM7SMMRFLB1TQQsRq1KXr.uQb7Aq', 'محمدصادق', 'مرآتی شیرازی', '0441815464', 1, '2020-07-16 18:24:51', 'rshLTgcambLXUCyWcrSZ0t30s9zyTE1OghH90nJr3jDlx07oEpEsWEL8P261', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_17.png'),
(377, 'D4.17.mobin.movahedi', '$2y$10$nthnLCOYC/k5UNinWWMhy.0/oefVOq5oaPTEZOnhlo4IvVUi3uAty', 'مبین', 'موحدی', '0441841945', 1, '2020-07-16 18:24:51', 'yhR78UGmueISihhsEk5QFE95bWhmH3233b0U8xkZlzTvVoef7PkcomPtyEOn', '', 1, '2020-07-16 18:24:51', 2000, 6, 0, 0, '4_18.png'),
(378, 'D4.17.matin.movahedi', '$2y$10$gXSWlFKnHIAlk2btJQrqC.Oh6PVGuCuvkd1mz1LlngyfL6aH0AbmO', 'متین', 'موحدی', '0441841953', 1, '2020-07-16 18:24:52', 'exxv56yGp0IfejlxMJtexwzmtLnZlr3cuzbOv0ZWZEBqNsSaB2HoSMiNutZF', '', 1, '2020-07-16 18:24:52', 2000, 6, 0, 0, '4_19.png'),
(379, 'D4.18.movahedimaram', '$2y$10$Rwws9adUKWGTaGUWtDaDJu5InicdAl77kCtU3F1eQ8i1dTTPvo84C', 'علی', 'موحدی مرام', '0441862276', 1, '2020-07-19 11:50:47', 'ZDTBoUgNGViNj3kyNRms9keoZjfT5zGg7yQgPRELTBBtNUQ5aRQrifMnhNYM', '', 1, '2020-07-16 18:24:52', 2000, 6, 0, 0, '4_20.png'),
(380, 'D4.19.moosavi', '$2y$10$RqiXxqAWryNM7rmmffWRb.Oe7MyQ75SFzaLtM1pnohn6V3NXy7Pai', 'سیدمحمدفؤاد', 'موسوی', '0441796052', 1, '2020-07-16 18:24:52', 'myAa2ou1ykwI0szIOA9b1aQvcZT2SdwXXDaDwMFmzfsplz7KCvYWuUXsyirJ', '', 1, '2020-07-16 18:24:52', 2000, 6, 0, 0, '4_21.png'),
(381, 'D4.20.nabavi', '$2y$10$7L7l21mOejkOn5sG5OU9AepXWj8q.lS.bHJsHhoRVlgthbF2NKUxm', 'سیدصدرا', 'نبوی', '0201933659', 1, '2020-07-16 18:24:52', 'Xr5qDY2DQWW8BgiBv1GuFmbgnKBfyQQZpkmwaxsll3XxArErdU2ZXtJzHXuj', '', 1, '2020-07-16 18:24:52', 2000, 6, 0, 0, '4_22.png'),
(382, 'D4.21.vajedi', '$2y$10$LuXQrJtUYzpimwHDG3uLMuuhU8OPpgHrbOoKbQvA8VfeV6BvsOH4S', 'سیدامیرعلی', 'واجدی', '0441902219', 1, '2020-07-16 21:14:12', 'qTeFPyCC03ra6Czr9gX6EAwEVEKyJDfXmhLXRZHRfpyydxH4cfMzXyXDlo8Y', '', 1, '2020-07-16 18:24:52', 2000, 6, 0, 0, '4_23.png'),
(383, 'D4.7.rahati', '$2y$10$UP/RNxgXk2bBX13W3rUP3uY4ZnG3Oa6GZG.hV6AgVFWU3lR5GedHG', 'محمدعلی', 'راحتی', '0960267905', 1, '2020-07-16 18:24:52', 'E5pruYlIZPP3YFY5sdAKI9aTZC5yhHf9yhflcbVkT9xsy8mLQhBRk1TSHhRC', '', 1, '2020-07-16 18:24:52', 2000, 6, 0, 0, '4_24.png'),
(384, 'test7', '$2y$10$2qmMeEXTUegVByCIo3aKXucamkMpzsJ7UDmgcrMt59hzGBoeXlVhC', 'تست', 'تست', '123456', 1, '2020-07-16 18:24:52', 'PlFOW9yRAislemWgy18qrzW9GgDJROLA30r8poNtyCEvNNLSNyFIbXBlZPny', '', 1, '2020-07-16 18:24:52', 2000, 6, 0, 0, '1.png'),
(385, 'test8', '$2y$10$ja6W1jR9wjeDjtDVWAOJluwvpcnZozXBT2lEgd4eE1yn02C/j1QJK', 'تست', '2 تست2', '123456', 1, '2020-07-17 06:37:35', '6QgZQhKRPaGgrOFbXevOaRUGEYGk0hU3bgN5HdMP4u1cu6ngu4lWgKwkt6hC', '', 1, '2020-07-16 18:24:52', 2000, 6, 2, 0, '2.png'),
(386, 'D3.1.ahmadi', '$2y$10$X.ai3Mi85eP0LF6yMoCPHOQDoWITPjGF4Dy7xyX.smuWlJQItlxKy', 'سیدمحمدحسن', 'احمدی', '0251267539', 1, '2020-07-16 18:25:34', 'COGZ5mNrq2Xq9I4UAUbBl3tBMt1KtiDM5Vl97TQiW8SD99CUsHBA3WBi2Ufu', '', 1, '2020-07-16 18:25:34', 2000, 7, 0, 0, '3_01.png'),
(387, 'D3.2.azhdari', '$2y$10$tfVb3LoG0Y.CioYkfecwGe2bykW0g7cM9zS2xKGdooMdfBv7FJ0EK', 'امیررضا', 'اژدری', '0441805019', 1, '2020-07-16 18:25:34', 'uiR6i1ZF8iWzfB3hYjh9z5gYhO5oQprhQi93Xp1nd14whLbI2XJEGQYuPKY3', '', 1, '2020-07-16 18:25:34', 2000, 7, 0, 0, '3_02.png'),
(388, 'D3.3.imani', '$2y$10$8qCq7JWb99ubjSn8f16i9er31ABw8KZBRGIBU7DeSjDx3yIaDWhcm', 'هویار', 'ایمانی', '0441764266', 1, '2020-07-16 18:25:35', 'fknVrqfwo6uxXRI7GNEIpqeRqfm4v28p0tkGpTwPPamyomS6nVLJVtRMQKN6', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_03.png'),
(389, 'D3.4.bahramgiri', '$2y$10$GMYbGqBqz8UtKwBLZbsy9ebJoHTAeqP0HWQwonCY7.jaH50U6rRQ2', 'محمد', 'بهرامگیری', '0251364992', 1, '2020-07-16 18:25:35', 'gSbTHmwVsJeI61GK4IaS2vzuigenP47hlonxxxHljqAggq1HxxWBwxn5uuGP', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_04.png'),
(390, 'D3.5.hajiabdolali', '$2y$10$CiHKXIvmV2gwGS3N5ZktcOvMNXgExBGecXGtRtXqfIowAN/Oha/Eu', 'محمدپارسا', 'حاجی عبدالعلی', '0026434520', 1, '2020-07-16 18:25:35', 'CW5fLAkybIuUN8aE1sypTv89EqWGt0PGl4DyYmgc8wnd8nkxGyBivCG1JIU0', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_05.png'),
(391, 'D3.6.hasanzadeh', '$2y$10$2iDvkxsJCa2ApqQHPbgRBu7r67DdquwtWKOogr5VQTUy1RSrrJY0S', 'امیراحمد', 'حسن زاده', '1275921965', 1, '2020-07-16 18:25:35', 'oWRL8TYNSZDI7L5pn7vnaf3T5lTl8w9wkfYEDH9r9Jau5WWTeHzxn89xUScO', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_06.png'),
(392, 'D3.7.dadman', '$2y$10$lv4JqHQNM.qcRtMxXuJhb.smjmqi1YmQh3QvOUXey5e9x4Q92NelO', 'امیرحسین', 'دادمان', '0441759890', 1, '2020-07-16 18:25:35', '5VO1RGYyOZSroPN5JQFnM22KoKNGOfLSBM1E200nzswsPlWimJHhggSqOShA', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_07.png'),
(393, 'D3.8.zakeri', '$2y$10$q4Nxp7DbeROeWi6jlD6toeIWdL5M/X7RwgShPWd8SG5jbIuCZ59FC', 'محمدطاها', 'ذاكری', '0441757537', 1, '2020-07-20 08:06:02', 'SCFkH9ojwrYOqCASMqeFxKHE4skgPZertczGbKHFRrv2Q7TYmnKL2yT3ux3H', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 1, '3_08.png'),
(394, 'D3.9.sabeghi', '$2y$10$UhOexxUVlTeRkfEomWVZqeXGRfKySgUE9FBFLqOY2331gHcJY3YfW', 'علی', 'سابقی', '0026453924', 1, '2020-07-16 18:25:35', 'jt0odfndnue9ejkgykF8ygHlNbNHDINXwkIr9IQV6A19ZCKCjgOp1Kduh3YZ', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_09.png'),
(395, 'D3.10.salimkhani', '$2y$10$oEA3UyoEhxjLrQ4tTCLF8uILA8hnGAt4MXiAoV.Yyv4a39XQoEd3m', 'محمدامین', 'سلیم خانی', '0152320938', 1, '2020-07-16 18:25:35', 'w19I066CqlrS3FXgcBmw056iQSNr5feAUtKtXnau4ygRPRewEUoOQ5ZtqzoL', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_10.png'),
(396, 'D3.11.seyyedrezazadeh', '$2y$10$2keV0izPdCAzQEIss4MRoePyIdsVbVkhh1TP62hJE0vZdvTkFFhb.', 'سیدامیرمهدی', 'سیدرضازاده', '0152253203', 1, '2020-07-16 18:25:35', 'jZR6JQXJtfoFCcRhYdgA6UjeQhj6Xe67Z2HMo46DY2vF2Qb8jC9BxDFohPlL', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_11.png'),
(397, 'D3.12.shirpoor', '$2y$10$./M1FH64r062KP1aYR2cAuDCbT/qtp.vZkVazBL/tkoebASxYbZCO', 'امیرعلی', 'شیرپور', '0441805371', 1, '2020-07-16 18:25:35', 'CEa628zk77q5ofOtXEUhM2ThzDp584oCzhu1HPZB5SPAaHrqOoN3gTqlLPa4', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_12.png'),
(398, 'D3.13.sanei', '$2y$10$WRmCP57JErGEoCO7Nlru7.kog.nBWIsz6wCw1vRb8iKEIvzFVjzYq', 'امیریحیی', 'صانعی طاهری', '0441732259', 1, '2020-07-16 18:25:35', 'CqnEyu4nBSFRZqRVHvJDFCwed9ZnHzYUF0cV3eXMvmPayKyCnkBkZHfJA5l3', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_13.png'),
(399, 'D3.14.taheri', '$2y$10$E1..gh3o2nOWhqoMFFTaCOaU3i1Q6Ui9WmWGvgdGV/YTLvtJuWfHS', 'محمد', 'طاهری', '0251204987', 1, '2020-07-16 18:25:35', '2vIrZT8p4E2rkKx1ysiJEM15NGY5v2lSJ5RRHpFMHnK1edaag4sz0PqjrqbJ', '', 1, '2020-07-16 18:25:35', 2000, 7, 0, 0, '3_14.png'),
(400, 'D3.15.adeli', '$2y$10$1K5zUJbcf7bstILNQpA/O.kBtmCqy2tub86DYcOVlT5OPI80DMXIS', 'علی', 'رضا عادلی', '0251317951', 1, '2020-07-17 16:25:24', 'DkqQpd6CCGTfw5bdzIptedvwJxTWHv3OlSkNedByifRHHOAz9yzB7tg1KGNK', '', 1, '2020-07-16 18:25:36', 2000, 7, 0, 0, '3_15.png'),
(401, 'D3.16.ghasemi', '$2y$10$S3oyodi/HJ.DTKazFE2yeuli6jf.vzI/IlWJjI6j9dSZIQVA2pLMy', 'یاسین', 'قاسمی', '0152335943', 1, '2020-07-16 18:25:36', 'cuz6WaIWZ6H1b3yCWi3bmT2IMY0UqqYSsEmlzaedHGDFGcSm0OP4zh6n6BCI', '', 1, '2020-07-16 18:25:36', 2000, 7, 0, 0, '3_16.png'),
(402, 'D3.17.mohammadi', '$2y$10$ymskwnLfOyAD0suQOr.yquXKaYiRUHTTTg8/fp5slm6ef1mayvBZq', 'امیرمحمد', 'محمدی', '0441807615', 1, '2020-07-16 18:25:36', 'HgJPdAR6vf8hw7uQRPDxVlDcw2suIIfA80jQpuBTQQ6IfN2BV7BxdYsBI2yd', '', 1, '2020-07-16 18:25:36', 2000, 7, 0, 0, '3_17.png'),
(403, 'D3.18.mohammadipoor', '$2y$10$1IfegcLGmtyOkPKAX0Gomu5w67OIeWaPwZrtK5mu1JRQP30DvHx5i', 'معین', 'محمدی پور', '0441755445', 1, '2020-07-16 18:25:36', 'DCYhBybkXPBzUSitu497V67Z7xAXuCErsHQdSMq6VGa3jtXsuvrnepWoe4w0', '', 1, '2020-07-16 18:25:36', 2000, 7, 0, 0, '3_18.png'),
(404, 'D3.19.nazeriha', '$2y$10$mgnRmrVNCPdFZe6NE4BsiutNidKdOcyfHeOvzuwvPAhRWFpEjyVFa', 'محمدعلی', 'ناظریها', '0026356112', 1, '2020-07-16 18:25:36', 'ikfnlDoBTAhR1eVv78aFuvkdTzFx6tVwfcqpmxev1KKKHSYbdluwmdbN6uUG', '', 1, '2020-07-16 18:25:36', 2000, 7, 0, 0, '3_19.png'),
(405, 'D3.20.nobahari', '$2y$10$TfxYlPctd58yErh8M3orqOtAe4y7lt.YDOIAIuemTvxfTMqHuqVgq', 'محمدحسین', 'نوبهاری', '0251204472', 1, '2020-07-16 18:25:36', 'GuqYCPGbprqfvvDP08Jl6lYd97tr1LJIriOMBWKffQ0YJCAZnOMP0dwNW51K', '', 1, '2020-07-16 18:25:36', 2000, 7, 0, 0, '3_20.png'),
(406, 'test9', '$2y$10$qV5uBVpjiRAFAjkwBZC4HucDYPEa7Vf7DYoiiWnR0VEVbAoSCv4zm', 'تست', 'تست', '123456', 1, '2020-07-16 18:25:36', 'Qsr5JHlw1QX7Cwu5C6flTwnsMkbeDeMJQZi4qjWL6AyzRo0nG3My1B1Yh3MC', '', 1, '2020-07-16 18:25:36', 2000, 7, 0, 0, '1.png'),
(407, 'test10', '$2y$10$WMdku700nd5/jBa1UEp/2.W1u26ty3NLYDriU7AI/PHBiN0PLgfX.', 'تست', '2 تست2', '123456', 1, '2020-07-16 18:28:13', 'QDGQkKYzcPDKGaHs74RHJEv6N8BanEBSjYyDF7h9nI8yyLbciuQCNvQGPlhj', '', 1, '2020-07-16 18:25:36', 2000, 7, 0, 0, '2.png'),
(408, 'D2.1.asadi', '$2y$10$rNkd7wPE.KbLN77vpYbyX.t5IGh4ThR.AyrQnL2GBw5Iqx.AFHpQm', 'محمدمصطفی', 'اسدی', '0441672515', 1, '2020-07-16 18:26:17', 'qdzvqQLoRAzqmfsC1ZVdi7XGPQJSvGAblJIuzhSomkF7HqijH50KDIfVA8D7', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_01.png'),
(409, 'D2.2.hejazi', '$2y$10$tjbNXNnmVZmwdHasQWu2Ae3Om3Ne8xQrX3pIgqhT.uAgvcwHu8.3S', 'هادی', 'امیرزاده حجازی', '0251148807', 1, '2020-07-16 18:26:17', 'uM35uElJlYQPIET2aaXEzxzsFCQFOQygIGleOKIzhNsx63G1jjsO8xD4ysx0', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_02.png'),
(410, 'D2.15.amin', '$2y$10$lOlAbpDPuYs.1IXk2.u9bugi42bBgiaXKSEdlU53Ky1X2Zsi1lCnq', 'سیدامیرحسین', 'امین', '0251162605', 1, '2020-07-16 18:26:17', 'KVW13436QzUCVNqHOTO0CEO971rRRjkRjgT41KxbV7JCRq4BpOj03VlwxKro', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_03.png'),
(411, 'D2.3.ahrabinia', '$2y$10$kRezntj1Mrl2orLBZrjLx.g/VJncAvMEvnaJYF6H.BBZ9a47QNT5y', 'محمدمهدی', 'اهرابی نیا', '0250936811', 1, '2020-07-16 18:26:17', 'OKhHhfHmEkg9UUYM7cF0BYwXg6V01Nqh96MIcMC6pmLgKvm2cXkcobuYmJVe', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_04.png'),
(412, 'D2.4.pelisieh', '$2y$10$cNIpMhn81mI8XigUqJFyrOywykeDuJVgAVC.RjLRztCTrKtzqcIeS', 'محمدحسین', 'پلیسیه', '9413004596', 1, '2020-07-16 18:26:17', 'N3JN3Dafxp9tZ85d3Zq0awREdMcfpn2WWlUfveJ6Gx39HRHnmuntlTYYxcrL', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_05.png'),
(413, 'D2.5.jahangard', '$2y$10$f3UrA/KtRAT.2N0oBx6B.OZuyt5mGwPMPJBgOAzD0nWo0HuHvYmTu', 'مهدی', 'جهانگرد', '0441666401', 1, '2020-07-16 18:26:17', 'xteutIMFG2pFkrafUSXMPualjfU7XD0xIeXnvxlKwIlybSGgXHTEEjeMC12T', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_06.png'),
(414, 'D2.6.chizari', '$2y$10$8Op9kLHHMp62VEFj5XOyMeb5hFciWQYgEID8bre6sl.vQbaGgyDou', 'محمدعلی', 'چیذری', '0441657583', 1, '2020-07-16 18:26:17', 'SXbMdUTV7s8A5u8g8X3lFavVWdVoRMG30ncP2WbTQsfoKWomYgfRuW7w6rBN', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_07.png'),
(415, 'D2.7.khodaverdi', '$2y$10$dqJRyMtyziwAQzPUdzntgeE.gBKKH92SNXwelnvqSXsvjdoCv2Nr2', 'امیرعلی', 'خداوردی', '0441693105', 1, '2020-07-16 18:26:17', 'QSThHb8FJglltpkUHFaLBFmUyeUPvXKubJAb6v2Fqynp9q9G6va6dSMi6K1i', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_08.png'),
(416, 'D2.8.khorasanchi', '$2y$10$9CSnSk2Ggnp4lS1PVv4vyORCjHTMaffDS36oll08EtJbmgrDXGHN2', 'علی', 'خراسانچی', '0441680402', 1, '2020-07-16 18:26:17', 'YASglmE8dxCp3n3hRRsUVnwy8zwxQu0XpTvWd6RaWsvOBzrZKvDjV6WQcxH8', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_09.png'),
(417, 'D2.9.zebhideh', '$2y$10$7QMPM7J/iZEKYqIpATPytez7bJUYBJ5pp7IzmofarK.E6Bc.mEgte', 'امیرحسین', 'زبهیده', '0152031278', 1, '2020-07-16 18:26:17', 'RKm9vJE2CKfUUK8CZaja5qKGFesro789fPFS6TT6TBYErZPMUVBFhyMkBDt8', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_10.png'),
(418, 'D2.10.fakharmanesh', '$2y$10$ig..NFrTnsJnIXooFIuq2Ocf50hfGdDIJfRVcmHKa4.5pb5awlKd.', 'امیرعلا', 'فخارمنش', '0441681484', 1, '2020-07-16 18:26:17', '6jiKVSgzt2JSji11pLWkps2G7YyGD0w1LDSjr0LMnbmxSkYLsW3HuuMzlVMX', '', 1, '2020-07-16 18:26:17', 2000, 8, 0, 0, '2_11.png'),
(419, 'D2.11.karkhaneh', '$2y$10$LephKUkOYAOTKpMjuG/bfud3kF4o0FVklILDKhDS8gkeXSyBHwgAm', 'محمدصادق', 'كارخانه', '0441702414', 1, '2020-07-16 18:26:18', 'DcjX5QcwCBky8mIklivcuy08OlGDzFgIlExyiVp3Ybgd3on6enW6MISqe2Do', '', 1, '2020-07-16 18:26:18', 2000, 8, 0, 0, '2_12.png'),
(420, 'D2.12.mohammadpazhooh', '$2y$10$XxzyxD9HGpmtnG2aXEUaoeDnoQky9FbKLNz2B/LcurIwkENLSu1Ue', 'محمدیاسین', 'محمدپژوه', '0441624677', 1, '2020-07-16 18:26:18', 'xG8f4b275781u8yAoWq2otqSMn7pw0XgK4o0ze2w2Q0r0LnuJgv5B8Dp8ERb', '', 1, '2020-07-16 18:26:18', 2000, 8, 0, 0, '2_13.png'),
(421, 'D2.13.mashayekh', '$2y$10$C0K.KLAkT7LCRqwKBde7Webq2pdgwlMb7Juv1g7Qt86ASafkZux6.', 'محمدمهدی', 'مشایخ', '0201361213', 1, '2020-07-16 18:26:18', 'yDlKFzdcCkVKYDBgEL6MiZBr5xR4LMiwiTb3jYY77gZiA3tujEdAlbdj4gbN', '', 1, '2020-07-16 18:26:18', 2000, 8, 0, 0, '2_14.png'),
(422, 'test11', '$2y$10$mxq8wcoQWzjW8TaQVn/kpO5blNMjLmA5p99sZkHrVplYLvsaMKiPG', 'تست', 'تست', '123456', 1, '2020-07-16 18:26:18', NULL, '', 1, '2020-07-16 18:26:18', 2000, 8, 0, 0, '1.png'),
(423, 'test12', '$2y$10$ciXDLNEofLTi/YC02vn/NeP7vQ3UC6/Tn6xMp70UhAXD1Myyo9UPa', 'تست2', 'تست2', '123456', 1, '2020-07-16 18:28:17', 'FMQwWEHErCAOzeElYdkQ37w8PBsdQgrP00EKZV57UeuItvp2j7NlB51DYsn8', '', 1, '2020-07-16 18:26:18', 2000, 8, 0, 0, '2.png'),
(424, 'D2.14.jodeiri', '$2y$10$KRCQvzNB.tN.1gRO2DBp/.xtjrlDWmRAVOXZCSkajUNzs2D1ts72a', 'محمد', 'جدیری', '0441696880', 1, '2020-07-18 09:29:09', 'VNAlORZDhuqgNePgxaiw8g1kbptHqcuCy5i3c1Q8fgGu7EbmlRLe5CV82u5r', '', 1, '2020-07-18 09:28:53', 2000, 8, 0, 0, '2_15.png'),
(430, 'zahra', '$2y$10$fgCeH1naBHWmmuzuMWCeHuNA/uqaRF4VHERLLlf8bvCnruV2XEtAi', 'محمد', 'فانع', '0018914373', 2, '2020-07-20 11:06:10', 'bnZ682BMJF3ZChoZh51ZbtEuOyqYl34gomWD84O3Sa4DJMXM0zmlI71b5Akm', '', 1, '2020-07-20 11:06:10', 2000, 3, 0, 0, '1.jpg'),
(431, 'sara', '$2y$10$95Q9YFWabwi8IYHdAwalCOfKg/lXwYIrl7IXDMcm0KVpSu.m1IoLe', 'احمد', 'قانع', '0020033087', 2, '2020-07-20 11:06:10', NULL, '', 1, '2020-07-20 11:06:10', 2000, 3, 0, 0, '2.jpg'),
(432, 'sharab', '$2y$10$8d0TkhR325TG2ijpAXEN5O8Z0OMPqMcll2mFRPQI1x0D1QJatOP4a', 'حسین', 'قانع', '0074804456', 2, '2020-07-20 11:06:10', NULL, '', 1, '2020-07-20 11:06:10', 2000, 3, 0, 0, '3.jpg'),
(433, 'rima', '$2y$10$G2mT3NQcQPQQm3SU.s30puNlZ.VnqRIB44ZEXjyIywlgjp0WX567q', 'حسن', 'قانع', '3861338300', 2, '2020-07-20 11:06:10', NULL, '', 1, '2020-07-20 11:06:10', 2000, 3, 0, 0, '4.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `mode` (`mode`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `common_question`
--
ALTER TABLE `common_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_category`
--
ALTER TABLE `faq_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mode` (`mode`);

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category_id_foreign` (`user_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `product_attach`
--
ALTER TABLE `product_attach`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_pic`
--
ALTER TABLE `product_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_pic_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_trailer`
--
ALTER TABLE `product_trailer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_attach`
--
ALTER TABLE `project_attach`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_buyers`
--
ALTER TABLE `project_buyers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_unique` (`user_id`,`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_grade`
--
ALTER TABLE `project_grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `grade_id` (`grade_id`);

--
-- Indexes for table `project_pic`
--
ALTER TABLE `project_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_tag`
--
ALTER TABLE `project_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projectTagUnique` (`project_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_attach`
--
ALTER TABLE `service_attach`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `service_buyer`
--
ALTER TABLE `service_buyer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_unique` (`user_id`,`service_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `service_grade`
--
ALTER TABLE `service_grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `service_pic`
--
ALTER TABLE `service_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_unique` (`user_id`,`product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `follow_code` (`follow_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `grade_id` (`grade_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `common_question`
--
ALTER TABLE `common_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faq_category`
--
ALTER TABLE `faq_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `msg`
--
ALTER TABLE `msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_attach`
--
ALTER TABLE `product_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_pic`
--
ALTER TABLE `product_pic`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_trailer`
--
ALTER TABLE `product_trailer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `project_attach`
--
ALTER TABLE `project_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `project_buyers`
--
ALTER TABLE `project_buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `project_grade`
--
ALTER TABLE `project_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `project_pic`
--
ALTER TABLE `project_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `project_tag`
--
ALTER TABLE `project_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_attach`
--
ALTER TABLE `service_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_buyer`
--
ALTER TABLE `service_buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `service_grade`
--
ALTER TABLE `service_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `service_pic`
--
ALTER TABLE `service_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=434;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `msg`
--
ALTER TABLE `msg`
  ADD CONSTRAINT `chatForeignInMsg` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_attach`
--
ALTER TABLE `product_attach`
  ADD CONSTRAINT `productForeignAttach` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_pic`
--
ALTER TABLE `product_pic`
  ADD CONSTRAINT `productForeignPic` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_trailer`
--
ALTER TABLE `product_trailer`
  ADD CONSTRAINT `productForeignTrailer` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_attach`
--
ALTER TABLE `project_attach`
  ADD CONSTRAINT `projectForeignInAttach` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_buyers`
--
ALTER TABLE `project_buyers`
  ADD CONSTRAINT `projectForeignInBuyer` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userForeignInBuyer` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_grade`
--
ALTER TABLE `project_grade`
  ADD CONSTRAINT `gradeForeignInGrade` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projectForeignInGrade` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_pic`
--
ALTER TABLE `project_pic`
  ADD CONSTRAINT `projectForeignInPic` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_tag`
--
ALTER TABLE `project_tag`
  ADD CONSTRAINT `projectForeignInTag` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tagForeignInProject` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_attach`
--
ALTER TABLE `service_attach`
  ADD CONSTRAINT `serviceForeignInAttach` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_buyer`
--
ALTER TABLE `service_buyer`
  ADD CONSTRAINT `serviceForeignInBuyer` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userForeignInServiceBuyer` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_grade`
--
ALTER TABLE `service_grade`
  ADD CONSTRAINT `gradeForeign` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `serviceForeignInGrade` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `productForeignInTransaction` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userForeignInTransaction` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
