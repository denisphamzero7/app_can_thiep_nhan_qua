<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trung Tâm Quản Trị - App Can Thiệp TV (Bố Mẹ)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">

    <!-- Top Navigation -->
    <header class="bg-indigo-600 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-tv"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold leading-tight">Can Thiệp Nhân Quả TV</h1>
                    <p class="text-xs text-indigo-200">Quản lý thời gian & Học tập cho bé</p>
                </div>
            </div>
            <div>
                <a href="tv_simulator.php" target="_blank" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-semibold flex items-center gap-1.5 shadow transition">
                    <i class="fa-solid fa-play"></i>
                    <span>Mở Giả Lập TV</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-6 space-y-6">

        <!-- 1. CÔNG TẮC ĐIỀU KHIỂN KHẨN CẤP TỪ XA -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Điều khiển TV từ xa</span>
                    <h2 class="text-xl font-extrabold text-slate-900 mt-0.5">Trạng thái Can thiệp</h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Khi <strong class="text-emerald-600">BẬT</strong>, TV tự động đếm giờ và hỏi bài. Khi <strong class="text-rose-600">TẮT</strong>, TV xem tự do (người lớn xem).
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    <button id="toggleBtn" onclick="toggleActiveStatus()" class="px-6 py-3 rounded-xl font-bold text-white flex items-center gap-2 shadow-md transition transform active:scale-95 bg-emerald-500 hover:bg-emerald-600">
                        <i id="toggleIcon" class="fa-solid fa-power-off text-lg"></i>
                        <span id="toggleText">ĐANG BẬT CAN THIỆP</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. CÀI ĐẶT THỜI GIAN & ĐỘ TUỔI -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Thời gian mỗi hiệp -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3 text-indigo-600 mb-2">
                    <i class="fa-solid fa-hourglass-half text-lg"></i>
                    <h3 class="font-bold text-slate-800">Thời gian mỗi hiệp</h3>
                </div>
                <p class="text-xs text-slate-500 mb-3">Sau bao nhiêu phút thì TV khóa hỏi bài</p>
                <div class="flex gap-2">
                    <button onclick="updateInterval(5)" class="interval-btn flex-1 py-1.5 rounded-lg border text-sm font-semibold hover:bg-slate-100" data-val="5">5 phút</button>
                    <button onclick="updateInterval(10)" class="interval-btn flex-1 py-1.5 rounded-lg border text-sm font-semibold hover:bg-slate-100" data-val="10">10 phút</button>
                    <button onclick="updateInterval(15)" class="interval-btn flex-1 py-1.5 rounded-lg border text-sm font-semibold hover:bg-slate-100" data-val="15">15 phút</button>
                </div>
            </div>

            <!-- Đối tượng học sinh -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3 text-amber-500 mb-2">
                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                    <h3 class="font-bold text-slate-800">Cấp học của bé</h3>
                </div>
                <p class="text-xs text-slate-500 mb-3">Hệ thống sẽ ưu tiên chọn bài tập phù hợp</p>
                <select id="targetGradeSelect" onchange="updateGrade(this.value)" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-sm font-medium focus:outline-none focus:border-indigo-500">
                    <option value="mam_non">Mầm non (3 - 5 tuổi) - Nhận biết & Đếm</option>
                    <option value="lop_1">Lớp 1 (6 tuổi) - Cộng trừ 10, Tiếng Việt</option>
                    <option value="lop_2">Lớp 2 (7 tuổi) - Bảng cửu chương 2-5</option>
                    <option value="lop_3">Lớp 3 (8 tuổi) - Bảng cửu chương 6-9</option>
                    <option value="lop_4">Lớp 4 (9 tuổi) - Toán nâng cao, Tiếng Anh</option>
                    <option value="lop_5">Lớp 5 (10 tuổi) - Tổng hợp kiến thức</option>
                </select>
            </div>

            <!-- Giới hạn ngày -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3 text-rose-500 mb-2">
                    <i class="fa-solid fa-clock text-lg"></i>
                    <h3 class="font-bold text-slate-800">Giới hạn xem / ngày</h3>
                </div>
                <p class="text-xs text-slate-500 mb-3">Đủ thời gian này TV sẽ khóa hẳn đi ngủ</p>
                <div class="flex items-center gap-2">
                    <input type="number" id="dailyLimitInput" value="60" min="15" max="300" step="15" class="w-24 bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 text-sm font-bold text-center">
                    <span class="text-sm font-medium text-slate-600">phút/ngày</span>
                    <button onclick="updateDailyLimit()" class="ml-auto px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700">Lưu</button>
                </div>
            </div>
        </div>

        <!-- 3. QUẢN LÝ NGÂN HÀNG CÂU HỎI -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Cột trái: Form thêm câu hỏi mới -->
            <div class="lg:col-span-1 bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-indigo-600"></i>
                    <span>Soạn câu hỏi mới</span>
                </h3>
                <p class="text-xs text-slate-500 mb-4">Nhập trên điện thoại, TV tự động cập nhật</p>

                <form id="addQuestionForm" onsubmit="saveQuestion(event)" class="space-y-3.5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Dành cho cấp</label>
                        <select id="formGrade" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs font-medium">
                            <option value="mam_non">Mầm non (3 - 5 tuổi)</option>
                            <option value="lop_1">Lớp 1</option>
                            <option value="lop_2">Lớp 2</option>
                            <option value="lop_3">Lớp 3</option>
                            <option value="lop_4">Lớp 4</option>
                            <option value="lop_5">Lớp 5</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nội dung câu hỏi</label>
                        <textarea id="formQuestionText" rows="2" required placeholder="Ví dụ: 7 x 8 = ? hoặc Đâu là quả Táo?" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs focus:outline-none focus:border-indigo-500"></textarea>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-semibold text-slate-700">Giọng đọc TV (TTS Tiếng Việt)</label>
                            <button type="button" onclick="testTTS()" class="text-indigo-600 text-xs font-bold hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-volume-high"></i> Nghe thử
                            </button>
                        </div>
                        <input type="text" id="formSpeechText" placeholder="Câu TV sẽ đọc to thành tiếng cho bé" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs">
                    </div>

                    <!-- 4 Lựa chọn theo 4 nút màu remote -->
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700">Đáp án theo 4 nút màu Remote (Tích chọn câu ĐÚNG):</label>
                        
                        <!-- Đỏ -->
                        <div class="flex items-center gap-2">
                            <input type="radio" name="correctColor" value="red" required class="accent-rose-500 w-4 h-4">
                            <span class="w-3 h-3 rounded-full bg-rose-500 flex-shrink-0"></span>
                            <input type="text" id="optRed" required placeholder="Đáp án Nút Đỏ" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs">
                        </div>

                        <!-- Xanh lá -->
                        <div class="flex items-center gap-2">
                            <input type="radio" name="correctColor" value="green" class="accent-emerald-500 w-4 h-4">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 flex-shrink-0"></span>
                            <input type="text" id="optGreen" required placeholder="Đáp án Nút Xanh Lá" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs">
                        </div>

                        <!-- Vàng -->
                        <div class="flex items-center gap-2">
                            <input type="radio" name="correctColor" value="yellow" class="accent-amber-400 w-4 h-4">
                            <span class="w-3 h-3 rounded-full bg-amber-400 flex-shrink-0"></span>
                            <input type="text" id="optYellow" required placeholder="Đáp án Nút Vàng" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs">
                        </div>

                        <!-- Xanh dương -->
                        <div class="flex items-center gap-2">
                            <input type="radio" name="correctColor" value="blue" class="accent-blue-500 w-4 h-4">
                            <span class="w-3 h-3 rounded-full bg-blue-500 flex-shrink-0"></span>
                            <input type="text" id="optBlue" required placeholder="Đáp án Nút Xanh Dương" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow transition mt-2">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Lưu Câu Hỏi
                    </button>
                </form>
            </div>

            <!-- Cột phải: Danh sách câu hỏi trong ngân hàng -->
            <div class="lg:col-span-2 bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Ngân hàng câu hỏi hiện có</h3>
                        <p class="text-xs text-slate-500" id="totalQuestionsCount">Đang tải...</p>
                    </div>
                    <select id="filterGrade" onchange="loadQuestions()" class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 text-xs font-medium">
                        <option value="all">Tất cả các lớp</option>
                        <option value="mam_non">Mầm non</option>
                        <option value="lop_1">Lớp 1</option>
                        <option value="lop_2">Lớp 2</option>
                        <option value="lop_3">Lớp 3</option>
                    </select>
                </div>

                <div id="questionsList" class="space-y-3 overflow-y-auto max-h-[550px] pr-1">
                    <!-- Javascript nạp danh sách câu hỏi -->
                </div>
            </div>

        </div>

    </main>

    <script>
        let currentSettings = {};

        // 1. Tải cài đặt
        async function loadSettings() {
            try {
                const res = await fetch('api/status.php');
                const result = await res.json();
                if (result.success) {
                    currentSettings = result.data;
                    updateUIWithSettings();
                }
            } catch (e) {
                console.error(e);
            }
        }

        function updateUIWithSettings() {
            const btn = document.getElementById('toggleBtn');
            const text = document.getElementById('toggleText');
            const icon = document.getElementById('toggleIcon');
            
            if (currentSettings.is_active) {
                btn.className = "px-6 py-3 rounded-xl font-bold text-white flex items-center gap-2 shadow-md transition transform active:scale-95 bg-emerald-500 hover:bg-emerald-600";
                text.innerText = "ĐANG BẬT CAN THIỆP";
                icon.className = "fa-solid fa-shield-halved text-lg";
            } else {
                btn.className = "px-6 py-3 rounded-xl font-bold text-white flex items-center gap-2 shadow-md transition transform active:scale-95 bg-rose-500 hover:bg-rose-600";
                text.innerText = "TẮT (NGƯỜI LỚN XEM)";
                icon.className = "fa-solid fa-power-off text-lg";
            }

            // Interval buttons
            document.querySelectorAll('.interval-btn').forEach(b => {
                if (parseInt(b.dataset.val) === currentSettings.interval_minutes) {
                    b.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                    b.classList.remove('hover:bg-slate-100');
                } else {
                    b.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                    b.classList.add('hover:bg-slate-100');
                }
            });

            document.getElementById('targetGradeSelect').value = currentSettings.target_grade || 'mam_non';
            document.getElementById('dailyLimitInput').value = currentSettings.daily_limit_minutes || 60;
        }

        // 2. Bật / Tắt can thiệp
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
            }
        }

        // 3. Cập nhật thời gian hiệp
        async function updateInterval(minutes) {
            const res = await fetch('api/toggle_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ interval_minutes: minutes })
            });
            const data = await res.json();
            if (data.success) {
                currentSettings.interval_minutes = minutes;
                updateUIWithSettings();
            }
        }

        // 4. Cập nhật cấp lớp
        async function updateGrade(grade) {
            await fetch('api/toggle_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ target_grade: grade })
            });
            currentSettings.target_grade = grade;
        }

        // 5. Cập nhật giới hạn ngày
        async function updateDailyLimit() {
            const val = document.getElementById('dailyLimitInput').value;
            await fetch('api/toggle_status.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ daily_limit_minutes: parseInt(val) })
            });
            alert('Đã lưu hạn mức ngày!');
        }

        // 6. Tải danh sách câu hỏi
        async function loadQuestions() {
            const grade = document.getElementById('filterGrade').value;
            const res = await fetch(`api/questions.php?grade=${grade}`);
            const data = await res.json();
            
            const list = document.getElementById('questionsList');
            document.getElementById('totalQuestionsCount').innerText = `${data.total} câu hỏi sẵn sàng`;
            
            if (!data.data || data.data.length === 0) {
                list.innerHTML = `<div class="p-8 text-center text-slate-400 text-sm">Chưa có câu hỏi nào cho lớp này. Hãy thêm ở cột bên trái!</div>`;
                return;
            }

            list.innerHTML = data.data.map(q => `
                <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white transition flex items-start justify-between gap-3">
                    <div class="space-y-1.5 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-100 text-indigo-700">${q.grade}</span>
                            <h4 class="font-bold text-sm text-slate-800">${q.question_text}</h4>
                        </div>
                        <p class="text-xs text-slate-500 italic"><i class="fa-solid fa-volume-low mr-1"></i> "${q.speech_text}"</p>
                        
                        <div class="grid grid-cols-2 gap-1.5 pt-1">
                            ${q.options.map(opt => `
                                <div class="flex items-center gap-1.5 text-xs ${opt.is_correct ? 'font-bold text-emerald-600 bg-emerald-50 border border-emerald-200' : 'text-slate-600 bg-white border border-slate-200'} px-2 py-1 rounded-lg">
                                    <span class="w-2 h-2 rounded-full ${opt.color === 'red' ? 'bg-rose-500' : opt.color === 'green' ? 'bg-emerald-500' : opt.color === 'yellow' ? 'bg-amber-400' : 'bg-blue-500'}"></span>
                                    <span>${opt.label}</span>
                                    ${opt.is_correct ? '<i class="fa-solid fa-check ml-auto text-emerald-600"></i>' : ''}
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

        // 7. Lưu câu hỏi mới
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

        // 8. Xóa câu hỏi
        async function deleteQuestion(id) {
            if (!confirm('Bạn có chắc muốn xóa câu hỏi này?')) return;
            await fetch('api/save_question.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ action: 'delete', id: id })
            });
            loadQuestions();
        }

        // 9. Nghe thử TTS
        function testTTS() {
            const text = document.getElementById('formSpeechText').value || document.getElementById('formQuestionText').value;
            if (!text) { alert('Vui lòng nhập câu hỏi trước'); return; }
            if ('speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'vi-VN';
                window.speechSynthesis.speak(utterance);
            } else {
                alert('Trình duyệt không hỗ trợ Web Speech');
            }
        }

        // Khởi động
        loadSettings();
        loadQuestions();
    </script>
</body>
</html>
