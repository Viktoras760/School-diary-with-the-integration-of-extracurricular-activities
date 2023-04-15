import React, { useState } from 'react'
import APIController from '../Controllers/APIController'

import { Row, Col, Card, Form, Button, Spinner } from 'react-bootstrap'
import { useNavigate, useLocation } from 'react-router-dom'

export default function Register () {
  const { http } = APIController()
  const [name, setName] = useState()
  const [surname, setSurname] = useState()
  const [personalCode, setPersonalCode] = useState()
  const [email, setEmail] = useState()
  const [password, setPassword] = useState()
  const [pdf, setPdf] = useState()

  const [isLoading, setLoading] = useState(false)

  const navigate = useNavigate()

  const location = useLocation()
  const queryParams = new URLSearchParams(location.search)
  const teacher = queryParams.get('teacher')

  const submitForm = () => {
    setLoading(true)
    const formData = new FormData()
    formData.append('name', name)
    formData.append('surname', surname)
    formData.append('personalCode', personalCode)
    formData.append('email', email)
    formData.append('password', password)
    formData.append('CV', pdf)
    http.post('/auth/users', formData).then((res) => {
      setName('')
      setSurname('')
      setPersonalCode('')
      setEmail('')
      setPdf('')
      setPassword('')
      navigate('/login?registered=true')
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
      }
    }).finally(() => {
      setLoading(false)
    })
  }

  return (
    <Row className="justify-content-center pt-5">
      <Col sm={6}>
        <Card className="p-4">
          <h1 className="text-center mb-3">Register</h1>
          <Form.Group className="mb-3" controlId="formBasicName">
            <Form.Label>Name</Form.Label>
            <Form.Control type="text" placeholder="Enter name" onChange={e => setName(e.target.value)}/>
          </Form.Group>

          <Form.Group className="mb-3" controlId="formBasicSurname">
            <Form.Label>Surname</Form.Label>
            <Form.Control type="text" placeholder="Enter surname" onChange={e => setSurname(e.target.value)}/>
          </Form.Group>

          <Form.Group className="mb-3" controlId="formBasicPersonalcode">
            <Form.Label>Personal code</Form.Label>
            <Form.Control type="number" placeholder="Enter personal code"
                          onChange={e => setPersonalCode(e.target.value)}/>
          </Form.Group>

          <Form.Group className="mb-3" controlId="formBasicEmail">
            <Form.Label>Email address</Form.Label>
            <Form.Control type="email" placeholder="Enter email" onChange={e => setEmail(e.target.value)}/>
          </Form.Group>

          <Form.Group className="mb-3" controlId="formBasicPassword">
            <Form.Label>Password</Form.Label>
            <Form.Control type="password" placeholder="Password" onChange={e => setPassword(e.target.value)}/>
          </Form.Group>

          {teacher && (
          <Form.Group className="mb-3" controlId="formBasicPdf">
            <Form.Label>PDF File</Form.Label>
            <Form.Control type="file" accept="application/pdf" onChange={e => setPdf(e.target.files[0])}/>
          </Form.Group>
          )}
          <div className="text-center">
            <Button variant="primary" onClick={submitForm} disabled={isLoading}>
              {isLoading ? <Spinner animation="border" size="sm"/> : 'Register'}
            </Button>
          </div>
        </Card>
      </Col>
    </Row>
  )
}
