import React, { useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Row, Col, Card, Form, Alert } from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom'

export default function AddClassroom () {
  const { http } = APIController()
  const navigate = useNavigate()
  const { id1, id2 } = useParams()

  const [lessonsName, setLessonsName] = useState()
  const [lessonsStartingTime, setLessonsStartingTime] = useState()
  const [lessonsEndingTime, setLessonsEndingTime] = useState()
  const [lowerGradeLimit, setLowerGradeLimit] = useState()
  const [upperGradeLimit, setUpperGradeLimit] = useState()

  const [isLoading, setLoading] = useState(false)

  const [errorMessage, setErrorMessage] = useState()

  const addLesson = () => {
    setLoading(true)
    http.post(`/schools/${id1}/classrooms/${id2}/lessons`, { lessonsName, lessonsStartingTime, lessonsEndingTime, lowerGradeLimit, upperGradeLimit }).then(() => {
      sessionStorage.setItem('post-success', 'Lesson added successfully')
      navigate(-1)
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

  const goBack = () => {
    setLoading(true)
    navigate(-1)
  }

  return (
        <Row className="justify-content-center pt-5">
            <Col>
                <Card className="p-4">
                    <h1 className="text-center mb-3">Add new lesson</h1>
                    <ErrorAlert message={errorMessage} />
                    <Form.Group className="mb-3" controlId="formBasicLessonName">
                        <Form.Label>Lesson name</Form.Label>
                        <Form.Control type="text" placeholder="Enter lessons name" onChange={e => setLessonsName(e.target.value)} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicLessonStartingTime">
                        <Form.Label>Lesson starting time</Form.Label>
                        <Form.Control type="datetime-local" placeholder="Enter lesson starting time" onChange={e => setLessonsStartingTime(e.target.value.replace('T', ' '))} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicLessonEndingTime">
                        <Form.Label>Lesson ending time</Form.Label>
                        <Form.Control type="datetime-local" placeholder="Enter lesson ending time" onChange={e => setLessonsEndingTime(e.target.value.replace('T', ' '))} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicLessonLowerGradeLimit">
                        <Form.Label>Lesson lower grade limit</Form.Label>
                        <Form.Control type="number" placeholder="Enter lesson lower grade limit" onChange={e => setLowerGradeLimit(e.target.value)} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicLessonUpperGradeLimit">
                        <Form.Label>Lesson upper grade limit</Form.Label>
                        <Form.Control type="number" placeholder="Enter lesson upper grade limit" onChange={e => setUpperGradeLimit(e.target.value)} />
                    </Form.Group>
                    <Button variant="primary" type="submit" disabled={isLoading} onClick={!isLoading ? addLesson : null}>
                        {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Add'}
                    </Button>
                  <Button variant="secondary" disabled={isLoading} onClick={!isLoading ? goBack : null} style={{ marginTop: '10px', backgroundColor: 'gray' }}>
                    {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Cancel'}
                  </Button>
                </Card>
            </Col>
        </Row>
  )
}
