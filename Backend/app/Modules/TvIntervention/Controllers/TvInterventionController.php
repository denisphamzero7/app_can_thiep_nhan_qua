<?php

namespace App\Modules\TvIntervention\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\TvIntervention\Models\TvInterventionLog;
use App\Modules\TvIntervention\Models\TvInterventionSetting;
use App\Modules\TvIntervention\Models\TvQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TvInterventionController extends Controller
{
    /**
     * Lấy trạng thái cấu hình can thiệp của TV (cho cả Web và TV app)
     */
    public function getStatus(Request $request): JsonResponse
    {
        $deviceId = $request->query('device_id', 'TV_DEFAULT');
        $setting = TvInterventionSetting::firstOrCreate(
            ['device_id' => $deviceId],
            [
                'is_active' => true,
                'interval_minutes' => 10,
                'daily_limit_minutes' => 60,
                'target_grade' => 'mam_non',
                'questions_to_pass' => 1,
                'max_penalty_cap' => 5,
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $setting,
        ]);
    }

    /**
     * Cập nhật cấu hình can thiệp (Bật/Tắt, thời gian, lớp)
     */
    public function updateSettings(Request $request): JsonResponse
    {
        $deviceId = $request->input('device_id', 'TV_DEFAULT');
        $setting = TvInterventionSetting::firstOrCreate(['device_id' => $deviceId]);

        if ($request->has('is_active')) {
            $setting->is_active = (bool) $request->input('is_active');
        }
        if ($request->has('interval_minutes')) {
            $setting->interval_minutes = max(1, (int) $request->input('interval_minutes'));
        }
        if ($request->has('daily_limit_minutes')) {
            $setting->daily_limit_minutes = max(10, (int) $request->input('daily_limit_minutes'));
        }
        if ($request->has('target_grade')) {
            $setting->target_grade = (string) $request->input('target_grade');
        }
        if ($request->has('questions_to_pass')) {
            $setting->questions_to_pass = max(1, (int) $request->input('questions_to_pass'));
        }
        if ($request->has('max_penalty_cap')) {
            $setting->max_penalty_cap = max(1, (int) $request->input('max_penalty_cap'));
        }

        $setting->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật cấu hình can thiệp thành công',
            'data' => $setting,
        ]);
    }

    /**
     * Lấy danh sách ngân hàng câu hỏi
     */
    public function getQuestions(Request $request): JsonResponse
    {
        $grade = $request->query('grade', 'all');
        $query = TvQuestion::query()->where('is_active', true);

        if ($grade !== 'all' && !empty($grade)) {
            $query->where('grade', $grade);
        }

        $questions = $query->orderBy('id', 'desc')->get();

        // Tự tạo dữ liệu mẫu nếu chưa có câu hỏi nào
        if ($questions->isEmpty() && TvQuestion::count() === 0) {
            $this->seedSampleQuestions();
            $questions = TvQuestion::where('is_active', true)->get();
        }

        return response()->json([
            'success' => true,
            'total' => $questions->count(),
            'data' => $questions,
        ]);
    }

    /**
     * Thêm câu hỏi mới
     */
    public function storeQuestion(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'grade' => 'required|string',
            'category' => 'nullable|string',
            'question_text' => 'required|string',
            'speech_text' => 'nullable|string',
            'options' => 'required|array|min:2',
        ]);

        $question = TvQuestion::create([
            'grade' => $validated['grade'],
            'category' => $validated['category'] ?? 'tong_hop',
            'question_text' => $validated['question_text'],
            'speech_text' => $validated['speech_text'] ?: $validated['question_text'],
            'options' => $validated['options'],
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu câu hỏi thành công',
            'data' => $question,
        ], 201);
    }

    /**
     * Xóa câu hỏi
     */
    public function deleteQuestion(int $id): JsonResponse
    {
        $question = TvQuestion::find($id);
        if (!$question) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy câu hỏi'], 404);
        }

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa câu hỏi thành công',
        ]);
    }

    /**
     * TV gửi báo cáo làm bài và thời gian xem
     */
    public function report(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'question_id' => 'nullable|integer',
            'is_correct' => 'required|boolean',
            'watch_time_minutes' => 'nullable|integer',
        ]);

        $log = TvInterventionLog::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Báo cáo đã được lưu trữ',
            'data' => $log,
        ]);
    }

    /**
     * Nạp câu hỏi mẫu ban đầu nếu rỗng
     */
    private function seedSampleQuestions(): void
    {
        $samples = [
            [
                'grade' => 'mam_non',
                'category' => 'nhan_biet',
                'question_text' => 'Đâu là quả Dâu Tây?',
                'speech_text' => 'Bé hãy tìm xem đâu là quả dâu tây nhé!',
                'options' => [
                    ['color' => 'red', 'label' => 'Quả Dâu Tây 🍓', 'is_correct' => true],
                    ['color' => 'green', 'label' => 'Quả Chuối 🍌', 'is_correct' => false],
                    ['color' => 'yellow', 'label' => 'Quả Cam 🍊', 'is_correct' => false],
                    ['color' => 'blue', 'label' => 'Quả Nho 🍇', 'is_correct' => false],
                ],
                'is_active' => true,
            ],
            [
                'grade' => 'mam_non',
                'category' => 'nhan_biet',
                'question_text' => "Con nào kêu 'Gâu Gâu'?",
                'speech_text' => 'Con nào kêu gâu gâu vậy bé?',
                'options' => [
                    ['color' => 'red', 'label' => 'Con Mèo 🐱', 'is_correct' => false],
                    ['color' => 'green', 'label' => 'Con Chó 🐶', 'is_correct' => true],
                    ['color' => 'yellow', 'label' => 'Con Vịt 🦆', 'is_correct' => false],
                    ['color' => 'blue', 'label' => 'Con Bò 🐮', 'is_correct' => false],
                ],
                'is_active' => true,
            ],
            [
                'grade' => 'mam_non',
                'category' => 'dem_hinh',
                'question_text' => 'Có bao nhiêu chú Thỏ? 🐰 🐰 🐰',
                'speech_text' => 'Bé đếm xem có bao nhiêu chú thỏ nhé!',
                'options' => [
                    ['color' => 'red', 'label' => '2 chú', 'is_correct' => false],
                    ['color' => 'green', 'label' => '3 chú', 'is_correct' => true],
                    ['color' => 'yellow', 'label' => '4 chú', 'is_correct' => false],
                    ['color' => 'blue', 'label' => '5 chú', 'is_correct' => false],
                ],
                'is_active' => true,
            ],
            [
                'grade' => 'lop_1',
                'category' => 'toan',
                'question_text' => '5 + 3 bằng bao nhiêu?',
                'speech_text' => 'Năm cộng ba bằng bao nhiêu vậy con?',
                'options' => [
                    ['color' => 'red', 'label' => '7', 'is_correct' => false],
                    ['color' => 'green', 'label' => '8', 'is_correct' => true],
                    ['color' => 'yellow', 'label' => '9', 'is_correct' => false],
                    ['color' => 'blue', 'label' => '6', 'is_correct' => false],
                ],
                'is_active' => true,
            ],
            [
                'grade' => 'lop_2',
                'category' => 'toan',
                'question_text' => '6 x 7 bằng bao nhiêu?',
                'speech_text' => 'Sáu nhân bảy bằng bao nhiêu con nhỉ?',
                'options' => [
                    ['color' => 'red', 'label' => '36', 'is_correct' => false],
                    ['color' => 'green', 'label' => '42', 'is_correct' => true],
                    ['color' => 'yellow', 'label' => '48', 'is_correct' => false],
                    ['color' => 'blue', 'label' => '54', 'is_correct' => false],
                ],
                'is_active' => true,
            ],
            [
                'grade' => 'lop_1',
                'category' => 'tieng_anh',
                'question_text' => "'Con Mèo' tiếng Anh là gì?",
                'speech_text' => 'Con mèo trong tiếng Anh đọc là gì vậy con?',
                'options' => [
                    ['color' => 'red', 'label' => 'Dog', 'is_correct' => false],
                    ['color' => 'green', 'label' => 'Cat', 'is_correct' => true],
                    ['color' => 'yellow', 'label' => 'Bird', 'is_correct' => false],
                    ['color' => 'blue', 'label' => 'Fish', 'is_correct' => false],
                ],
                'is_active' => true,
            ],
        ];

        foreach ($samples as $sample) {
            TvQuestion::create($sample);
        }
    }
}
