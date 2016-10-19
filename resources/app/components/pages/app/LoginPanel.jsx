import React from 'react';
import {Link, browserHistory} from 'react-router';
import Clearfix from './../../common/Clearfix.jsx';

export default class LoginPanel extends React.Component {
  render() {
    var formType = this.props.formType;
    var formTitle = 'Sign in to manage your TODOs';
    var alternateText = <Link to="signup" className="text-center new-account">Create an account</Link>;
    var formComponent = (
      <form className="form-signin" onSubmit={this.submitForm}>
        <input type="email" className="form-control" placeholder="Email" required autoFocus="autoFocus"/>
        <input type="password" className="form-control" placeholder="Password" required/>
        <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    );

    if (formType == 'signup') {
      formTitle = 'Create account and manage your TODOs';
      alternateText = <Link to="login" className="text-center new-account">Have an account? Login</Link>;
      formComponent = (
        <form className="form-signin form-signup" onSubmit={this.submitForm}>
          <input type="text" className="form-control" placeholder="Name" required autoFocus="autoFocus"/>
          <input type="email" className="form-control" placeholder="Email" required/>
          <input type="password" className="form-control" placeholder="Password" required/>
          <button className="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
        </form>
      );
    }

    return (
      <div className="row">
        <div className="col-sm-6 col-md-offset-3">
          <h2 className="text-center login-title">{formTitle}</h2>
          <div className="account-wall">
            {formComponent}
            <Clearfix/>
          </div>
          {alternateText}
          <Clearfix/>
        </div>
      </div>
    );
  }

  submitForm(e) {
    e.preventDefault();
    browserHistory.push('/my');
  }
}
