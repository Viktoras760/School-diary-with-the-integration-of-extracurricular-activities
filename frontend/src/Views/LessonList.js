import React, { useEffect, useState } from 'react'
import PropTypes from 'prop-types'
import APIController from '../Controllers/APIController'
import { useParams, useNavigate } from 'react-router-dom'
import { Spinner, Button, Alert, Row, Modal, Col } from 'react-bootstrap'

const LessonDetail = ({ lesson, onDelete }) => {
  const { http, user } = APIController()
  const [isLoadingDelete, setLoadingDelete] = useState(false)
  const [isLoadingApprove] = useState(false)
  const navigate = useNavigate()
  const { id1, id2 } = useParams()

  LessonDetail.propTypes = {
    lesson: PropTypes.object.isRequired,
    onDelete: PropTypes.func.isRequired
  }

  const deleteLesson = () => {
    setLoadingDelete(true)
  }

  const editLesson = async () => {
    navigate(`/schools/${id1}/classrooms/${id2}/edit_lesson/${lesson.id_Lesson}`)
  }

  const Register = async () => {
    http.post(`/schools/${id1}/classrooms/${id2}/lessons/${lesson.id_Lesson}`).then((res) => {
      alert(res.data.success)
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
    })
  }

  function submitDelete () {
    http.delete(`/schools/${id1}/classrooms/${id2}/lessons/${lesson.id_Lesson}`).then((res) => {
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
              <Modal.Body>Are you sure you want to delete lesson {lesson.Lessons_name}?</Modal.Body>
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
                      <p>Lessons name<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><title>book_2_line</title><g id="页面-1" stroke="none" strokeWidth="1" fill="none" fillRule="evenodd"><g id="Education" transform="translate(-144.000000, 0.000000)" fillRule="nonzero"><g id="book_2_line" transform="translate(144.000000, 0.000000)"><path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fillRule="nonzero"/><path d="M18,2 C19.1046,2 20,2.89543 20,4 L20,16.99 C20,17.1576 19.9623,17.3115 19.8872,17.4617 L19.3416,18.5528 C19.2009,18.8343 19.2009,19.1657 19.3416,19.4472 L19.8854,20.5348 C19.9586,20.6737 20,20.832 20,21 C20,21.5523 19.5523,22 19,22 L7,22 C5.34315,22 4,20.6569 4,19 L4,5 C4,3.34315 5.34315,2 7,2 L18,2 Z M17.4076,18 L7,18 C6.44772,18 6,18.4477 6,19 C6,19.51285 6.38604429,19.9355092 6.88337975,19.9932725 L7,20 L17.4076,20 C17.2043111,19.4250667 17.1817235,18.803042 17.339837,18.2176439 L17.4076,18 Z M18,4 L7,4 C6.48716857,4 6.06449347,4.38604429 6.0067278,4.88337975 L6,5 L6,16.1707 C6.250224,16.0823 6.51568,16.026092 6.79138112,16.0071448 L7,16 L18,16 L18,4 Z M14,7 C14.5523,7 15,7.44772 15,8 C15,8.51283143 14.613973,8.93550653 14.1166239,8.9932722 L14,9 L10,9 C9.44772,9 9,8.55228 9,8 C9,7.48716857 9.38604429,7.06449347 9.88337975,7.0067278 L10,7 L14,7 Z" id="形状" fill="#09244B"/></g></g></g></svg>: {lesson.Lessons_name}</p>
                      <p>Lessons starting time: {lesson.Lessons_starting_time} <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><title>alarm_2_line</title><g id="页面-1" stroke="none" strokeWidth="1" fill="none" fillRule="evenodd"><g id="Device" transform="translate(-96.000000, 0.000000)" fillRule="nonzero"><g id="alarm_2_line" transform="translate(96.000000, 0.000000)"><path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fillRule="nonzero"/><path d="M12,4 C16.9706,4 21,8.02944 21,13 C21,17.9706 16.9706,22 12,22 C7.02944,22 3,17.9706 3,13 C3,8.02944 7.02944,4 12,4 Z M12,6 C8.13401,6 5,9.13401 5,13 C5,16.866 8.13401,20 12,20 C15.866,20 19,16.866 19,13 C19,9.13401 15.866,6 12,6 Z M12,8 C12.51285,8 12.9355092,8.38604429 12.9932725,8.88337975 L13,9 L13,12.5859 L14.8125,14.3983 C15.203,14.7889 15.203,15.422 14.8125,15.8125 C14.4519462,16.1730538 13.8847651,16.2007888 13.4924224,15.8957047 L13.3982,15.8125 L11.2928,13.7071 C11.1272167,13.5415167 11.0318417,13.3322528 11.006675,13.1163454 L11,12.9863 L11,9 C11,8.44772 11.4477,8 12,8 Z M16.6344,2.97088 C16.911,2.49281 17.5227,2.32945 18.0008,2.606 C19.252,3.3298 20.3599,4.27272 21.2724,5.38217 C21.6232,5.80873 21.5618,6.43891 21.1352,6.78972 C20.7087,7.14054 20.0785,7.07914 19.7277,6.65258 C18.9663,5.72685 18.0421,4.94042 16.9993,4.33721 C16.5212,4.06066 16.3579,3.44894 16.6344,2.97088 Z M5.9993,2.606 C6.47736,2.32945 7.08909,2.49282 7.36563,2.97088 C7.64218,3.44894 7.47882,4.06066 7.00075,4.33721 C5.95799,4.94042 5.03373,5.72685 4.27237,6.65258 C3.92156,7.07914 3.29138,7.14054 2.86482,6.78972 C2.43827,6.43891 2.37687,5.80873 2.72769,5.38217 C3.64015,4.27272 4.74805,3.3298 5.9993,2.606 Z" id="形状" fill="#09244B"/></g></g></g></svg></p>
                      <p>Lessons ending time: {lesson.Lessons_ending_time} <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><title>alarm_2_line</title><g id="页面-1" stroke="none" strokeWidth="1" fill="none" fillRule="evenodd"><g id="Device" transform="translate(-96.000000, 0.000000)" fillRule="nonzero"><g id="alarm_2_line" transform="translate(96.000000, 0.000000)"><path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fillRule="nonzero"/><path d="M12,4 C16.9706,4 21,8.02944 21,13 C21,17.9706 16.9706,22 12,22 C7.02944,22 3,17.9706 3,13 C3,8.02944 7.02944,4 12,4 Z M12,6 C8.13401,6 5,9.13401 5,13 C5,16.866 8.13401,20 12,20 C15.866,20 19,16.866 19,13 C19,9.13401 15.866,6 12,6 Z M12,8 C12.51285,8 12.9355092,8.38604429 12.9932725,8.88337975 L13,9 L13,12.5859 L14.8125,14.3983 C15.203,14.7889 15.203,15.422 14.8125,15.8125 C14.4519462,16.1730538 13.8847651,16.2007888 13.4924224,15.8957047 L13.3982,15.8125 L11.2928,13.7071 C11.1272167,13.5415167 11.0318417,13.3322528 11.006675,13.1163454 L11,12.9863 L11,9 C11,8.44772 11.4477,8 12,8 Z M16.6344,2.97088 C16.911,2.49281 17.5227,2.32945 18.0008,2.606 C19.252,3.3298 20.3599,4.27272 21.2724,5.38217 C21.6232,5.80873 21.5618,6.43891 21.1352,6.78972 C20.7087,7.14054 20.0785,7.07914 19.7277,6.65258 C18.9663,5.72685 18.0421,4.94042 16.9993,4.33721 C16.5212,4.06066 16.3579,3.44894 16.6344,2.97088 Z M5.9993,2.606 C6.47736,2.32945 7.08909,2.49282 7.36563,2.97088 C7.64218,3.44894 7.47882,4.06066 7.00075,4.33721 C5.95799,4.94042 5.03373,5.72685 4.27237,6.65258 C3.92156,7.07914 3.29138,7.14054 2.86482,6.78972 C2.43827,6.43891 2.37687,5.80873 2.72769,5.38217 C3.64015,4.27272 4.74805,3.3298 5.9993,2.606 Z" id="形状" fill="#09244B"/></g></g></g></svg></p>
                      <p>Lessons lower grade limit: {lesson.Lower_grade_limit}</p>
                      <p>Lessons upper grade limit: {lesson.Upper_grade_limit}</p>
                      <Button variant="primary" className="w-100 mb-2" disabled={isLoadingApprove} onClick={!isLoadingDelete ? Register : null}>
                          {isLoadingApprove ? <><Spinner animation="border" size="sm" /> Registering…</> : 'Register to lesson'}
                      </Button>

                      {user != null && (user.role === 'School Administrator' || user.role === 'System Administrator' || (user.role === 'Teacher' && user.id_User === lesson.creatorId))
                        ? (
                      <Button variant="success" className="w-100 mb-2" onClick={!isLoadingDelete ? editLesson : null}>
                          {isLoadingDelete ? <><Spinner animation="border" size="sm" /> Fetching details…</> : 'Edit'}
                      </Button>
                          )
                        : null}

                      {user != null && (user.Role === 'School Administrator' || user.Role === 'System Administrator' || (user.Role === 'Teacher' && user.id_User === lesson.creatorId))
                        ? (
                      <Button variant="danger" className="w-100 mb-2" disabled={isLoadingDelete} onClick={!isLoadingDelete ? deleteLesson : null}>
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

function LessonList () {
  const { id1, id2 } = useParams()
  const navigate = useNavigate()
  const { http, user } = APIController()
  const [Lessons, setLessons] = useState('')
  const [successMessage, setSuccessMessage] = useState(sessionStorage.getItem('post-success'))

  useEffect(() => {
    fetchLessons()
  }, [])

  const fetchLessons = () => {
    http.get(`/schools/${id1}/classrooms/${id2}/lessons`).then((res) => {
      setLessons(res.data)
      console.log(res.data)
    })
  }

  const addLesson = () => {
    navigate(`/schools/${id1}/classrooms/${id2}/lesson`)
  }

  /* const DeleteLesson = async (e, id) => {
    http.delete(`/schools/${id1}/floors/${id2}/classroom/${id3}/lessons/${id}`, {

    }).then((res) => {
      console.log(res.data)
      window.location.reload()
    }).catch((res) => {
      // alert(res.data);
      alert('Failed to remove lesson')
      navigate(`/schools/${id1}/floors/${id2}/classrooms/${id3}/lessons`)
    })
    navigate(`/schools/${id1}/floors/${id2}/classrooms/${id3}/lessons`)
  } */

  function SuccessAlert ({ message }) {
    const [show, setShow] = useState(!!message)

    if (show) {
      // sessionStorage.removeItem('post-success');
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
        {user != null && (user.Role === 'School Administrator' || user.Role === 'System Administrator' || user.Role === 'Teacher')
          ? (
                <div className="flex items-center">
                    <Button variant="success" className="w-100" onClick={addLesson}>Add new lesson
                    </Button>

                </div>
            )
          : null}
        <Row className="justify-content-center mt-3">
            {Lessons
              ? Lessons.map((lesson, index) => {
                return (<LessonDetail lesson={lesson} onDelete={fetchLessons} key={index} />)
              })
              : <div className="text-center">
                <Spinner animation="border" />
            </div>}
        </Row>
    </div>
  )
}

export default LessonList
