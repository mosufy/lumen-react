import React from 'react';
import {Link} from 'react-router';

export default class NotFoundPage extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h2>Page Not Found</h2>
          <p>Oops, seems like you might have accessed this page by accident. Click <Link to="/">here</Link> to go back to the homepage.</p>
        </div>
      </div>
    );
  }
}
