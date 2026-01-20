import { defineStore } from 'pinia'
import { ref } from 'vue'

const API = 'http://127.0.0.1:8000/api'

export const useAuthStore = defineStore('auth', () => {
  const token = ref<string | null>(localStorage.getItem('token'))
  const loading = ref(false)
  const error = ref<string | null>(null)

  async function loginOnce() {
    if (token.value) return

    loading.value = true
    error.value = null

    try {
      const res = await fetch(`${API}/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email: 'xingrangliu@gmail.com',
          password: 'abce1234'
        })
      })

      const data = await res.json()

      if (!res.ok) {
        throw new Error(data.message || 'Login failed')
      }

      token.value = data.token
      localStorage.setItem('token', data.token)
    } catch (e: any) {
      error.value = e.message
    } finally {
      loading.value = false
    }
  }

  function logout() {
    token.value = null
    localStorage.removeItem('token')
    location.reload()
  }

  return { token, loginOnce, logout, loading, error }
})
