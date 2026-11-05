# 🔌 TÀI LIỆU ĐẶC TẢ API - WEB DASHBOARD & TV

Giao thức: HTTP RESTful API (Định dạng JSON) qua mạng Wi-Fi LAN gia đình.

---

### 1. `GET /api/tv/status`
Lấy trạng thái cấu hình hiện tại mà Bố Mẹ thiết lập trên Dashboard. TV gọi endpoint này định kỳ (mỗi 3 giây) hoặc khi TV khởi động.

#### Response (JSON):
```json
{
  "success": true,
  "data": {
    "is_active": true,
    "interval_minutes": 10,
    "daily_limit_minutes": 60,
    "target_grade": "mam_non",
    "required_correct_answers": 1,
    "updated_at": "2026-11-05 17:15:00"
  }
}
```

*Nếu `is_active == false`*: TV lập tức hạ màn hình câu hỏi xuống và dừng đếm giờ (người lớn đang xem).

---

### 2. `GET /api/tv/questions`
Đồng bộ toàn bộ ngân hàng câu hỏi từ Dashboard về lưu offline trên TV.

#### Query Parameters:
- `grade`: (Tùy chọn) `all`, `mam_non`, `lop_1`, `lop_2`, `lop_3`, `lop_4`, `lop_5`.

#### Response (JSON):
```json
{
  "success": true,
  "total": 50,
  "data": [
    {
      "id": 1,
      "grade": "mam_non",
      "category": "nhan_biet",
      "question_text": "Đâu là quả Dâu Tây?",
      "speech_text": "Bé hãy tìm xem đâu là quả dâu tây nhé!",
      "options": [
        {"color": "red", "type": "image", "content": "/uploads/dau_tay.png", "is_correct": true},
        {"color": "green", "type": "image", "content": "/uploads/chuoi.png", "is_correct": false},
        {"color": "yellow", "type": "image", "content": "/uploads/cam.png", "is_correct": false},
        {"color": "blue", "type": "image", "content": "/uploads/nho.png", "is_correct": false}
      ]
    },
    {
      "id": 2,
      "grade": "lop_2",
      "category": "toan",
      "question_text": "7 x 8 bằng bao nhiêu?",
      "speech_text": "Bảy nhân tám bằng bao nhiêu vậy con?",
      "options": [
        {"color": "red", "type": "text", "content": "54", "is_correct": false},
        {"color": "green", "type": "text", "content": "56", "is_correct": true},
        {"color": "yellow", "type": "text", "content": "48", "is_correct": false},
        {"color": "blue", "type": "text", "content": "64", "is_correct": false}
      ]
    }
  ]
}
```

---

### 3. `POST /api/tv/report`
TV gửi báo cáo nhật ký xem và kết quả làm bài của con về Dashboard.

#### Request Body (JSON):
```json
{
  "device_id": "TV_PHONG_KHACH",
  "watch_time_minutes": 10,
  "question_id": 1,
  "is_correct": true,
  "timestamp": "2026-11-05 17:20:00"
}
```

#### Response (JSON):
```json
{
  "success": true,
  "message": "Report logged successfully"
}
```
