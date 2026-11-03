-- phpMyAdmin SQL Dump
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Cơ sở dữ liệu: `web_baochi`
--
CREATE DATABASE IF NOT EXISTS `web_baochi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web_baochi`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `articles` (Gồm: mã, tiêu đề, nội dung, tác giả)
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu 8 bài báo mẫu cho bảng `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `author`) VALUES
(1, 'Xu hướng phát triển trí tuệ nhân tạo năm 2026', 'Trí tuệ nhân tạo đang ngày càng trở nên phổ biến và đóng vai trò quan trọng trong mọi lĩnh vực của đời sống xã hội hiện đại. Từ giáo dục, y tế cho đến sản xuất công nghiệp, các hệ thống thông minh giúp tối ưu hóa quy trình làm việc, tiết kiệm thời gian và nâng cao hiệu suất lao động đáng kể cho con người trong kỷ nguyên số hóa toàn cầu hiện nay.', 'Nguyễn Văn An'),
(2, 'Kinh nghiệm tự học lập trình Backend hiệu quả cho người mới', 'Đối với sinh viên mới bắt đầu làm quen với lập trình web, việc nắm vững kiến thức cơ bản về ngôn ngữ PHP và hệ quản trị cơ sở dữ liệu MySQL là vô cùng cần thiết. Bạn nên thực hành xây dựng các dự án nhỏ như quản lý sản phẩm hoặc trang tin tức báo chí để hiểu rõ luồng dữ liệu đi từ giao diện người dùng xuống máy chủ.', 'Trần Minh Tuấn'),
(3, 'Khám phá vẻ đẹp bình yên của miền Tây mùa nước nổi', 'Mùa nước nổi miền Tây Nam Bộ thường bắt đầu từ tháng tám đến tháng mười một âm lịch hàng năm, mang theo lượng phù sa màu mỡ và nguồn thủy sản vô cùng phong phú. Du khách đến đây sẽ được trải nghiệm cảm giác ngồi trên chiếc xuồng ba lá len lỏi qua những cánh rừng tràm xanh mướt và thưởng thức nhiều món ăn đặc sản dân dã.', 'Lê Hoàng Nam'),
(4, 'Lợi ích tuyệt vời của việc chạy bộ mỗi buổi sáng', 'Duy trì thói quen dậy sớm và dành ra ba mươi phút chạy bộ mỗi ngày không chỉ giúp cơ thể đốt cháy lượng mỡ thừa hiệu quả mà còn cải thiện sức khỏe tim mạch rất tốt. Bên cạnh đó, việc hít thở bầu không khí trong lành vào buổi sáng sớm còn giúp tinh thần sảng khoái, giảm căng thẳng và tăng cường khả năng tập trung học tập.', 'Phạm Thu Hà'),
(5, 'Hướng dẫn tối ưu hóa cơ sở dữ liệu MySQL trong dự án thực tế', 'Khi xây dựng các ứng dụng web có lượng truy cập lớn, việc thiết kế cấu trúc bảng hợp lý và đánh chỉ mục chính xác sẽ giúp tăng tốc độ truy vấn dữ liệu lên gấp nhiều lần. Ngoài ra, lập trình viên cần chú ý sử dụng câu lệnh chuẩn bị trước để ngăn chặn triệt để các lỗ hổng bảo mật nguy hiểm liên quan đến tấn công cơ sở dữ liệu.', 'Đinh Hoàng Cước'),
(6, 'Văn hóa cà phê vỉa hè độc đáo của người dân Sài Gòn', 'Không cần những quán xá sang trọng hay cầu kỳ, cà phê bệt hay cà phê vỉa hè từ lâu đã trở thành một nét văn hóa đặc trưng vô cùng gần gũi của người dân thành phố. Chỉ với một ly cà phê sữa đá thơm lừng vào buổi sáng, mọi người có thể ngồi trò chuyện rôm rả cùng bạn bè và ngắm nhìn nhịp sống hối hả qua lại.', 'Võ Thanh Trúc'),
(7, 'Những kỹ năng mềm cần thiết cho sinh viên công nghệ thông tin', 'Ngoài kiến thức chuyên môn vững vàng về lập trình và thuật toán, sinh viên ngành công nghệ thông tin cần chủ động rèn luyện thêm kỹ năng giao tiếp, làm việc nhóm và giải quyết vấn đề. Khả năng đọc hiểu tài liệu tiếng Anh chuyên ngành cũng là một lợi thế cạnh tranh vô cùng lớn giúp các bạn dễ dàng tiếp cận công nghệ mới trên thế giới.', 'Hoàng Gia Bảo'),
(8, 'Giải pháp bảo vệ môi trường xanh sạch đẹp từ những hành động nhỏ', 'Bảo vệ môi trường sống không phải là những điều quá xa vời mà bắt đầu ngay từ chính thói quen sinh hoạt hàng ngày của mỗi cá nhân trong cộng đồng. Việc hạn chế sử dụng túi nilon dùng một lần, phân loại rác thải tại nguồn và tiết kiệm điện nước sẽ góp phần quan trọng vào việc giảm thiểu ô nhiễm và chống biến đổi khí hậu.', 'Đỗ Mai Phương');
COMMIT;