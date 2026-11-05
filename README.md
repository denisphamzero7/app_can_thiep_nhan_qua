# 📺 APP CAN THIỆP NHÂN QUẢ (STUDY-TO-WATCH TV)

> **Cơ chế:** Muốn xem TV thì phải giải đố! Cứ sau mỗi 10 phút xem, TV tự động phủ màn hình câu hỏi. Trả lời đúng -> Màn hình tự tắt và reset đồng hồ đếm lại từ đầu. Trả lời sai -> Đưa ra câu hỏi mới. Mọi quyền kiểm soát nằm trọn trong tay Bố Mẹ thông qua Web Dashboard.

---

## 🎯 1. Đối tượng sử dụng
- **Trẻ Mầm non (3 - 5 tuổi):** Câu hỏi nhận biết hình ảnh (con vật, hoa quả, màu sắc, hình khối), đếm số lượng trực quan kèm **giọng đọc tiếng Việt (Text-to-Speech)**. Điều khiển bằng **4 nút màu remote (🔴 🟢 🟡 🔵)**.
- **Học sinh Cấp 1 (Lớp 1 - 5):** Câu hỏi toán học nhẩm nhanh, ghép từ tiếng Việt, từ vựng tiếng Anh.

---

## 🏗️ 2. Kiến trúc Hệ thống

```
┌─────────────────────────────────────────────────────────────┐
│                 WEB DASHBOARD (BỐ MẸ)                       │
│    (Chạy trên Web LAN / Điện thoại di động của Bố Mẹ)       │
│  - Nút gạt khẩn cấp: BẬT / TẮT can thiệp TV (0 delay)       │
│  - Quản lý Ngân hàng câu hỏi (Hình ảnh, Âm thanh, Môn học)  │
│  - Cấu hình: Thời gian mỗi hiệp (10p), Giới hạn/ngày (60p)  │
│  - RESTful API đồng bộ với TV                               │
└──────────────────────────────┬──────────────────────────────┘
                               │ Wi-Fi LAN
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                 APP ANDROID TV (TRẺ EM)                     │
│         (Xây dựng bằng Flutter + Android Native)            │
│  - Chạy ngầm vĩnh viễn (Foreground Service)                 │
│  - Khóa cứng trên TV: Không có nút thoát, chặn Home/Back    │
│  - Hoạt động OFFLINE 100%: Ngân hàng lưu trong bộ nhớ máy   │
│  - Tự động sinh câu hỏi ngẫu nhiên không bao giờ cạn        │
│  - Đúng -> Tự đóng & Reset đếm giờ | Sai -> Ra câu hỏi mới  │
└─────────────────────────────────────────────────────────────┘
```

---

## 📂 3. Cấu trúc Thư mục
- `Dashboard/`: Web quản trị dành cho Phụ huynh (Backend API + Frontend giao diện điều khiển).
- `App_TV/`: Ứng dụng Flutter chạy trên Android TV.
- `docs/`: Tài liệu đặc tả kỹ thuật, luồng nghiệp vụ và hướng dẫn cài đặt.

---

## 📜 4. Quy tắc Dự án (Kế thừa từ Equipment Manager)
Tuân thủ nghiêm ngặt quy tắc trong `AGENTS.md`: Tự động Commit & Push lên GitHub sau mỗi lần thay đổi mã nguồn với chuẩn Conventional Commits.
