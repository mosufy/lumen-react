import React from 'react';
import {Link} from 'react-router';
import Clearfix from './common/Clearfix';

export default class Login extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-sm-6 col-md-offset-3">
          <h2 className="text-center login-title">Sign in to manage your TODOs</h2>
          <div className="account-wall">
            <form className="form-signin" onSubmit={this.props.submitForm}>
              <input id="email" type="email" className="form-control" placeholder="Email" required autoFocus="autoFocus"/>
              <input id="password" type="password" className="form-control" placeholder="Password" required/>
              <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>
            <Clearfix/>
          </div>
          <Link to="signup" className="text-center new-account">Create an account</Link>
          <Clearfix/>
        </div>
      </div>
    );
  }
}
