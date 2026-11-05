<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
          <v-icon color="indigo" size="32">mdi-television-box</v-icon>
          <span>Quản Lý Can Thiệp TV (Nhân Quả)</span>
        </h1>
        <p class="text-sm text-slate-500 mt-1">
          Hệ thống kiểm soát thời gian xem TV & rèn luyện kiến thức tự động cho trẻ
        </p>
      </div>

      <div class="flex items-center gap-3">
        <v-btn
          color="indigo-darken-1"
          variant="elevated"
          prepend-icon="mdi-remote-tv"
          href="/tv_simulator.php"
          target="_blank"
          class="text-none font-bold shadow-sm"
        >
          Mở Giả Lập TV
        </v-btn>
      </div>
    </div>

    <!-- 1. BẢNG ĐIỀU KHIỂN KHẨN CẤP TỪ XA -->
    <v-card elevation="1" rounded="xl" class="border border-slate-200">
      <v-card-text class="p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái thời gian thực</div>
            <h2 class="text-xl font-extrabold text-slate-900 mt-1">
              Chế độ Can thiệp TV: 
              <span :class="settings.is_active ? 'text-emerald-600' : 'text-rose-600'">
                {{ settings.is_active ? '🟢 ĐANG BẬT' : '🔴 ĐÃ TẮT (TỰ DO XEM)' }}
              </span>
            </h2>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl">
              Khi <strong class="text-emerald-600">BẬT</strong>: Cứ đến giờ TV sẽ khóa cứng và đưa ra câu hỏi. 
              Khi bố mẹ muốn xem phim/thời sự, bấm <strong class="text-rose-600">TẮT</strong> để TV tự do.
            </p>
          </div>

          <div>
            <v-btn
              :color="settings.is_active ? 'success' : 'error'"
              size="large"
              rounded="xl"
              class="font-black px-6 shadow-md"
              :loading="loadingToggle"
              @click="toggleActive"
            >
              <v-icon start>{{ settings.is_active ? 'mdi-shield-check' : 'mdi-power' }}</v-icon>
              {{ settings.is_active ? 'ĐANG BẬT (BẤM ĐỂ TẮT)' : 'ĐÃ TẮT (BẤM ĐỂ BẬT)' }}
            </v-btn>
          </div>
        </div>
      </v-card-text>
    </v-card>

    <!-- 2. CÀI ĐẶT THỜI GIAN & KHỐI LỚP -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <!-- Thời gian mỗi hiệp -->
      <v-card elevation="1" rounded="xl" class="border border-slate-200">
        <v-card-text>
          <div class="flex items-center gap-2 text-indigo-600 font-bold mb-1">
            <v-icon>mdi-timer-sand</v-icon>
            <span>Thời gian mỗi hiệp</span>
          </div>
          <div class="text-xs text-slate-500 mb-3">Sau bao nhiêu phút thì TV khóa đố bài</div>
          <v-select
            v-model="settings.interval_minutes"
            :items="[
              { title: '5 phút (Test thử)', value: 5 },
              { title: '10 phút (Chuẩn)', value: 10 },
              { title: '15 phút', value: 15 },
              { title: '20 phút', value: 20 },
              { title: '30 phút', value: 30 }
            ]"
            density="compact"
            variant="outlined"
            hide-details
            @update:model-value="saveSettings"
          ></v-select>
        </v-card-text>
      </v-card>

      <!-- Khối lớp ưu tiên -->
      <v-card elevation="1" rounded="xl" class="border border-slate-200">
        <v-card-text>
          <div class="flex items-center gap-2 text-amber-600 font-bold mb-1">
            <v-icon>mdi-school</v-icon>
            <span>Cấp học của con</span>
          </div>
          <div class="text-xs text-slate-500 mb-3">TV sẽ ưu tiên chọn bài tập phù hợp</div>
          <v-select
            v-model="settings.target_grade"
            :items="[
              { title: 'Mầm non (3 - 5 tuổi) - Nhận biết & Đếm', value: 'mam_non' },
              { title: 'Lớp 1 (6 tuổi) - Toán cộng trừ 10, Đọc chữ', value: 'lop_1' },
              { title: 'Lớp 2 (7 tuổi) - Bảng cửu chương 2-5', value: 'lop_2' },
              { title: 'Lớp 3 (8 tuổi) - Bảng cửu chương 6-9', value: 'lop_3' },
              { title: 'Lớp 4 (9 tuổi) - Phép nhân chia phân số', value: 'lop_4' },
              { title: 'Lớp 5 (10 tuổi) - Tổng hợp kiến thức', value: 'lop_5' }
            ]"
            density="compact"
            variant="outlined"
            hide-details
            @update:model-value="saveSettings"
          ></v-select>
        </v-card-text>
      </v-card>

      <!-- Hạn mức tổng giờ trong ngày -->
      <v-card elevation="1" rounded="xl" class="border border-slate-200">
        <v-card-text>
          <div class="flex items-center gap-2 text-rose-600 font-bold mb-1">
            <v-icon>mdi-clock-alert-outline</v-icon>
            <span>Giới hạn xem / ngày</span>
          </div>
          <div class="text-xs text-slate-500 mb-3">Đủ thời gian này TV khóa hẳn đi ngủ</div>
          <div class="flex items-center gap-2">
            <v-text-field
              v-model.number="settings.daily_limit_minutes"
              type="number"
              density="compact"
              variant="outlined"
              suffix="phút/ngày"
              hide-details
            ></v-text-field>
            <v-btn color="indigo" variant="tonal" @click="saveSettings">Lưu</v-btn>
          </div>
        </v-card-text>
      </v-card>
    </div>

    <!-- 3. QUẢN LÝ NGÂN HÀNG CÂU HỎI -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Cột Trái: Soạn câu hỏi mới -->
      <v-card elevation="1" rounded="xl" class="border border-slate-200 p-5">
        <h3 class="text-lg font-bold text-slate-800 mb-1 flex items-center gap-2">
          <v-icon color="indigo">mdi-plus-circle</v-icon>
          <span>Soạn câu hỏi mới</span>
        </h3>
        <p class="text-xs text-slate-500 mb-4">Lưu câu hỏi trên máy, TV tự động đồng bộ</p>

        <v-form @submit.prevent="submitQuestion" class="space-y-4">
          <v-select
            v-model="newQuestion.grade"
            label="Dành cho cấp lớp"
            :items="[
              { title: 'Mầm non (3 - 5 tuổi)', value: 'mam_non' },
              { title: 'Lớp 1', value: 'lop_1' },
              { title: 'Lớp 2', value: 'lop_2' },
              { title: 'Lớp 3', value: 'lop_3' }
            ]"
            density="compact"
            variant="outlined"
            hide-details
          ></v-select>

          <v-textarea
            v-model="newQuestion.question_text"
            label="Nội dung câu hỏi"
            placeholder="Ví dụ: 7 x 8 = ? hoặc Đâu là quả Dâu Tây?"
            rows="2"
            density="compact"
            variant="outlined"
            hide-details
            required
          ></v-textarea>

          <div>
            <div class="flex items-center justify-between mb-1">
              <span class="text-xs font-semibold text-slate-600">Giọng đọc TV (Tiếng Việt)</span>
              <v-btn variant="text" size="x-small" color="indigo" @click="testSpeech(newQuestion.speech_text || newQuestion.question_text)">
                <v-icon start size="small">mdi-volume-high</v-icon> Nghe thử
              </v-btn>
            </div>
            <v-text-field
              v-model="newQuestion.speech_text"
              placeholder="Câu TV sẽ đọc to cho con nghe"
              density="compact"
              variant="outlined"
              hide-details
            ></v-text-field>
          </div>

          <!-- 4 Lựa chọn theo 4 nút màu remote -->
          <div class="space-y-2 pt-2 border-t border-slate-100">
            <div class="text-xs font-bold text-slate-700">4 Nút màu Remote (Tích chọn câu ĐÚNG):</div>

            <!-- Đỏ -->
            <div class="flex items-center gap-2">
              <v-radio :model-value="correctColor === 'red'" @click="correctColor = 'red'" density="compact"></v-radio>
              <div class="w-3 h-3 rounded-full bg-rose-500 flex-shrink-0"></div>
              <v-text-field v-model="newQuestion.options.red" placeholder="Đáp án Nút Đỏ" density="compact" variant="outlined" hide-details></v-text-field>
            </div>

            <!-- Xanh Lá -->
            <div class="flex items-center gap-2">
              <v-radio :model-value="correctColor === 'green'" @click="correctColor = 'green'" density="compact"></v-radio>
              <div class="w-3 h-3 rounded-full bg-emerald-500 flex-shrink-0"></div>
              <v-text-field v-model="newQuestion.options.green" placeholder="Đáp án Nút Xanh Lá" density="compact" variant="outlined" hide-details></v-text-field>
            </div>

            <!-- Vàng -->
            <div class="flex items-center gap-2">
              <v-radio :model-value="correctColor === 'yellow'" @click="correctColor = 'yellow'" density="compact"></v-radio>
              <div class="w-3 h-3 rounded-full bg-amber-400 flex-shrink-0"></div>
              <v-text-field v-model="newQuestion.options.yellow" placeholder="Đáp án Nút Vàng" density="compact" variant="outlined" hide-details></v-text-field>
            </div>

            <!-- Xanh Dương -->
            <div class="flex items-center gap-2">
              <v-radio :model-value="correctColor === 'blue'" @click="correctColor = 'blue'" density="compact"></v-radio>
              <div class="w-3 h-3 rounded-full bg-blue-500 flex-shrink-0"></div>
              <v-text-field v-model="newQuestion.options.blue" placeholder="Đáp án Nút Xanh Dương" density="compact" variant="outlined" hide-details></v-text-field>
            </div>
          </div>

          <v-btn
            type="submit"
            color="indigo-darken-1"
            block
            rounded="xl"
            class="font-bold text-none mt-4 shadow"
            :loading="loadingSave"
          >
            <v-icon start>mdi-content-save</v-icon>
            Lưu Câu Hỏi Vào Ngân Hàng
          </v-btn>
        </v-form>
      </v-card>

      <!-- Cột Phải: Danh sách câu hỏi -->
      <v-card elevation="1" rounded="xl" class="border border-slate-200 p-5 lg:col-span-2 flex flex-col">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h3 class="text-lg font-bold text-slate-800">Ngân hàng câu hỏi TV</h3>
            <p class="text-xs text-slate-500">Tổng cộng: {{ questions.length }} câu hỏi</p>
          </div>
          <v-select
            v-model="selectedGradeFilter"
            :items="[
              { title: 'Tất cả các lớp', value: 'all' },
              { title: 'Mầm non', value: 'mam_non' },
              { title: 'Lớp 1', value: 'lop_1' },
              { title: 'Lớp 2', value: 'lop_2' },
              { title: 'Lớp 3', value: 'lop_3' }
            ]"
            density="compact"
            variant="outlined"
            hide-details
            class="max-w-[180px]"
            @update:model-value="fetchQuestions"
          ></v-select>
        </div>

        <div class="space-y-3 overflow-y-auto max-h-[550px] pr-1">
          <div
            v-for="q in questions"
            :key="q.id"
            class="p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white transition flex items-start justify-between gap-3"
          >
            <div class="space-y-2 flex-1">
              <div class="flex items-center gap-2">
                <v-chip size="x-small" color="indigo" class="font-bold uppercase">{{ q.grade }}</v-chip>
                <span class="font-extrabold text-sm text-slate-800">{{ q.question_text }}</span>
              </div>
              <div class="text-xs text-slate-500 italic">
                <v-icon size="x-small" color="indigo">mdi-volume-high</v-icon> "{{ q.speech_text }}"
              </div>
              
              <div class="grid grid-cols-2 gap-2 pt-1">
                <div
                  v-for="(opt, idx) in q.options"
                  :key="idx"
                  class="flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-lg border"
                  :class="opt.is_correct ? 'bg-emerald-50 border-emerald-300 text-emerald-800 font-bold' : 'bg-white border-slate-200 text-slate-600'"
                >
                  <span
                    class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                    :class="{
                      'bg-rose-500': opt.color === 'red',
                      'bg-emerald-500': opt.color === 'green',
                      'bg-amber-400': opt.color === 'yellow',
                      'bg-blue-500': opt.color === 'blue'
                    }"
                  ></span>
                  <span>{{ opt.label }}</span>
                  <v-icon v-if="opt.is_correct" size="x-small" color="emerald" class="ml-auto">mdi-check-bold</v-icon>
                </div>
              </div>
            </div>

            <v-btn
              icon="mdi-trash-can-outline"
              size="small"
              variant="text"
              color="error"
              @click="deleteQuestion(q.id)"
            ></v-btn>
          </div>

          <div v-if="questions.length === 0" class="text-center py-10 text-slate-400 text-sm">
            Chưa có câu hỏi nào. Bạn hãy soạn câu hỏi mới ở cột bên trái!
          </div>
        </div>
      </v-card>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { tvInterventionService } from '../../services/tvInterventionService'
import { toast } from '@/core/helpers/toast'

const loadingToggle = ref(false)
const loadingSave = ref(false)
const selectedGradeFilter = ref('all')

const settings = ref({
  is_active: true,
  interval_minutes: 10,
  daily_limit_minutes: 60,
  target_grade: 'mam_non'
})

const questions = ref([])

const correctColor = ref('green')
const newQuestion = ref({
  grade: 'mam_non',
  category: 'tong_hop',
  question_text: '',
  speech_text: '',
  options: {
    red: '',
    green: '',
    yellow: '',
    blue: ''
  }
})

async function fetchStatus() {
  try {
    const res = await tvInterventionService.getStatus()
    if (res.data?.success) {
      settings.value = res.data.data
    }
  } catch (err) {
    console.error(err)
  }
}

async function fetchQuestions() {
  try {
    const res = await tvInterventionService.getQuestions(selectedGradeFilter.value)
    if (res.data?.success) {
      questions.value = res.data.data
    }
  } catch (err) {
    console.error(err)
  }
}

async function toggleActive() {
  loadingToggle.value = true
  try {
    const newStatus = !settings.value.is_active
    const res = await tvInterventionService.toggle({ is_active: newStatus })
    if (res.data?.success) {
      settings.value.is_active = newStatus
      toast.success(newStatus ? 'Đã BẬT can thiệp TV' : 'Đã TẮT can thiệp TV')
    }
  } catch (err) {
    toast.error('Không thể cập nhật trạng thái')
  } finally {
    loadingToggle.value = false
  }
}

async function saveSettings() {
  try {
    const res = await tvInterventionService.updateSettings(settings.value)
    if (res.data?.success) {
      toast.success('Đã lưu cấu hình can thiệp')
    }
  } catch (err) {
    toast.error('Lỗi khi lưu cài đặt')
  }
}

async function submitQuestion() {
  if (!newQuestion.value.question_text) {
    toast.warning('Vui lòng nhập nội dung câu hỏi')
    return
  }

  loadingSave.value = true
  try {
    const payload = {
      grade: newQuestion.value.grade,
      category: 'tong_hop',
      question_text: newQuestion.value.question_text,
      speech_text: newQuestion.value.speech_text || newQuestion.value.question_text,
      options: [
        { color: 'red', label: newQuestion.value.options.red || 'Đáp án A', is_correct: correctColor.value === 'red' },
        { color: 'green', label: newQuestion.value.options.green || 'Đáp án B', is_correct: correctColor.value === 'green' },
        { color: 'yellow', label: newQuestion.value.options.yellow || 'Đáp án C', is_correct: correctColor.value === 'yellow' },
        { color: 'blue', label: newQuestion.value.options.blue || 'Đáp án D', is_correct: correctColor.value === 'blue' }
      ]
    }

    const res = await tvInterventionService.storeQuestion(payload)
    if (res.data?.success) {
      toast.success('Đã thêm câu hỏi thành công')
      newQuestion.value.question_text = ''
      newQuestion.value.speech_text = ''
      newQuestion.value.options = { red: '', green: '', yellow: '', blue: '' }
      fetchQuestions()
    }
  } catch (err) {
    toast.error('Lỗi khi lưu câu hỏi')
  } finally {
    loadingSave.value = false
  }
}

async function deleteQuestion(id) {
  if (!confirm('Bạn có chắc muốn xóa câu hỏi này?')) return
  try {
    const res = await tvInterventionService.deleteQuestion(id)
    if (res.data?.success) {
      toast.success('Đã xóa câu hỏi')
      fetchQuestions()
    }
  } catch (err) {
    toast.error('Lỗi khi xóa câu hỏi')
  }
}

function testSpeech(text) {
  if (!text) return
  if ('speechSynthesis' in window) {
    window.speechSynthesis.cancel()
    const utterance = new SpeechSynthesisUtterance(text)
    utterance.lang = 'vi-VN'
    utterance.rate = 0.95
    window.speechSynthesis.speak(utterance)
  }
}

onMounted(() => {
  fetchStatus()
  fetchQuestions()
})
</script>
