import React from 'react';
import {Link} from 'react-router';

export default class Hero extends React.Component {
  render() {
    return (
      <div className="jumbotron">
        <h1>Welcome</h1>
        <p className="lead">Manage your TODOs today!</p>
        <p>This is a demo/sample for the Lumen-API project. <a href="https://github.com/mosufy/lumen-api" target="_new">https://github.com/mosufy/lumen-api</a>
        </p>
        <p><Link className="btn btn-lg btn-success" to="signup" role="button">Sign up today</Link></p>
      </div>
    );
  }
}
