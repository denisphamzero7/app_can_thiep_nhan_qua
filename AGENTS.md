# Project Rules & Guidelines (Quy tắc Dự án - App Can Thiệp Nhân Quả)

Dự án kế thừa hệ thống quy tắc phát triển phần mềm chuẩn mực từ `equipment_manager`.

---

## 📌 1. Quy tắc Bắt buộc: Tự động Commit & Push lên Git sau mỗi thay đổi
- **Mục tiêu:** Đảm bảo toàn bộ tiến độ, mã nguồn, tài liệu và các cấu hình mới nhất luôn được lưu vết an toàn trên GitHub repository của dự án (`https://github.com/denisphamzero7/app_can_thiep_nhan_qua.git`) ngay sau khi hoàn thành công việc.
- **Quy trình thực hiện bắt buộc cho Agent:**
  1. **Kiểm tra trạng thái:** Chạy `git status` để xem các file vừa được tạo mới hoặc chỉnh sửa.
  2. **Stage thay đổi:** Chạy `git add <các file đã thay đổi>` (hoặc `git add .` nếu phù hợp). **Lưu ý:** Tuyệt đối không commit file `.env` hoặc file chứa secrets / credentials.
  3. **Tạo commit:** Commit với thông điệp rõ ràng, chuẩn định dạng **Conventional Commits**:
     - `feat: ...` khi thêm chức năng / module mới.
     - `fix: ...` khi sửa lỗi.
     - `docs: ...` khi cập nhật tài liệu / README / API docs.
     - `refactor: ...` khi tái cấu trúc code.
     - `chore: ...` cho các thay đổi cấu hình, dependencies, v.v.
  4. **Push lên GitHub:** Chạy `git push origin <tên-nhánh>` (mặc định là `main`).
  5. Báo cáo lại cho người dùng commit hash và tóm tắt những gì đã được đẩy lên remote repository.

---

## 🐳 2. Quy tắc Bắt buộc: Tự động Build & Cập nhật Docker sau mỗi lần sửa code thành công
- **Mục tiêu:** Đảm bảo container Docker luôn chạy mã nguồn và bản build Frontend/Backend mới nhất, người dùng chỉ cần F5 là thấy ngay kết quả.
- **Quy trình thực hiện bắt buộc cho Agent:**
  1. **Khi có thay đổi Frontend (Vue/JS/CSS):**
     - Chạy `npm run build` tại thư mục `Frontend` để tạo bản build mới (`Frontend/dist`).
     - Đồng bộ bản build vào container: `docker cp Frontend/dist/. equipment_manager-app-1:/var/www/html/public/` (nếu chạy Docker).
  2. **Khi có thay đổi Backend (PHP/Config/Migrations):**
     - Kiểm tra cú pháp PHP: `php -l <file>`.
     - Xóa cache Laravel: `php artisan optimize:clear`.
  3. Báo cáo trạng thái đồng bộ cho người dùng sau mỗi lượt sửa code.

---

## 🛡️ 3. Quy tắc An toàn & Bảo mật
- Luôn kiểm tra `.gitignore` để đảm bảo các file nhạy cảm (`.env`, `storage/`, `vendor/`, `node_modules/`, tokens) không bị lộ.
- Giữ vững tính toàn vẹn của code và các tài liệu liên quan trong dự án.

---

## 🏗️ 4. Kiến trúc Hệ thống & Phân chia Trách nhiệm
1. **Web Dashboard (Phụ huynh):** Quản trị câu hỏi, cấu hình thời gian đếm ngược, nút gạt khẩn cấp BẬT/TẮT từ xa (Kế thừa nền tảng Laravel + Vue 3).
2. **App TV (Trẻ em - Flutter):** Chạy ngầm trên Android TV, giao diện sinh động, Text-To-Speech tiếng Việt, chọn đáp án bằng 4 nút màu remote (🔴 🟢 🟡 🔵), hoạt động 100% offline và tự sinh câu hỏi.
3. **Docs (`docs/`):** Tài liệu đặc tả kỹ thuật, luồng dữ liệu, API, và hướng dẫn cài đặt.
