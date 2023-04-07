import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Row, Col, Alert, Modal } from 'react-bootstrap'
import PropTypes from 'prop-types'

const LessonDetail2 = ({ lesson, onDelete }) => {
  const { http } = APIController()
  const [isLoadingDelete, setLoadingDelete] = useState(false)
  const [isLoadingApprove] = useState(false)

  LessonDetail2.propTypes = {
    lesson: PropTypes.object.isRequired,
    onDelete: PropTypes.func.isRequired
  }

  const deleteLesson = () => {
    setLoadingDelete(true)
  }

  function submitDelete () {
    http.delete(`/teacher_lessons/${lesson.id_Lesson}`).then((res) => {
      alert(res.data.success)
      onDelete()
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
      setLoadingDelete(false)
    })
  }

  function DeleteApproval ({ message }) {
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
                    <Modal.Title>Delete lesson</Modal.Title>
                </Modal.Header>
                <Modal.Body>Are you sure you want to delete {lesson.Lessons_name}?</Modal.Body>
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
            <Col sm={6}>
                <div className="card mb-3">
                    <div className="card-body">

                        <p>Lessons name: {lesson.Lessons_name}</p>
                        <p>Lessons starting time: {lesson.Lessons_starting_time}</p>
                        <p>Lessons ending time: {lesson.Lessons_ending_time}</p>
                        <Button variant="primary" className="w-100 mb-2" disabled={isLoadingApprove}>
                            {isLoadingApprove ? <><Spinner animation="border" size="sm" /> Fetching details…</> : 'Details'}
                        </Button>
                        <Button variant="danger" className="w-100" disabled={isLoadingDelete} onClick={!isLoadingDelete ? deleteLesson : null}>
                            {isLoadingDelete ? <><Spinner animation="border" size="sm" /> Unregistering…</> : 'Unregister'}
                        </Button>
                    </div>
                </div>
            </Col>
        </>
  )
}

function Schedule () {
  const { http } = APIController()

  const [LessonDetails, setLessonDetails] = useState('')

  const [successMessage, setSuccessMessage] = useState(sessionStorage.getItem('post-success'))

  const [, setLoading] = useState(false)

  useEffect(() => {
    fetchLessonDetails()
  }, [])

  const fetchLessonDetails = () => {
    http.get('/teacher_lessons/').then((res) => {
      setLessonDetails(res.data)
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

  function SuccessAlert ({ message }) {
    const [show, setShow] = useState(!!message)

    if (show) {
      sessionStorage.removeItem('post-success')
      return (
                <Alert variant="success" onClose={() => { setShow(false); setSuccessMessage() }} dismissible className="mt-3">
                    <Alert.Heading>Success</Alert.Heading>
                    <p>
                        {message}
                    </p>
                </Alert>
      )
    }
    return (<></>)
  }
  SuccessAlert.propTypes = {
    message: PropTypes.string
  }

  return (
        <div>
            <h1 className="mb-4 mt-4">Lessons</h1>
            <SuccessAlert message={successMessage} />
            <Row className="justify-content-center mt-3">
                {LessonDetails
                  ? LessonDetails.map((lesson, index) => {
                    return (<LessonDetail2 lesson={lesson} onDelete={fetchLessonDetails} key={index} />)
                  })
                  : <div className="text-center">
                    <Spinner animation="border" />
                </div>}
            </Row>
        </div>
  )
}

export default Schedule
