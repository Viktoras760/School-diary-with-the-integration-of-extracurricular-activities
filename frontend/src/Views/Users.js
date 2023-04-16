import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { useNavigate } from 'react-router-dom'

function UserList () {
  const navigate = useNavigate()
  const { http } = APIController()
  const [Users, setUsers] = useState([])

  useEffect(() => {
    fetchUsers()
  }, [])

  const fetchUsers = () => {
    http.get('/users/').then((res) => {
      setUsers(res.data)
    })
  }
  const editUser = async (e, id) => {
    navigate(`/user/${id}`)
  }

  const DeleteUser = async (e, id) => {
    http.delete(`/users/${id}`, {
    }).then(() => {
      window.location.reload()
    }).catch(() => {
      alert('Failed to remove user')
      navigate('/users/')
    })
    navigate('/users/')
  }

  const downloadCV = (e, id) => {
    http.get(`/users/${id}/CV`, { responseType: 'blob' }).then((res) => {
      const url = window.URL.createObjectURL(new Blob([res.data]))
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', `${res.headers['content-disposition'].split('"')[1]}`)
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
    }).catch(() => {
      alert('Failed to download CV')
    })
  }

  return (
        <div>
          <div className="container">
            <div className="row">
              <div className="col-md-12">
                <div className="card">
                  <div className="card-header">
                    <h4><svg height="24" width="24" viewBox="0 0 24 24" className="EmployeeSelect-module_avatar_f8203f" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid meet" fill="currentColor"><path d="M17.6 13.714A9.987 9.987 0 0122 22h-2a8 8 0 00-4.124-7 8.026 8.026 0 001.724-1.286zM12 2a6 6 0 01.225 11.996L12 14a8 8 0 00-8 8H2c0-4.21 2.603-7.814 6.287-9.288A6 6 0 0112 2zm0 2C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z" fillRule="evenodd"></path></svg>Users</h4>
                  </div>
                  <div className="card-body">
                    </div>
                  <table className="table">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Surname</th>
                        <th scope="col">Email</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Role</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Download CV</th>
                      </tr>
                    </thead>
                    <tbody>
                      {Object.entries(Users).map(([key, val]) => (
                        <tr key={val.id_User}>
                          <th scope="row">{val.name}</th>
                          <th scope="row">{val.surname}</th>
                          <th scope="row">{val.email}</th>
                          <th scope="row">{val.grade}</th>
                          <th scope="row">{val.role}</th>
                          <td>
                            <button
                              className="btn btn-success"
                              onClick={(e) => editUser(e, val.id_User)}
                            >
                              Edit
                            </button>
                          </td>
                          <td>
                            <button
                              className="btn btn-warning"
                              onClick={(e) => DeleteUser(e, val.id_User)}
                            >
                              Delete
                            </button>
                          </td>
                          {(val.role === 'Teacher' &&
                          <td>
                            <button
                              className="btn btn-warning"
                              onClick={(e) => downloadCV(e, val.id_User)}
                            >
                              Download CV
                            </button>
                          </td>
                          )}
                          {((val.role !== 'Teacher' || val.role === null) &&
                            <td>

                            </td>
                          )}
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
  )
}

export default UserList
