import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { useParams, useNavigate } from 'react-router-dom'
import { Spinner, Button, Alert, Row, Modal, Col } from 'react-bootstrap'
import PropTypes from 'prop-types'

const ClassroomDetail = ({ classroom, onDelete }) => {
  const { http, user } = APIController()
  const [isLoadingDelete, setLoadingDelete] = useState(false)
  const [isLoadingApprove] = useState(false)
  const [, setSchool] = useState(() => {
    return ''
  })

  const navigate = useNavigate()
  const { id1 } = useParams()
  ClassroomDetail.propTypes = {
    classroom: PropTypes.object.isRequired,
    onDelete: PropTypes.func.isRequired
  }

  useEffect(() => {
    fetchSchool()
  }, [])

  const fetchSchool = async () => {
    try {
      const res = await http.get(`/schools/${id1}`)
      setSchool(res.data)
    } catch (error) {
      console.error(error)
    }
  }

  const deleteClassroom = () => {
    setLoadingDelete(true)
  }

  const Lessons = () => {
    navigate(`/schools/${id1}/classrooms/${classroom.id_Classroom}/lessons`)
  }

  const editClassroom = () => {
    navigate(`/schools/${id1}/classroom_edit/${classroom.id_Classroom}`)
  }

  const submitDelete = async () => {
    try {
      const res = await http.delete(`/schools/${id1}/classrooms/${classroom.id_Classroom}`)
      alert(res.data.success)
      onDelete()
    } catch (error) {
      if (error.response?.data?.error != null) {
        alert(error.response.data.error)
      } else if (error.response?.data?.errors != null) {
        const errors = error.response.data.errors
        const allErrors = []
        Object.keys(errors).forEach((err) => {
          allErrors.push(errors[err][0])
        })
        alert(allErrors.join('\n'))
      }
    } finally {
      setLoadingDelete(false)
    }
  }

  const DeleteApproval = ({ message }) => {
    const [show, setShow] = useState(message)

    const handleSubmit = () => {
      setShow(false)
      submitDelete()
    }

    const handleClose = () => {
      setShow(false)
      setLoadingDelete(false)
    }

    return (
            <>
                <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>Delete classroom</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>Are you sure you want to delete classroom Nr.{classroom.number}?</Modal.Body>
                    <Modal.Footer>
                        <Button variant="danger" onClick={handleSubmit}>
                            Delete
                        </Button>
                        <Button variant="secondary" onClick={handleClose}>
                            Cancel
                        </Button>
                    </Modal.Footer>
                </Modal>
            </>
    )
  }
  DeleteApproval.propTypes = {
    message: PropTypes.bool.isRequired
  }

  return (
        <>
            <DeleteApproval message={isLoadingDelete} />
            <Col sm={10}>
                <div className="card mb-3">
                    <div className="card-body">
                        <img
                            className="mb-2"
                            src={require('../Images/empty-classroom.jpg')}
                            style={{ maxWidth: '80%' }}
                            height={200}
                            align={'right'}
                            alt={'empty classroom'}
                        ></img>
                        <p style={{ color: '#1B3D6C', margin: 20, fontSize: 20, fontFamily: 'Playfair Display' }}>
                            Classroom number: {classroom.number}
                        </p>
                        <p style={{ color: '#1B3D6C', margin: 20, fontSize: 20, fontFamily: 'Playfair Display' }}>Classroom pupil capacity: {classroom.pupilCapacity}</p>
                      <Button variant="primary" className="w-100 mb-2" disabled={isLoadingApprove} onClick={!isLoadingDelete ? Lessons : null}>
                          {isLoadingApprove ? <><Spinner animation="border" size="sm" /> Fetching details…</> : 'Classroom lessons'}
                      </Button>

                      {user != null && (user.role === 'School Administrator' || user.role === 'System Administrator')
                        ? (
                      <Button variant="success" className="w-100 mb-2" onClick={!isLoadingDelete ? editClassroom : null}>
                          {isLoadingDelete ? <><Spinner animation="border" size="sm" /> Fetching details…</> : 'Edit'}
                      </Button>
                          )
                        : null}

                      {user != null && (user.role === 'School Administrator' || user.role === 'System Administrator')
                        ? (
                      <Button variant="danger" className="w-100 mb-2" disabled={isLoadingDelete} onClick={!isLoadingDelete ? deleteClassroom : null}>
                          {isLoadingDelete ? <><Spinner animation="border" size="sm" /> Deleting…</> : 'Delete'}
                      </Button>
                          )
                        : null}
                  </div>
              </div>
          </Col>
      </>
  )
}

function ClassroomList () {
  const { id1 } = useParams()
  const navigate = useNavigate()
  const { http, user } = APIController()
  const [classrooms, setClassrooms] = useState([])
  const [successMessage, setSuccessMessage] = useState(sessionStorage.getItem('post-success'))

  useEffect(() => {
    fetchClassrooms()
  }, [])

  const fetchClassrooms = () => {
    http.get(`/schools/${id1}/classrooms`).then((res) => {
      setClassrooms(res.data)
    })
  }

  const addClassroom = () => {
    navigate(`/schools/${id1}/classroom/`)
  }

  function SuccessAlert ({ message }) {
    const [show, setShow] = useState(!!message)

    const handleClose = () => {
      setShow(false)
      setSuccessMessage(null)
      sessionStorage.removeItem('post-success') // Remove message from sessionStorage
    }

    if (show) {
      return (
        <Alert variant="success" onClose={handleClose} dismissible className="mt-3">
          <Alert.Heading>Success</Alert.Heading>
          <p>{message}</p>
        </Alert>
      )
    }
    return null
  }

  SuccessAlert.propTypes = {
    message: PropTypes.string
  }

  return (
    <div>
      <h1 className="mb-4 mt-4">Classrooms</h1>
      <SuccessAlert message={successMessage} />
      {user && (user.role === 'School Administrator' || user.role === 'System Administrator') && (
        <div className="flex items-center">
          <Button variant="success" className="w-100" onClick={addClassroom}>
            Add new classroom
          </Button>
        </div>
      )}
      <Row className="justify-content-center mt-3">
        {classrooms
          ? (
              classrooms.map((classroom, index) => {
                return <ClassroomDetail classroom={classroom} onDelete={fetchClassrooms} key={index} />
              })
            )
          : (
            <div className="text-center">
              <Spinner animation="border" />
            </div>
            )}
      </Row>
    </div>
  )
}

export default ClassroomList
