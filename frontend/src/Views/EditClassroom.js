import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Row, Col, Card, Form, Alert } from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom'
import PropTypes from 'prop-types'

export default function EditClassroom () {
  const { http } = APIController()
  const navigate = useNavigate()

  const { id1, id2 } = useParams()

  const [number, setNumber] = useState()
  const [pupilCapacity, setPupilCapacity] = useState()
  const [musicalEquipment, setMusicalEquipment] = useState()
  const [chemistryEquipment, setChemistryEquipment] = useState()
  const [computers, setComputers] = useState()

  const [isLoading, setLoading] = useState(false)

  const [errorMessage, setErrorMessage] = useState()

  useEffect(() => {
    fetchClassroomDetails()
  }, [])

  const fetchClassroomDetails = () => {
    http.get(`schools/${id1}/classrooms/${id2}`).then((res) => {
      setNumber(res.data.number)
      setPupilCapacity(res.data.pupilCapacity)
      setMusicalEquipment(res.data.musicalEquipment)
      setChemistryEquipment(res.data.chemistryEquipment)
      setComputers(res.data.computers)
    }).catch(() => {
      navigate(-1)
    })
  }

  const updateClassroom = () => {
    setLoading(true)
    http.put(`schools/${id1}/classrooms/${id2}`, { number, pupilCapacity, musicalEquipment, chemistryEquipment, computers }).then((res) => {
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

  if (number || pupilCapacity) {
    return (
            <Row className="justify-content-center pt-5">
                <Col>
                    <Card className="p-4">
                        <h1 className="text-center mb-3">Edit classroom</h1>
                        <ErrorAlert message={errorMessage} />
                        <Form.Group className="mb-3" controlId="formBasicNumber">
                            <Form.Label>Number</Form.Label>
                            <Form.Control type="number" placeholder="Enter number" value={number} onChange={e => setNumber(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicPupil_capacity">
                            <Form.Label>Pupil capacity</Form.Label>
                            <Form.Control type="number" placeholder="Enter pupil capacity" value={pupilCapacity} onChange={e => setPupilCapacity(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicMusicalEquipment">
                            <Form.Label>Musical equipment</Form.Label>
                            <Form.Select className="mb-3" defaultValue={musicalEquipment} onChange={e => setMusicalEquipment(e.target.value)}>
                                <option value={musicalEquipment} >{musicalEquipment}</option>
                                <option value="1" >Yes</option>
                                <option value="2" >No</option>
                            </Form.Select>
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicChemistryEquipment">
                            <Form.Label>Chemical equipment</Form.Label>
                            <Form.Select className="mb-3" defaultValue={chemistryEquipment} onChange={e => setChemistryEquipment(e.target.value)}>
                                <option value={chemistryEquipment} >{chemistryEquipment}</option>
                                <option value="1" >Yes</option>
                                <option value="2" >No</option>
                            </Form.Select>
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicComputers">
                            <Form.Label>Computers</Form.Label>
                            <Form.Select className="mb-3" defaultValue={computers} onChange={e => setComputers(e.target.value)}>
                                <option value={computers} >{computers}</option>
                                <option value="1" >Yes</option>
                                <option value="2" >No</option>
                            </Form.Select>
                        </Form.Group>
                        <Button variant="primary" type="submit" disabled={isLoading} onClick={!isLoading ? updateClassroom : null}>
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
