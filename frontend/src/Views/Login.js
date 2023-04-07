import React, { useState } from 'react'
import APIController from '../Controllers/APIController'
import { useNavigate } from 'react-router-dom'

import { Row, Col, Card, Form, Button, Spinner } from 'react-bootstrap'

export default function Login () {
  const { http, setToken } = APIController()
  const [email, setEmail] = useState()
  const [password, setPassword] = useState()

  const [isLoading, setLoading] = useState(false)

  const navigate = useNavigate()

  const submitForm = () => {
    setLoading(true)
    http.post('/auth/iat', { email, password }).then((res) => {
      setToken(res.data.user, res.data.access_token)
      navigate('/dashboard')
      window.location.reload(false)
    }).catch((error) => {
      if (error.response.data.error != null) {
        alert(error.response.data.error)
      } else if (error.response.data.errors != null) {
        const errors = error.response.data.errors
        const allErrors = []
        Object.keys(errors).map((err) => (
          allErrors.push(errors[err][0])
        ))
        alert(allErrors.join('\n'))
      } else {
        alert('Cannot login! Incorrect credentials!')
      }
    }).finally(() => {
      setLoading(false)
    })
  }

  return (
        <Row className="justify-content-center pt-5">
            <Col sm={6}>
                <Card className="p-4">
                    <h1 className="text-center mb-3">Login</h1>
                    <Form.Group className="mb-3" controlId="formBasicEmail">
                        <Form.Label>Email address</Form.Label>
                        <Form.Control type="email" placeholder="Enter email" onChange={e => setEmail(e.target.value)} />
                    </Form.Group>

                    <Form.Group className="mb-3" controlId="formBasicPassword">
                        <Form.Label>Password</Form.Label>
                        <Form.Control type="password" placeholder="Password" onChange={e => setPassword(e.target.value)} />
                    </Form.Group>
                    <Button variant="primary" type="submit" disabled={isLoading} onClick={!isLoading ? submitForm : null}>
                        {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Login'}
                    </Button>
                </Card>
            </Col>
        </Row>
  )
}
