# 📺 ĐẶC TẢ KỸ THUẬT ỨNG DỤNG FLUTTER TRÊN ANDROID TV

## 1. Nền tảng & Cấu hình Android TV
- **Framework:** Flutter 3.x (Dart 3.x).
- **Target OS:** Android TV / Google TV (API Level 24 trở lên - Android 7.0 đến Android 14+).
- **Hỗ trợ điều khiển:** D-Pad Navigation và 4 nút màu tiêu chuẩn trên Remote TV:
  - 🔴 `KEYCODE_PROG_RED` (hoặc phím số 1)
  - 🟢 `KEYCODE_PROG_GREEN` (hoặc phím số 2)
  - 🟡 `KEYCODE_PROG_YELLOW` (hoặc phím số 3)
  - 🔵 `KEYCODE_PROG_BLUE` (hoặc phím số 4)

---

## 2. Các Plugin Flutter then chốt
- `flutter_overlay_window`: Hiển thị cửa sổ đè toàn màn hình lên các ứng dụng khác (YouTube/Netflix).
- `flutter_foreground_task`: Duy trì tiến trình chạy ngầm đếm thời gian vĩnh viễn không bị giải phóng bộ nhớ.
- `flutter_tts`: Đọc câu hỏi bằng giọng đọc tiếng Việt của Google Text-to-Speech.
- `audioplayers`: Phát âm thanh chúc mừng "Ting ting" hoặc âm thanh thử lại.
- `hive` hoặc `sqflite`: Cơ sở dữ liệu NoSQL/SQL cực nhanh lưu trữ Offline ngân hàng câu hỏi trên TV.

---

## 3. Bộ máy Tự sinh câu hỏi Logic (Procedural Question Generator)
Khi không có kết nối mạng hoặc hết ngân hàng câu hỏi thủ công, thuật toán nội bộ tự động sinh câu hỏi:

```dart
// Ví dụ sinh câu hỏi Mầm non (Đếm hình)
Map<String, dynamic> generateCountingQuestion() {
  final random = Random();
  final count = random.nextInt(9) + 1; // 1 đến 9
  final item = ['apple', 'banana', 'cat', 'dog', 'car'][random.nextInt(5)];
  return {
    'question': 'Có bao nhiêu $item trên màn hình?',
    'speech': 'Bé hãy đếm xem có bao nhiêu hình nhé!',
    'count': count,
    'correct_answer': count.toString(),
  };
}

// Ví dụ sinh phép tính Toán Cấp 1
Map<String, dynamic> generateMathQuestion(int grade) {
  final random = Random();
  if (grade <= 2) {
    int a = random.nextInt(20) + 1;
    int b = random.nextInt(20) + 1;
    return {
      'question': '$a + $b = ?',
      'speech': 'Mấy cộng mấy bằng bao nhiêu con nhỉ?',
      'correct_answer': (a + b).toString(),
    };
  } else {
    int a = random.nextInt(9) + 1;
    int b = random.nextInt(9) + 1;
    return {
      'question': '$a x $b = ?',
      'speech': '$a nhân $b bằng bao nhiêu con?',
      'correct_answer': (a * b).toString(),
    };
  }
}
```
