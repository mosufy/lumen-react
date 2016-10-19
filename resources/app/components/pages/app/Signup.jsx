import React from 'react';
import LoginPanel from './LoginPanel.jsx';

export default class Signup extends React.Component {
  render() {
    return (
      <div>
        <LoginPanel formType="signup"/>
      </div>
    );
  }
}
