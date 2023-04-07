import axios from 'axios'
import { useState } from 'react'

export default function APIController () {
  const getToken = () => {
    const tokenString = sessionStorage.getItem('token')
    return JSON.parse(tokenString)
  }

  const getUser = () => {
    const userString = sessionStorage.getItem('user')
    return JSON.parse(userString)
  }

  const [token, setToken] = useState(getToken())
  const [user, setUser] = useState(getUser())

  const saveToken = (user, token) => {
    sessionStorage.setItem('token', JSON.stringify(token))
    sessionStorage.setItem('user', JSON.stringify(user))

    setToken(token)
    setUser(user)
  }

  const logout = () => {
    sessionStorage.clear()
  }

  const http = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
      'Content-type': 'application/json',
      Authorization: `Bearer ${token}`
    }
  })

  return {
    setToken: saveToken,
    token,
    user,
    getToken,
    http,
    logout
  }
}
