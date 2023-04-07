import React, { useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Row, Col, Card, Form, Alert } from 'react-bootstrap'
import { useNavigate } from 'react-router-dom'

export default function EditSchool () {
  const { http } = APIController()
  const navigate = useNavigate()

  const [name, setName] = useState()
  const [address, setAddress] = useState()
  const [pupilAmount, setPupilAmount] = useState()
  const [teacherAmount, setTeacherAmount] = useState()

  const [isLoading, setLoading] = useState(false)

  const [errorMessage, setErrorMessage] = useState()

  const addSchool = () => {
    setLoading(true)
    http.post('/schools/', { name, address, pupilAmount, teacherAmount }).then((res) => {
      sessionStorage.setItem('post-success', res.data.success)
      navigate('/schools')
    }).catch((error) => {
      if (error.response.data.error != null) {
        setErrorMessage(error.response.data.error)
      } else if (error.response.data.errors != null) {
        const errors = error.response.data.errors
        const allErrors = []
        Object.keys(errors).map((err) => (
          allErrors.push(errors[err][0])
        ))
        setErrorMessage(allErrors.join('\n'))
      }
    }).finally(() => {
      setLoading(false)
    })
  }

  // eslint-disable-next-line react/prop-types
  function ErrorAlert ({ message }) {
    const [show, setShow] = useState(!!message)

    if (show) {
      return (
                <Alert variant="danger" onClose={() => setShow(false)} dismissible className="mt-3">
                    <Alert.Heading>Error</Alert.Heading>
                    <p>
                        {message}
                    </p>
                </Alert>
      )
    }
    return (<></>)
  }

  return (
        <Row className="justify-content-center pt-5">
            <Col>
                <Card className="p-4">
                    <h1 className="text-center mb-3">Add new school</h1>
                    <ErrorAlert message={errorMessage} />
                    <Form.Group className="mb-3" controlId="formBasicName">
                        <Form.Label>Name</Form.Label>
                        <Form.Control type="text" placeholder="Enter name" onChange={e => setName(e.target.value)} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicAddress">
                        <Form.Label>Address</Form.Label>
                        <Form.Control type="text" placeholder="Enter address" onChange={e => setAddress(e.target.value)} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicPupilAmount">
                        <Form.Label>Pupil amount</Form.Label>
                        <Form.Control type="number" placeholder="Enter pupil amount" onChange={e => setPupilAmount(e.target.value)} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicPupilAmount">
                        <Form.Label>Teacher amount</Form.Label>
                        <Form.Control type="number" placeholder="Enter teacher amount" onChange={e => setTeacherAmount(e.target.value)} />
                    </Form.Group>
                    <Button variant="primary" type="submit" disabled={isLoading} onClick={!isLoading ? addSchool : null}>
                        {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Add'}
                    </Button>
                </Card>
            </Col>
        </Row>
  )
}
