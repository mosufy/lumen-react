import React from 'react';
import {Link} from 'react-router';
import Clearfix from './common/Clearfix';
import LaddaButton, {SLIDE_RIGHT} from 'react-ladda';

const Signup = (props) => {
  return (
    <div className="row">
      <div className="col-sm-6 col-md-offset-3">
        <h2 className="text-center login-title">Create account and manage your TODOs</h2>
        <div className="account-wall">
          <form className="form-signin form-signup" onSubmit={props.submitForm}>
            <input id="name" type="text" className="form-control" placeholder="Name" required autoFocus="autoFocus"/>
            <input id="email" type="email" className="form-control" placeholder="Email" required/>
            <input id="password" type="password" className="form-control" placeholder="Password" required/>
            <LaddaButton
              className="btn btn-lg btn-primary btn-block"
              type="submit"
              loading={props.loading}
              data-style={SLIDE_RIGHT}>Sign up</LaddaButton>
          </form>
          <Clearfix/>
        </div>
        <Link to="login" className="text-center new-account">Have an account? Login</Link>
        <Clearfix/>
      </div>
    </div>
  );
};

export default Signup;