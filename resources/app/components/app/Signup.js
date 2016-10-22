import React from 'react';
import {Link, browserHistory} from 'react-router';
import Clearfix from './../common/Clearfix';

export default class Signup extends React.Component {
  submitForm(e) {
    e.preventDefault();
    browserHistory.push('/my');
  }

  render() {
    return (
      <div className="row">
        <div className="col-sm-6 col-md-offset-3">
          <h2 className="text-center login-title">Create account and manage your TODOs</h2>
          <div className="account-wall">
            <form className="form-signin form-signup" onSubmit={this.submitForm}>
              <input type="text" className="form-control" placeholder="Name" required autoFocus="autoFocus"/>
              <input type="email" className="form-control" placeholder="Email" required/>
              <input type="password" className="form-control" placeholder="Password" required/>
              <button className="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
            </form>
            <Clearfix/>
          </div>
          <Link to="login" className="text-center new-account">Have an account? Login</Link>
          <Clearfix/>
        </div>
      </div>
    );
  }
}
