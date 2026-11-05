import { axiosClient } from '@/core/api/axiosClient'
import { Endpoints } from '@/core/api/endpoints'

export const tvInterventionService = {
  getStatus(deviceId = 'TV_DEFAULT') {
    return axiosClient.get(Endpoints.TV_INTERVENTION.STATUS, { params: { device_id: deviceId } })
  },

  updateSettings(data) {
    return axiosClient.post(Endpoints.TV_INTERVENTION.SETTINGS, data)
  },

  toggle(data) {
    return axiosClient.post(Endpoints.TV_INTERVENTION.TOGGLE, data)
  },

  getQuestions(grade = 'all') {
    return axiosClient.get(Endpoints.TV_INTERVENTION.QUESTIONS, { params: { grade } })
  },

  storeQuestion(data) {
    return axiosClient.post(Endpoints.TV_INTERVENTION.STORE_QUESTION, data)
  },

  deleteQuestion(id) {
    return axiosClient.delete(Endpoints.TV_INTERVENTION.DELETE_QUESTION(id))
  },
}
