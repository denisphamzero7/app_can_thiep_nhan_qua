<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mô Phỏng Trải Nghiệm Trên TV - App Can Thiệp Nhân Quả</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .tv-bezel {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        .pulse-soft { animation: pulse-ring 2s infinite ease-in-out; }
    </style>
</head>
<body class="bg-slate-900 text-white min-h-screen flex flex-col items-center justify-center p-4 select-none">

    <!-- Thanh trạng thái mô phỏng Remote & Dashboard -->
    <div class="w-full max-w-5xl flex items-center justify-between pb-3 text-xs text-slate-400">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>TV Simulator (Android TV / Flutter Mode)</span>
        </div>
        <div class="flex items-center gap-4">
            <span id="remoteSyncBadge" class="bg-slate-800 px-3 py-1 rounded-full border border-slate-700 text-emerald-400 font-mono">
                Dashboard: Đồng bộ kết nối OK
            </span>
            <a href="index.php" class="text-indigo-400 hover:text-indigo-300 font-bold underline">Mở Dashboard Quản trị</a>
        </div>
    </div>

    <!-- KHUNG MÀN HÌNH TIVI (16:9) -->
    <div class="relative w-full max-w-5xl aspect-video bg-black rounded-3xl border-8 border-slate-800 tv-bezel overflow-hidden">
        
        <!-- LỚP 1: NỘI DUNG TV ĐANG CHIẾU (HOẠT HÌNH YOUTUBE) -->
        <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900">
            <div class="text-center space-y-4 p-8">
                <div class="w-24 h-24 mx-auto rounded-full bg-red-600/90 flex items-center justify-center text-4xl text-white shadow-2xl">
                    <i class="fa-brands fa-youtube"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black tracking-wide text-white">Bé Đang Xem Hoạt Hình</h2>
                    <p class="text-slate-300 text-sm mt-1">Đồng hồ chạy ngầm đang đếm thời gian xem TV...</p>
                </div>
                
                <!-- Đồng hồ đếm ngược hiệp xem -->
                <div class="inline-flex items-center gap-3 bg-black/50 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/10 mt-4">
                    <i class="fa-solid fa-hourglass-start text-amber-400 text-xl"></i>
                    <div class="text-left">
                        <div class="text-[10px] uppercase tracking-wider text-slate-400 font-bold">Thời gian còn lại của hiệp</div>
                        <div id="countdownTimer" class="text-2xl font-black text-amber-400 font-mono">10:00</div>
                    </div>
                </div>

                <div class="pt-4 flex justify-center gap-3">
                    <button onclick="fastForward()" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold border border-white/20 transition">
                        ⚡ Tua nhanh đến giờ hỏi bài (Test ngay)
                    </button>
                </div>
            </div>
        </div>

        <!-- LỚP 2: MÀN HÌNH CAN THIỆP ĐÈ LÊN MỌI THỨ (OVERLAY KIOSK) -->
        <div id="questionOverlay" class="absolute inset-0 z-50 bg-slate-950/95 backdrop-blur-xl flex flex-col items-center justify-between p-8 md:p-12 hidden transition-all duration-300">
            
            <!-- Header của Overlay -->
            <div class="w-full flex items-center justify-between border-b border-white/10 pb-4">
                <div class="flex items-center gap-3">
                    <span class="w-3.5 h-3.5 rounded-full bg-amber-400 animate-ping"></span>
                    <span class="text-sm font-extrabold uppercase tracking-widest text-amber-400">
                        Thử Thách Vui - Trả Lời Đúng Để Xem Tiếp!
                    </span>
                </div>
                <div class="text-xs text-slate-400 font-semibold bg-white/5 px-3 py-1.5 rounded-lg border border-white/10">
                    Phím bấm: Dùng 4 nút màu Remote hoặc phím <span class="text-white font-bold">1, 2, 3, 4</span>
                </div>
            </div>

            <!-- Khung Câu hỏi -->
            <div class="my-auto text-center max-w-3xl space-y-4">
                <div class="inline-block px-4 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-bold uppercase tracking-wider border border-indigo-500/30">
                    <span id="overlayGradeBadge">Mầm Non</span>
                </div>
                
                <h3 id="overlayQuestionText" class="text-3xl md:text-5xl font-black text-white leading-tight">
                    Đâu là quả Dâu Tây?
                </h3>

                <div class="flex items-center justify-center gap-2 text-slate-300 text-sm">
                    <button onclick="speakCurrentQuestion()" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-amber-400 transition" title="Đọc lại câu hỏi">
                        <i class="fa-solid fa-volume-high text-lg"></i>
                    </button>
                    <span id="overlaySpeechHint" class="italic">"Bé hãy tìm xem đâu là quả dâu tây nhé!"</span>
                </div>
            </div>

            <!-- 4 Đáp án tương ứng 4 màu Remote TV -->
            <div id="optionsContainer" class="w-full grid grid-cols-2 gap-4 md:gap-6 max-w-4xl">
                <!-- Javascript nạp 4 nút màu -->
            </div>

            <!-- Footer: Thông báo kết quả / cảnh báo -->
            <div class="w-full text-center pt-2">
                <div id="feedbackMessage" class="text-sm font-bold text-slate-400 transition min-h-[24px]">
                    Chọn đúng để mở lại TV ngay lập tức!
                </div>
            </div>

        </div>

    </div>

    <!-- Hướng dẫn phím Remote phía dưới -->
    <div class="max-w-5xl w-full mt-4 flex items-center justify-center gap-6 text-xs text-slate-400">
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-rose-500"></span> Phím 1: Đỏ</div>
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Phím 2: Xanh Lá</div>
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-400"></span> Phím 3: Vàng</div>
        <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Phím 4: Xanh Dương</div>
    </div>

    <script>
        let isInterventionActive = true;
        let intervalSeconds = 600; // 10 phút mặc định
        let timeLeft = 600;
        let timerInterval = null;
        let allQuestions = [];
        let currentQuestion = null;

        // Âm thanh Web Audio API tạo tiếng Beep vui nhộn
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        function playTone(freq, type, duration) {
            try {
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = type;
                osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
                gain.gain.setValueAtTime(0.15, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start();
                osc.stop(audioCtx.currentTime + duration);
            } catch(e) {}
        }
        function playCorrectSound() {
            playTone(523.25, 'triangle', 0.15); // C5
            setTimeout(() => playTone(659.25, 'triangle', 0.15), 100); // E5
            setTimeout(() => playTone(783.99, 'triangle', 0.3), 200); // G5
        }
        function playWrongSound() {
            playTone(250, 'sawtooth', 0.2);
            setTimeout(() => playTone(200, 'sawtooth', 0.3), 150);
        }

        // 1. Đồng bộ trạng thái với Web Dashboard (mỗi 3 giây)
        async function syncWithDashboard() {
            try {
                const res = await fetch('api/status.php');
                const result = await res.json();
                if (result.success) {
                    const st = result.data;
                    isInterventionActive = st.is_active;
                    intervalSeconds = st.interval_minutes * 60;
                    
                    const badge = document.getElementById('remoteSyncBadge');
                    if (isInterventionActive) {
                        badge.className = "bg-slate-800 px-3 py-1 rounded-full border border-slate-700 text-emerald-400 font-mono";
                        badge.innerHTML = `<i class="fa-solid fa-shield-halved mr-1"></i> Bố Mẹ: BẬT Can Thiệp (${st.interval_minutes}p/hiệp)`;
                    } else {
                        badge.className = "bg-slate-800 px-3 py-1 rounded-full border border-slate-700 text-rose-400 font-mono";
                        badge.innerHTML = `<i class="fa-solid fa-power-off mr-1"></i> Bố Mẹ: ĐÃ TẮT CAN THIỆP (Tự do xem)`;
                        // Nếu bố mẹ tắt thì tắt ngay overlay
                        closeOverlay();
                    }
                }
            } catch (e) {
                console.error(e);
            }
        }

        // 2. Tải toàn bộ ngân hàng câu hỏi (Lưu offline trên Simulator)
        async function loadOfflineQuestions() {
            try {
                const res = await fetch('api/questions.php');
                const data = await res.json();
                if (data.success && data.data.length > 0) {
                    allQuestions = data.data;
                }
            } catch (e) {
                console.error(e);
            }
        }

        // 3. Bộ đếm thời gian xem TV
        function startTimer() {
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                if (!isInterventionActive) return; // Bố mẹ tắt can thiệp thì không đếm
                
                timeLeft--;
                updateCountdownDisplay();
                
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    triggerQuestionOverlay(); // KÍCH HOẠT HỎI BÀI!
                }
            }, 1000);
        }

        function updateCountdownDisplay() {
            const m = Math.floor(timeLeft / 60).toString().padStart(2, '0');
            const s = (timeLeft % 60).toString().padStart(2, '0');
            document.getElementById('countdownTimer').innerText = `${m}:${s}`;
        }

        // 4. Bật Overlay câu hỏi (Kiosk Mode)
        function triggerQuestionOverlay() {
            pickRandomQuestion();
            document.getElementById('questionOverlay').classList.remove('hidden');
            speakCurrentQuestion();
        }

        // Đóng Overlay & Reset Timer
        function closeOverlay() {
            document.getElementById('questionOverlay').classList.add('hidden');
            timeLeft = intervalSeconds;
            updateCountdownDisplay();
            startTimer();
        }

        // Tua nhanh test ngay
        function fastForward() {
            timeLeft = 2;
            updateCountdownDisplay();
        }

        // 5. Bốc ngẫu nhiên câu hỏi
        function pickRandomQuestion() {
            if (allQuestions.length === 0) {
                // Tự sinh câu hỏi toán nếu không có câu hỏi nào
                currentQuestion = {
                    grade: 'Toán nhẩm',
                    question_text: '5 + 4 bằng bao nhiêu?',
                    speech_text: 'Năm cộng bốn bằng bao nhiêu con nhỉ?',
                    options: [
                        { color: 'red', label: '8', is_correct: false },
                        { color: 'green', label: '9', is_correct: true },
                        { color: 'yellow', label: '10', is_correct: false },
                        { color: 'blue', label: '7', is_correct: false }
                    ]
                };
            } else {
                const randIndex = Math.floor(Math.random() * allQuestions.length);
                currentQuestion = allQuestions[randIndex];
            }
            renderQuestion();
        }

        function renderQuestion() {
            document.getElementById('overlayGradeBadge').innerText = currentQuestion.grade || 'Đố vui';
            document.getElementById('overlayQuestionText').innerText = currentQuestion.question_text;
            document.getElementById('overlaySpeechHint').innerText = `"${currentQuestion.speech_text}"`;
            document.getElementById('feedbackMessage').innerHTML = `<span class="text-slate-400">Chọn đúng để mở lại TV ngay lập tức!</span>`;

            const container = document.getElementById('optionsContainer');
            const colorClasses = {
                red: 'from-rose-600 to-rose-700 hover:from-rose-500 hover:to-rose-600 text-white border-rose-400',
                green: 'from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white border-emerald-400',
                yellow: 'from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-slate-950 border-amber-300',
                blue: 'from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white border-blue-400'
            };
            const keyNames = { red: '1', green: '2', yellow: '3', blue: '4' };

            container.innerHTML = currentQuestion.options.map(opt => `
                <button onclick="handleAnswer('${opt.color}', ${opt.is_correct})" 
                        class="p-5 md:p-7 rounded-2xl bg-gradient-to-r ${colorClasses[opt.color]} border-2 shadow-xl flex items-center justify-between text-left transition transform active:scale-95 group">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-black/20 flex items-center justify-center font-black text-sm font-mono">
                            ${keyNames[opt.color]}
                        </span>
                        <span class="text-xl md:text-2xl font-black">${opt.label}</span>
                    </div>
                    <i class="fa-solid fa-circle-chevron-right text-xl opacity-50 group-hover:opacity-100 transition"></i>
                </button>
            `).join('');
        }

        // 6. XỬ LÝ NHÂN QUẢ: ĐÚNG THÌ ĐÓNG & RESET, SAI THÌ RA CÂU MỚI
        function handleAnswer(color, isCorrect) {
            const feedback = document.getElementById('feedbackMessage');
            
            if (isCorrect) {
                // TRẢ LỜI ĐÚNG!
                playCorrectSound();
                feedback.innerHTML = `<span class="text-emerald-400 font-extrabold text-lg animate-bounce">
                    🎉 BÉ GIỎI QUÁ! CHÍNH XÁC RỒI! ĐANG MỞ LẠI TV...
                </span>`;
                
                // Đọc khen ngợi
                speakText("Bé giỏi quá! Bé được xem tiếp nhé!");

                // Sau 1.2 giây tự động đóng overlay và reset timer hiệp mới!
                setTimeout(() => {
                    closeOverlay();
                }, 1200);

            } else {
                // TRẢ LỜI SAI!
                playWrongSound();
                feedback.innerHTML = `<span class="text-rose-400 font-extrabold text-lg animate-shake">
                    ❌ TIẾC QUÁ, CHƯA ĐÚNG! HÃY THỬ CÂU HỎI MỚI NÀY NHÉ!
                </span>`;

                speakText("Chưa đúng rồi! Bé thử lại câu mới nhé!");

                // MÀN HÌNH KHÔNG ĐÓNG -> LẬP TỨC ĐỔI CÂU HỎI MỚI!
                setTimeout(() => {
                    pickRandomQuestion();
                    speakCurrentQuestion();
                }, 1000);
            }
        }

        // 7. Đọc giọng TTS tiếng Việt
        function speakCurrentQuestion() {
            if (currentQuestion && currentQuestion.speech_text) {
                speakText(currentQuestion.speech_text);
            }
        }

        function speakText(text) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel(); // Dừng câu trước nếu đang nói
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'vi-VN';
                utterance.rate = 0.95; // Đọc thong thả cho bé nghe
                window.speechSynthesis.speak(utterance);
            }
        }

        // 8. Bắt phím bàn phím giả lập Remote (1, 2, 3, 4 hoặc R, G, Y, B)
        window.addEventListener('keydown', (e) => {
            const overlay = document.getElementById('questionOverlay');
            if (overlay.classList.contains('hidden') || !currentQuestion) return;

            const keyMap = {
                '1': 'red', 'r': 'red', 'R': 'red',
                '2': 'green', 'g': 'green', 'G': 'green',
                '3': 'yellow', 'y': 'yellow', 'Y': 'yellow',
                '4': 'blue', 'b': 'blue', 'B': 'blue'
            };

            const color = keyMap[e.key];
            if (color) {
                const opt = currentQuestion.options.find(o => o.color === color);
                if (opt) {
                    handleAnswer(color, opt.is_correct);
                }
            }
        });

        // Khởi động
        loadOfflineQuestions();
        syncWithDashboard();
        startTimer();
        setInterval(syncWithDashboard, 3000); // Polling mỗi 3s đồng bộ với điện thoại
    </script>
</body>
</html>
