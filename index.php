<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Can Thiệp Nhân Quả TV - Dashboard Phụ Huynh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-active {
            background-color: #e0e7ff;
            color: #4338ca;
            font-weight: 700;
        }
        .tv-bezel {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex">

    <!-- ========================================== -->
    <!-- 1. MÀN HÌNH ĐĂNG NHẬP PHỤ HUYNH (LOGIN) -->
    <!-- ========================================== -->
    <div id="loginScreen" class="fixed inset-0 z-50 bg-slate-900/90 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-slate-100 relative">
            <div class="text-center space-y-3">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-indigo-600 flex items-center justify-center text-white text-3xl shadow-lg shadow-indigo-200">
                    <i class="fa-solid fa-shield-cat"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Khu Vực Phụ Huynh</h2>
                    <p class="text-sm text-slate-500 mt-1">Vui lòng nhập mã PIN để quản lý cài đặt TV</p>
                </div>
            </div>

            <form onsubmit="handleLogin(event)" class="mt-8 space-y-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Mã PIN Phụ Huynh</label>
                    <div class="relative">
                        <input type="password" id="loginPinInput" maxlength="6" autofocus required placeholder="Nhập PIN (Mặc định: 1234)" 
                            class="w-full text-center text-2xl tracking-[0.4em] font-black py-3.5 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:border-indigo-600 focus:outline-none transition">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-2 text-center">Gợi ý: Mã PIN mặc định ban đầu là <strong class="text-indigo-600 font-bold">1234</strong></p>
                </div>

                <div id="loginErrorMsg" class="text-xs text-rose-600 font-bold text-center hidden">
                    Mã PIN không chính xác. Vui lòng thử lại!
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-lock-open"></i>
                    <span>Mở Khóa Quản Trị</span>
                </button>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. THANH ĐIỀU HƯỚNG BÊN TRÁI (SIDEBAR)     -->
    <!-- ========================================== -->
    <aside id="sidebar" class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between transition-all duration-300 z-40 fixed md:static inset-y-0 left-0 -translate-x-full md:translate-x-0">
        <div>
            <!-- Logo Header -->
            <div class="p-5 border-b border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-500 flex items-center justify-center text-white text-xl shadow-md">
                    <i class="fa-solid fa-tv"></i>
                </div>
                <div>
                    <h1 class="text-sm font-black text-slate-900 tracking-tight leading-tight">Can Thiệp TV</h1>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded">Kids Karma</span>
                </div>
            </div>

            <!-- Menu Navigation -->
            <div class="p-3 space-y-1">
                <div class="px-3 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bảng điều khiển</div>
                
                <button onclick="switchTab('dashboard')" id="nav-dashboard" class="sidebar-btn sidebar-active w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                    <span>Tổng quan & Điều khiển</span>
                </button>

                <button onclick="switchTab('questions')" id="nav-questions" class="sidebar-btn text-slate-600 hover:bg-slate-50 w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition">
                    <i class="fa-solid fa-circle-question w-5 text-center"></i>
                    <span>Ngân hàng câu hỏi</span>
                </button>

                <button onclick="switchTab('simulator')" id="nav-simulator" class="sidebar-btn text-slate-600 hover:bg-slate-50 w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition">
                    <i class="fa-solid fa-gamepad w-5 text-center"></i>
                    <span>Trình giả lập TV</span>
                </button>

                <div class="pt-4 px-3 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Hệ thống</div>

                <button onclick="switchTab('logs')" id="nav-logs" class="sidebar-btn text-slate-600 hover:bg-slate-50 w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition">
                    <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
                    <span>Nhật ký làm bài</span>
                </button>

                <button onclick="switchTab('settings')" id="nav-settings" class="sidebar-btn text-slate-600 hover:bg-slate-50 w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition">
                    <i class="fa-solid fa-key w-5 text-center"></i>
                    <span>Đổi mã PIN phụ huynh</span>
                </button>
            </div>
        </div>

        <!-- Footer Profile -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600 text-xs">
                    BM
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Bố Mẹ</div>
                    <div class="text-[10px] text-slate-400">Quyền Quản Trị</div>
                </div>
            </div>
            <button onclick="logout()" class="text-slate-400 hover:text-rose-500 p-1.5 rounded-lg text-sm transition" title="Đăng xuất">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </div>
    </aside>

    <!-- ========================================== -->
    <!-- 3. KHU VỰC NỘI DUNG CHÍNH (MAIN AREA)      -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">

        <!-- Top Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-30 px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="md:hidden text-slate-600 text-lg p-1.5 rounded-lg hover:bg-slate-100">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="flex items-center gap-2">
                    <span id="tvStatusDot" class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span id="tvStatusText" class="text-xs font-bold text-slate-700">TV: Đang bật can thiệp</span>
                </div>
            </div>

            <!-- Nút bật/tắt nhanh trên Topbar -->
            <div class="flex items-center gap-3">
                <button id="topbarToggleBtn" onclick="toggleActiveStatus()" class="px-4 py-1.5 rounded-xl text-xs font-bold text-white flex items-center gap-1.5 shadow transition bg-emerald-500 hover:bg-emerald-600">
                    <i class="fa-solid fa-power-off"></i>
                    <span id="topbarToggleText">ĐANG BẬT</span>
                </button>
            </div>
        </header>

        <!-- Main Content Body -->
        <main class="p-6 max-w-6xl w-full mx-auto space-y-6">

            <!-- ====================================== -->
            <!-- TAB 1: TỔNG QUAN & ĐIỀU KHIỂN TV       -->
            <!-- ====================================== -->
            <div id="tab-dashboard" class="tab-content space-y-6">
                <!-- Thẻ công tắc lớn -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Công tắc khẩn cấp</span>
                            <h2 class="text-2xl font-black text-slate-900">
                                Chế độ Can thiệp TV: 
                                <span id="bigStatusBadge" class="text-emerald-600">🟢 ĐANG BẬT</span>
                            </h2>
                            <p class="text-sm text-slate-500 max-w-xl">
                                Khi BẬT, cứ sau 10 phút xem thì TV tự khóa đố bài. Khi TẮT, TV được mở hoàn toàn tự do để người lớn xem phim hoặc thời sự.
                            </p>
                        </div>

                        <div>
                            <button id="bigToggleBtn" onclick="toggleActiveStatus()" class="px-8 py-4 rounded-2xl font-black text-white text-base shadow-lg shadow-emerald-200 transition transform active:scale-95 bg-emerald-500 hover:bg-emerald-600 flex items-center gap-3">
                                <i class="fa-solid fa-shield-halved text-xl"></i>
                                <span id="bigToggleText">ĐANG BẬT (BẤM ĐỂ TẮT)</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 3 Thẻ thống kê & Cài đặt thời gian -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Thời gian mỗi hiệp -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="flex items-center gap-2 text-indigo-600 font-bold mb-1">
                            <i class="fa-solid fa-hourglass-half"></i>
                            <h3 class="text-sm font-bold text-slate-800">Thời gian mỗi hiệp</h3>
                        </div>
                        <p class="text-xs text-slate-500 mb-3">Sau bao nhiêu phút thì TV khóa đố bài</p>
                        <div class="flex gap-2">
                            <button onclick="updateInterval(5)" class="interval-btn flex-1 py-1.5 rounded-lg border text-xs font-bold hover:bg-slate-50" data-val="5">5 phút</button>
                            <button onclick="updateInterval(10)" class="interval-btn flex-1 py-1.5 rounded-lg border text-xs font-bold hover:bg-slate-50" data-val="10">10 phút</button>
                            <button onclick="updateInterval(15)" class="interval-btn flex-1 py-1.5 rounded-lg border text-xs font-bold hover:bg-slate-50" data-val="15">15 phút</button>
                        </div>
                    </div>

                    <!-- Khối lớp của con -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="flex items-center gap-2 text-amber-500 font-bold mb-1">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <h3 class="text-sm font-bold text-slate-800">Cấp học của bé</h3>
                        </div>
                        <p class="text-xs text-slate-500 mb-3">TV ưu tiên câu hỏi theo khối lớp này</p>
                        <select id="targetGradeSelect" onchange="updateGrade(this.value)" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs font-semibold focus:outline-none focus:border-indigo-500">
                            <option value="mam_non">Mầm non (3 - 5 tuổi) - Nhận biết & Đếm</option>
                            <option value="lop_1">Lớp 1 (6 tuổi) - Toán 10, Đọc chữ</option>
                            <option value="lop_2">Lớp 2 (7 tuổi) - Bảng cửu chương 2-5</option>
                            <option value="lop_3">Lớp 3 (8 tuổi) - Bảng cửu chương 6-9</option>
                        </select>
                    </div>

                    <!-- Giới hạn ngày -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="flex items-center gap-2 text-rose-500 font-bold mb-1">
                            <i class="fa-solid fa-clock"></i>
                            <h3 class="text-sm font-bold text-slate-800">Giới hạn xem / ngày</h3>
                        </div>
                        <p class="text-xs text-slate-500 mb-3">Đủ thời gian này TV khóa hẳn đi ngủ</p>
                        <div class="flex items-center gap-2">
                            <input type="number" id="dailyLimitInput" value="60" min="15" max="300" step="15" class="w-20 bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-center">
                            <span class="text-xs font-medium text-slate-600">phút/ngày</span>
                            <button onclick="updateDailyLimit()" class="ml-auto px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-bold hover:bg-indigo-700">Lưu</button>
                        </div>
                    </div>
                </div>

                <!-- Thống kê nhanh hôm nay -->
                <div class="bg-indigo-900 text-white rounded-3xl p-6 shadow-md flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-1">
                        <h4 class="text-lg font-extrabold">Hôm nay bé đã xem: 35 / 60 phút</h4>
                        <p class="text-xs text-indigo-200">Đã vượt qua 4 câu hỏi trắc nghiệm thành công</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="switchTab('simulator')" class="px-5 py-2.5 bg-white text-indigo-900 rounded-xl font-bold text-xs shadow hover:bg-indigo-50 transition flex items-center gap-2">
                            <i class="fa-solid fa-play"></i>
                            <span>Xem Trình Giả Lập TV</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ====================================== -->
            <!-- TAB 2: NGÂN HÀNG CÂU HỎI               -->
            <!-- ====================================== -->
            <div id="tab-questions" class="tab-content hidden space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Form thêm câu hỏi -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-circle-plus text-indigo-600"></i>
                            <span>Soạn câu hỏi mới</span>
                        </h3>
                        <p class="text-xs text-slate-500">Soạn trên điện thoại, TV tự động lấy về</p>

                        <form id="addQuestionForm" onsubmit="saveQuestion(event)" class="space-y-3.5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Dành cho cấp</label>
                                <select id="formGrade" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-semibold">
                                    <option value="mam_non">Mầm non (3 - 5 tuổi)</option>
                                    <option value="lop_1">Lớp 1</option>
                                    <option value="lop_2">Lớp 2</option>
                                    <option value="lop_3">Lớp 3</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nội dung câu hỏi</label>
                                <textarea id="formQuestionText" rows="2" required placeholder="Ví dụ: 7 x 8 = ? hoặc Đâu là quả Dâu Tây?" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-medium focus:outline-none focus:border-indigo-500"></textarea>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="text-xs font-bold text-slate-700">Giọng đọc TV (TTS Tiếng Việt)</label>
                                    <button type="button" onclick="testTTS()" class="text-indigo-600 text-[11px] font-bold hover:underline flex items-center gap-1">
                                        <i class="fa-solid fa-volume-high"></i> Nghe thử
                                    </button>
                                </div>
                                <input type="text" id="formSpeechText" placeholder="Câu TV sẽ đọc to cho bé nghe" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium">
                            </div>

                            <!-- 4 Nút màu Remote -->
                            <div class="space-y-2 pt-2 border-t border-slate-100">
                                <label class="block text-xs font-bold text-slate-700">4 Nút màu Remote (Tích chọn câu ĐÚNG):</label>
                                
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="correctColor" value="red" required class="accent-rose-500 w-4 h-4">
                                    <span class="w-3 h-3 rounded-full bg-rose-500 flex-shrink-0"></span>
                                    <input type="text" id="optRed" required placeholder="Đáp án Nút Đỏ" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5 text-xs">
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="radio" name="correctColor" value="green" class="accent-emerald-500 w-4 h-4">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500 flex-shrink-0"></span>
                                    <input type="text" id="optGreen" required placeholder="Đáp án Nút Xanh Lá" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5 text-xs">
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="radio" name="correctColor" value="yellow" class="accent-amber-400 w-4 h-4">
                                    <span class="w-3 h-3 rounded-full bg-amber-400 flex-shrink-0"></span>
                                    <input type="text" id="optYellow" required placeholder="Đáp án Nút Vàng" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5 text-xs">
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="radio" name="correctColor" value="blue" class="accent-blue-500 w-4 h-4">
                                    <span class="w-3 h-3 rounded-full bg-blue-500 flex-shrink-0"></span>
                                    <input type="text" id="optBlue" required placeholder="Đáp án Nút Xanh Dương" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5 text-xs">
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow transition">
                                <i class="fa-solid fa-floppy-disk mr-1"></i> Lưu Câu Hỏi
                            </button>
                        </form>
                    </div>

                    <!-- Danh sách câu hỏi -->
                    <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-200 flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Danh sách câu hỏi sẵn sàng</h3>
                                <p class="text-xs text-slate-500" id="totalQuestionsCount">Đang tải...</p>
                            </div>
                            <select id="filterGrade" onchange="loadQuestions()" class="bg-slate-50 border border-slate-300 rounded-xl px-3 py-1.5 text-xs font-semibold">
                                <option value="all">Tất cả các lớp</option>
                                <option value="mam_non">Mầm non</option>
                                <option value="lop_1">Lớp 1</option>
                                <option value="lop_2">Lớp 2</option>
                                <option value="lop_3">Lớp 3</option>
                            </select>
                        </div>

                        <div id="questionsList" class="space-y-3 overflow-y-auto max-h-[500px] pr-1">
                            <!-- Javascript nạp danh sách câu hỏi -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====================================== -->
            <!-- TAB 3: TRÌNH GIẢ LẬP TV (SIMULATOR)    -->
            <!-- ====================================== -->
            <div id="tab-simulator" class="tab-content hidden space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Mô Phỏng Trực Tiếp Màn Hình TV</h3>
                        <p class="text-xs text-slate-500">Trải nghiệm tương tác giống 100% như trên Android TV thật</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="fastForwardSim()" class="px-3.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold shadow transition">
                            ⚡ Tua nhanh 2s đến giờ hỏi
                        </button>
                    </div>
                </div>

                <!-- Khung TV Simulator 16:9 -->
                <div class="relative w-full aspect-video bg-black rounded-3xl border-8 border-slate-800 tv-bezel overflow-hidden">
                    <!-- Video hoạt hình đang chiếu -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 p-8 text-center text-white">
                        <div class="w-20 h-20 mx-auto rounded-full bg-red-600 flex items-center justify-center text-3xl shadow-xl mb-3">
                            <i class="fa-brands fa-youtube"></i>
                        </div>
                        <h4 class="text-xl font-black">Bé Đang Xem Hoạt Hình</h4>
                        <p class="text-xs text-slate-300 mt-1">Đồng hồ ngầm đang đếm thời gian xem TV...</p>

                        <div class="inline-flex items-center gap-3 bg-black/50 backdrop-blur-md px-5 py-2.5 rounded-2xl border border-white/10 mt-4">
                            <i class="fa-solid fa-hourglass-start text-amber-400 text-lg"></i>
                            <div class="text-left">
                                <div class="text-[9px] uppercase tracking-wider text-slate-400 font-bold">Thời gian còn lại</div>
                                <div id="simCountdown" class="text-xl font-black text-amber-400 font-mono">10:00</div>
                            </div>
                        </div>
                    </div>

                    <!-- Màn hình câu hỏi phủ lên (Overlay) -->
                    <div id="simOverlay" class="absolute inset-0 z-50 bg-slate-950/95 backdrop-blur-xl flex flex-col items-center justify-between p-6 md:p-8 hidden">
                        <div class="w-full flex items-center justify-between border-b border-white/10 pb-3">
                            <span class="text-xs font-extrabold text-amber-400 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                                Thử Thách Vui - Trả Lời Đúng Để Xem Tiếp!
                            </span>
                            <span class="text-[11px] text-slate-400 font-semibold">Phím: 1, 2, 3, 4</span>
                        </div>

                        <div class="my-auto text-center max-w-2xl space-y-3">
                            <span id="simGradeBadge" class="inline-block px-3 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 text-[10px] font-bold uppercase border border-indigo-500/30">Mầm Non</span>
                            <h3 id="simQuestionText" class="text-2xl md:text-4xl font-black text-white leading-tight">Đâu là quả Dâu Tây?</h3>
                            <div class="text-xs text-slate-300 italic" id="simSpeechText">"Bé hãy tìm xem đâu là quả dâu tây nhé!"</div>
                        </div>

                        <!-- 4 Đáp án -->
                        <div id="simOptionsContainer" class="w-full grid grid-cols-2 gap-3 max-w-3xl"></div>

                        <!-- Thông báo đúng sai -->
                        <div id="simFeedback" class="text-xs font-bold text-slate-400 min-h-[20px] text-center">
                            Chọn đúng để mở lại TV ngay lập tức!
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====================================== -->
            <!-- TAB 4: NHẬT KÝ LÀM BÀI                 -->
            <!-- ====================================== -->
            <div id="tab-logs" class="tab-content hidden space-y-4">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                    <h3 class="text-base font-bold text-slate-900 mb-1">Nhật Ký Học Tập Của Con</h3>
                    <p class="text-xs text-slate-500 mb-4">Lịch sử trả lời câu hỏi và các hiệp xem TV</p>

                    <div class="space-y-2.5">
                        <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs"><i class="fa-solid fa-check"></i></span>
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Trả lời đúng câu: Đâu là quả Dâu Tây?</div>
                                    <div class="text-[10px] text-slate-400">Cách đây 20 phút • TV Phòng khách</div>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-emerald-600">+10 phút xem</span>
                        </div>

                        <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-xs"><i class="fa-solid fa-xmark"></i></span>
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Trả lời sai: 6 x 7 = ?</div>
                                    <div class="text-[10px] text-slate-400">Cách đây 35 phút • Đổi câu hỏi mới</div>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-rose-500">Tiếp tục giải</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====================================== -->
            <!-- TAB 5: ĐỔI MÃ PIN PHỤ HUYNH            -->
            <!-- ====================================== -->
            <div id="tab-settings" class="tab-content hidden space-y-4">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 max-w-md">
                    <h3 class="text-base font-bold text-slate-900 mb-1">Bảo Mật & Mã PIN Phụ Huynh</h3>
                    <p class="text-xs text-slate-500 mb-5">Đổi mã PIN để ngăn trẻ vào can thiệp cài đặt</p>

                    <form onsubmit="changePin(event)" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Mã PIN hiện tại</label>
                            <input type="password" id="oldPinInput" required placeholder="Nhập PIN cũ" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Mã PIN mới (ít nhất 4 số)</label>
                            <input type="password" id="newPinInput" minlength="4" required placeholder="Nhập PIN mới" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold">
                        </div>

                        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow transition">
                            Cập Nhật Mã PIN
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- JAVASCRIPT XỬ LÝ TOÀN BỘ LOGIC -->
    <script>
        let currentSettings = { is_active: true, interval_minutes: 10, daily_limit_minutes: 60, target_grade: 'mam_non' };
        let allQuestions = [];
        let currentSimQuestion = null;
        let simTimeLeft = 600;
        let simInterval = null;

        // 1. Kiểm tra trạng thái đăng nhập
        function checkAuth() {
            const token = sessionStorage.getItem('parent_auth_token');
            if (token) {
                document.getElementById('loginScreen').classList.add('hidden');
            } else {
                document.getElementById('loginScreen').classList.remove('hidden');
            }
        }

        async function handleLogin(e) {
            e.preventDefault();
            const pin = document.getElementById('loginPinInput').value;
            const res = await fetch('api/auth.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ action: 'login', pin: pin })
            });
            const data = await res.json();
            if (data.success) {
                sessionStorage.setItem('parent_auth_token', data.token);
                document.getElementById('loginScreen').classList.add('hidden');
                document.getElementById('loginErrorMsg').classList.add('hidden');
            } else {
                document.getElementById('loginErrorMsg').classList.remove('hidden');
            }
        }

        function logout() {
            sessionStorage.removeItem('parent_auth_token');
            location.reload();
        }

        // 2. Chuyển Tab Sidebar
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.sidebar-btn').forEach(btn => {
                btn.classList.remove('sidebar-active', 'font-bold');
                btn.classList.add('text-slate-600', 'font-medium');
            });

            document.getElementById(`tab-${tabId}`).classList.remove('hidden');
            const activeBtn = document.getElementById(`nav-${tabId}`);
            if (activeBtn) {
                activeBtn.classList.add('sidebar-active', 'font-bold');
                activeBtn.classList.remove('text-slate-600', 'font-medium');
            }

            // Đóng sidebar trên mobile nếu đang mở
            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.add('-translate-x-full');
            }
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        }

        // 3. Tải và đồng bộ Cài đặt
        async function loadSettings() {
            try {
                const res = await fetch('api/status.php');
                const result = await res.json();
                if (result.success) {
                    currentSettings = result.data;
                    updateUIWithSettings();
                }
            } catch (e) { console.error(e); }
        }

        function updateUIWithSettings() {
            const isActive = currentSettings.is_active;

            // Topbar
            const topbarBtn = document.getElementById('topbarToggleBtn');
            const topbarText = document.getElementById('topbarToggleText');
            const dot = document.getElementById('tvStatusDot');
            const statusText = document.getElementById('tvStatusText');

            // Tab Dashboard
            const bigBtn = document.getElementById('bigToggleBtn');
            const bigText = document.getElementById('bigToggleText');
            const bigBadge = document.getElementById('bigStatusBadge');

            if (isActive) {
                topbarBtn.className = "px-4 py-1.5 rounded-xl text-xs font-bold text-white flex items-center gap-1.5 shadow transition bg-emerald-500 hover:bg-emerald-600";
                topbarText.innerText = "ĐANG BẬT";
                dot.className = "w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse";
                statusText.innerText = "TV: Đang bật can thiệp";

                bigBtn.className = "px-8 py-4 rounded-2xl font-black text-white text-base shadow-lg shadow-emerald-200 transition transform active:scale-95 bg-emerald-500 hover:bg-emerald-600 flex items-center gap-3";
                bigText.innerText = "ĐANG BẬT (BẤM ĐỂ TẮT)";
                bigBadge.innerText = "🟢 ĐANG BẬT";
                bigBadge.className = "text-emerald-600";
            } else {
                topbarBtn.className = "px-4 py-1.5 rounded-xl text-xs font-bold text-white flex items-center gap-1.5 shadow transition bg-rose-500 hover:bg-rose-600";
                topbarText.innerText = "ĐÃ TẮT";
                dot.className = "w-2.5 h-2.5 rounded-full bg-rose-500";
                statusText.innerText = "TV: Đã tắt can thiệp (Tự do)";

                bigBtn.className = "px-8 py-4 rounded-2xl font-black text-white text-base shadow-lg shadow-rose-200 transition transform active:scale-95 bg-rose-500 hover:bg-rose-600 flex items-center gap-3";
                bigText.innerText = "ĐÃ TẮT (BẤM ĐỂ BẬT)";
                bigBadge.innerText = "🔴 ĐÃ TẮT (TỰ DO XEM)";
                bigBadge.className = "text-rose-600";
            }

            // Interval buttons
            document.querySelectorAll('.interval-btn').forEach(b => {
                if (parseInt(b.dataset.val) === currentSettings.interval_minutes) {
                    b.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                    b.classList.remove('hover:bg-slate-50');
                } else {
                    b.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                    b.classList.add('hover:bg-slate-50');
                }
            });

            document.getElementById('targetGradeSelect').value = currentSettings.target_grade || 'mam_non';
            document.getElementById('dailyLimitInput').value = currentSettings.daily_limit_minutes || 60;
        }

        async function toggleActiveStatus() {
            const newStatus = !currentSettings.is_active;
            const res = await fetch('api/toggle_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ is_active: newStatus })
            });
            const data = await res.json();
            if (data.success) {
                currentSettings.is_active = newStatus;
                updateUIWithSettings();
                if (!newStatus) closeSimOverlay();
            }
        }

        async function updateInterval(minutes) {
            const res = await fetch('api/toggle_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ interval_minutes: minutes })
            });
            const data = await res.json();
            if (data.success) {
                currentSettings.interval_minutes = minutes;
                simTimeLeft = minutes * 60;
                updateUIWithSettings();
            }
        }

        async function updateGrade(grade) {
            await fetch('api/toggle_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ target_grade: grade })
            });
            currentSettings.target_grade = grade;
        }

        async function updateDailyLimit() {
            const val = document.getElementById('dailyLimitInput').value;
            await fetch('api/toggle_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ daily_limit_minutes: parseInt(val) })
            });
            alert('Đã lưu hạn mức ngày!');
        }

        // 4. Ngân hàng câu hỏi
        async function loadQuestions() {
            const grade = document.getElementById('filterGrade').value;
            const res = await fetch(`api/questions.php?grade=${grade}`);
            const data = await res.json();
            allQuestions = data.data || [];
            
            const list = document.getElementById('questionsList');
            document.getElementById('totalQuestionsCount').innerText = `${allQuestions.length} câu hỏi sẵn sàng`;
            
            if (allQuestions.length === 0) {
                list.innerHTML = `<div class="p-8 text-center text-slate-400 text-xs">Chưa có câu hỏi nào.</div>`;
                return;
            }

            list.innerHTML = allQuestions.map(q => `
                <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white transition flex items-start justify-between gap-3">
                    <div class="space-y-1 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-indigo-100 text-indigo-700">${q.grade}</span>
                            <span class="font-bold text-xs text-slate-800">${q.question_text}</span>
                        </div>
                        <div class="text-[11px] text-slate-500 italic"><i class="fa-solid fa-volume-low"></i> "${q.speech_text}"</div>
                        <div class="grid grid-cols-2 gap-1.5 pt-1">
                            ${q.options.map(opt => `
                                <div class="flex items-center gap-1.5 text-[11px] ${opt.is_correct ? 'font-bold text-emerald-700 bg-emerald-50 border border-emerald-300' : 'text-slate-600 bg-white border border-slate-200'} px-2 py-1 rounded-lg">
                                    <span class="w-2 h-2 rounded-full ${opt.color === 'red' ? 'bg-rose-500' : opt.color === 'green' ? 'bg-emerald-500' : opt.color === 'yellow' ? 'bg-amber-400' : 'bg-blue-500'}"></span>
                                    <span>${opt.label}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    <button onclick="deleteQuestion(${q.id})" class="text-slate-400 hover:text-rose-500 text-xs p-1" title="Xóa">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            `).join('');
        }

        async function saveQuestion(e) {
            e.preventDefault();
            const correctColor = document.querySelector('input[name="correctColor"]:checked').value;
            const newQ = {
                grade: document.getElementById('formGrade').value,
                category: 'tong_hop',
                question_text: document.getElementById('formQuestionText').value,
                speech_text: document.getElementById('formSpeechText').value || document.getElementById('formQuestionText').value,
                options: [
                    { color: 'red', label: document.getElementById('optRed').value, is_correct: correctColor === 'red' },
                    { color: 'green', label: document.getElementById('optGreen').value, is_correct: correctColor === 'green' },
                    { color: 'yellow', label: document.getElementById('optYellow').value, is_correct: correctColor === 'yellow' },
                    { color: 'blue', label: document.getElementById('optBlue').value, is_correct: correctColor === 'blue' }
                ]
            };

            const res = await fetch('api/save_question.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(newQ)
            });
            const data = await res.json();
            if (data.success) {
                alert('Đã thêm câu hỏi thành công!');
                document.getElementById('addQuestionForm').reset();
                loadQuestions();
            }
        }

        async function deleteQuestion(id) {
            if (!confirm('Bạn có chắc muốn xóa câu hỏi này?')) return;
            await fetch('api/save_question.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ action: 'delete', id: id })
            });
            loadQuestions();
        }

        function testTTS() {
            const text = document.getElementById('formSpeechText').value || document.getElementById('formQuestionText').value;
            if (!text) { alert('Vui lòng nhập câu hỏi trước'); return; }
            if ('speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'vi-VN';
                window.speechSynthesis.speak(utterance);
            }
        }

        // 5. Trình Giả Lập TV Simulator (Tích hợp trực tiếp)
        function startSimTimer() {
            clearInterval(simInterval);
            simInterval = setInterval(() => {
                if (!currentSettings.is_active) return;
                simTimeLeft--;
                const m = Math.floor(simTimeLeft / 60).toString().padStart(2, '0');
                const s = (simTimeLeft % 60).toString().padStart(2, '0');
                document.getElementById('simCountdown').innerText = `${m}:${s}`;

                if (simTimeLeft <= 0) {
                    clearInterval(simInterval);
                    triggerSimOverlay();
                }
            }, 1000);
        }

        function fastForwardSim() {
            simTimeLeft = 2;
        }

        function triggerSimOverlay() {
            pickSimQuestion();
            document.getElementById('simOverlay').classList.remove('hidden');
            if (currentSimQuestion?.speech_text && 'speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(currentSimQuestion.speech_text);
                utterance.lang = 'vi-VN';
                window.speechSynthesis.speak(utterance);
            }
        }

        function closeSimOverlay() {
            document.getElementById('simOverlay').classList.add('hidden');
            simTimeLeft = (currentSettings.interval_minutes || 10) * 60;
            startSimTimer();
        }

        function pickSimQuestion() {
            if (allQuestions.length === 0) {
                currentSimQuestion = {
                    grade: 'Mầm non',
                    question_text: 'Đâu là quả Dâu Tây?',
                    speech_text: 'Bé hãy tìm xem đâu là quả dâu tây nhé!',
                    options: [
                        { color: 'red', label: 'Quả Dâu Tây 🍓', is_correct: true },
                        { color: 'green', label: 'Quả Chuối 🍌', is_correct: false },
                        { color: 'yellow', label: 'Quả Cam 🍊', is_correct: false },
                        { color: 'blue', label: 'Quả Nho 🍇', is_correct: false }
                    ]
                };
            } else {
                const rand = Math.floor(Math.random() * allQuestions.length);
                currentSimQuestion = allQuestions[rand];
            }

            document.getElementById('simGradeBadge').innerText = currentSimQuestion.grade;
            document.getElementById('simQuestionText').innerText = currentSimQuestion.question_text;
            document.getElementById('simSpeechText').innerText = `"${currentSimQuestion.speech_text}"`;
            document.getElementById('simFeedback').innerText = "Chọn đúng để mở lại TV ngay lập tức!";

            const container = document.getElementById('simOptionsContainer');
            const colorClasses = {
                red: 'from-rose-600 to-rose-700 text-white',
                green: 'from-emerald-600 to-emerald-700 text-white',
                yellow: 'from-amber-400 to-amber-500 text-slate-950',
                blue: 'from-blue-600 to-blue-700 text-white'
            };
            const keyNames = { red: '1', green: '2', yellow: '3', blue: '4' };

            container.innerHTML = currentSimQuestion.options.map(opt => `
                <button onclick="handleSimAnswer(${opt.is_correct})" class="p-3 md:p-4 rounded-xl bg-gradient-to-r ${colorClasses[opt.color]} font-bold text-left flex items-center justify-between shadow active:scale-95 transition">
                    <span class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-black/20 flex items-center justify-center text-xs font-mono">${keyNames[opt.color]}</span>
                        <span class="text-sm md:text-base font-black">${opt.label}</span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-xs opacity-50"></i>
                </button>
            `).join('');
        }

        function handleSimAnswer(isCorrect) {
            const fb = document.getElementById('simFeedback');
            if (isCorrect) {
                fb.innerHTML = `<span class="text-emerald-400 font-black text-sm">🎉 BÉ GIỎI QUÁ! CHÍNH XÁC RỒI! ĐANG MỞ LẠI TV...</span>`;
                setTimeout(() => closeSimOverlay(), 1200);
            } else {
                fb.innerHTML = `<span class="text-rose-400 font-black text-sm">❌ CHƯA ĐÚNG! HÃY THỬ CÂU HỎI MỚI NÀY NHÉ!</span>`;
                setTimeout(() => pickSimQuestion(), 1000);
            }
        }

        // Bắt phím 1, 2, 3, 4 trên bàn phím giả lập Remote
        window.addEventListener('keydown', (e) => {
            const overlay = document.getElementById('simOverlay');
            if (overlay.classList.contains('hidden') || !currentSimQuestion) return;
            const keyMap = { '1': 'red', '2': 'green', '3': 'yellow', '4': 'blue' };
            const color = keyMap[e.key];
            if (color) {
                const opt = currentSimQuestion.options.find(o => o.color === color);
                if (opt) handleSimAnswer(opt.is_correct);
            }
        });

        // 6. Đổi mã PIN
        async function changePin(e) {
            e.preventDefault();
            const oldPin = document.getElementById('oldPinInput').value;
            const newPin = document.getElementById('newPinInput').value;

            const res = await fetch('api/auth.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ action: 'change_pin', old_pin: oldPin, new_pin: newPin })
            });
            const data = await res.json();
            if (data.success) {
                alert('Đổi mã PIN thành công! Hãy nhớ mã PIN mới.');
                e.target.reset();
            } else {
                alert(data.message || 'Lỗi khi đổi mã PIN');
            }
        }

        // Khởi động
        checkAuth();
        loadSettings();
        loadQuestions();
        startSimTimer();
    </script>
</body>
</html>
