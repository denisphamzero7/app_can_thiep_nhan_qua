# 🏗️ KIẾN TRÚC HỆ THỐNG - APP CAN THIỆP NHÂN QUẢ

## 1. Luồng vận hành toàn hệ thống (End-to-End Flow)

```mermaid
sequenceDiagram
    autonumber
    actor Child as Trẻ em (TV)
    participant TV as App Android TV (Flutter)
    participant LocalDB as Bộ nhớ trong TV (SQLite/Cache)
    actor Parent as Bố Mẹ (Mobile)
    participant Web as Web Dashboard (XAMPP/PHP)

    Note over Parent,Web: Bố mẹ soạn câu hỏi & cài đặt thời gian
    Parent->>Web: Cấu hình: 10 phút/hiệp, BẬT can thiệp
    Parent->>Web: Nhập câu hỏi Mầm non (ảnh con vật) & Cấp 1
    TV->>Web: Định kỳ đồng bộ câu hỏi & cấu hình (qua Wi-Fi)
    Web-->>TV: Trả về JSON câu hỏi
    TV->>LocalDB: Lưu trữ Offline trên TV

    Note over Child,TV: Bắt đầu chu kỳ can thiệp trên TV
    Child->>TV: Bật TV xem YouTube
    TV->>TV: Background Service bắt đầu đếm giờ (10 phút)
    
    rect rgb(255, 230, 230)
    Note over TV: HẾT 10 PHÚT
    TV->>TV: Kích hoạt màn hình Overlay đè kín YouTube
    TV->>TV: Chặn phím Home, Back, chặn vào Cài đặt TV
    TV->>LocalDB: Bốc ngẫu nhiên câu hỏi (hoặc tự sinh câu hỏi)
    TV->>Child: Đọc to câu hỏi bằng tiếng Việt + Hiện 4 nút màu
    end

    alt Trẻ trả lời ĐÚNG
        Child->>TV: Bấm đúng nút màu trên Remote
        TV->>Child: Phát âm thanh chúc mừng "Ting ting"
        TV->>TV: Tự động ĐÓNG màn hình Overlay
        TV->>TV: RESET đồng hồ về 0, bắt đầu đếm 10 phút mới
    else Trẻ trả lời SAI
        Child->>TV: Bấm sai nút màu trên Remote
        TV->>Child: Phát âm thanh nhắc nhở
        TV->>TV: GIỮ NGUYÊN MÀN HÌNH KHÓA
        TV->>TV: Lập tức bốc câu hỏi MỚI tiếp theo!
    end

    opt Bố Mẹ muốn xem TV
        Parent->>Web: Gạt công tắc: TẮT CAN THIỆP
        Web-->>TV: Tín hiệu Real-time: is_active = false
        TV->>TV: Lập tức hạ màn hình câu hỏi xuống, trả lại TV tự do
    end
```

## 2. Nguyên tắc "Pháo đài" trên Android TV
- Không cung cấp bất kỳ nút thoát hoặc cài đặt nào trên màn hình TV.
- Vô hiệu hóa Accessibility cho màn hình `Settings` của hệ điều hành TV để ngăn trẻ tự gỡ cài đặt.
- Nút `Power` (Nguồn) vẫn hoạt động để trẻ có thể chủ động tắt TV đi ngủ nếu không muốn giải bài.
- 100% chức năng giải đố hoạt động Offline. Mất mạng internet hay rút cáp mạng thì app vẫn hoạt động bình thường nhờ cơ chế tự sinh câu hỏi logic.
