/**
 * AuthRequiredContainer
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import {connect} from 'react-redux';
import {browserHistory} from 'react-router';
import {generateClientAccessToken} from './../helpers/sdk';
import * as actionCreators from './../actions';

/**
 * class AuthRequiredContainer
 *
 * Checks if user is logged in and redirect to login page if not.
 */
class AuthRequiredContainer extends React.Component {
  componentWillMount() {
    this.checkAuth();
  }

  checkAuth() {
    // Check if user is authenticated
    if (!this.props.isAuthenticated) {
      // Check if client access token exists or has not already expired
      // TODO: Compare token expires with current timestamp
      if (this.props.clientAccessToken == '' || this.props.clientTokenExpiresIn == '') {
        // Generate client access token
        this.props.genClientAccessToken();
      }

      let redirectAfterLogin = this.props.location.pathname;
      browserHistory.push('/login?next=' + redirectAfterLogin);
    }
  }

  render() {
    return this.props.children;
  }
}

const mapStateToProps = (state) => {
  return {
    isAuthenticated: state.auth.isAuthenticated,
    clientAccessToken: state.auth.clientAccessToken,
    clientTokenExpiresIn: state.auth.clientTokenExpiresIn
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
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

export default connect(mapStateToProps, mapDispatchToProps)(AuthRequiredContainer);