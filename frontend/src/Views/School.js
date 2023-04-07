import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Row, Col, Card, Form, Alert } from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom'
import PropTypes from 'prop-types'

export default function EditSchool () {
  const { http } = APIController()
  const navigate = useNavigate()

  const { id } = useParams()

  const [name, setName] = useState()
  const [address, setAddress] = useState()
  const [pupilAmount, setPupilAmount] = useState()
  const [teacherAmount, setTeacherAmount] = useState()

  const [isLoading, setLoading] = useState(false)

  const [errorMessage, setErrorMessage] = useState()

  useEffect(() => {
    fetchSchoolDetails()
  }, [])

  const fetchSchoolDetails = () => {
    http.get(`/schools/${id}`).then((res) => {
      setName(res.data.name)
      setAddress(res.data.address)
      setPupilAmount(res.data.pupilAmount)
      setTeacherAmount(res.data.teacherAmount)
    }).catch(() => {
      navigate('/schools/')
    })
  }

  const updateSchool = () => {
    setLoading(true)
    http.put(`/schools/${id}`, { name, address, pupilAmount, teacherAmount }).then((res) => {
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

  if (name || address || pupilAmount || teacherAmount) {
    return (
            <Row className="justify-content-center pt-5">
                <Col>
                    <Card className="p-4">
                        <h1 className="text-center mb-3">Edit school</h1>
                        <ErrorAlert message={errorMessage} />
                        <Form.Group className="mb-3" controlId="formBasicName">
                            <Form.Label>Name</Form.Label>
                            <Form.Control type="text" placeholder="Enter name" value={name} onChange={e => setName(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicAdress">
                            <Form.Label>Adress</Form.Label>
                            <Form.Control type="text" placeholder="Enter adress" value={address} onChange={e => setAddress(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicPupilAmount">
                            <Form.Label>Pupil amount</Form.Label>
                            <Form.Control type="number" placeholder="Enter pupil amount" value={pupilAmount} onChange={e => setPupilAmount(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicPupilAmount">
                            <Form.Label>Teacher amount</Form.Label>
                            <Form.Control type="number" placeholder="Enter teacher amount" value={teacherAmount} onChange={e => setTeacherAmount(e.target.value)} />
                        </Form.Group>
                        <Button variant="primary" type="submit" disabled={isLoading} onClick={!isLoading ? updateSchool : null}>
                            {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Edit'}
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
