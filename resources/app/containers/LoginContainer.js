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
import {generateUserAccessToken} from './../helpers/sdk';

class LoginContainer extends React.Component {
  componentWillMount() {
    this.checkAuth();
  }

  checkAuth() {
    // Check if user is authenticated
    if (this.props.auth.isAuthenticated) {
      // redirect to expected page
      browserHistory.push('/' + (this.props.location.query.next != '') ? this.props.location.query.next : 'dashboard');
    }
  }

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

      console.log(ownProps);

      generateUserAccessToken(this.props.auth.clientAccessToken, email, password)
        .then(function (response) {
          dispatch(actionCreators.storeAccessToken(response));
        })
        .catch(function (error) {
          console.log('Failed generating access token. Please try again');
          console.log(error);
        });

      // redirect to expected page
      browserHistory.push('/' + (this.props.location.query.next != '') ? this.props.location.query.next : 'dashboard');
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(LoginContainer);