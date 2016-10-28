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
import * as authActions from './../actions/authActions';

class LoginContainer extends React.Component {
  componentWillMount() {
    // Check if user is already authenticated
    if (this.props.auth.isAuthenticated) {
      browserHistory.push('/dashboard');
    }

    // Check if client access token exists or has not already expired
    if (this.props.auth.clientAccessToken == '' || this.props.auth.clientTokenExpiresAt <= Date.now()) {
      // Generate client access token
      this.props.genClientAccessToken();
    }
  }

  render() {
    return (
      <Login submitForm={this.props.loginUser}
             loading={this.props.loading}/>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    auth: state.auth,
    loading: !state.loading.completed
  }
};

const mapDispatchToProps = (dispatch, ownProps) => {
  return {
    loginUser: (e) => {
      e.preventDefault();

      var email = $("#email").val();
      var password = $("#password").val();

      dispatch(authActions.loginUser(email, password))
        .then(() => {
          let nextUrl = 'dashboard';
          if (ownProps.location.query.next != undefined) {
            nextUrl = ownProps.location.query.next;
          }
          browserHistory.push('/' + nextUrl);
        })
        .catch(function (error) {
          console.log('Failed to log in user. Please try again');
          console.log(error);
        });
    },
    genClientAccessToken: () => {
      dispatch(authActions.generateClientAccessToken());
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(LoginContainer);