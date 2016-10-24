/**
 * LoginContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import {browserHistory} from 'react-router';
import Login from './../components/Login';
import {connect} from 'react-redux';
import * as actionCreators from './../actions';

class LoginContainer extends React.Component {
  render() {
    return (
      <Login submitForm={this.props.loginUser}/>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    auth: state.auth
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    loginUser: (e) => {
      e.preventDefault();

      var email = $("#email").val();
      var password = $("#password").val();

      dispatch(actionCreators.loginUser(email, password));
      browserHistory.push('/dashboard');
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(LoginContainer);