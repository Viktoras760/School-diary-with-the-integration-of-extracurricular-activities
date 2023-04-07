import React, { useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Row, Col, Card, Form, Alert } from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom'
import PropTypes from 'prop-types'

export default function AddClassroom () {
  const { http } = APIController()
  const navigate = useNavigate()
  const { id1 } = useParams()

  const [number, setNumber] = useState()
  const [floor, setFloor] = useState()
  const [pupilCapacity, setPupilCapacity] = useState()
  const [musicalEquipment, setMusicalEquipment] = useState()
  const [chemistryEquipment, setChemistryEquipment] = useState()
  const [computers, setComputers] = useState()

  const [isLoading, setLoading] = useState(false)

  const [errorMessage, setErrorMessage] = useState()

  const addClassroom = () => {
    setLoading(true)
    http.post(`/schools/${id1}/classrooms`, { number, floorNuber: floor, pupilCapacity, musicalEquipment, chemistryEquipment, computers }).then((res) => {
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
                    <p>{message}</p>
                </Alert>
      )
    }

    return null
  }
  ErrorAlert.propTypes = {
    message: PropTypes.string
  }

  return (
        <Row className="justify-content-center pt-5">
            <Col>
                <Card className="p-4">
                    <h1 className="text-center mb-3">Add new classroom</h1>
                    <ErrorAlert message={errorMessage} />
                    <Form.Group className="mb-3" controlId="formBasicClassroomNumber">
                        <Form.Label>Classroom number</Form.Label>
                        <Form.Control type="number" placeholder="Enter classroom number" onChange={e => setNumber(e.target.value)} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicFloorNumber">
                      <Form.Label>Floor number</Form.Label>
                      <Form.Control type="number" placeholder="Enter floor number" onChange={e => setFloor(e.target.value)} />
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formBasicPupilCapacity">
                        <Form.Label>Pupil capacity amount</Form.Label>
                        <Form.Control type="number" placeholder="Enter pupil capacity" onChange={e => setPupilCapacity(e.target.value)} />
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
                    <Button variant="primary" type="submit" disabled={isLoading} onClick={!isLoading ? addClassroom : null}>
                        {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Add'}
                    </Button>
                </Card>
            </Col>
        </Row>
  )
}
