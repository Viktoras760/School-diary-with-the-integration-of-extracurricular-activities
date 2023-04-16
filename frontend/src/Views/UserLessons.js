import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Alert, Modal, Table, Card } from 'react-bootstrap'
import PropTypes from 'prop-types'
import { useNavigate } from 'react-router-dom'

const LessonDetail = ({ lesson, onDelete }) => {
  const { http } = APIController()
  const [isLoadingDelete, setLoadingDelete] = useState(false)
  const [isLoadingApprove] = useState(false)

  LessonDetail.propTypes = {
    lesson: PropTypes.object.isRequired,
    onDelete: PropTypes.func.isRequired
  }

  const deleteLesson = () => {
    setLoadingDelete(true)
  }

  function submitDelete () {
    http
      .delete(`/user_lessons/${lesson.id_Lesson}`)
      .then((res) => {
        alert(res.data.success)
        onDelete()
      })
      .catch((error) => {
        if (error.response.data.error != null) {
          alert(error.response.data.error)
        } else if (error.response.data.errors != null) {
          const errors = error.response.data.errors
          const allErrors = []
          Object.keys(errors).map((err) => allErrors.push(errors[err][0]))
          alert(allErrors.join('\n'))
        }
      })
      .finally(() => {
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
            <Modal.Title>Unregister from lesson</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            Are you sure you want to unregister from {lesson.lessonsName}?
          </Modal.Body>
          <Modal.Footer>
            <Button variant="danger" onClick={handleSubmit}>
              Unregister
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
      <tr>
        <DeleteApproval message={isLoadingDelete} />
        <td>{lesson.lessonsName}</td>
        <td>{lesson.lessonsStartingTime}</td>
        <td>{lesson.lessonsEndingTime}</td>
        <td>
          <Button
            variant="primary"
            className="w-100 mb-2"
            disabled={isLoadingApprove}
          >
            {isLoadingApprove
              ? (
              <>
                <Spinner animation="border" size="sm" /> Fetching details…
              </>
                )
              : (
                  'Details'
                )}
          </Button>
        </td>
        <td>
          <Button
            variant="danger"
            className="w-100"
            disabled={isLoadingDelete}
            onClick={!isLoadingDelete ? deleteLesson : null}
          >
            {isLoadingDelete
              ? (
              <>
                <Spinner animation="border" size="sm" /> Unregistering…
              </>
                )
              : (
                  'Unregister'
                )}
          </Button>
        </td>
      </tr>
    </>
  )
}

function UserLessons () {
  const { http } = APIController()
  const [lessonDetails, setLessonDetails] = useState(null)
  const [successMessage, setSuccessMessage] = useState(sessionStorage.getItem('post-success'))
  const navigate = useNavigate()
  const [, setLoading] = useState(false)

  const weekDates = getCurrentWeekDates()
  const startDate = weekDates[0].toLocaleDateString()
  const endDate = weekDates[6].toLocaleDateString()

  const [weekStartDate, setWeekStartDate] = useState(startDate)
  const [weekEndDate, setWeekEndDate] = useState(endDate)

  useEffect(() => {
    fetchLessonDetails()
  }, [])

  const fetchLessonDetails = () => {
    const params = {
      start_date: weekStartDate,
      end_date: weekEndDate
    }
    http.get('/user_lessons/', { params }).then((res) => {
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
      navigate(-1)
    }).finally(() => {
      setLoading(false)
    })
  }

  function SuccessAlert ({ message }) {
    const [show, setShow] = useState(!!message)

    if (show) {
      sessionStorage.removeItem('post-success')
      return (
        <Alert variant="success" onClose={() => {
          setShow(false)
          setSuccessMessage()
        }} dismissible className="mt-3">
          <Alert.Heading>Success</Alert.Heading>
          <p>
            {message}
          </p>
        </Alert>
      )
    }
    return (<></>)
  }

  function handlePreviousWeek () {
    const newWeekStartDate = new Date(weekStartDate)
    newWeekStartDate.setDate(newWeekStartDate.getDate() - 7)
    const newWeekEndDate = new Date(weekEndDate)
    newWeekEndDate.setDate(newWeekEndDate.getDate() - 7)
    setWeekStartDate(newWeekStartDate.toLocaleDateString())
    setWeekEndDate(newWeekEndDate.toLocaleDateString())
  }

  function handleNextWeek () {
    const newWeekStartDate = new Date(weekStartDate)
    newWeekStartDate.setDate(newWeekStartDate.getDate() + 7)
    const newWeekEndDate = new Date(weekEndDate)
    newWeekEndDate.setDate(newWeekEndDate.getDate() + 7)
    setWeekStartDate(newWeekStartDate.toLocaleDateString())
    setWeekEndDate(newWeekEndDate.toLocaleDateString())
  }

  function getWeekDates () {
    const dates = []
    for (let date = new Date(weekStartDate); date <= new Date(weekEndDate); date.setDate(date.getDate() + 1)) {
      dates.push(new Date(date))
    }
    return dates
  }

  SuccessAlert.propTypes = {
    message: PropTypes.string
  }

  if (lessonDetails === null) {
    return <div>Loading...</div>
  }

  return (
    <div>
      <h1 className="mb-4 mt-4">Lessons</h1>
      <SuccessAlert message={successMessage}/>
      <div>
        <h3>Selected week: {weekStartDate} - {weekEndDate}</h3>
        <button onClick={handlePreviousWeek}>Previous Week</button>
        <button onClick={handleNextWeek}>Next Week</button>
      </div>
      {getWeekDates().map((date, index) => {
        const lessonsForDay = lessonDetails ? lessonDetails.filter(lesson => new Date(lesson.lessonsStartingTime).toDateString() === date.toDateString()) : []
        return (
          <Card className="justify-content-center mt-3" key={index} border="light">
            <Card.Title className="mb-0">
              <h4>{date.toLocaleDateString()} - {date.toLocaleDateString(undefined, { weekday: 'long' })}</h4>
            </Card.Title>
            <Table striped hover responsive>
              <thead>
              <tr>
                <th>Name</th>
                <th>Starting Time</th>
                <th>Ending Time</th>
                <th>Details</th>
                <th>Unregister</th>
              </tr>
              </thead>
              <tbody>
              {lessonsForDay.length > 0
                ? (
                    lessonsForDay.map((lesson, index) => (
                    <LessonDetail lesson={lesson} onDelete={fetchLessonDetails} key={index}/>
                    ))
                  )
                : (
                  <tr className="text-center">
                    <td colSpan={5}>You have no planned activities for this day.</td>
                  </tr>
                  )}
              </tbody>
            </Table>
          </Card>
        )
      })}
    </div>
  )
}

export default UserLessons

function getCurrentWeekDates () {
  const today = new Date()
  const dayOfWeek = today.getDay()
  const startOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - dayOfWeek)
  const dates = []
  for (let i = 0; i < 7; i++) {
    const date = new Date(startOfWeek.getFullYear(), startOfWeek.getMonth(), startOfWeek.getDate() + i)
    dates.push(date)
  }
  return dates
}
