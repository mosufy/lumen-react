/**
 * SignupContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import {browserHistory} from 'react-router';
import {connect} from 'react-redux';
import Signup from './../components/Signup';
import * as authActions from './../actions/authActions';

class SignupContainer extends React.Component {
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
      <Signup submitForm={this.props.signup}
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

const mapDispatchToProps = (dispatch) => {
  return {
    signup: (e) => {
      e.preventDefault();

      var email = $("#email").val();
      var password = $("#password").val();
      var name = $("#name").val();

      dispatch(authActions.signup(email, password, name))
        .then(() => {
          browserHistory.push('/dashboard');
        })
        .catch((error) => {
          console.log('Failed to sign up. Please try again');
          console.log(error);
        });
    },
    genClientAccessToken: () => {
      dispatch(authActions.generateClientAccessToken());
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(SignupContainer);