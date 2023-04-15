import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Row, Col, Card, Form, Alert } from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom'
import PropTypes from 'prop-types'

export default function EditLesson () {
  const { http } = APIController()
  const navigate = useNavigate()

  const { id1, id2, id3 } = useParams()

  const [lessonsName, setLessonsName] = useState()
  const [lessonsStartingTime, setLessonsStartingTime] = useState()
  const [lessonsEndingTime, setLessonsEndingTime] = useState()
  const [lowerGradeLimit, setLowerGradeLimit] = useState()
  const [upperGradeLimit, setUpperGradeLimit] = useState()

  const [isLoading, setLoading] = useState(false)

  const [errorMessage, setErrorMessage] = useState()

  useEffect(() => {
    fetchLessonDetails()
  }, [])

  const fetchLessonDetails = () => {
    http.get(`schools/${id1}/classrooms/${id2}/lessons/${id3}`).then((res) => {
      setLessonsName(res.data.lessonsName)
      setLessonsStartingTime(res.data.lessonsStartingTime)
      setLessonsEndingTime(res.data.lessonsEndingTime)
      setLowerGradeLimit(res.data.lowerGradeLimit)
      setUpperGradeLimit(res.data.upperGradeLimit)
    }).catch(() => {
      navigate(-1)
    })
  }

  const updateLesson = () => {
    setLoading(true)
    http.put(`schools/${id1}/classrooms/${id3}/lessons/${id3}`, { lessonsName, lessonsStartingTime, lessonsEndingTime, lowerGradeLimit, UpperGradeLimit: upperGradeLimit }).then((res) => {
      sessionStorage.setItem('post-success', res.data.success)
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

  const goBack = () => {
    setLoading(true)
    navigate(-1)
  }

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
  ErrorAlert.propTypes = {
    message: PropTypes.string
  }

  if (lessonsName || lessonsStartingTime || lessonsEndingTime || lowerGradeLimit || upperGradeLimit) {
    return (
            <Row className="justify-content-center pt-5">
                <Col>
                    <Card className="p-4">
                        <h1 className="text-center mb-3">Edit lesson</h1>
                        <ErrorAlert message={errorMessage} />
                        <Form.Group className="mb-3" controlId="formBasicLessonName">
                            <Form.Label>Lesson name</Form.Label>
                            <Form.Control type="text" placeholder="Enter lessons name" value={lessonsName} onChange={e => setLessonsName(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicLessonStartingTime">
                            <Form.Label>Lesson starting time</Form.Label>
                            <Form.Control type="datetime-local" placeholder="Enter lesson starting time" value={lessonsStartingTime} onChange={e => setLessonsStartingTime(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicLessonEndingTime">
                            <Form.Label>Lesson ending time</Form.Label>
                            <Form.Control type="datetime-local" placeholder="Enter lesson ending time" value={lessonsEndingTime} onChange={e => setLessonsEndingTime(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicLessonLowerGradeLimit">
                            <Form.Label>Lesson lower grade limit</Form.Label>
                            <Form.Control type="number" placeholder="Enter lesson lower grade time" value={lowerGradeLimit} onChange={e => setLowerGradeLimit(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicLessonUpperGradeLimit">
                            <Form.Label>Lesson upper grade limit</Form.Label>
                            <Form.Control type="number" placeholder="Enter lesson upper grade limit" value={upperGradeLimit} onChange={e => setUpperGradeLimit(e.target.value)} />
                        </Form.Group>
                        <Button variant="primary" type="submit" disabled={isLoading} onClick={!isLoading ? updateLesson : null}>
                            {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Update'}
                        </Button>
                      <Button variant="secondary" disabled={isLoading} onClick={!isLoading ? goBack : null} style={{ marginTop: '10px', backgroundColor: 'gray' }}>
                        {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Back'}
                      </Button>
                    </Card>
                </Col>
            </Row>
    )
  } else {
    return (
            <Row className="justify-content-center pt-5">
                <Spinner animation="border" />
            </Row>
    )
  }
}
