import React from 'react'

const OneEvent = ({dogadjaj}) => {
  return (
    <div className="card">
  <div className="card-header">
    Featured
  </div>
  <div className="card-body">
    <h5 className="card-title">{dogadjaj.ime_dogadjaja}</h5>
    <p className="card-text">{dogadjaj.lokacija}</p>
    <p className="card-text">{dogadjaj.opis}</p>
    <p className="card-text">{dogadjaj.status}</p>
    <a href="#" className="btn btn-primary">Details</a>
  </div>
  <div className="card-footer text-muted">
    {dogadjaj.datum_registracije}
  </div>
</div>
  )
}

export default OneEvent