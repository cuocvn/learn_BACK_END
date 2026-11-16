# HỒ SƠ TIẾN ĐỘ & LỘ TRÌNH ÔN THI CẤP TỐC BACK-END WEB 1 (PHP & MYSQL)
> **Dành cho:** Trợ lý AI tiếp theo tiếp quản việc hướng dẫn học viên.  
> **Mục tiêu:** Thi thực hành đỗ điểm cao (8-9đ) môn **Lập trình Back-End Web 1** (Trường CĐ Công nghệ Thủ Đức - TDC) trong vòng 3 tuần.

---

## 1. ĐẶC ĐIỂM HỌC VIÊN & ĐỊNH HƯỚNG GIẢNG DẠY
- **Hiện trạng:** Hiểu tư duy và luồng hoạt động tổng thể, nhưng **yếu kỹ năng gõ code ("mù code")**, dễ bị bối rối khi nhìn vào màn hình trắng hoặc gõ nhầm cú pháp (dấu `<`, `?>`, chính tả SQL).
- **Tính cách học tập:** Thích dồn sức học tập trung theo buổi lớn (học một cục/cấp tốc), không thích chia nhỏ lắt nhắt mỗi ngày một ít.
- **Dạng đề thi của trường:** Đề thi cho sẵn **1 thư mục HTML tĩnh + 1 file database `.sql`**. Yêu cầu:
  1. Đổi đuôi `.html` sang `.php`.
  2. Kết nối CSDL (`db.php`).
  3. Đổ dữ liệu động lên giao diện (Trang chủ, Danh sách).
  4. Làm trọn vẹn CRUD (Create, Read, Update, Delete) cho bảng Sản phẩm / Danh mục.
  5. Tìm kiếm (`LIKE %keyword%`) & Phân trang (`LIMIT`, `OFFSET`).
  6. Quản lý Session / Cookie (Đăng nhập, đăng xuất).
- **Yêu cầu đối với AI hướng dẫn:**
  - **Code ngắn gọn, dễ nhớ, có khuôn mẫu (template)** để học viên có thể học thuộc lòng form code đi thi.
  - Hướng dẫn chậm rãi từng dòng, luôn soi và giải thích lỗi sai cú pháp ngay khi học viên gõ.
  - Tuyệt đối không dùng thư viện phức tạp, không viết code dài dòng khó hiểu.

---

## 2. NHỮNG THỨ ĐÃ LÀM VÀ ĐÃ HOÀN THÀNH ĐẾN HIỆN TẠI

### A. Môi trường & Database
- Đã kiểm tra môi trường WampServer (PHP 8.2, Apache 2.4, MySQL).
- Database đã import: **`shop_db`** (từ file `sql/shop_db.sql`) gồm 4 bảng:
  - `products` (id, name, price, image, description, stock, created_at)
  - `categories` (id, name)
  - `product_categories` (product_id, category_id)
  - `users` (id, fullname, email, password, phone, address, role)

### B. Chuẩn bị file & Cấu trúc Model (OOP)
- Đã đổi toàn bộ file từ `.html` sang `.php`.
- **`model/db.php`**: Đã viết hoàn chỉnh kết nối PDO siêu ngắn gọn:
  ```php
  <?php
  $host='localhost'; $dbname='shop_db'; $user='root'; $pass='';
  try {
      $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      die("Lỗi kết nối: " . $e->getMessage());
  }
  ```
- **`model/Category.php`**: Class `Category` chứa hàm `getAllCategory()`.
- **`model/Product.php`**: Class `Product` chứa đủ các hàm:
  - `getAllProduct($limit = null)`: Lấy sản phẩm kèm tên danh mục (`GROUP_CONCAT`).
  - `getProductById($id)`: Lấy chi tiết 1 sản phẩm theo ID.
  - `getProductByCateId($cateId)`: Lấy danh sách sản phẩm theo mã loại.
  - `add($name, $price, $image, $description, $stock)`: Thêm sản phẩm.
  - `edit($id, $name, $price, $image, $description, $stock)`: Cập nhật sản phẩm.
  - `delete($id)`: Xóa sản phẩm.

### C. Giao diện đã hoàn thành
1. **`index.php` (Trang chủ):**
   - Đã nhúng Model lấy danh mục động đổ vào dropdown.
   - Đã đổ 6 sản phẩm mới nhất ra lưới card Bootstrap bằng vòng lặp `foreach`.
   - Đã chuẩn hóa form "Thêm vào giỏ" mang ID động và chuyển các link sang đuôi `.php`.
2. **`admin-products.php` (Trang Quản trị - READ):**
   - Đã đổ danh sách toàn bộ 12 sản phẩm lên bảng HTML gồm 7 cột: `ID`, `Ảnh`, `Tên`, `Danh mục`, `Giá`, `Tồn`, `Thao tác`.
   - Đã gắn sẵn các nút Sửa (`admin-product-form.php?id=...`) và Xóa (`name="delete" value="..."`).

---

## 3. NHỮNG VIỆC CẦN LÀM TIẾP THEO (LỘ TRÌNH CHO AI KẾ TIẾP)

Trợ lý AI tiếp theo hãy hướng dẫn học viên đi theo thứ tự ưu tiên thi sau:

### 🔴 Việc 1: Chức năng XÓA sản phẩm trên `admin-products.php`
- Bắt sự kiện khi người dùng nhấn nút Xóa (`isset($_POST['delete'])` hoặc `$_GET['delete']`).
- Gọi phương thức `$productModel->delete($id)` hoặc viết câu truy vấn xóa trực tiếp.
- Dùng `header("Location: admin-products.php"); exit;` để làm mới danh sách.

### 🔴 Việc 2: Chức năng THÊM MỚI & SỬA sản phẩm trên `admin-product-form.php`
- **Khi Thêm mới:** Form rỗng, người dùng nhập tên, giá, mô tả, tồn kho $\rightarrow$ bấm submit $\rightarrow$ gọi `$productModel->add(...)`.
- **Khi Sửa (`?id=...`):** Lấy ID từ `$_GET['id']`, gọi `$productModel->getProductById($id)` để điền sẵn dữ liệu cũ vào các ô `<input value="...">` $\rightarrow$ bấm submit $\rightarrow$ gọi `$productModel->edit(...)`.
- **Kỹ thuật Upload ảnh (Chương 7 giáo trình):**
  - Form có `enctype="multipart/form-data"`.
  - Nhận file qua `$_FILES['image']`, dùng `move_uploaded_file()` để lưu vào thư mục `images/` hoặc `uploads/`.

### 🟡 Việc 3: Trang `products.php` (Lọc theo danh mục)
- Kiểm tra `$_GET['cat']`:
  - Nếu không có `cat` $\rightarrow$ gọi `getAllProduct()` (hiện tất cả).
  - Nếu có `cat` $\rightarrow$ gọi `getProductByCateId($_GET['cat'])` (chỉ hiện sản phẩm loại đó).
  - Đánh dấu class `active` cho tab danh mục đang được chọn.

### 🟡 Việc 4: Trang `product-detail.php` (Chi tiết sản phẩm)
- Lấy `$_GET['id']`.
- Gọi `$productModel->getProductById($id)`.
- Đổ các thông tin đầy đủ: Ảnh, Tên, Giá, Mô tả (`description`), Tồn kho (`stock`).

### 🟢 Việc 5: Tìm kiếm & Phân trang (Chương 6 giáo trình - Điểm 9-10)
- **Tìm kiếm:** Thêm ô input `<input name="keyword">`, truy vấn SQL: `WHERE name LIKE ?` với tham số `'%'.$keyword.'%'`.
- **Phân trang 7 bước:**
  1. Số bản ghi mỗi trang: `$perPage = 4;`
  2. Số trang hiện tại: `$page = $_GET['page'] ?? 1;`
  3. Vị trí bắt đầu: `$offset = ($page - 1) * $perPage;`
  4. Đếm tổng sản phẩm: `SELECT COUNT(*) FROM products` $\rightarrow$ tính `$maxPage = ceil($total / $perPage);`
  5. Truy vấn giới hạn: `LIMIT $offset, $perPage`
  6. Vẽ thanh phân trang: Nút Previous, vòng lặp `for ($i=1; $i<=$maxPage; $i++)`, nút Next.

### 🟢 Việc 6: Đăng nhập & Đăng xuất (Chương 4 giáo trình - Session)
- Trang `login.php`: Kiểm tra `email` / `password` bằng `password_verify()`. Lưu thông tin vào `$_SESSION['user']`.
- Trang `logout.php`: `session_start(); session_destroy(); header("Location: login.php");`.
- Phân quyền: Nếu role không phải `'admin'` thì chặn không cho vào `admin-products.php`.

---

## 4. QUY TẮC VÀNG CHO AI HƯỚNG DẪN:
1. **Mỗi tính năng chỉ viết từ 3 đến 5 dòng code cốt lõi.**
2. **Không làm thay tất cả một lượt.** Hãy đưa từng đoạn nhỏ, chỉ rõ "Dán vào dòng số mấy", để học viên thao tác và kiểm tra trình duyệt.
3. **Khi học viên gặp lỗi:** Yêu cầu học viên gửi mã lỗi hoặc code, AI chỉ ra chính xác từ ngữ hoặc ký tự viết sai để học viên sửa và nhớ sâu.
