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
import {generateClientAccessToken, generateUserAccessToken} from './../helpers/sdk';

class LoginContainer extends React.Component {
  componentWillMount() {
    // Check if user is already authenticated
    if (this.props.auth.isAuthenticated) {
      browserHistory.push('/dashboard');
    }
  }

  componentDidMount() {
    // Check if client access token exists or has not already expired
    // TODO: Compare token expires with current timestamp
    if (this.props.auth.clientAccessToken == '' || this.props.auth.clientTokenExpiresAt <= Date.now()) {
      // Generate client access token
      this.props.genClientAccessToken();
    }
  }

  render() {
    var submitForm = this.props.loginUser.bind(this, this.props.auth.clientAccessToken);
    return (
      <Login submitForm={submitForm} xt='asdasd'/>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    auth: state.auth
  }
};

const mapDispatchToProps = (dispatch, ownProps) => {
  return {
    loginUser: (clientAccessToken, e) => {
      e.preventDefault();

      var email = $("#email").val();
      var password = $("#password").val();

      generateUserAccessToken(clientAccessToken, email, password)
        .then(function (response) {
          let nextUrl = 'dashboard';
          if (ownProps.location.query.next != undefined) {
            nextUrl = ownProps.location.query.next;
          }

          dispatch(actionCreators.storeAccessToken(response));
          browserHistory.push('/' + nextUrl);
        })
        .catch(function (error) {
          console.log('Failed generating access token. Please try again');
          console.log(error);
        });

      // spinner
    },
    genClientAccessToken: () => {
      generateClientAccessToken().then(function (response) {
        dispatch(actionCreators.storeClientToken(response));
      }).catch(function (error) {
        console.log('Failed generating client token. Please try again');
        console.log(error);
      });
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(LoginContainer);