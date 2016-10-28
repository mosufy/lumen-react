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
import * as commonActions from './../actions/commonActions';
import * as authActions from './../actions/authActions';
import {signup, generateClientAccessToken, generateUserAccessToken} from './../helpers/sdk';

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
    var submitForm = this.props.signup.bind(this, this.props.auth.clientAccessToken);
    return (
      <Signup submitForm={submitForm}
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
    signup: (clientAccessToken, e) => {
      e.preventDefault();

      var email = $("#email").val();
      var password = $("#password").val();
      var name = $("#name").val();

      dispatch(commonActions.updateLoader(0.25));

      signup(clientAccessToken, email, password, name)
        .then(function (response) {
          dispatch(commonActions.updateLoader(0.5));
          generateUserAccessToken(clientAccessToken, email, password)
            .then(function (response2) {
              dispatch(authActions.saveAccessToken(response2));
              dispatch(commonActions.updateLoader(1));
              browserHistory.push('/dashboard');
            })
            .catch(function (error) {
              dispatch(commonActions.updateLoader(1));
              console.log('Failed generating access token. Please try again');
              console.log(error);
            });
        })
        .catch(function (error) {
          dispatch(commonActions.updateLoader(1));
          console.log('Failed signup. Please try again');
          console.log(error);
        });

      // spinner
    },
    genClientAccessToken: () => {
      generateClientAccessToken().then(function (response) {
        dispatch(authActions.saveClientAccessToken(response));
      }).catch(function (error) {
        console.log('Failed generating client token. Please try again');
        console.log(error);
      });
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(SignupContainer);