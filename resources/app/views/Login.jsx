import React from 'react';
import LoginPanel from './../components/LoginPanel.jsx';

export default class Login extends React.Component {
  render() {
    return (
      <div>
        <LoginPanel formType="login"/>
      </div>
    );
  }
}
