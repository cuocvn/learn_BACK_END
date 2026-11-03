# HỆ THỐNG MÔ PHỎNG QUẢN LÝ THƯ VIỆN (OOP PHP)

Dự án áp dụng đầy đủ các nguyên lý lập trình hướng đối tượng (OOP) trong PHP để xây dựng hệ thống quản lý tài liệu thư viện (Sách in, EBook, Tạp chí), đi kèm giao diện web tương tác trực quan.

---

## 1. Cấu Trúc Mã Nguồn

```text
c:/wamp/www/week4/
├── Borrowable.php      # Interface định nghĩa chức năng mượn/trả (borrow, returnDocument, isAvailable)
├── Exceptions.php      # Các lớp ngoại lệ tùy chỉnh (DuplicateIdException, DocumentNotFoundException, DocumentUnavailableException)
├── Document.php        # Abstract class Document quản lý thuộc tính và phương thức dùng chung
├── Book.php            # Subclass kế thừa Document: bổ sung $pages (số trang), $weight (khối lượng)
├── EBook.php           # Subclass kế thừa Document: bổ sung $fileSize (dung lượng MB), $format (định dạng)
├── Magazine.php        # Subclass kế thừa Document: bổ sung $issueNumber (số phát hành), $month (tháng)
├── Library.php         # Lớp Library quản lý danh sách Document: thêm, xóa, tìm kiếm, lọc, sắp xếp, thống kê, mượn/trả
├── sample_data.php     # Khởi tạo ít nhất 6 tài liệu mẫu ban đầu (2 Book, 2 EBook, 2 Magazine)
├── test_lib.php        # Script kiểm thử toàn diện các lớp OOP và ngoại lệ qua CLI
├── index.php           # Giao diện web mô phỏng thư viện (Bootstrap 5, Responsive, UX hiện đại)
└── README.md           # Hướng dẫn chi tiết
```

---

## 2. Các Khái Niệm OOP Được Ứng Dụng

1. **Tính Trừu tượng (Abstraction):**
   - Lớp trừu tượng `abstract class Document` định nghĩa khung thuộc tính chung:
     - Thuộc tính: `$id`, `$title`, `$author`, `$year`, `$category`, `$status` (`available` / `borrowed`).
     - Phương thức trừu tượng: `abstract public function getType(): string;` và `abstract public function getSpecificDetails(): array;`.

2. **Giao diện (Interface):**
   - `interface Borrowable` định nghĩa hợp đồng:
     - `public function borrow(): bool;`
     - `public function returnDocument(): bool;`
     - `public function isAvailable(): bool;`

3. **Tính Kế thừa (Inheritance):**
   - `Book extends Document`: Bổ sung `$pages` và `$weight`.
   - `EBook extends Document`: Bổ sung `$fileSize` và `$format`.
   - `Magazine extends Document`: Bổ sung `$issueNumber` và `$month`.

4. **Tính Đóng gói (Encapsulation):**
   - Thuộc tính trong `Document` được đặt `protected`, thuộc tính trong các subclass được đặt `private`.
   - Truy xuất và sửa đổi dữ liệu an toàn thông qua các getter/setter và phương thức nghiệp vụ.

5. **Tính Đa hình (Polymorphism):**
   - Lớp `Library` quản lý một mảng các đối tượng `Document`.
   - Khi gọi `getType()` hoặc `toArray()`, mỗi đối tượng con (`Book`, `EBook`, `Magazine`) sẽ tự xử lý hành vi đặc thù riêng mà không cần biết chính xác loại đối tượng trước.

6. **Xử lý Ngoại lệ (Exception Handling):**
   - `DuplicateIdException`: Bắt lỗi khi thêm tài liệu có mã `$id` đã tồn tại.
   - `DocumentNotFoundException`: Bắt lỗi khi tìm kiếm, xóa hoặc mượn/trả tài liệu không tồn tại.
   - `DocumentUnavailableException`: Bắt lỗi khi mượn tài liệu đang ở trạng thái `borrowed` hoặc trả tài liệu khi đang `available`.

---

## 3. Các Chức Năng Của Hệ Thống

1. **Hiển thị danh sách:** Bảng dữ liệu chi tiết kèm các badge nhận diện loại tài liệu và trạng thái.
2. **Thêm tài liệu mới:** Modal thêm tài liệu động; tự động chuyển đổi các trường nhập liệu tương ứng khi chọn `Book`, `EBook`, hoặc `Magazine`.
3. **Mượn & Trả tài liệu:** Thao tác 1-click để chuyển đổi trạng thái giữa `available` và `borrowed` qua interface `Borrowable`.
4. **Xóa tài liệu:** Xóa tài liệu khỏi danh sách có hộp thoại xác nhận.
5. **Tìm kiếm:** Tìm theo Mã ID, Tiêu đề hoặc Tác giả (không phân biệt hoa thường).
6. **Lọc dữ liệu:**
   - Lọc theo Thể loại (Công nghệ, Văn học, Khoa học, Kinh tế, Lịch sử...).
   - Lọc theo Loại tài liệu (Sách in, EBook, Tạp chí).
   - Lọc theo Trạng thái (Sẵn sàng mượn, Đang mượn).
7. **Sắp xếp:**
   - Theo Tên tài liệu (A-Z hoặc Z-A).
   - Theo Năm xuất bản (Mới nhất hoặc Cũ nhất).
8. **Thống kê Dashboard:**
   - Tổng số tài liệu.
   - Số lượng tài liệu theo từng loại (Book, EBook, Magazine).
   - Số lượng tài liệu theo từng trạng thái (Available, Borrowed).
9. **Khôi phục dữ liệu mẫu:** Nút khôi phục nhanh về 6 tài liệu chuẩn bất cứ lúc nào.

---

## 4. Cách Chạy Ứng Dụng

- **Qua Trình duyệt Web (WAMP Server):**
  Truy cập URL: [http://localhost/week4/index.php](http://localhost/week4/index.php)
- **Kiểm thử tự động CLI:**
  Chạy lệnh trong PowerShell/CMD:
  ```bash
  php test_lib.php
  ```
